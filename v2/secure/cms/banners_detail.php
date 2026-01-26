<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."banners where id = '".get('id')."'");
foreach($row as $k => $v)
	$$k = stripslashes($v);

$g_page_heading = 'Content Management';
$g_section_heading = 'Banner Detail';
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

            <form action="" method="post" enctype="multipart/form-data" id="form1">
              <table width="100%"  border="0" cellpadding="2" cellspacing="1" class="one_px_bdr">
                <tr>
                  <td width="25%" class="data_row"> Select Banner Area: </td>
                  <td width="75%" class="td_bdr">
                  	<?=stripslashes($db->GetOne("select title from ".DB_TABLE_PREFIX."banner_areas where id = '$area_id'"));?></td>
                </tr>
                <tr>
                  <td class="data_row">Banner Name: </td>
                  <td class="td_bdr"><?=$name;?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Description Text: <span class="required"></span></td>
                  <td class="td_bdr"><?=$detail;?></td>
                </tr>
                
                <tr>
                  <td colspan="2" class="td_heading"><strong>Select Banner File to Upload</strong></td>
                </tr>
                <tr>
                  <td class="data_row">Banner: </td>
                  <td class="td_bdr"><?
				  	$path = '../../up_data/banners/banner'.$id.$ext;
				  	if($ext != '' && file_exists($path))
						echo '<a href="'.$path.'" class="thickbox"><img src="'.$path.'" border="0" width="75" /></a>';
					else echo 'N/A';
					?>
                  
                  </td>
                </tr>
                <tr>
                  <td class="data_row">Link to Open:</td>
                  <td class="td_bdr"><?=$linkURL;?></td>
                </tr>
                <tr>
                  <td class="data_row">Link Target: </td>
                  <td class="td_bdr"><? if($target == '_blank') echo 'New Window'; else echo 'Same Window';?></td>
                </tr>
                
                <tr>
                  <td colspan="2" class="td_heading"><strong>Or Copy Paste Banner Code Here</strong></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Banner Code: </td>
                  <td class="td_bdr"><?=$banner_code;?></td>
                </tr>
                
                <tr>
                  <td colspan="2" class="td_heading"><strong>Banner Properties </strong></td>
                </tr>
                <tr>
                  <td class="data_row">Status:</td>
                  <td class="td_bdr"><? 
					if($status == 'Y') echo 'Active'; 
					else echo 'In-active';
					?></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" class="data_row"><input name="Button" type="button" class="submit" value="&laquo; Back" onclick="history.back();" /></td>
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
