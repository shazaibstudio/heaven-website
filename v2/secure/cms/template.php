<?
include('../../includes/open_con.php'); include('includes/inc.session_check.php');
$g_page_title = 'Welcome';
$bread_crumb = 'Home / Manage / '.$g_page_title;		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?=print_admin_title($g_page_title);?>
</title>

<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/smoothness/jquery.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery_ui.js"></script>
<script type="text/javascript" language="javascript" src="js/scripts.js"></script>
</head>
<body>
<? include('includes/inc.header.php'); ?>
<div id="pagecell1"> <img alt="" src="images/tl_curve_white.gif" height="6" width="6" id="tl" /> <img alt="" src="images/tr_curve_white.gif" height="6" width="6" id="tr" />
  <? include('includes/inc.bread_crumb.php'); ?>
  <div id="pageName">
    <h2><?=$g_page_title;?></h2>
  </div>
  <div id="content">
    <div class="story">
      <table width="100%" cellpadding="0" cellspacing="0" summary="">
        <tr valign="top">
          <td height="350" class="storyLeft">
				  
		  </td>
        </tr>
      </table>
    </div>
  </div>
  <? include('includes/inc.footer.php'); ?>
</div>
</body>
</html>
