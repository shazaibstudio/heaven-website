<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('update'))
{
	$db->Execute("update ".DB_TABLE_PREFIX."web_pages set page_title = ".$db->qstr(post('page_title')).", page_heading = ".$db->qstr(post('page_heading')).", page_tagline = ".$db->qstr(post('page_tagline')).", meta_desc = ".$db->qstr(post('meta_desc')).", meta_keywords = ".$db->qstr(post('meta_keywords')).", page_text = ".$db->qstr(post('body_text'))." where id = ".post('id'));
	$msg = urlencode("Webpage updated successfully.");
	redirect("cms_pages.php?msg=$msg&cs=ok&id=".post('id'));
}
if(get('id')) $page_id = get('id');
else $page_id = 1;
$page_text = $db->GetRow("select * from ".DB_TABLE_PREFIX."web_pages where id = $page_id");

$g_page_heading = 'Content Management';
$g_section_heading = 'Manage Web Pages';
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
            <!-- InstanceBeginEditable name="txt" -->

		
        <form id="frm_page_editor" name="frm_page_editor" method="post" action="">
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
                <tr class="smpText">
                  <td width="17%" class="data_row">Select a Page:</td>
                  <td width="83%">
				  <select name="page_id" id="page_id" onchange="location.href='cms_pages.php?id='+this.value;" style="width:300px;">
                   <?
				   $rs_pages = $db->Execute("select id, page_name from ".DB_TABLE_PREFIX."web_pages order by id asc");
				   while(!$rs_pages->EOF)
				   {
				   ?>
				   <option value="<?=$rs_pages->fields('id')?>" <? if(get('id') == $rs_pages->fields('id')) echo 'selected="selected"'; ?>><?=$rs_pages->fields('page_name')?></option>
				   <?
				   		$rs_pages->MoveNext();
				   }	$rs_pages->Close();
				   ?>
				  </select>				  </td>
                </tr>
                <tr class="smpText">
                  <td class="data_row">Page Title:</td>
                  <td><input name="page_title" type="text" class="text" id="page_title" maxlength="128" value="<?=stripslashes($page_text['page_title']);?>" style="width:300px;" /></td>
                </tr>
                <tr class="smpText">
                  <td class="data_row">Page Heading:</td>
                  <td><input name="page_heading" type="text" class="text" id="page_heading" maxlength="128" value="<?=stripslashes($page_text['page_heading']);?>" style="width:300px;" /></td>
                </tr>
                <tr class="smpText">
                  <td class="data_row">Page Tagline:</td>
                  <td><input name="page_tagline" type="text" class="text" id="page_tagline" maxlength="128" value="<?=stripslashes($page_text['page_tagline']);?>" style="width:300px;" /></td>
                </tr>
                <tr class="smpText">
                  <td class="data_row">Meta Description:</td>
                  <td><input name="meta_desc" type="text" class="text" id="meta_desc" maxlength="255" value="<?=stripslashes($page_text['meta_desc']);?>" style="width:300px;" /></td>
                </tr>
                <tr class="smpText">
                  <td class="data_row">Meta Keywords:</td>
                  <td><input name="meta_keywords" type="text" class="text" id="meta_keywords" style="width:300px;" value="<?=stripslashes($page_text['meta_keywords']);?>" maxlength="255" /></td>
                </tr>
                <tr class="smpText">
                  <td colspan="2" valign="top" class="data_row">Body Text:</td>
                </tr>
                
                <tr>
                  <td colspan="2" class="data_row_corporate">
                    <? include('tiny_mce_config.php'); ?>
                    <textarea id="body_text" name="body_text" class="mce" rows="15" cols="80" style="width: 100%; height:500px;"><?=stripslashes($page_text['page_text'])?></textarea>
                    
                    </td>
                </tr>
                <tr>
                  <td colspan="2" class="data_row"><input name="update" type="hidden" id="update" value="true" />
                  <input name="id" type="hidden" id="id" value="<?=$page_id?>" />
                  <input name="Submit" type="submit" class="submit" value="Update" /></td>
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
