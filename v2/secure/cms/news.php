<?
include('../../includes/open_con.php'); include('includes/inc.session_check.php');

if(post('act') == 'status')
{
	$ids = post('id');
	for($i = 0 ; $i < sizeof($ids) ; $i++)
	{
		if(post('status_'.$ids[$i]) == 'Y') $status = 'Y'; else $status = 'N';
		$db->Execute("update ".DB_TABLE_PREFIX."news set status = '$status' where id = '".$ids[$i]."'");
	}
	$msg = urlencode("News status updated successfully.");
	redirect("news.php?msg=$msg&page=".post('page'));
}

if(post('act') == 'home')
{
	$ids = post('id');
	for($i = 0 ; $i < sizeof($ids) ; $i++)
	{
		if(post('is_latest_'.$ids[$i]) == 'Y') $status = 'Y'; else $status = 'N';
		$db->Execute("update ".DB_TABLE_PREFIX."news set is_latest = '$status' where id = '".$ids[$i]."'");
	}
	$msg = urlencode("News show on home status updated successfully.");
	redirect("news.php?msg=$msg&page=".post('page'));
}

if(req('act') == 'delete')
{
	$ids = req('del_id');
	for($i = 0 ; $i < sizeof($ids) ; $i++)
	{
		$src_image_file = $db->GetOne("select src_image_file from ".DB_TABLE_PREFIX."news where id = '".$ids[$i]."'");
		$path = '../../up_data/news/'.$src_image_file;
		if($src_image_file != '' && file_exists($path))
			unlink($path);		
		$db->Execute("delete from ".DB_TABLE_PREFIX."news where id = '".$ids[$i]."'");
	}
	
	$msg = urlencode("News deleted successfully.");
	redirect("news.php?msg=$msg&page=".req('page'));
}

$g_page_heading = 'News';
$g_section_heading = 'Manage News';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
$add_link = array('caption' => 'Add News', 'link' => 'news_add.php');
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
            <form action="" method="post" name="form1" id="form1">
              <?
			  $sql = "select * from ".DB_TABLE_PREFIX."news order by id desc";
			  $result = $db->Execute($sql);
			  
			  if($result->RecordCount() > 0)
			  {
			  ?>
              <table class="datatable">
                <thead>
                  <tr>
                    <th class="bSortable"><input name="select_all" type="checkbox" id="select_all" value="1" onclick="make_selection(this.form, this);" /></th>
                    <th width="10%" align="left">Image</th>
                    <th width="35%" height="26" align="left">Title </th>
                    <th width="17%" align="left">News  Date </th>
                    <th width="13%" align="left" class="bSortable">Show on Home </th>
                    <th width="12%" align="left" class="bSortable">Status</th>
                    <th width="9%" align="left"  class="bSortable">Actions</th>
                  </tr>
                </thead>
                <?
					  while(!$result->EOF)
					  {
						$id = $result->fields('id');
						$status = $result->fields('status');
						
						$path = '../../up_data/news/'.$result->fields('src_image_file');
						if($result->fields('src_image_file') != '' && file_exists($path))
							$img = '<img src="'.$path.'" width="80" border="0" align="absmiddle" />';
						else
							$img = 'N/A';
					  ?>
                <tr>
                  <td width="4%"><input name="del_id[]" type="checkbox" id="del_id[]" value="<?=$id;?>" class="checkbox" />
                    <input name="id[]" type="hidden" id="id[]" value="<?=$id;?>"  /></td>
                  <td align="left"><?=$img;?></td>
                  <td align="left"><?=stripslashes($result->fields('name'));?></td>
                  <td align="left"><?=date('M d, Y', strtotime($result->fields('news_date')));?></td>
                  <td align="left"><input name="is_latest_<?=$id;?>" type="checkbox" id="is_latest_<?=$id;?>" value="Y" <? if($result->fields('is_latest') == 'Y') echo 'checked="checked"'; ?> class="no_bdr" /></td>
                  <td align="left"><?=show_status($status, $id);?></td>
                  <td align="left"><a href="news_edit.php?id=<?=$id;?>&amp;page=<?=get('page')?>"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a> <a href="<?=$_SERVER['PHP_SELF'];?>?act=delete&del_id[]=<?=$id;?>" onclick="return window.confirm('Are you sure, you want to delete this record?');"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a></td>
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
                    <option value="home">update home status</option>
                    <option value="status">update status</option>
                    <option value="delete">delete</option>
                  </select>
                  <input type="submit" value="Apply" id="submit1" class="submit fl-space" onclick="if(this.form.act.value == 'delete') return validate_delete(this.form);" />
                </div>
              </div>
              <input name="page" type="hidden" id="page" value="<?=get('page');?>" />
              <?
				  	
				  }
				  else
				  	echo no_results();
				  ?>
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
