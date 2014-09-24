<?php
global $CFG;
$root=str_replace('auth/mojeid/api/common.php', false, __FILE__);
require_once($root.'config.php');

// Settings
define('TEST', false);
//define('HTTP_SERVER', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' . trim($_SERVER['SERVER_NAME'], '/') . '/');
define('HTTP_SERVER', $CFG->wwwroot);

$error = null;

ob_start();

if (!is_readable('/dev/urandom')) {
	define('Auth_OpenID_RAND_SOURCE', null);
}

ob_end_clean();

$include_path=get_include_path();

set_include_path($root.'auth/mojeid/api/');
//set_include_path(getcwd() . '/OpenID' . PATH_SEPARATOR . get_include_path());

require_once('Auth/OpenID/Consumer.php');
require_once('Auth/OpenID/FileStore.php');
require_once('Auth/OpenID/AX.php');
require_once('Auth/OpenID/PAPE.php');

set_include_path($include_path);

global $pape_policy_uris;
$config=get_config('auth/mojeid');
$pape_policy_uris = array(PAPE_AUTH_MULTI_FACTOR_PHYSICAL);
if($config->security_level==='PHISHING_RESISTANT'){
	$pape_policy_uris=array(PAPE_AUTH_PHISHING_RESISTANT);
}
elseif($config->security_level==='MULTI_FACTOR'){
	$pape_policy_uris=array(PAPE_AUTH_MULTI_FACTOR);
}

global $ax_attributes;

