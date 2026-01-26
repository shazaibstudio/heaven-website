<?
include('../../includes/open_con.php');

if(post('act') == 'login')
{
	if(post('login') == '' || post('login') == 'Your Login ID')
		$errors .= '- Please enter your Username.\n';
	if(post('password') == '' || post('password') == '********************')
		$errors .= '- Please enter your Password.';
		
	if(!isset($errors))
	{
		$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."admin where login = ".$db->qstr(post('login'))." and pass = ".$db->qstr(post('password'))."");
		if($row['id'] != '')
		{
			set_session('ses_admin_id', $row['id']); 
			
			if(post('remember'))
				set_cookie(DB_TABLE_PREFIX.'admin', post('login').'~>'.post('password'), ((60*60)*24)*7);
			redirect('home.php');	
		}
		else
		{
			$errors .= '- Invalid Username or Password.';		
		}
	}
}

if(get('act') == 'logout')
{
	unset_session('ses_admin_id');
	unset_cookie(DB_TABLE_PREFIX.'admin');
	$msg = urlencode("You have successfully logged out.");
	redirect("index.php?msg=$msg&cs=ok");
}

if(get_cookie(DB_TABLE_PREFIX.'admin'))
{
	$admin_cookie = explode('~>', get_cookie(DB_TABLE_PREFIX.'admin'));
	$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."admin where login = ".$db->qstr($admin_cookie[0])." and pass = ".$db->qstr($admin_cookie[1])."");
	if($row['id'] != '')
	{
		set_session('ses_admin_id', $row['login']); 
		set_cookie(DB_TABLE_PREFIX.'admin', $row['login'].'~>'.$row['pass'], ((60*60)*24)*7);
		redirect('home.php');
	}
}

$g_page_title = 'Please login to continue';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description"  content=""/>
<meta name="keywords" content=""/>
<meta name="robots" content="ALL,FOLLOW"/>
<meta name="Author" content="AIT"/>
<meta http-equiv="imagetoolbar" content="no"/>
<title>
<?=print_admin_title($g_page_title);?>
</title>
<link rel="stylesheet" href="css/reset.css" type="text/css"/>
<link rel="stylesheet" href="css/screen.css" type="text/css"/>
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="css/ie7.css" />
<![endif]-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/jquery.datatables.js"></script>
<script type="text/javascript" src="js/Geometr231_Hv_BT_400.font.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</head>

<body class="no-side" onload="document.form1.login.focus();">
<div class="login-box">
  <div class="login-border">
    <div class="login-style">
      <div class="login-header">
        <div class="logo clear"><div style="text-align:center">
        <span class="title">
          <?=COMPANY_NAME;?> 
        - CMS Login</span></div> <span class="text" style="padding-top:15px;">Please enter your username/password to continue.</span> </div>
      </div>
      <form action="" name="form1" id="form1" method="post">
      	<div class="login-inside">
          <div class="login-data">
            <div class="row clear">
              <label for="user">Username:</label>
              <input type="text" size="25" class="text" id="login" name="login" />
            </div>
            <div class="row clear">
              <label for="password">Password:</label>
              <input type="password" size="25" class="text" id="password" name="password" />
            </div>
            <input type="submit" class="submit" value="Login" />
            <input name="act" type="hidden" id="act" value="login" />
          </div>
          <p>Press login to go to the Content Management System of <?=COMPANY_NAME;?>. </p>
        </div>
        <div class="login-footer clear"> <span class="remember">
          <input type="checkbox" class="checkbox" id="remember" name="remember" value="1" />
          <label for="remember">Remember</label>
          </span> <a href="../../" class="fr-space">Back to Main Site</a> </div>
      </form>
    </div>
  </div>
</div>
<?
if(get('msg') != '' || $errors != '')
{
	echo '<script language="javascript" type="text/javascript">
			caution(\''.urldecode(get('msg')).'\', \''.$errors.'\');
		</script>';		
}
?>
</body>
</html>