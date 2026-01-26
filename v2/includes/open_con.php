<?php
session_start();
error_reporting(0);
include('adodb/adodb.inc.php');

//$db_host = 'localhost';
//$db_user = 'root';
//$db_pass = 'password';
//$db_name = 'heaven_hotel';

$db_host = 'localhost';
$db_user = 'heavenho_wbusr';
$db_pass = 'Dzd0cZ^T]?#8';
$db_name = 'heavenho_website';

$db = NewADOConnection('mysql');

$db->Connect($db_host, $db_user, $db_pass, $db_name);

include('global.php');
include('functions.php');

$base_tag = '<base href="'. BASE_PATH .'" />';

extract($_POST);
extract($_GET);