<?php
ob_start("ob_gzhandler");
error_reporting(1);
session_start();

/* DATABASE CONFIGURATION */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ajuwaya');
define("BASE_URL", "http://localhost/ajuwaya/");
define("API_BASE_URL", "http://localhost/ajuwaya/");
define("UPLOAD_PATH", "uploads/");



/*SMTP CONFIGURATIONS */
define("SMTP_CONNECTION", "0"); //On "1" Off "0"
define("SMTP_USERNAME", "");
define("SMTP_PASSWORD", "");
define("SMTP_HOST", "");
define("SMTP_PORT", "");
define("SMTP_FROM_EMAIL", ""); //Your website supprot email.
define("SMTP_FROM_TITLE", "WallScript Support"); //eg: Support WebsiteName
/*SMTP CONFIGURATIONS END*/


function getDB()
{
	$dbhost=DB_SERVER;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	$dbname=DB_DATABASE;
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbConnection->exec("set names utf8mb4");
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}
/* DATABASE CONFIGURATION END */


/*SITE DETAILS */
function siteDetails()
{
	$db = getDB();
	$stmt = $db->prepare("SELECT applicationName,applicationDesc,applicationToken FROM configurations WHERE con_id='1'");  
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$data = json_decode(json_encode($row),true);
	$db = null;
	return $data;
}

$siteData=siteDetails();
define("SITE_KEY", $siteData['applicationToken']);
define("SITE_NAME", $siteData['applicationName']);
define("SITE_DESC", $siteData['applicationDesc']);


/*SITE DETAILS END*/
function templateOrderData()
{
	$db = getDB();
	$stmt = $db->prepare("SELECT t_id,t_name,t_file,t_order FROM template ORDER BY t_order ASC");  
	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	$data = json_decode(json_encode($row),true);
	$db = null;
	return $data;
}
