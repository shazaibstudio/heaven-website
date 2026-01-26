<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	if($name == '')
		$errors .= '- Please enter certificate name.<br />';
	if($seo_name == '')
		$errors .= '- Please enter slug.<br />';
	if($price == '')
		$errors .= '- Please enter price/fee.<br />';
	elseif(!is_numeric($price))
		$errors .= '- Please enter only numeric value for price/fee.<br />';
	if(trim(strip_tags($details)) == '')
		$errors .= '- Please enter details.<br />';	
	if($_FILES['file_image']['tmp_name'] == '')
		$errors .= '- Please select picture to upload.<br />';	
	if($_FILES['file_image']['tmp_name'] != '')
	{
		$ext = strtolower( strrchr($_FILES['file_image']['name'], '.') );
		if(!in_array($ext,$G_IMG_EXTS))
			$errors .= '- Please upload only JPG, PNG or GIF images.';
	}
	if($duration == '')
		$errors .= '- Please enter duration.<br />';	
	
	if($errors == '')
	{
		if($_FILES['file_image'] != '')
		{
			$src_image = time().'_'.generate_file_name($_FILES['file_image']['name'],'_');
			$dest = '../../up_data/courses/'.$src_image;
			move_uploaded_file($_FILES['file_image']['tmp_name'], $dest);
		}
		
		$db->Execute("insert into ".DB_TABLE_PREFIX."courses set 
						type = ".$db->qstr($type).", 
						name = ".$db->qstr($name).", 
						seo_name = ".$db->qstr($seo_name).", 
						price = ".$db->qstr($price).", 
						details = ".$db->qstr($details).", 
						src_image = ".$db->qstr($src_image).",
						duration = ".$db->qstr($duration).", 
						certificate = ".$db->qstr($certificate).", 
						status = ".$db->qstr($status)."
						");
		
		$msg = urlencode('Course added successfully.');
		redirect("courses.php?msg=$msg&type=$type");
	}
	foreach($_POST as $k => $v)
		$$k = stripslashes($v);
}

$g_page_heading = 'Courses';
$g_section_heading = 'Add '.substr($G_COURSE_TYPES[$type],0,-1);
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
            	<input type="hidden" name="type" id="type" value="<?=$type;?>" />
              <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                <tr>
                  <td width="25%" align="left" class="data_row"> Name:  * </td>
                  <td width="75%" align="left"><input name="name" type="text" class="text" id="name" size="30" maxlength="128" value="<?=$name?>" onchange="gen_seo_name(this.value);" placeholder="The name of Course" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Slug: *</td>
                  <td align="left"><input name="seo_name" type="text" class="text" id="seo_name" size="30" maxlength="255" value="<?=$seo_name?>" placeholder="Permalink Name of Course" />
                    <input type="hidden" name="table_name" id="table_name" value="courses" />
                    <input type="hidden" name="action" id="action" value="add" />
Must be unique and without any special characters and spaces</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Fee / Price: *</td>
                  <td align="left"><input name="price" type="text" class="text" id="price" size="30" maxlength="255" value="<?=$price?>" placeholder="e.g. &pound;149.95" /> GBP (Only numeric values)</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Details: *</td>
                  <td align="left"><? include('tiny_mce_config.php'); ?>
                  <textarea id="details" name="details" class="mce" rows="15" cols="80" style="width: 100%; height:500px;"><?=$details;?></textarea></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Picture: *</td>
                  <td align="left"><input name="file_image" type="file" id="file_image" size="30" />
                    (Only JPG, PNG or GIF images)</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Duration: *</td>
                  <td align="left"><input name="duration" placeholder="1 Day" type="text" class="text" id="duration" size="30" maxlength="64" value="<?=$duration?>" /> (e.g. 1 Day, 1 Week, 1 Month)</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Certificate:</td>
                  <td align="left">
                  <select name="certificate" id="certificate">
                    <option value="0">No Certificate for this Course ...</option>
                    <?
                    	$rs = $db->Execute("SELECT id, name FROM ".DB_TABLE_PREFIX."certificates ORDER BY name ASC");
						while(!$rs->EOF)
						{
							if($certificate == $rs->fields('id')) $sl = 'selected="selected"'; else $sl = '';
							echo '<option value="'. $rs->fields('id') .'" '. $sl .'>'. stripslashes($rs->fields('name')) .'</option>';
							$rs->MoveNext();
						}	$rs->Close();
					?>
                  </select>
                  </td>
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
                    <input name="type" type="hidden" id="type" value="<?=$type;?>" />
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
