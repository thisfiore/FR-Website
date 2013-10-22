<?php

class ShopController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->loadFile($this->method, $this->self);
	}

	
    public function postIpn () {
	    // intercetta le variabili IPN inviate da PayPal
	    $req = 'cmd=_notify-validate';
	     
	    // legge l'intero contenuto dell'array POST
	    foreach ($_POST as $key => $value) {
	        $value = urlencode(stripslashes($value));
	        $req .= "&$key=$value";
	    }
	
	    // intestazione, prepara le variabili PayPal per la validazione
	    $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
	    // apre una connessione al socket PayPal 
	    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
	
	    // converte le variabili inviate da IPN in variabili locali
	    $id_ordine_admin = filter_var($_POST['id_ordine_admin'], FILTER_SANITIZE_STRING);

	    $payment_status = filter_var($_POST['payment_status'], FILTER_SANITIZE_STRING);
	    $receiver_email = filter_var($_POST['receiver_email'], FILTER_SANITIZE_EMAIL);
// 	    $payer_email = filter_var($_POST['payer_email'], FILTER_SANITIZE_EMAIL);
// 	    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
// 	    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
// 	    $address_street = filter_var($_POST['address_street'], FILTER_SANITIZE_STRING);
// 	    $address_city = filter_var($_POST['address_city'], FILTER_SANITIZE_STRING);
// 	    $address_state = filter_var($_POST['address_state'], FILTER_SANITIZE_STRING);
// 	    $address_zip = filter_var($_POST['address_zip'], FILTER_SANITIZE_STRING);
	
	    // verifica l'apertura della connessione al socket
	    if (!$fp) {
	
	        // se la connessione non avviene l'esecuzione dello script viene bloccata
	        exit();
	
	        // in alternativa  per esempio possibile inviare un'email al venditore
	    } else {
	
	        // elaborazione delle informazioni
	        fputs ($fp, $header . $req);
	        while (!feof($fp)) {
	            $res = fgets ($fp, 1024);
	
	            // azioni in caso di risposta positiva da parte di PayPal
	            if (strcmp ($res, "VERIFIED") == 0) {
	
	                // controllo sull'email del venditore
	                if($receiver_email == "info@food-republic.it"){
	                     
	            		// connessione a MySQL tramite istanza
	                	$this->loadModules('ordine');
	                	$ordineModel = new Ordine();
	                	$ordine['id_ordine_admin'] =  $id_ordine_admin;
	                	$ordine['stato'] = 1;
	                	$ordine['id_utente'] = $_COOKIE['id_utente'];
	                	
	                	$log = $ordineModel->updateOrdineUtente($ordine);
	                }
	
	            }
	
	            // azione in caso di risposta negativa da parte di PayPal else 
	            if (strcmp ($res, "INVALID") == 0) {
	                //  possibile eseguire qualsiasi operazione
	        		// per esempio compilare un log degli errori o inviare una mail al venditore
	            }
	            else {
	            	header('Location: foodrepublic.70division.com');
	            }
	
	        }
	
	        // chiusura della sorgente di dati
	        fclose($fp);
	    }
    }
  
}
    ?>