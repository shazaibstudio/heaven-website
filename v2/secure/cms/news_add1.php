<?
include('../../includes/open_con.php'); include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	extract($_POST);
			
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
		if($_FILES['file_image']['tmp_name'] != '')
		{
			$src_image_file = time().'_'.generate_file_name($_FILES['file_image']['name']);
			copy($_FILES['file_image']['tmp_name'], '../up_data/news/'.$src_image_file);
		}
		else $src_file_name = '';
		
		$news_date = date('Y-m-d', strtotime($news_date));
		$db->Execute("insert into ".DB_TABLE_PREFIX."news set name = ".$db->qstr($name).", seo_name = ".$db->qstr($seo_name).", short_detail = ".$db->qstr($short_detail).", full_detail = ".$db->qstr($full_detail).", src_image_file = '$src_image_file', news_date = '$news_date', is_latest = '$is_latest', status = '$status'");
		
		if($db->ErrorNo() == 1062)
			$errors .= '- The permalink <strong>"'.$seo_name.'"</strong> already exists.';
		else
		{		
			$msg = urlencode('News "'.$name.'" added successfully.');			
			redirect("news.php?msg=$msg&cs=ok");
		}
	}
	
	foreach($_REQUEST as $k => $v)
		$$k = stripslashes($v);
}

$g_page_title = 'Add News';
$bread_crumb = 'Home / Manage News / '.$g_page_title;	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title><?=print_admin_title($g_page_title);?></title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/smoothness/jquery.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery_ui.js"></script>
<script type="text/javascript" language="javascript" src="js/scripts.js"></script>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript">
$(function() {
	$("#news_date").datepicker();	
});
</script>
<!-- InstanceEndEditable -->
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
          <td height="350" class="storyLeft"><!-- InstanceBeginEditable name="txt" -->
                  <?=@caution(get("msg"),get("cs"),"h3", $errors);?>
                  <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                      <tr>
                        <td width="25%" align="left" class="data_row">  News Title:  * </td>
                        <td width="75%" align="left"><input name="name" type="text"  id="name" size="30" maxlength="128" value="<?=$name?>" onblur="seo_name_gen(this, this.form.seo_name);" /></td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row"> Perma Link: * </td>
                        <td align="left"><input name="seo_name" type="text"  id="seo_name" size="30" maxlength="255" value="<?=$seo_name?>" /> 
                        (Must be unique, without any special characters or space) </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" class="data_row">Short Description: * </td>
                        <td align="left"><textarea name="short_detail" cols="50" rows="5" id="short_detail"><?=$short_detail;?></textarea></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" class="data_row">Full Detail: *</td>
                        <td align="left">
                        	<?
							
							require_once('editor/fckeditor.php');
							$oFCKeditor = new FCKeditor('full_detail') ;
							$oFCKeditor->BasePath = 'editor/';
							$oFCKeditor->Config['SkinPath'] = 'skins/silver/' ;
							$oFCKeditor->Value = $full_detail;
							$oFCKeditor->Create() ;
							?>                        </td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">Upload  Image: </td>
                        <td align="left"><input name="file_image" type="file" id="file_image" size="30" />
                          (Upload only <?=implode(', ', $G_IMG_EXTS);?> image types)</td>
                      </tr>
                      <tr>
                        <td align="left" class="data_row">News  Date: * </td>
                        <td align="left"><input name="news_date" type="text"  id="news_date" size="30" maxlength="128" value="<?=$news_date?>" readonly="readonly" /></td>
                      </tr>
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
                        <input name="save" type="hidden" id="save" value="yes" /></td>
                        <td align="left"><input name="Submit" type="submit" class="btns" value="Add News" /></td>
                      </tr>
                    </table>
            </form>
          <!-- InstanceEndEditable --></td>
        </tr>
      </table>
    </div>
  </div>
  <? include('includes/inc.footer.php'); ?>
</div>
</body>
<!-- InstanceEnd --></html>