$ax_attributes = array(
	'firstname' => array(
			'scheme'   => 'http://axschema.org/namePerson/first',
			'text'     => 'Jméno',
			'required' => true
		),
	'lastname' => array(
			'scheme'   => 'http://axschema.org/namePerson/last',
			'text'     => 'Příjmení',
			'required' => true
		),
	'email' => array(
		'scheme'   => 'http://axschema.org/contact/email',
		'text'     => 'Email – Hlavní',
		'required' => true
	),
	'status' => array(
		'scheme'   => 'http://specs.nic.cz/attr/contact/status',
		'text'     => 'Stav účtu',
		'required' => true
	),



	'h_city' => array(
		'scheme'   => 'http://axschema.org/contact/city/home',
		'text'     => 'Domácí adresa – Město',
		'required' => false
	),
	'h_country' => array(
		'scheme'   => 'http://axschema.org/contact/country/home',
		'text'     => 'Domácí adresa – Země',
		'required' => false
	),
	'h_state' => array(
		'scheme'   => 'http://axschema.org/contact/state/home',
		'text'     => 'Domácí adresa – Stát',
		'required' => false
	),
	'h_postcode' => array(
		'scheme'   => 'http://axschema.org/contact/postalCode/home',
		'text'     => 'Domácí adresa – PSČ',
		'required' => false
	),
	'h_address' => array(
		'scheme'   => 'http://axschema.org/contact/postalAddress/home',
		'text'     => 'Domácí adresa – Ulice',
		'required' => false
	),
//	'h_address2' => array(
//		'scheme'   => 'http://axschema.org/contact/postalAddressAdditional/home',
//		'text'     => 'Domácí adresa – Ulice2',
//		'required' => FALSE
//	),
//	'h_address3' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/main/street3',
//		'text'     => 'Domácí adresa – Ulice3',
//		'required' => FALSE
//	),



	'phone' => array(
		'scheme'   => 'http://axschema.org/contact/phone/default',
		'text'     => 'Telefon – Hlavní',
		'required' => FALSE
	),
	'phone_mobile' => array(
		'scheme'   => 'http://axschema.org/contact/phone/cell',
		'text'     => 'Telefon – Mobil',
		'required' => FALSE
	),
	'url' => array(
		'scheme'   => 'http://axschema.org/contact/web/default',
		'text'     => 'URL – Hlavní',
		'required' => FALSE
	),
	'icq' => array(
		'scheme'   => 'http://axschema.org/contact/IM/ICQ',
		'text'     => 'IM -ICQ',
		'required' => FALSE
	),
	'skype' => array(
		'scheme'   => 'http://axschema.org/contact/IM/Skype',
		'text'     => 'IM – Skype',
		'required' => FALSE
	),
	'valid' => array(
		'scheme'   => 'http://specs.nic.cz/attr/contact/valid',
		'text'     => 'Příznak – Validace',
		'required' => FALSE
	),




//	'nick' => array(
//		'scheme'   => 'http://axschema.org/namePerson/friendly',
//		'text'     => 'Přezdívka',
//		'required' => true
//	),
//	'image' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/contact/image',
//		'text'     => 'Obrázek (base64)',
//		'required' => FALSE
//	),





//	'fullname' => array(
//		'scheme'   => 'http://axschema.org/namePerson',
//		'text'     => 'Celé jméno',
//		'required' => false
//	),
//	'company' => array(
//		'scheme'   => 'http://axschema.org/company/name',
//		'text'     => 'Jméno společnosti',
//		'required' => FALSE
//	),
//	'b_address' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/bill/street',
//		'text'     => 'Faktur. adresa – Ulice',
//		'required' => FALSE
//	),
//	'b_address2' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/bill/street2',
//		'text'     => 'Faktur. adresa – Ulice2',
//		'required' => FALSE
//	),
//	'b_address3' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/bill/street3',
//		'text'     => 'Faktur. adresa – Ulice3',
//		'required' => FALSE
//	),
//	'b_city' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/bill/city',
//		'text'     => 'Faktur. adresa – Město',
//		'required' => FALSE
//	),
//	'b_state' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/bill/sp',
//		'text'     => 'Faktur. adresa – Stát',
//		'required' => FALSE
//	),
//	'b_country' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/bill/cc',
//		'text'     => 'Faktur. adresa – Země',
//		'required' => FALSE
//	),
//	'b_postcode' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/bill/pc',
//		'text'     => 'Faktur. adresa – PSČ',
//		'required' => FALSE
//	),
//	's_address' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/ship/street',
//		'text'     => 'Doruč. adresa – Ulice',
//		'required' => FALSE
//	),
//	's_address2' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/ship/street2',
//		'text'     => 'Doruč. adresa – Ulice2',
//		'required' => FALSE
//	),
//	's_address3' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/ship/street3',
//		'text'     => 'Doruč. adresa – Ulice3',
//		'required' => FALSE
//	),
//	's_city' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/ship/city',
//		'text'     => 'Doruč. adresa – Město',
//		'required' => FALSE
//	),
//	's_state' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/ship/sp',
//		'text'     => 'Doruč. adresa – Stát',
//		'required' => FALSE
//	),
//	's_country' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/ship/cc',
//		'text'     => 'Doruč. adresa – Země',
//		'required' => FALSE
//	),
//	's_postcode' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/ship/pc',
//		'text'     => 'Doruč. adresa – PSČ',
//		'required' => FALSE
//	),
//	'm_address' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/mail/street',
//		'text'     => 'Koresp. adresa – Ulice',
//		'required' => FALSE
//	),
//	'm_address2' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/mail/street2',
//		'text'     => 'Koresp. adresa – Ulice2',
//		'required' => FALSE
//	),
//	'm_address3' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/mail/street3',
//		'text'     => 'Koresp. adresa – Ulice3',
//		'required' => FALSE
//	),
//	'm_city' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/mail/city',
//		'text'     => 'Koresp. adresa – Město',
//		'required' => FALSE
//	),
//	'm_state' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/mail/sp',
//		'text'     => 'Koresp. adresa – Stát',
//		'required' => FALSE
//	),
//	'm_country' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/mail/cc',
//		'text'     => 'Koresp. adresa – Země',
//		'required' => FALSE
//	),
//	'm_postcode' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/addr/mail/pc',
//		'text'     => 'Koresp. adresa – PSČ',
//		'required' => FALSE
//	),
//	'phone_home' => array(
//		'scheme'   => 'http://axschema.org/contact/phone/home',
//		'text'     => 'Telefon – Domácí',
//		'required' => FALSE
//	),
//	'phone_work' => array(
//		'scheme'   => 'http://axschema.org/contact/phone/business',
//		'text'     => 'Telefon – Pracovní',
//		'required' => FALSE
//	),
//	'fax' => array(
//		'scheme'   => 'http://axschema.org/contact/phone/fax',
//		'text'     => 'Telefon – Fax',
//		'required' => FALSE
//	),
//	'email2' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/email/notify',
//		'text'     => 'Email – Notifikační',
//		'required' => FALSE
//	),
//	'email3' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/email/next',
//		'text'     => 'Email – Další',
//		'required' => FALSE
//	),
//	'blog' => array(
//		'scheme'   => 'http://axschema.org/contact/web/blog',
//		'text'     => 'URL – Blog',
//		'required' => FALSE
//	),
//	'url2' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/url/personal',
//		'text'     => 'URL – Osobní',
//		'required' => FALSE
//	),
//	'url3' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/url/work',
//		'text'     => 'URL – Pracovní',
//		'required' => FALSE
//	),
//	'rss' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/url/rss',
//		'text'     => 'URL – RSS',
//		'required' => FALSE
//	),
//	'fb' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/url/facebook',
//		'text'     => 'URL – Facebook',
//		'required' => FALSE
//	),
//	'twitter' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/url/twitter',
//		'text'     => 'URL – Twitter',
//		'required' => FALSE
//	),
//	'linkedin' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/url/linkedin',
//		'text'     => 'URL – LinkedIN',
//		'required' => FALSE
//	),
//	'jabber' => array(
//		'scheme'   => 'http://axschema.org/contact/IM/Jabber',
//		'text'     => 'IM – Jabber',
//		'required' => FALSE
//	),
//	'gtalk' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/im/google_talk',
//		'text'     => 'IM – Google Talk',
//		'required' => FALSE
//	),
//	'wlive' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/im/windows_live',
//		'text'     => 'IM – Windows Live',
//		'required' => FALSE
//	),
//	'vat_id' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/contact/ident/vat_id',
//		'text'     => 'Identifikátor - ICO',
//		'required' => FALSE
//	),
//	'vat' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/contact/vat',
//		'text'     => 'Identifikátor - DIC',
//		'required' => FALSE
//	),
//	'op' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/contact/ident/card',
//		'text'     => 'Identifikátor – OP',
//		'required' => FALSE
//	),
//	'pas' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/contact/ident/pass',
//		'text'     => 'Identifikátor - PAS',
//		'required' => FALSE
//	),
//	'mpsv' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/contact/ident/ssn',
//		'text'     => 'Identifikátor - MPSV',
//		'required' => FALSE
//	),
//	'student' => array(
//		'scheme'   => 'http://specs.nic.cz/attr/contact/student',
//		'text'     => 'Příznak - Student',
//		'required' => FALSE
//	),
);

