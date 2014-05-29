<!DOCTYPE html>
<html>
  <head>
	<meta http-equiv="Content-type" value="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="description" content="description of your site">
    <meta name="author" content="author of the site">
    
	    <title>Food Republic</title>
	    <link rel="icon" href="/img/favicon.ico" />
	
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <?php
    
//     header('Content-type: text/html; charset=utf-8');
    
    // including styles
	if ($this->styles) {
		foreach($this->styles as $style) {
			echo '<link type="'.$style["type"].'" rel="'.$style["rel"].'" href="'.$style["href"].'">'."\n";
		}
	}
	
	// including scripts
	if ($this->scripts) {
		foreach($this->scripts as $scriptName => $script) {
			echo '<script id="'.$scriptName.'-script" type="'.$script["type"].'" src="'.$script["src"].'" defer="defer"></script>'."\n";
		}
	}
	?>

  </head>

<?php if ( isset($_COOKIE['id_utente']) && $_COOKIE != null ) { echo '<body class="blurred">'; } else { echo '<body class="neat">'; }