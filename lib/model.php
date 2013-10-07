<?php 
/**
 * @author 70 Division
 *
 */
class DB {
	
	protected $_tablename;

	protected $_select;
	
	protected $_insert;
	
	protected $_update;
	
	protected $_joinSql;
	
	public $_mysqli;
	
	public $_mysqli_stmt;
	
	protected $_delete;
	
	public function __construct() {
		$config = Config::getConfig(APPLICATION_ENV);
		$this->_mysqli = $this->connect($config);
	}

	public function connect($config) {
		
		$host = $config['components']['db']['host'];
		$user = $config['components']['db']['user'];
		$password = $config['components']['db']['pass'];
		$db_name = $config['components']['db']['db'];
		$db_port = $config['components']['db']['port'];
		
		$mysqli = new mysqli();
		$mysqli->connect($host, $user, $password, $db_name, $db_port);
		$mysqli->query('SET CHARACTER SET utf8');
		
		if ($mysqli->connect_error) {
			throw new Exception('Connect error: ('.$mysqli->connect_errno.') '.$mysqli->connect_error);
		}
		
		if (mysqli_connect_error()) {
			throw new Exception('Connect error: ('.mysqli_connect_errno().') '.mysqli_connect_error());
		}
		if ($mysqli) {
			return $mysqli;
		}
	}
	
	function _isValidDateTime($dateTime) {
		if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
			if (checkdate($matches[2], $matches[3], $matches[1])) {
				return true;
			}
		}
	
