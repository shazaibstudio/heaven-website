<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	extract($_POST);
			
	if($name == '')
		$errors .= '- Name is a required field.<br />';
	if($short_detail == '')
		$errors .= '- Short detail is a required field.<br />';	
	
	
	if($_FILES['src_icon_file']['tmp_name'] == '')
		$errors .= '- Please upload image.<br />';
	else
	{
		$ext = strtolower(strrchr($_FILES['src_icon_file']['name'], '.'));
		if(!in_array($ext, $G_IMG_EXTS))
			$errors .= '- Please select '.implode(', ',$G_IMG_EXTS).' images to upload.<br />';
	}
	
	if($pos == '')
		$errors .= '- Display position is a required field.<br />';	
	elseif(!ctype_digit($pos))
		$errors .= '- Display position should be a numeric value.<br />';			
	
	if(!isset($errors))
	{
		
		$src_icon = time().'_'.generate_file_name($_FILES['src_icon_file']['name']);
		move_uploaded_file($_FILES['src_icon_file']['tmp_name'], '../../up_data/icons/'.$src_icon);		
		
		$db->Execute("insert into ".DB_TABLE_PREFIX."home_items set name = ".$db->qstr($name).", short_detail = ".$db->qstr($short_detail).", src_icon = '$src_icon', link_url = ".$db->qstr($link_url).", target = ".$db->qstr($target).", pos = '".$pos."', status = '$status'");
		
		$msg = urlencode('Home page item added successfully.');			
		redirect("home_items.php?msg=$msg&cs=ok");
	}
	
	foreach($_REQUEST as $k => $v)
		$$k = stripslashes($v);
}
else
{
	$pos = $db->GetOne("select max(pos) as mx_id from ".DB_TABLE_PREFIX."home_items") + 1;
}

$g_page_heading = 'Home Blocks';
$g_section_heading = 'Add Home Block';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/cms_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
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
            
            <!-- CONTENT -->           
            
            
            <!-- Custom Forms --><!-- /#forms --> 
          <!-- InstanceBeginEditable name="txt" -->
                  <?=@caution(get("msg"),get("cs"),"h3", $errors);?>
                  <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                      <tr>
                        <td width="25%" align="left" class="data_row">  Name: * </td>
                        <td width="75%" align="left"><input name="name" type="text"  id="name" size="30" maxlength="128" value="<?=$name?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" class="data_row">Short Detail: * </td>
                        <td align="left"><textarea name="short_detail" cols="50" rows="5" id="short_detail"><?=$short_detail?></textarea></td>
                      </tr>
                      
                      <tr>
                        <td align="left" class="data_row">Picture: * </td>
                        <td align="left"><input name="src_icon_file" type="file" id="src_icon_file" size="30" />
(Only .JPG, .GIF or .PNG Images) </td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">Display Position: * </td>
                        <td align="left"><input name="pos" type="text"  id="pos" size="30" maxlength="4" value="<?=$pos?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">Link URL:</td>
                        <td align="left"><input name="link_url" type="text" id="link_url" size="30" maxlength="255" value="<?=$link_url;?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">Link Target:</td>
                        <td align="left"><label>
                          <input name="target" type="radio" class="no_bdr" value="_self" <? if($target == '' || $target == '_self') echo 'checked="checked"'; ?> />
Same Window</label>
                          <label>
                          <input name="target" type="radio" class="no_bdr" value="_blank" <? if($target == '_blank') echo 'checked="checked"'; ?> />
New Window</label></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">Status: </td>
                        <td align="left"><label>
                          <input name="status" type="radio" class="no_bdr" value="Y" <? if($status == '' || $status == 'Y') echo 'checked="checked"'; ?> />
Active</label>
                          <label>
                          <input name="status" type="radio" class="no_bdr" value="N" <? if($status == 'N') echo 'checked="checked"'; ?> />
In-active</label></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">* required
                        <input name="save" type="hidden" id="save" value="yes" /></td>
                        <td align="left"><input name="Submit" type="submit" class="submit" value="Submit" />
                          <?php /*?><input name="Submit2" type="button" class="btns" value="Preview Landing Page" /><?php */?>                        </td>
                      </tr>                      
                    </table>
            </form>
          <!-- InstanceEndEditable --></div>
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
