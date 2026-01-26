<?
include('../../includes/open_con.php'); include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	extract($_POST);
	
	if($name == '')
		$errors .= '- Please enter name.<br />';
	if($email == '')
		$errors .= '- Please enter email address.<br />';	
	elseif(check_email($email) == false)
		$errors .= '- Please enter a valid email address.<br />';
	
	if($errors == '')
	{
		$db->Execute("update ".DB_TABLE_PREFIX."subscribers set name = ".$db->qstr($name).", email = ".$db->qstr($email).", phone = ".$db->qstr($phone)." where id = '$id'");
		
		if($db->ErrorNo() == 1062)
		{
			$errors = '- The email address you have entered is already exists.';
			$deleted = $db->GetOne("select deleted from ".DB_TABLE_PREFIX."subscribers where email = ".$db->qstr($email)."");			
			if($deleted == 'Y')
				$errors = '- The email address you have entered is already exists but it is in deleted subscribers list, please go to deleted subscribers list and change its status to subscribed.';
		}
		else
		{
			if($send_mail == 'Y')
			{
			
				/// E-mail to admin
				$email_text = $db->GetRow("select * from ".DB_TABLE_PREFIX."email_notifications where id = '2'");
				if($email_text['send_email'] == 'Y')
				{
					$subject = stripslashes(str_replace('{SUBSCRIBER_NAME}', $name, $email_text['subject']));
					$body = str_replace('{SUBSCRIBER_NAME}', $name, $email_text['email_text']);
					$body = str_replace('{SUBSCRIBER_EMAIL}', $email, $body);
					$body = str_replace('{SUBSCRIBER_PHONE}', $phone, $body);
					$body = str_replace('{SUBSCRIBE_DATE}', date('M d, Y H:i:s'), $body);
					$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
					
					$body = stripslashes('<div style="font-family:Tahoma; font-size:12px;">'.$body.'</div>');
					
					$headers  = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$headers .= "From: ".COMPANY_NAME." <".COMPANY_INFO.">\r\nReply-To:".$email."\r\n";
					
					@mail(COMPANY_INFO, $subject, $body, $headers);
				}
				/// E-mail to admin
				
				/// E-mail to subscriber
				$email_text = $db->GetRow("select * from ".DB_TABLE_PREFIX."email_notifications where id = '3'");
				if($email_text['send_email'] == 'Y')
				{
					$subject = stripslashes(str_replace('{COMPANY_NAME}', COMPANY_NAME, $email_text['subject']));
					$body = str_replace('{SUBSCRIBER_NAME}', $name, $email_text['email_text']);
					$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
					
					$un_subscribe_link = BASE_PATH.'news-letter/un-subscribe/'.base64_encode($email);
					$un_subscribe = '<a href="'.$un_subscribe_link.'">click here</a>';
					$un_subscribe_link = '<a href="'.$un_subscribe_link.'">'.$un_subscribe_link.'</a>';
					
					$body = str_replace('{CLICK_HERE}', $un_subscribe, $body);
					$body = str_replace('{UN_SUBSCRIBE_COMPLETE_LINK}', $un_subscribe_link, $body);
								
					$body = stripslashes('<div style="font-family:Tahoma; font-size:12px;">'.$body.'</div>');
					
					$headers  = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$headers .= "From: ".COMPANY_NAME." <".COMPANY_INFO.">\r\nReply-To:".$email."\r\n";
					
					@mail($email, $subject, $body, $headers);
				}
				/// E-mail to admin
			}
			$msg = urlencode('Subscriber updated successfully.');
			redirect("subscribers.php?msg=$msg");			
		}	
	}
	foreach($_POST as $k => $v)
		$$k = stripslashes($v);
}
else
{
	$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."subscribers where id = '".get('id')."'");
	foreach($row as $k => $v)
		$$k = stripslashes($v);
}

$g_page_heading = 'Newsletters';
$g_section_heading = 'Modify Subscriber';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
#$add_link = array('caption' => 'Add Subscriber', 'link' => 'subscribers_add.php');
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
<title>
<?=print_admin_title($g_page_title);?>
</title>
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
            <?=@caution(get("msg"),get("cs"),"h3", $errors);?>
            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                <tr>
                  <td width="25%" align="left" class="data_row"> Name:  * </td>
                  <td width="75%" align="left"><input name="name" type="text"  id="name" class="text" size="30" maxlength="64" value="<?=$name?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row"> E-mail Address: * </td>
                  <td align="left"><input name="email" type="text"  id="email" size="30" class="text" maxlength="255" value="<?=$email?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Phone Number: </td>
                  <td align="left"><input name="phone" type="text"  id="phone" class="text" size="30" maxlength="20" value="<?=$phone?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Send E-mails: </td>
                  <td align="left">
				  	<label>
					<input name="send_mail" type="checkbox" class="no_bdr" id="send_mail" value="Y" <? if($send_mail == 'Y') echo 'checked="checked"'; ?> />
                    Send newsletter subscription emails to admin and subscriber.</label> </td>
                </tr>
                <tr>
                  <td align="left" class="data_row">* required
                    <input name="save" type="hidden" id="save" value="yes" />
                    <input name="id" type="hidden" id="id" value="<?=get('id');?>" /></td>
                  <td align="left"><input name="Submit" type="submit" class="submit" value="Update Subscriber" />                    </td>
                </tr>
              </table>
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
