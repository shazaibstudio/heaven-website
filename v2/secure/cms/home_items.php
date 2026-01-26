<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(req('act') == 'status')
{
	$ids = req('id');
	for($i = 0 ; $i < sizeof($ids) ; $i++)
	{
		if(req('status_'.$ids[$i]) == 'Y') $status = 'Y'; else $status = 'N';
		$pos = req('pos_'.$ids[$i]);
		
		$db->Execute("update ".DB_TABLE_PREFIX."home_items set status = '$status' where id = '".$ids[$i]."'");
		$db->Execute("update ".DB_TABLE_PREFIX."home_items set pos = '$pos' where id = '".$ids[$i]."'");
	}
	
	$msg = urlencode("Home item(s) position & status updated successfully.");
	redirect("home_items.php?msg=$msg&page=".post('page'));
}

if(req('act') == 'delete')
{
	$ids = req('del_id');

	for($i = 0 ; $i < sizeof($ids) ; $i++)
	{
		$img_path = '../../up_data/icons/'.$row['src_icon'];
		if(file_exists($img_path)) unlink($img_path);
		
		$db->Execute("delete from ".DB_TABLE_PREFIX."home_items where id = '".$ids[$i]."'");
	}
	
	$msg = urlencode("Home item(s) deleted successfully.");
	redirect("home_items.php?msg=$msg&page=".post('page'));
}

$g_page_heading = 'Home Blocks';
$g_section_heading = 'Manage Home Blocks';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
$add_link = array('caption' => 'Add Home Block', 'link' => 'home_items_add.php');		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/cms_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
            
            <!-- CONTENT -->           
            
            
            <!-- Custom Forms --><!-- /#forms --> 
          <!-- InstanceBeginEditable name="txt" -->
                  
				  <form action="" method="post" name="form1" id="form1">
				  <?
				  $sql = "select * from ".DB_TABLE_PREFIX."home_items order by pos asc";
				  $result = $db->Execute($sql);
				  
				  if($result->RecordCount() > 0)
				  {
				  ?>
                    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="datatable">
                      <thead>
                      <tr>
                      	<th width="3%" class="bSortable"><input name="select_all" type="checkbox" id="select_all" value="1" onclick="make_selection(this.form, this);" /></th>
                        <th height="26" colspan="2" class="td_heading"> Image and Name</th>
                        <th width="14%" align="left" class="td_heading">Position</th>
                        <th width="14%" align="left" class="td_heading">Status</th>
                        <th width="15%" align="center" class="td_heading">Actions</th>
                        </tr>
                      </thead>
                      <?
					  $inc = 0;
					  while(!$result->EOF)
					  {
					  	if($inc%2 == 1) $class = ' class="data_row" '; else $class = '';
						$inc++;
						$id = $result->fields('id');
						if($result->fields('link_url') == '') $link_url = 'N/A';
						else $link_url = stripslashes($result->fields('link_url'));
					  ?>
					  <tr <?=$class?>>
                      	<td><input name="del_id[]" type="checkbox" id="del_id[]" value="<?=$id;?>" class="checkbox" />
					      <input name="id[]" type="hidden" id="id[]" value="<?=$id;?>"  /></td>
					    <td width="10%"><img src="../../up_data/icons/<?=$result->fields('src_icon');?>" /></td>
                        <td width="44%"><?php /*?><img src="../up_data/icons/<?=$result->fields('src_header_image');?>" /><br /><?php */?><?=stripslashes($result->fields('name'));?></td>
                        <td align="left"><input name="pos_<?=$id;?>" type="text" id="pos_<?=$id;?>" maxlength="4" style="width:35px; text-align:center;" value="<?=$result->fields('pos');?>" /></td>
                        <td align="left"><?=show_status($result->fields('status'), $id);?></td>
                        <td align="left"><a href="home_items_edit.php?id=<?=$id;?>&amp;page=<?=get('page')?>"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a> <a href="<?=$_SERVER['PHP_SELF'];?>?act=delete&del_id[]=<?=$id;?>" onclick="return window.confirm('Are you sure, you want to delete this record?');"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a></td>
                      </tr>
					  <?
					  	$result->MoveNext();
					  }	$result->Close();
					  ?>
                    </table>
            <div class="tab-footer clear fl">
                <div class="fl">
                  <select name="act" id="act" class="fl-space">
                    <option value="">choose action...</option>
                    <option value="status">update position & status</option>
                    <option value="delete">delete</option>
                  </select>
                  <input type="submit" value="Apply" id="submit1" class="submit fl-space" onclick="if(this.form.act.value == 'delete') return validate_delete(this.form);" />
                </div>
              </div>
              <input name="page" type="hidden" id="page" value="<?=get('page');?>" />
				  <?
				  	echo '<br /><div align="center">'.links().'</div>';
				  }
				  else
				  	echo no_results();
				  ?>
            </form>
                <!-- InstanceEndEditable --></div>
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
