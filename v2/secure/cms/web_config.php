<? 
require_once("../../includes/open_con.php");
require_once('includes/inc.session_check.php');
   
if(post('save'))
{
	foreach($id as $i)
	{
		$v = $_POST['key_value_'.$i];
		$sql = "update ".DB_TABLE_PREFIX."web_config set key_value = ".$db->qstr($v)." where id = '".$i."'";
		$db->Execute($sql);
	}
	$msg = urlencode("Configurations updated successfully.");
	redirect("web_config.php?msg=$msg&cs=ok");
}


$g_page_heading = 'Preferences';
$g_section_heading = 'Global Configuration';
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
            <form id="frm" action="" method="post" style="padding:0px; margin:0px;">
              <table width="100%" border="0" cellspacing="2" cellpadding="2"  >
               <tr>
                <td height="10" colspan="2"><strong>Note:</strong> If you are not sure, please do not change anything.</td>
               </tr> 
              <?
              $rs = $db->Execute("select * from ".DB_TABLE_PREFIX."web_config order by id asc");
              while(!$rs->EOF)
              {
              ?>
              <tr>
                <td width="25%" align="left" nowrap="nowrap"><?=stripslashes($rs->fields('detail')).':';?> </td>
                <td align="left">
                    <?
						$name = 'key_value_'.$rs->fields('id');
						if($rs->fields('key_name') == 'SITE_LIVE')
						{
						?>
						<select name="<?=$name;?>" id="<?=$name;?>">
                        	<option value="Yes" <? if($rs->fields('key_value') == 'Yes') echo 'selected="selected"'; ?>>Yes</option>
                            <option value="No" <? if($rs->fields('key_value') == 'No') echo 'selected="selected"'; ?>>No</option>
                        </select>
						<?
						}
						else
							echo '<input name="'.$name.'" type="text" id="'.$name.'" size="30" value="'.stripslashes($rs->fields('key_value')).'" class="text" />';
                    ?>       
                    <input name="id[]" type="hidden" id="id[]" value="<?=$rs->fields('id');?>" /></td>
                </tr>
              <?
                $rs->MoveNext();
              }	$rs->Close();
              ?>
              
              <tr>
                <td align="left"><input name="save" type="hidden" id="save" value="true" />            *  required </td>
                <td align="left"><input name="btn_submit" type="submit" class="submit" id="btn_submit" value="Update" /></td>
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
