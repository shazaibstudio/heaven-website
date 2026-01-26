<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	if($sender_name == '')
		$errors .= '- Please enter customer name.<br />';
	if($sender_role == '')
		$errors .= '- Please enter company name / role.<br />';
	if(trim(strip_tags($details)) == '')
		$errors .= '- Please enter testimonial text.<br />';	
	
	if($errors == '')
	{	
		$db->Execute("insert into ".DB_TABLE_PREFIX."testimonials set 
						sender_name = ".$db->qstr($sender_name).", 
						sender_role = ".$db->qstr($sender_role).", 
						details = ".$db->qstr($details).", 						
						status = ".$db->qstr($status)."
						");
		$msg = urlencode('Testimonial added successfully.');
		redirect("testimonials.php?msg=$msg");
	}
	
	foreach($_POST as $k => $v)
		$$k = stripslashes($v);
}

$g_page_heading = 'Testimonials';
$g_section_heading = 'Add Testimonial';
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
           
            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

              <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                <tr>
                  <td width="25%" align="left" class="data_row"> Sender Name:  * </td>
                  <td width="75%" align="left"><input name="sender_name" type="text" class="text" id="sender_name" size="30" maxlength="128" value="<?=$sender_name?>" placeholder="e.g. John Smith" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Company Name / Rolw: *</td>
                  <td align="left"><input name="sender_role" type="text" class="text" id="sender_role" size="30" maxlength="255" value="<?=$sender_role?>" placeholder="e.g. Customer" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Testimonial Text: *</td>
                  <td align="left"><? include('tiny_mce_config.php'); ?>
                  <textarea id="details" name="details" class="mce" rows="15" cols="80" style="width: 100%; height:500px;"><?=$details;?></textarea></td>
                </tr>                
                <tr>
                  <td align="left" class="data_row">Status:</td>
                  <td align="left"><label>
                    <input type="radio" name="status" id="status" value="Y" <? if($status == '' || $status == 'Y') echo 'checked="checked"'; ?> />
                    Active</label>
                    <label>
                      <input type="radio" name="status" id="status" value="N" <? if($status == 'N') echo 'checked="checked"'; ?> />
                      In-active</label></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">* required
                    <input name="save" type="hidden" id="save" value="yes" />
                    </td>
                  <td align="left"><input name="Submit" type="submit" class="submit" value="Submit" />                    </td>
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