		return false;
	}
	
	protected function checkRow($array) {
		$row = $this->_row;
		
		foreach($array as $key => $value) {
			if ($row[$key]) {
				switch ($value) {
					case 'INT' :
						$check = is_int($value) ? true : false;
						break;
					case 'TEXT' : 
						$check = is_string($value) ? true : false;
						break;
					case 'DATETIME' :
						$check = $this->_isValidDateTime($value) ? true : false;
						break;
					default :
						$check = true;
				
				}
				
				if ($check === false) {
					throw new Exception('The given value: '.$key.' is not well formatted!');
					break;
				}
				
				
			} else { // no equal field found
				throw new Exception('The given value: '.$key.' is not in the given table!');
				$check = false;
				break;
			}
		}
		
		return $check;
		
	}
	
	
	/**
	 * Define SELECT syntax
	 * 
	 * @param string $what
	 * @param string $from
	 * @return DB
	 */
	public function select($what = "*", $from = null) {
		
		$whatSQL = '';
		
		// Select the table, if null set default table name
		if (is_null($from)) {
			$from = $this->_tablename;
		}
		
		$this->_select = "SELECT";
		return $this;
	}
	
	
	/**
	 * Define FROM syntax
	 *
	 * @param string $from		Table name, if null will be set the default table name	
	 * @param string|array $what		Fields of the table to select
	 * @return DB
	 */
	public function from($from = null, $what = null ) {
	
		if (is_array($from)) {
			$fromSql = ' FROM';
			foreach($from as $asFrom => $from) {
				if (is_int($asFrom)) { // no as table name given
					$from = " `$from`";
					$fromName = $from;
				} else {
					$from = " `$from` AS `$asFrom`";
					$fromName = "`$asFrom`";
				}
				$fromSql .= $from;
			}
		} else {
			if (is_null($from)) {
				$from = $this->_tablename;
			}
			
			$fromName = '`'.$from.'`';
			$fromSql = ' FROM `'.$from.'`';
			if (!is_array($what)) {
				if (strpos($what, '!')) {
					$fromName = ' ';
				}
			}
		}
	
		$fieldSql = '';
		if (!is_null($what)) {
			if (is_array($what)) { // array('id', 'title', ...)
				$limit = count($what) - 1;
				$i = 0;
				foreach($what as $asField => $field) {
					$i++;
					$field = "`$field`";
					$fieldSql .= ' '.$fromName.'.'.$field;
					if (!is_int($asField)) { // no as field name given
						$fieldSql .= ' AS `'.$asField.'`';
					}
					$fieldSql .= $i <= $limit ? ', ' : '';
				}
	
			} else {
				
				$pos = strpos($what, ',');
				
				if ($what == '*') {
					$whatField = $what;
					$fieldSql = ' '.$fromName.'.'.$whatField;
				} else if (strpos($what, '!') === false) {
					if ($pos !== false) {
						$whatField = $what;
						$fieldSql = $whatField;
					} else{
						$whatField = '`'.$what.'`';
						$fieldSql = ' '.$fromName.'.'.$whatField;
					}
				} else {
					$whatField = '';
					$fieldSql = '';
				}
			}	
		} else {
			$fieldSql = ' *';
		}
	
		$fieldSql .= ' '.$fromSql;
		$this->_select .= $fieldSql;
		
		return $this;
	}
	
	
	/**
	 * Define JOIN syntax
	 * 
	 * @param string $table		Name of the second table on which to do the JOIN
	 * @param string $matching	String joining two fields in the table 					$matching = 'firstTable.Id = secondTable.Id'
	 * @param array	$columns 	Array of fields to be selected in the second table 		$columns = 'field' || array('asfield' => 'field', 'otherField')
	*/
	public function join($table, $matching, $columns = null) {
		if (isset($this->_joinSql)) { 
			$joinSql = $this->_joinSql . ' JOIN';
		}else{
			$joinSql = ' JOIN';
		}
		
		// process tha table to get the right name
		if (is_array($table)) {
			foreach($table as $asTable => $tableName) {
				$joinSql .= ' `'.$tableName.'`';
				if (!is_int($asTable)) { // as table name given
					$joinSql .= ' AS `'.$asTable.'`';
					$joinTableName = '`'.$asTable.'`';
				} else {
					$joinTableName = '`'.$tableName.'`';
				}
			}
		} else {
			$joinTableName = '`'.$table.'`';
			$joinSql .= ' `'.$table.'`';
		}
		
		$columsSql = '';
		
		if (is_array($columns)) {
			$limit = count($columns);
			$i = 0;
			foreach($columns as $asColumn => $columnName) {
				$i++;
				if (strrpos($columnName,'(')){
					$sql = explode ('(', $columnName);
					$columsSql .= $sql[0] .'('. $joinTableName .'.'. $sql[1];
				}
				else {
					$columsSql .= ' '.$joinTableName.'.'.$columnName;
				}
				if (!is_int($asColumn)) { // as field name given
					$columsSql .=  ' AS `'.$asColumn.'`';
				}
				$columsSql .= $i < $limit ? ', ' : '';
			}
		} else if (is_null($columns)) {
			$columsSql .= ' '.$joinTableName.'.*';
		} else {
			$columsSql .= ' '.$joinTableName.'.`'.$columns.'`';
		}
		
		$sql = explode('FROM', $this->_select);
		$comma = (strpos($sql[0], '`')) ? ', ' : '';
		
		$joinAddSql = $sql[0].$comma.$columsSql.' FROM '.$sql[1];
		
		$joinSql = $joinAddSql.$joinSql;
		
		$joinSql .= ' ON '.$matching;

		$this->_select = $joinSql;
		
		return $this;
	}
	
	function leftJoin($table, $matching, $columns = null){
		$this->_joinSql = ' LEFT';
		$this -> join($table, $matching, $columns);
		return $this;
	}
	
	
	/** 
	 * Define WHERE syntax
	 * 
	 * @param string | array $field				Table field
	 * @param string|int $value			Value of the field that is searched
	 * @return DB
	 */	
	 public function where( $field = null, $value = null ) {
	 	$whereSQL = isset($whereSQL) ? $whereSQL : '';
		
		if (!strrpos($this->_select, 'FROM')) { // no from table and field declared
			$whereSQL .= ' * FROM `'.$this->_tablename.'`';
		}
		
		if (!is_null($field)) {
			if (!strrpos($this->_select, 'WHERE')) {
				$whereSQL .= ' WHERE';
			} else { // where clause already declared, so add an 'AND'
				$whereSQL .= ' AND';
			}
			
			if (is_array($field)) {
				$whereCount = count($field) - 1;
				$i = 0;
				$whereSQL .= ' (';
				foreach($field as $whereField => $whereValue) {
					
					// OR case
					if (is_int($whereField)) {
						$whereSQL .= $whereValue;
					} else {
						
						if (strpos($whereField, 'LIKE')) {
							$whereValue = '%'.$whereValue.'%';
						}
							
						if (!strpos($whereField, '=')) {
							$whereField .= ' = ';
						}
						// get where value type ( int || string )
						$whereValue = is_int($whereValue) ? intval($whereValue) : "'$whereValue'";
						// construct the where sql string
						$whereSQL .= ' '.$whereField.' '.$whereValue;
					}
					$i++;
					$whereSQL .= $i <= $whereCount ? ' OR ' : '';
				}
 				$whereSQL .= ')';
			} else {
				// is clause has 'LIKE' add % on value begin and end.
				if (!is_null($value)) {
					$value = strrpos($value, 'LIKE') ? '%'.$value.'%' : $value;
					$value = is_int($value) ? intval($value) : "'$value'";
					$whereSQL .= ' '.$field.' '.$value;
				} else { // means the field value is a already a query string
					$whereSQL .= ' ('.$field.')';
				}
			}
			$this->_select .= $whereSQL;
		}

	return $this;
		
	}
	
	/**
	 * Define ORDER BY syntax
	 * 
	 * @param string $by				Table field
	 * @param string $order				(DESC or ASC) Select the sort order, ascending or descending
	 * @return DB
	 */
	
	public function order($by, $order = null) {
		
		$this->_correctQuery();
		
		if (!strrpos($this->_select, 'ORDER BY')) { // on first order use
			$this->_select .= ' ORDER BY';
		} else { // if reused add a comma to form the right query
			$this->_select .= ', ';
		}
		if (strpos($by, '.')) {
			$byArr = explode('.', $by);
			$by = implode('`.`', $byArr);
		}
		$this->_select .= ' `'.$by.'` '.$order;
		
		return $this;
	}
	
	
	/**
	 * Define GROUP BY syntax
	 * 
	 * @param string $by				Table field
	 * @return DB
	 */
	public function group ($by) {
	
		$this->_correctQuery();
	
		if (!strrpos($this->_select, 'GROUP BY')) { // on first order use
			$this->_select .= ' GROUP BY';
		} else { // if reused add a comma to form the right query
			$this->_select .= ', ';
		}
	
		if (strpos($by, '.')) {
			$byArr = explode('.', $by);
			$by = implode('`.`', $byArr);
		}
		
		if (strpos($by, '(') ){
			$this->_select .= ' '.$by;
		}
		else {
			$this->_select .= ' `'.$by.'`';
		}
		
	
		return $this;
	}
	
	
	/**
	 * Define LIMIT syntax
	 * 
	 * @param int $start				Select from row $start, if $stop is not set $start number of rows
	 * @param int $stop					Range limit selection
	 * @return DB
	 */
	public function limit($start, $stop = null) {
		$this->_select .= ' LIMIT '.intval($start);
		
		if (!is_null($stop)) {
			$this->_select .= ', '.intval($stop);
		}
		
		return $this;	
	}
	

		
	/**
	 * Define INSERT INTO syntax
	 *
	 * @param string|array $data		Array which associates field name table with the value to insert
	 * @param string $table				Table where insert new record
	 * @throws Exception
	 * @return int						Returns the index of the new record
	 */
	
	public function insert($data, $table = null) {
		if (is_null($table)) {
			$into = $this->_tablename;
		} else {
			$into = $table;
		}
	
		// select table
		if (is_null($data)) {
			throw new Exception('No data passed in insert operation');
		}
	
		if (is_array($data)) {
			$sql = 'INSERT INTO `'.$into.'`';
			$fieldsStr = ' ( ';
			$valuesStr = ' ( ';
			$numFields = count($data);
			$i = 0;
			foreach($data as $field => $value) {
				$i++;
				$comma = $i < $numFields ? ', ' : ')';
				$fieldsStr .= "`$field`".$comma;
				$value = mysqli_real_escape_string($this->_mysqli, $value);
				$value = is_int($value) ? $value : "'$value'";
				$valuesStr .= "$value".$comma;
			}
			// construct the insert query
			$insertSql = $sql.$fieldsStr.' VALUES '.$valuesStr;
				
			$this->_insert = $insertSql;
			$insertId = $this->_insertQuery();
			
			return $insertId;
		} else {
			echo 'Insert data has to be an array.';
		}
	
	}
	
	
	/**
	 * Define UPDATE syntax
	 * 
	 * @param array $data				array of data to upload	
	 * @param string $table				table name
	 * @param string|array $where		array or string of control array($whereFields => $whereValue)
	 * @return int
	 */
	public function update($data, $table = null, $where) {
		if (is_null($where)) {
			//throw new Exception('where clause is missed');
		} else {
			$whereSQL = ' WHERE ';
		}
		
		$whereCount = count($where);
		
		if (is_array($where)) {
			$i = 0;
			
			foreach($where as $whereField => $whereValue){
				$whereValue = mysqli_real_escape_string($this->_mysqli, $whereValue);
				if (strpos($whereField, 'LIKE')) {
					$whereValue = '%'.$whereValue.'%';
				}
				
				// get where value type ( int || string )
				$whereValue = is_int($whereValue) ? intval($whereValue) : "'$whereValue'";
				
// 				if () {
					
// 				}
				
				// construct the where sql string
				$whereSQL .= ' '.$whereField.' '.$whereValue;
				
				$i++;
				$whereSQL .= $i < $whereCount ? ' AND ' : '';
			}
		}
		
		if (is_null($table)) {
			$into = $this->_tablename;
		} else {
			$into = $table;
		}
		
		if (is_array($data)) {
			$sql = 'UPDATE `'.$into.'` SET ';
			$numFields = count($data);
			$i = 0;
			
			foreach($data as $field => $value) {

				$i++;
				//control whether to insert a comma or no
				$comma = $i < $numFields ? ', ' : '';
				
				//check if value is null
				# FIXME check on value = null
				if (is_null($value)) {
						$sql .= $field. " = NULL".$value . $comma . " ";
				} else {
					//check if value is a number or a string
					$value = mysqli_real_escape_string($this->_mysqli, $value);
					$value = is_int($value) ? $value : "'$value'";
					if (!strpos($field, '=')) {
						$field .= '` = ';
					}
					
// 					if (($i+1) != $numFields){
						$sql .= "`$field ". $value . $comma . " ";
// 					}
				}
				
			}
	
			$sql .= $whereSQL;
			
			$this->_update = $sql;
			$updateId = $this->_updateQuery();
			
			return $updateId;
		
		} else {
			echo 'Insert data has to be an array.';
		}
	}
	
	/**
	 * Define DELETE syntax
	 * 
	 * @param string $table
	 * @param array $where
	 * @return NULL
	 */
	public function delete($table = null, $where) {
		if (is_null($where)) {
			$message = "insert WHERE clause";
			error_log($message);
			exit();
		}
		else {
			$whereSQL = ' WHERE ';
		}
		
		$whereCount = count($where);
	
		if (is_array($where)) {
			$i = 0;
				
			foreach($where as $whereField => $whereValue){
				if (strpos($whereField, 'LIKE')) {
					$whereValue = '%'.$whereValue.'%';
				}
				// get where value type ( int || string )
				$whereValue = is_int($whereValue) ? intval($whereValue) : "'$whereValue'";
	
				// construct the where sql string
				$whereSQL .= ' '.$whereField.' '.$whereValue;
	
				$i++;
				$whereSQL .= $i < $whereCount ? ' AND ' : '';
			}
		}
	
		if (is_null($table)) {
			$into = $this->_tablename;
		} else {
			$into = $table;
		}
	
		$sql = 'DELETE FROM `'.$into.'`';
		$sql .= $whereSQL;
		
		$this->_delete = $sql;
		$deleteId = $this->_deleteQuery();
			
		
		return $deleteId;
	}
	
	
	/**
	 * FETCH ROW
	 * 
	 * @return array				Returns the result of the query if it's a single row
	 */
	public function fetchRow() {
		$this->_select = $this->_checkSql($this->_select);
		$result = $this->_mysqli->query($this->_select);
		if (empty($result)) {
			$this->queryErr();
 		}
		
		// fetch only one results
		$fetchedResult = $result->fetch_assoc();
		
// 		print_r($fetchedResult);
// 		die;
		
		if (is_array($fetchedResult)) {
			foreach ($fetchedResult as $field => $value) {
				$fetchedResult[$field] = stripslashes($value);
			}
		}
		
		if (empty($fetchedResult)) {
			return null;
		} else {
			return $fetchedResult;
		}
	}
	
	/**
	 * FETCH ALL
	 * 
	 * @return array				Returns the results of the query if there are more rows
	 */
	public function fetchAll() {
		
		
		// perform the query
		$results = $this->_mysqli->query($this->_select);

		if (empty($results)) {
			$this->queryErr();
		}
		// fetch all results
		$rows = array();
		$strippedRow = array();
		
		while($row = $results->fetch_assoc()) {
			
			foreach ($row as $field => $value) {
				$strippedRow[$field] = stripslashes($value);
			}
			
			$rows[] = $strippedRow;
			$strippedRow = array();
			
		}

		if (empty($rows)) {
			return null;
		} else {
			return $rows;
		}
	
	}
	
	protected function _insertQuery() {
		$this->_insert = $this->_checkSql($this->_insert);
		$results = $this->_mysqli->query($this->_insert);
		if (empty($results)) {
			$this->queryErr();
		}
		if ($results == 1) { // row inserted
			return $this->_mysqli->insert_id;
		} else {
			return null;
		}
	}
	
	protected function _updateQuery() {
	
		$results = $this->_mysqli->query($this->_update);
		if (empty($results)) {
			$this->queryErr();
		}
		if ($results > 0) { // row updated
			return $this->_mysqli->affected_rows;
		} else {
			return null;
		}
	}
	
	protected function _deleteQuery() {
	
		$results = $this->_mysqli->query($this->_delete);
		if (empty($results)) {
			$this->queryErr();
		}
		if ($results > 0) { // row updated
			return $this->_mysqli->affected_rows;
		} else {
			return null;
		}
	}
	
	public function queryErr() {
		print_r('['.$this->_mysqli->errno.']: '.$this->_mysqli->error.'<br />');
		print_r(isset($this->_insert) ? 'Query '.$this->_insert : '');
		print_r(isset($this->_select) ? 'Query: '.$this->_select : '');
		print_r(isset($this->_update) ? 'Query: '.$this->_update : '');
		die;
	}
	
	protected function _correctQuery() {
		if (!strrpos($this->_select, 'FROM')) {
			$this->_select .= '* FROM `'.$this->_tablename.'`';
		}
	}
	
	
	protected function _checkSql($sql) {
		$sql = str_replace("`'", "`", $sql);
		$sql = str_replace("'`", "`", $sql);
		return $sql;
	}
	
}
?>