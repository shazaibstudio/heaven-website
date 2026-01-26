<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	for($i = 0 ; $i < sizeof($page_id) ; $i++)
	{
		$pid = $page_id[$i];
		$sid = $s_group_id[$i];	
		$db->Execute("UPDATE ".DB_TABLE_PREFIX."web_pages SET s_group_id = '$sid' WHERE id = '$pid'");
	}
	
	$msg = urlencode('Slides settings updated for pages.');
	redirect("slides_settings.php?msg=$msg");
}


$g_page_heading = 'Manage Slides';
$g_section_heading = 'Slider Settings';
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
                  <td align="left" class="data_row"><strong>Page Name</strong></td>
                  <td align="left"><strong>Select Slider</strong></td>
                </tr>
                <?
                $pages = $db->Execute("SELECT id, page_name, s_group_id FROM ".DB_TABLE_PREFIX."web_pages WHERE id > 1 ORDER BY page_name ASC");
				while(!$pages->EOF)
				{
				?>
                <tr>
                  <td width="25%" align="left" class="data_row"><?=stripslashes($pages->fields('page_name')).':';?></td>
                  <td width="75%" align="left">
                  <input type="hidden" name="page_id[]" id="page_id[]" value="<?=$pages->fields('id');?>" />
                  <select name="s_group_id[]" id="s_group_id[]" class="text">
                    <option value="0">Default Slider ...</option>
                    <?
                    	$rs = $db->Execute("SELECT id, name FROM ".DB_TABLE_PREFIX."slides_groups ORDER BY name ASC");
						while(!$rs->EOF)
						{
							if($pages->fields('s_group_id') == $rs->fields('id')) $sl = 'selected="selected"'; else $sl = '';
							echo '<option value="'. $rs->fields('id') .'" '. $sl .'>'. stripslashes($rs->fields('name')) .'</option>';
							$rs->MoveNext();
						}	$rs->Close();
					?>
                  </select>
                  </td>
                </tr>
                <?
					$pages->MoveNext();
				}	$pages->Close();
				?>
                <tr>
                  <td align="left" class="data_row"><input name="save" type="hidden" id="save" value="yes" /></td>
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
