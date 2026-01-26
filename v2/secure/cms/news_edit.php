<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	if($name == '')
		$errors .= '- News title is a required field.<br />';
	if($seo_name == '')
		$errors .= '- Permalink is a required field.<br />';
	if(trim($short_detail) == '')
		$errors .= '- Short detail is a required field.<br />';
	if(trim(strip_tags($full_detail)) == '')
		$errors .= '- Full detail is a required field.<br />';
	if($_FILES['file_image']['tmp_name'] != '')
	{
		$ext = strtolower(strrchr($_FILES['file_image']['name'], '.'));
		if(!in_array($ext,$G_IMG_EXTS))
			$errors .= '- Please upload only '. implode(', ', $G_IMG_EXTS) .' image types.<br />';
	}
	if($news_date == '')
		$errors .= '- News date is a required field.<br />';
	
	if(!isset($errors))
	{
		$path = '../../up_data/news/'.$current_image;
		if($del_image == 'Y' && file_exists($path))
		{
			unlink($path);
			$sql_image = " src_image_file = '', ";
		}
		
		if($_FILES['file_image']['tmp_name'] != '')
		{
			if($current_image != '' && file_exists($path))
				unlink($path);
			
			$src_image_file = time().'_'.generate_file_name($_FILES['file_image']['name']);
			copy($_FILES['file_image']['tmp_name'], '../../up_data/news/'.$src_image_file);

			$sql_image = " src_image_file = '$src_image_file', ";
		}
		
		$db->Execute("update ".DB_TABLE_PREFIX."news set name = ".$db->qstr($name).", seo_name = ".$db->qstr($seo_name).", short_detail = ".$db->qstr($short_detail).", full_detail = ".$db->qstr($full_detail).", $sql_image news_date = '$news_date', s_group_id = '$s_group_id', is_latest = '$is_latest', status = '$status' where id = '$id'");
		
		if($db->ErrorNo() == 1062)
			$errors .= '- The permalink <strong>"'.$seo_name.'"</strong> already exists.';
		else
		{		
			$msg = urlencode('News "'.$name.'" updated successfully.');			
			redirect("news.php?msg=$msg&cs=ok");
		}
	}
	
	foreach($_REQUEST as $k => $v)
		$$k = stripslashes($v);
}
else
{
	$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."news where id = '".get('id')."'");
	foreach($row as $k => $v)
		$$k = stripslashes($v);
	$current_image = $src_image_file;
}

$g_page_heading = 'News';
$g_section_heading = 'Modify News';
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
		<script type="text/javascript">
        $(function() {
        	$("#news_date").datepicker({dateFormat:'yy-mm-dd'});	
        });
        </script>
            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                      <tr>
                        <td width="25%" align="left" class="data_row">  News Title:  * </td>
                        <td width="75%" align="left"><input name="name" type="text"  id="name" size="30" maxlength="128" value="<?=$name?>" onblur="seo_name_gen(this, this.form.seo_name);" onchange="gen_seo_name(this.value);" class="text" /></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row"> Permalink: * </td>
                        <td align="left"><input name="seo_name" type="text"  id="seo_name" size="30" maxlength="255" value="<?=$seo_name?>" class="text" /> 
                        <input type="hidden" name="table_name" id="table_name" value="news" />
                  <input type="hidden" name="action" id="action" value="add" />(Must be unique, without any special characters or space) </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" class="data_row">Short Description: * </td>
                        <td align="left"><textarea name="short_detail" cols="50" rows="5" id="short_detail"><?=$short_detail;?></textarea></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" class="data_row">Full Detail: *</td>
                        <td align="left">
                        	                        
                            <? include('tiny_mce_config.php'); ?>
                  <textarea name="full_detail" cols="60" rows="8" class="text mce" id="full_detail"><?=$full_detail?></textarea>
                            </td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">Upload  Image: </td>
                        <td align="left"><input name="file_image" type="file" id="file_image" class="text" size="30" />
                          (Upload only <?=implode(', ', $G_IMG_EXTS);?> image types) <?
							$path = '../../up_data/news/'.$src_image_file;
							if($src_image_file != '' && file_exists($path))
							{
								if($del_image == 'Y') $chk = 'checked="checked"';
								echo ' | <label><input type="checkbox" class="no_bdr" value="Y" name="del_image" id="del_image" '.$chk.' /> Delete this image</label> | <a href="'.$path.'" class="thickbox" title="Current Image">See Image</a>';
							}
						  ?></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">News  Date: * </td>
                        <td align="left"><input name="news_date" type="text"  id="news_date" size="30" maxlength="128" value="<?=$news_date?>" readonly="readonly" class="text" /></td>
                      </tr>
                      <?php /*?><tr>
                        <td align="left" class="data_row">Slider Settings: </td>
                        <td align="left"><select name="s_group_id" id="s_group_id" class="text">
                          <option value="0">Default Slider ...</option>
                          <?
                                $rs = $db->Execute("SELECT id, name FROM ".DB_TABLE_PREFIX."slides_groups ORDER BY name ASC");
                                while(!$rs->EOF)
                                {
                                    if($s_group_id == $rs->fields('id')) $sl = 'selected="selected"'; else $sl = '';
                                    echo '<option value="'. $rs->fields('id') .'" '. $sl .'>'. stripslashes($rs->fields('name')) .'</option>';
                                    $rs->MoveNext();
                                }	$rs->Close();
                            ?>
                        </select></td>
                      </tr><?php */?>
                      <tr>
                        <td align="left" class="data_row">Show on Home : </td>
                        <td align="left"><label>
                          <input name="is_latest" type="radio" class="no_bdr" value="Y" <? if($is_latest == '' || $is_latest == 'Y') echo 'checked="checked"'; ?> />
                          Yes </label>
                            <label>
                            <input name="is_latest" type="radio" class="no_bdr" value="N" <? if($is_latest == 'N') echo 'checked="checked"'; ?> />
                              No </label></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">Status:</td>
                        <td align="left"><label>
                          <input name="status" type="radio" class="no_bdr" value="Y" <? if($status == '' || $status == 'Y') echo 'checked="checked"'; ?> />
                          Active</label>
                            <label>
                              <input name="status" type="radio" class="no_bdr" value="N" <? if($status == 'N') echo 'checked="checked"'; ?> />
                              In-active</label></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">* required
                        <input name="save" type="hidden" id="save" value="yes" />
                        <input name="id" type="hidden" id="id" value="<?=$id;?>" />
						<input name="current_image" type="hidden" id="current_image" value="<?=$current_image;?>" />
                        </td>
                        <td align="left"><input name="Submit" type="submit" class="submit" value="Submit" /></td>
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