if($config->verification_level==='validation_adult_control'){
	$ax_attributes['adult']=array(
		'scheme'   => 'http://specs.nic.cz/attr/contact/adult',
		'text'     => 'Příznak – Starší 18 let',
		'required' => true
	);
}

if (empty($_SESSION['nonce'])) {
	$_SESSION['nonce'] = md5(uniqid());
}

// Functions
//function displayError($message) {
//	global $error;
//
//    $error = $message;
//
//    include('index.php');
//
//    exit(0);
//}

function &getStore() {
	global $CFG;
	$store_path = $CFG->dataroot.'/mojeid_cache';

	if (!file_exists($store_path) && !mkdir($store_path, 0777, true)) {
		echo 'Could not create the FileStore directory ' . $store_path . '.<br />' .
			 'Please check the effective permissions.';

		exit(0);
	}

	$return=new Auth_OpenID_FileStore($store_path);
	return $return;
}

function getScheme() {
	return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http');
}

function getReturnTo() {
	if ($_SERVER['SERVER_PORT'] == 80) {
		return HTTP_SERVER . '/auth/mojeid/api/finish.php';
	} else {
		return HTTP_SERVER . '/auth/mojeid/api/finish.php';
	}
}

function getTrustRoot() {
	if ($_SERVER['SERVER_PORT'] == 80) {
		return HTTP_SERVER;
	} else {
		return HTTP_SERVER;
	}
}

function &getConsumer() {
	$store = getStore();
	$consumer = new Auth_OpenID_Consumer($store);
//	$consumer =& new Auth_OpenID_Consumer($store);

	return $consumer;
}

function getEndPoint($action = 'endpoint') {
	if (TEST) {
		$endpoint = 'https://mojeid.fred.nic.cz/';
	} else {
		$endpoint = 'https://mojeid.cz/';
	}

	return $endpoint . trim($action, '/') . '/';
}