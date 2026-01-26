<?
include('../../includes/open_con.php'); include('includes/inc.session_check.php');

if(post('update'))
{
	if($btn_submit == 'Show Selected')
	{
		$id = $db->GetOne("select id from ".DB_TABLE_PREFIX."email_notifications where name = '". $keywords ."'");
		if($id == '')
		{
			$msg = urlencode('Could not find any matching e-mail notification template.');
			redirect("email_notifications.php?msg=$msg&cs=er");
		}	
		redirect("email_notifications.php?id=$id&search=yes");
	}
	
	$db->Execute("update ".DB_TABLE_PREFIX."email_notifications set subject = ".$db->qstr(post('subject')).", email_text = ".$db->qstr(post('page_text')).", send_email = '".post('send_email')."', email_address = ".$db->qstr(post('email_address'))." where id = ".post('id'));
	$msg = urlencode("E-mail notification Updated successfully.");
	redirect("email_notifications.php?msg=$msg&cs=ok&id=".post('id'));
}

if(get('id')) $page_id = get('id');
else $page_id = 1;

$page_text = $db->GetRow("select * from ".DB_TABLE_PREFIX."email_notifications where id = $page_id");

$g_page_heading = 'Content Management';
$g_section_heading = 'E-mail Notifications';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/cms_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description"  content=""/>
<meta name="keywords" content=""/>
<meta name="robots" content="ALL,FOLLOW"/>
<meta name="Author" content="AIT"/>
<meta http-equiv="imagetoolbar" content="no"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title><?=print_admin_title($g_page_title);?></title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/reset.css" type="text/css"/>
<link rel="stylesheet" href="css/screen.css" type="text/css"/>
<link rel="stylesheet" href="css/jquery.ui.css" type="text/css"/>
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="css/ie7.css" />
<![endif]-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.datatables.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/excanvas.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/Geometr231_Hv_BT_400.font.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/thickbox.js"></script>
</head>

<body>
<div class="clear">
  <? include('includes/inc.menu.php'); ?>
  <div class="main"> <!-- *** mainpage layout *** -->
    <div class="main-wrap">
      <? include('includes/inc.header.php'); ?>
      <div class="page clear">
        <? include('includes/inc.section_header.php'); ?>
        
        <!-- CONTENT BOXES -->
        <div class="content-box">
          <div class="box-header clear">
            <h2>
              <?=$g_section_heading;?>
            </h2>
          </div>
          <div class="box-body clear"> 
            <!-- CONTENT -->
            <!-- InstanceBeginEditable name="txt" -->

            
        <form id="frm_page_editor" name="frm_page_editor" method="post" action="">
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                <tr class="smpText">
                  <td width="20%" class="data_row">Select E-mail Template:</td>
                  <td>
                    <select name="page_id" class="text" id="page_id" onchange="location.href='email_notifications.php?id='+this.value;" style="width:400px;">
                      <?
				   $rs_pages = $db->Execute("select id, name from ".DB_TABLE_PREFIX."email_notifications order by name asc");
				   while(!$rs_pages->EOF)
				   {
				   ?>
                      <option value="<?=$rs_pages->fields('id')?>" <? if(get('id') == $rs_pages->fields('id')) { echo 'selected="selected"'; $keywords = $rs_pages->fields('name'); } ?>>
                      	<?=$rs_pages->fields('name')?>
                      </option>
                      <?
				   		$rs_pages->MoveNext();
				   }	$rs_pages->Close();
				   ?>
                  </select>                    &nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr class="smpText">
                  <td class="data_row">Subject:</td>
                  <td><input name="subject" type="text" id="subject" value="<?=stripslashes($page_text['subject'])?>" style="width:395px;" class="text" /></td>
                </tr>
                <tr class="smpText">
                  <td valign="top" class="data_row">Send this E-mail: </td>
                  <td valign="top">
				  	<label>
					<input name="send_email" type="radio" class="no_bdr" value="Y" <? if($page_text['send_email'] == 'Y') echo 'checked="checked"'; ?> /> 
                    Yes</label>
					<label>
                    <input name="send_email" type="radio" class="no_bdr" value="N" <? if($page_text['send_email'] == 'N') echo 'checked="checked"'; ?> />
                    No</label>
				   </td>
                </tr>
                <tr class="smpText">
                  <td valign="top" class="data_row">E-mail Address: </td>
                  <td valign="top"><input name="email_address" type="text" id="email_address" value="<?=stripslashes($page_text['email_address'])?>" maxlength="255" style="width:395px;" class="text" /> (comma separate multiple email addresses)</td>
                </tr>
                <tr class="smpText">
                  <td colspan="2" valign="top" class="data_row">Notification Text:</td>
                </tr>
                <tr>
                  <td height="23" colspan="2" valign="top">
				  	<? include('tiny_mce_config.php'); ?>
                    <textarea id="page_text" name="page_text" class="mce" rows="15" cols="80" style="width: 100%; height:500px;"><?=$page_text['email_text']?></textarea></td>
                </tr>
                
                <tr>
                  <td colspan="2" class="data_row"><input name="update" type="hidden" id="update" value="true" />
                  <input name="id" type="hidden" id="id" value="<?=$page_id?>" />                  
                  <input name="btn_submit" type="submit" class="submit" id="btn_submit" value="Update" /></td>
                </tr>
                <tr>
                  <td height="22" colspan="2" valign="bottom" class="data_row"><strong>Note:</strong> Please do not change text within {} e.g. {MEMBER_NAME}</td>
                </tr>
  </table>
            <br />
        </form>
<!-- InstanceEndEditable -->
            
            
            
            <!-- CONTENT -->           
            
            
            <!-- Custom Forms --><!-- /#forms --> 
          </div>
          <!-- end of box-body --> 
        </div>
        <!-- end of content-box --><!-- end of content-box --><!-- end of content-box --><!-- /.content-box --><!-- /.clear --><!-- end of content-box --><!-- end of content-box --></div>
      <!-- end of page -->
      
      <? include('includes/inc.footer.php'); ?>
    </div>
  </div>
</div>
</body>
<!-- InstanceEnd --></html>
