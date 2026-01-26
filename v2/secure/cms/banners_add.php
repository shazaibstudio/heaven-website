<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('insert'))
{
	extract($_POST);
	
	if($area_id == '_')
		$errors .= ' - Please select area for this banner.<br />';
	if(trim($name) == '')
		$errors .= ' - Please enter banner name.<br />';
	if($banner_code == '' && $_FILES['banner']['tmp_name'] == '')
		$errors .= ' - Please Select Banner to Upload.<br />';
	

	if(!isset($errors))
	{
		$ext = substr($_FILES["banner"]["name"],-4);
		if($page_id == 'news') $page_id = 0;
		
		$db->Execute("insert into ".DB_TABLE_PREFIX."banners set area_id = '".$area_id."', name = ".$db->qstr(post('name')).", detail = ".$db->qstr(post('detail')).", modifyDate = '".time()."', ext = '$ext', linkURL = ".$db->qstr(post("link")).", target = '".post("target")."', banner_code = ".$db->qstr(post('banner_code')).", status = '".$_POST["status"]."'");	
			
		if($_FILES["banner"]["tmp_name"] != "")
			copy($_FILES["banner"]["tmp_name"], "../../up_data/banners/banner". $db->Insert_ID() . $ext);
		
		$msg = urlencode("Banner saved successfully.");
		redirect("banners.php?msg=$msg&cs=ok");
	}
}

$g_page_heading = 'Content Management';
$g_section_heading = 'Add Banner';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
#$add_link = array('caption' => 'Add Subscriber', 'link' => 'subscribers_add.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/cms_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
            
<script language="JavaScript" type="text/javascript">
<!--
function set_size_text(v){
	<?
	$areas1 = $db->Execute("select id,size_info from ".DB_TABLE_PREFIX."banner_areas order by id asc");
		echo '
		if(v == "_") 
		{
			document.getElementById("size_text").innerHTML = "";
			return;
		}
		';
		while(!$areas1->EOF){
			echo '
			
			else if(v == '.$areas1->fields('id').'){
				document.getElementById("size_text").innerHTML = "'.$areas1->fields('size_info').'";
				return;
			}
			';
				$areas1->MoveNext();
			} $areas1->Close();
   ?>
	
}
-->
</script>            
            
            <form action="" method="post" enctype="multipart/form-data" id="form1">
              <table width="100%"  border="0" cellpadding="2" cellspacing="1" class="one_px_bdr">
                <tr>
                  <td width="25%" class="data_row"> Select Banner Area: *</td>
                  <td width="75%" class="td_bdr"><select name="area_id" id="area_id" onchange="set_size_text(this.value)">
                    <option value="_" selected="selected">Please Select ... </option>
                    <?
						$areas = $db->Execute("select * from ".DB_TABLE_PREFIX."banner_areas order by id asc");
						while(!$areas->EOF)
						{
							if(req('area_id') == $areas->fields('id')) $sel = "selected"; else $sel = "";
							echo '<option value="'.$areas->fields('id').'" '.$sel.'>'.$areas->fields('title').'</option>';
							$areas->MoveNext();
						} $areas->Close();			
						?>
                  </select>
                    &nbsp; <span id="size_text">
                      <? if($area_id != '') echo stripslashes($db->GetOne("select size_info from ".DB_TABLE_PREFIX."banner_areas where id = '$area_id'")); ?>
                    </span></td>
                </tr>
                <tr>
                  <td class="data_row">Banner Name: *<font class="required">&nbsp;</font></td>
                  <td class="td_bdr"><input name="name" type="text" class="text" id="name" size="30" maxlength="50" value="<?=stripslashes(post('name'));?>" /></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Description Text: <span class="required"></span></td>
                  <td class="td_bdr">
                  <? // include('tiny_mce_config.php'); ?>
                  <textarea name="detail" cols="50" rows="5" id="detail"><?=stripslashes(post('detail'));?></textarea></td>
                </tr>
                
                <tr>
                  <td colspan="2" class="td_heading"><strong>Select Banner File to Upload</strong></td>
                </tr>
                <tr>
                  <td class="data_row">Banner: *<font class="required">&nbsp;</font></td>
                  <td class="td_bdr"><input name="banner" type="file" class="text" id="banner" size="30" />
                  
                  	
                  
                  </td>
                </tr>
                <tr>
                  <td class="data_row">Link to Open:</td>
                  <td class="td_bdr"><input name="link" type="text" class="text" id="link" size="50" maxlength="255" style="width:350px;" value="<?=stripslashes(post('link'));?>" /></td>
                </tr>
                <tr>
                  <td class="data_row">Link Target: </td>
                  <td class="td_bdr"><select name="target" id="target">
                    <option value="_blank" <? if(post('target') == '_blank') echo 'selected="selected"';?>>New Window</option>
                    <option value="_self" <? if(post('target') == '_self') echo 'selected="selected"';?>>Same Window</option>
                  </select></td>
                </tr>
                
                <tr>
                  <td colspan="2" class="td_heading"><strong>Or Copy Paste Banner Code Here</strong></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Banner Code: * </td>
                  <td class="td_bdr"><textarea name="banner_code" cols="50" rows="5" id="banner_code"><?=stripslashes(post('banner_code'));?></textarea></td>
                </tr>
                
                <tr>
                  <td colspan="2" class="td_heading"><strong>Banner Properties </strong></td>
                </tr>
                <tr>
                  <td class="data_row">Status:</td>
                  <td class="td_bdr"><label>
                    <input name="status" type="radio" class="no_bdr" value="Y" <? if($status == '' || $status == 'Y') echo 'checked="checked"'; ?> />
                    Active</label>
                    <label>
                      <input name="status" type="radio" class="no_bdr" value="N" <? if($status == 'N') echo 'checked="checked"'; ?> />
                  In-active</label></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">*  required </td>
                  <td class="td_bdr"><input name="Submit" type="submit" class="submit" value="Submit" />                    <input name="insert" type="hidden" id="insert" value="true" /></td>
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
<!-- InstanceEnd -->
</html>
