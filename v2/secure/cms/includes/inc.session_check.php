<?
if(!get_session('ses_admin_id'))
{
	$msg = urlencode('Not logged in or session expired, please login to continue.');
	redirect("index.php?msg=$msg&cs=er");	
}

$SA = $_SESSION['ses_admin_access'];
