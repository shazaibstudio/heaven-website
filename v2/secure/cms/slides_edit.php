<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	if($group_id == '')
		$errors .= '- Please select slide group.<br />';
	if($name == '')
		$errors .= '- Please enter slide name.<br />';
	if($detail == '')
		$errors .= '- Please enter slide description.<br />';
	
	if($_FILES['src_image_file']['tmp_name'] != '')
	{
		$ext = strtolower(strrchr($_FILES['src_image_file']['name'], '.'));
		if(!in_array($ext, $G_IMG_EXTS))
			$errors .= '- Please upload only .JGP, .PNG or .GIF images.<br />';
	}
	
	if($errors == '')
	{
		if($_FILES['src_image_file']['tmp_name'] != '')
		{
			$src_image = $db->GetOne("select src_image from ".DB_TABLE_PREFIX."slides where id = '$id'");
			$path = '../../up_data/slides/'.$src_image;
			if($src_image != '' && file_exists($path)) unlink($path);
			
			$src_image = time().'_'.generate_file_name($_FILES['src_image_file']['name']);
			move_uploaded_file($_FILES['src_image_file']['tmp_name'], '../../up_data/slides/'.$src_image);
			$sql_image = "src_image 	= ".$db->qstr($src_image).", ";
		}
		
		$sql = "update ".DB_TABLE_PREFIX."slides set 
				group_id 	= ".$db->qstr($group_id).", 
				name 		= ".$db->qstr($name).", 
				detail 		= ".$db->qstr($detail).", 
				$sql_image
				link_url 	= ".$db->qstr($link_url).", 
				target 		= ".$db->qstr($target).", 
				status 		= '$status'
				where id = '$id'
				";
		
		$db->Execute($sql);
		$msg = urlencode('Slide updated successfully.');
		redirect("slides.php?msg=$msg");
	}
	
	foreach($_POST as $k => $v)
		$$k = stripslashes($v);
}
else
{
	$row = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."slides WHERE id = '$id'");
	foreach($row as $k => $v)
		$$k = stripslashes($v);
}


$g_page_heading = 'Manage Slides';
$g_section_heading = 'Modify Slide';
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
                  <td align="left" class="data_row">Slide Group: *</td>
                  <td align="left">
                  <select name="group_id" id="group_id" class="text">
                    <option value="">Please Select ...</option>
                    <?
                    	$rs = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."slides_groups ORDER BY name ASC");
						while(!$rs->EOF)
						{
							if($group_id == $rs->fields('id')) $sl = 'selected="selected"'; else $sl = '';
							echo '<option value="'. $rs->fields('id') .'" '. $sl .'>'. stripslashes($rs->fields('name')) .'</option>';
							$rs->MoveNext();
						}	$rs->Close();
					?>
                  </select>
                  </td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Name:  * </td>
                  <td width="75%" align="left"><input name="name" type="text"  id="name" size="30" maxlength="128" value="<?=$name?>" class="text" /></td>
                </tr>
                <tr>
                  <td class="data_row">Description: *</td>
                  <td class="td_bdr"><textarea name="detail" cols="50" rows="5" class="text" id="detail"><?=$detail?></textarea></td>
                </tr>
                <tr>
                  <td class="data_row">Upload Slide Image: </td>
                  <td class="td_bdr"><input name="src_image_file" type="file" id="src_image_file" size="30" />
                    (Only .JGP, .PNG or .GIF images) | <a href="../../up_data/slides/<?=$src_image;?>" target="_blank">Uploaded Image</a></td>
                </tr>
                <tr>
                  <td class="data_row">Link URL:</td>
                  <td class="td_bdr"><input name="link_url" type="text"  id="link_url" size="30" maxlength="255" value="<?=$link_url?>" class="text" /></td>
                </tr>
                <tr>
                  <td class="data_row">Link Target:</td>
                  <td class="td_bdr"><input name="target" type="radio" class="no_bdr" value="_blank" <? if($target == '_blank') echo ' checked="checked"'; ?> />
New Window
  <input name="target" type="radio" class="no_bdr" value="_self"  <? if($target == '' || $target == '_self') echo ' checked="checked"'; ?> /> 
  Same Window
</td>
                </tr>
                <tr>
                  <td class="data_row">Status:</td>
                  <td class="td_bdr"><input name="status" type="radio" class="no_bdr" value="Y" <? if($status == '' || $status == 'Y') echo ' checked="checked"'; ?> />
                    Yes
                    <input name="status" type="radio" class="no_bdr" value="N"  <? if($status == 'N') echo ' checked="checked"'; ?> />
                    No</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">* required
                    <input name="save" type="hidden" id="save" value="yes" />
                    <input name="id" type="hidden" id="id" value="<?=$id;?>" /></td>
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
