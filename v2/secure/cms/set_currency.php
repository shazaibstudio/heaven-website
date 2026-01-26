<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

//http://finance.yahoo.com/q?s=GBPUSD=X

set_session('ses_curr', $curr);

$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."currencies where id = '$curr'");
$_SESSION['ses_curr'] = $row;

#echo '<pre>';
#print_r($_SESSION['ses_curr']);
#exit;

redirect($_SERVER['HTTP_REFERER']);