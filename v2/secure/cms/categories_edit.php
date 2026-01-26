<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	if($name == '')
		$errors .= '- Please enter category name.<br />';
	if($seo_name == '')
		$errors .= '- Please enter permalink name.<br />';
	if($pos == '')
		$errors .= '- Please enter position.<br />';
	elseif(!ctype_digit($pos))
		$errors .= '- Please enter only numeric value for position.<br />';
	if($_FILES['menu_pdf']['tmp_name'] != '')
	{
		$ext = strtolower(strrchr($_FILES['menu_pdf']['name'], '.'));
		if($ext != '.pdf')
			$errors .= 'Please upload only .PDF files for Menu.<br />';
	}
	
	if($errors == '')
	{
		if($del_file == 'Y')
		{
			$path = '../../up_data/pdfs/'.$old_file;
			if($old_file != '' && file_exists($path))
			unlink($path);
			$sql_menu = ", menu_file = '' ";
		}
		
		if($_FILES['menu_pdf']['tmp_name'] != '')
		{
			$path = '../../up_data/pdfs/'.$old_file;
			if($old_file != '' && file_exists($path))
			unlink($path);
			
			$menu_file = time().'_'.generate_file_name($_FILES['menu_pdf']['name'],'_');
			move_uploaded_file($_FILES['menu_pdf']['tmp_name'], '../../up_data/pdfs/'.$menu_file);
			$sql_menu = ", menu_file = '$menu_file' ";
		}
		
		$db->Execute("update ".DB_TABLE_PREFIX."categories set page_id = '$page_id', parent_id = '$parent_id', name = ".$db->qstr($name).", seo_name = ".$db->qstr($seo_name).", description = ".$db->qstr($description)." $sql_menu , pos = ".$db->qstr($pos).", status = ".$db->qstr($status)." where id = '$id'");
		
		if($db->ErrorNo() == 1062)
			$errors .= '- Category permalink name already exists.<br />';
		else
		{
			$msg = urlencode('Category updated successfully.');
			redirect("categories.php?msg=$msg");
		}
	}
	foreach($_POST as $k => $v)
		$$k = stripslashes($v);
}
else
{
	$row = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."categories WHERE id = '$id'");
	foreach($row as $k => $v)
		$$k = stripslashes($v);
}

$g_page_heading = 'Price List';
$g_section_heading = 'Modify Category';
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
            	<input type="hidden" name="parent_id" id="parent_id" value="0" />
              <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                <?php /*?><tr>
                  <td align="left" class="data_row">Parent Category: </td>
                  <td align="left">
                  	<select name="parent_id" id="parent_id">
                    	<option value="0">- No Parent Category -</option>
                        <?
                        	$cats = $db->Execute("select id, name from ".DB_TABLE_PREFIX."categories where parent_id = '0' and type = 'menu'  order by name asc");
							while(!$cats->EOF)
							{
								if($parent_id == $cats->fields('id')) $sl = 'selected="selected"'; else $sl = '';
								echo '<option value="'. $cats->fields('id') .'" '. $sl .'>'. stripslashes($cats->fields('name')) .'</option>';
								$cats->MoveNext();
							}	$cats->Close();
						?>
                  	</select>
                  </td>
                </tr><?php */?>
                <tr>
                  <td width="25%" align="left" class="data_row">Select Section:  * </td>
                  <td width="75%" align="left">
                    <label><input type="radio" name="page_id" id="page_id" value="4" <?php if($page_id == '4') echo 'checked="checked"'; ?> /> Salon Price List</label>
                    <label><input type="radio" name="page_id" id="page_id" value="5" <?php if($page_id == '5') echo 'checked="checked"'; ?> /> Be a Model</label>
                  </td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Name:  * </td>
                  <td width="75%" align="left"><input name="name" type="text" class="text" id="name" size="30" maxlength="128" value="<?=$name?>" onchange="gen_seo_name(this.value);" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Permalink Name: *</td>
                  <td align="left"><input name="seo_name" type="text" class="text" id="seo_name" size="30" maxlength="255" value="<?=$seo_name?>" />
                  <input type="hidden" name="table_name" id="table_name" value="categories" />
                  <input type="hidden" name="action" id="action" value="edit" />
                  Must be unique and without any special characters and spaces</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Description:</td>
                  <td align="left"><textarea name="description" cols="60" rows="6" class="text" id="description"><?=$description?></textarea></td>
                </tr>
                <?php /*?><tr>
                  <td align="left" class="data_row">Upload Menu PDF:</td>
                  <td align="left"><input name="menu_pdf" type="file" class="text" id="menu_pdf" size="30" />
                    (Only .PDF Files)
                    <?
					$path = '../../up_data/pdfs/'.$menu_file;
                    if($menu_file != '' && file_exists($path))
					{
						if($del_file == 'Y') $chk = 'checked="checked"';
						echo ' | <label><input type="checkbox" class="no_bdr" value="Y" name="del_file" id="del_file" '.$chk.' /> Delete this Menu PDF</label> | <a href="'.$path.'" target="_blank">Download Menu PDF</a>';
						echo '<input type="hidden" name="old_file" id="old_file" value="'. $menu_file .'" />';
					}
					?>
                    </td>
                </tr><?php */?>
                <tr>
                  <td align="left" class="data_row">Position: *</td>
                  <td align="left"><input name="pos" type="text" class="text" id="pos" size="30" maxlength="128" value="<?=$pos?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Status:</td>
                  <td align="left">
                  	<label>
                    <input type="radio" name="status" id="status" value="Y" <? if($status == '' || $status == 'Y') echo 'checked="checked"'; ?> />
                    Active</label>
                    <label>
                    <input type="radio" name="status" id="status" value="N" <? if($status == 'N') echo 'checked="checked"'; ?> />
                    In-active</label>
</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">* required
                    <input name="save" type="hidden" id="save" value="yes" />
                    <input name="id" type="hidden" id="id" value="<?=$id;?>" />
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
