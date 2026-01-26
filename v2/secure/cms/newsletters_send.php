<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	extract($_POST);
	
	if(sizeof($subscribers) == 0)
		$errors .= '- Please select at-least one subscriber to send newsletter.';
	if($subject == '')
		$errors .= '- Please enter newsletter subject.<br />';	
	if(trim(strip_tags($message)) == '')
		$errors .= '- Please enter newsletter message.<br />';
	
	if($errors == '')
	{
		$newsletter_id = $id;
		$sent_to_detail = 'Newsletter sent to '.sizeof($subscribers).' subscribers.';
		
		$db->Execute("insert into ".DB_TABLE_PREFIX."newsletters_sent set newsletter_id = ".$db->qstr($newsletter_id).", subject = ".$db->qstr($subject).", message = ".$db->qstr($message).", sent_to_detail = '$sent_to_detail', date_sent = '". date('Y-m-d H:i:s') ."'");
		$newsletter_sent_id = $db->Insert_ID();
		$db->Execute("update ".DB_TABLE_PREFIX."newsletters set date_sent = '". date('Y-m-d H:i:s') ."' where id = '$newsletter_id'");
		
		for($i = 0 ; $i < sizeof($subscribers) ; $i++)
		{
			$arr_ex = explode('##', $subscribers[$i]);
			$sid = $arr_ex[0];
			$sname = $arr_ex[1];
			$semail = $arr_ex[2];
			$sent_type = 'subscriber';
			
			$unsubscribe_link = '<a href="'.COMPANY_URL.'news-letter/un-subscribe?email='.$semail.'">Click here to unsubscribe from our mailing list</a>';			
			
			$subject_nl = str_replace('{SUBSCRIBER_NAME}', $sname, $subject);
			$subject_nl = str_replace('{COMPANY_NAME}', COMPANY_NAME, $subject_nl);
			
			$message_nl = str_replace('{SUBSCRIBER_NAME}', $sname, $message);
			$message_nl = str_replace('{COMPANY_NAME}', COMPANY_NAME, $message_nl);
			$message_nl = str_replace('{UNSUBSCRIBE_LINK}', $unsubscribe_link, $message_nl);
			$message_nl = str_replace('../../up_data/', BASE_PATH.'up_data/', $message_nl);

            $message_nl = str_replace(' ,', ',', $message_nl); // If there is any empty space, like subscriber name not exits.

			$subject_nl = stripslashes($subject_nl);
			$message_nl = stripslashes($message_nl);
			
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: ".COMPANY_NAME." <".COMPANY_INFO.">\r\nReply-To:".$email."\r\n";
			#echo $semail.'<hr />'.$subject_nl.'<hr />'.$message_nl;
			#continue;
			@mail($semail, $subject_nl, $message_nl, $headers);
		}
		
		$msg = urlencode('Newsletter sent successfully.');
		redirect("newsletters.php?msg=$msg");
	}
	foreach($_POST as $k => $v)
		$$k = stripslashes($v);
}
else
{
	$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."newsletters where id = '".get('id')."'");
	foreach($row as $k => $v)
		$$k = stripslashes($v);
}

$g_page_heading = 'Newsletters';
$g_section_heading = 'Send Newsletter';
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
                  <td width="25%" align="left" valign="top" class="data_row">Subscribers:</td>
                  <td width="75%" align="left">
				  <select name="subscribers[]" size="7" multiple="multiple" id="subscribers" class="text" style="height:100px;">
				  	<?
						$subs = $db->Execute("select id, name, email from ".DB_TABLE_PREFIX."subscribers where deleted = 'N' order by id asc");
						while(!$subs->EOF)
						{
							$val = stripslashes($subs->fields('id').'##'.$subs->fields('name').'##'.$subs->fields('email'));
							if(in_array($val, $subscribers))
								$sl = 'selected="selected"';
							else
								$sl = '';
                            $name = $subs->fields('name') == '' ? 'Unknown User' : $subs->fields('name');
							echo '<option value="'. $val .'" '. $sl .'>'. stripslashes($name.' ('. $subs->fields('email') .')') .'</option>';
							$subs->MoveNext();
						}	$subs->Close();
					?>
                  </select>
				  <br />
				  <label><input name="select_all_subs" type="checkbox" class="no_bdr" id="select_all_subs" onchange="for(var i = 0 ; i < document.getElementById('subscribers').options.length ; i++) document.getElementById('subscribers').options[i].selected = this.checked;" value="Y" /> 
				  Select All</label>                  </td>
                </tr>
                <tr>
                  <td align="left" class="data_row"> Subject: * </td>
                  <td align="left"><input name="subject" type="text" class="text"  id="subject" size="30" maxlength="128" value="<?=$subject?>" /></td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="data_row">Message: * </td>
                  <td align="left">
				  	<? include('tiny_mce_config.php'); ?>
                    <textarea id="message" name="message" class="mce" rows="15" cols="80" style="width: 100%; height:500px;"><?=$message?></textarea>		  </td>
                </tr>
                <tr>
                  <td align="left" class="data_row">* required
                    <input name="save" type="hidden" id="save" value="yes" />
					<input name="id" type="hidden" id="id" value="<?=get('id');?>" />					</td>
                  <td align="left"><input name="Submit" type="submit" class="submit" value="Send Newsletter" />                    </td>
                </tr>
				<tr>
                        <td height="28" colspan="2" align="left" valign="bottom"><strong>Note:</strong> To place <strong>subscriber/member name</strong> in newsletter, use {SUBSCRIBER_NAME} keyword. The {SUBSCRIBER_NAME} keyword will work for both subscribers and members. To put <strong>unsubscribe link</strong>, please {UNSUBSCRIBE_LINK} keyword in newsletter text. </td>
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
