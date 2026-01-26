<?
$now_time = date('Y-m-d H:i:s');
echo "SELECT s.email_address from ".DB_TABLE_PREFIX."subscribers s,
						".DB_TABLE_PREFIX."package_months p where s.id=p.subscriber_id and s.canceled=0 and s.status = 1
						and p.expiry_date >'$now_time' ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Perk Hog Administration Panel</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/scripts.js"></script>
</head>
<body onmousemove="closesubnav(event);">
<? include('includes/inc.header.php'); ?>
<div id="pagecell1"> <img alt="" src="images/tl_curve_white.gif" height="6" width="6" id="tl" /> <img alt="" src="images/tr_curve_white.gif" height="6" width="6" id="tr" />
  <? include('includes/inc.bread_crumb.php'); ?>
  <div id="pageName">
    <h2>&nbsp;</h2>
  </div>
  <div id="content">
    <div class="story">
      <table width="100%" cellpadding="0" cellspacing="0" summary="">
        <tr valign="top">
          <td height="350" class="storyLeft"><p>sfd asdf asfd </p></td>
        </tr>
      </table>
    </div>
  </div>
  <? include('includes/inc.footer.php'); ?>
</div>
</body>
</html>