<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('act') == 'status')
{
	$ids = post('id');
	for($i = 0 ; $i < sizeof($ids) ; $i++)
	{
		if(post('status_'.$ids[$i]) == 'Y') $status = 'Y'; else $status = 'N';
		$db->Execute("update ".DB_TABLE_PREFIX."banners set status = '$status' where id = '".$ids[$i]."'");
	}
	$msg = urlencode("Banner(s) status updated successfully.");
	if(post('area_id') != '') $msg .= "&area_id=".post('area_id');
	redirect("banners.php?msg=$msg&page=".post('page'));
}

if(req('act') == 'delete')
{
	$ids = req('del_id');
	$skiped = false;
	$deleted = false;
	for($i = 0 ; $i < sizeof($ids) ; $i++)
	{
		$ext = $db->GetOne("select ext from ".DB_TABLE_PREFIX."banners where id = '".$ids[$i]."'");		
		if($ext != '')
		{
			$path = '../up_data/banners/banner'.$ids[$i].$ext;
			if(file_exists($path)) unlink($path);
		}
		$db->Execute("delete from ".DB_TABLE_PREFIX."banners where id = '".$ids[$i]."'");		
	}
	$msg = urlencode("Banner(s) deleted successfully.");
	if(post('area_id') != '') $msg .= "&area_id=".post('area_id');
	redirect("banners.php?msg=$msg&page=".post('page'));
}

$g_page_heading = 'Content Management';
$g_section_heading = 'Manage Banners';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
$add_link = array('caption' => 'Add Banner', 'link' => 'banners_add.php');
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
            <!-- InstanceBeginEditable name="txt" -->
                  <form action="" method="get" name="frm" id="frm">
                <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="1">
                  <tr>
                    <td width="21%" align="left" nowrap="nowrap" class="heading_tds">Select area to view Banners:</td>
                    <td width="79%" align="left" class="td_bdr"><select name="area_id" id="area_id" onchange="if(this.value != '_') document.frm.submit();">
                            <option selected="selected" value="_">Please Select ... </option>
                            <?
                                $areas = $db->Execute("select id, title from ".DB_TABLE_PREFIX."banner_areas order by id asc");
                                while(!$areas->EOF)
                                {
                                    if(get('area_id') == $areas->fields('id')) $sel = 'selected="selected"'; else $sel = "";
                                    echo '<option value="'.$areas->fields('id').'" '.$sel.'>'.stripslashes($areas->fields('title')).'</option>';
                                    $areas->MoveNext();
                                }	$areas->Close();
                              ?>
                          </select></td>
                  </tr>
                </table>
              </form>
          
				  <form action="" method="post" name="form1" id="form1">
				  <?
				  $sql = "select b.*, ba.title from ".DB_TABLE_PREFIX."banners b, ".DB_TABLE_PREFIX."banner_areas ba where b.area_id = ba.id ";
				  if(get('area_id') && get('area_id') != '_') $sql .= " and b.area_id = '".get('area_id')."'";
				  $sql .= " order by ba.title asc, b.id desc";
				  $result = $db->Execute($sql);
				  if($result->RecordCount() > 0)
				  {
				  ?>
                    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="datatable">
                      <thead>
                      <tr>
                        <th class="bSortable"><input name="select_all" type="checkbox" id="select_all" value="1" onclick="make_selection(this.form, this);" /></th>
                        <th width="23%" height="24" class="td_heading">Banner Name</th>
                        <th width="23%" class="td_heading">Banner Type</th>
                        <th width="21%" align="center" class="td_heading"> Area</th>
                        <th width="12%" align="center" class="td_heading"><span class="bSortable">Hits</span></th>
                        <th width="8%" align="left"  class="bSortable">Status</th>
                        <th width="9%" align="left"  class="bSortable">Actions</th>
                      </tr>
                      </thead>
                      <?
					  $inc = 0;
					  while(!$result->EOF)
					  {
					  	if($inc%2 == 1) $class = ' class="data_row" '; else $class = '';
						$inc++;
						$id = $result->fields('id');			
						
						$image_path = '../../up_data/news/'.$result->fields('src_image_file');
						if($result->fields('src_image_file') != '' && file_exists($image_path))
							$picture = '<img src="'. $image_path .'" width="75" border="0" />';
						else
							$picture = 'N/A';
											
					  ?>
					  <tr <?=$class?>>
					    <td width="4%"><input name="del_id[]" type="checkbox" id="del_id[]" value="<?=$id;?>" class="checkbox" />
                   		<input name="id[]" type="hidden" id="id[]" value="<?=$id;?>"  /></td>
                        <td><a href="banners_detail.php?id=<?=$id;?>"><span class="td_bdr">
                          <?=stripslashes($result->fields('name'));?>
                        </span></a></td>
                        <td><span class="td_bdr">
                          <?
						if($result->fields('ext') == ".swf") echo "Flash Banner";	
						else if($result->fields('ext') == ".jpg") echo "JPG image";
						else if($result->fields('ext') == ".gif") echo "GIF animated image";
						else if($result->fields('ext') == ".png") echo "PNG image";
						else if($result->fields('ext') == ".bmp") echo "BMP image";
						else echo "Unknown image type";
						?>
                        </span></td>
                        <td align="left"><?=$result->fields('title');?></td>
                        <td align="left"><span class="td_bdr">
                          <?=$result->fields('hits');?>
                        </span></td>
                        <td align="left"><input name="status_<?=$id;?>" type="checkbox" class="no_bdr" id="status_<?=$id;?>" value="Y" <? if($result->fields('status') == 'Y') echo 'checked="checked"'; ?> /></td>
                        <td align="left"><a href="banners_edit.php?id=<?=$id;?>&amp;page=<?=get('page')?>"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a> <a href="<?=$_SERVER['PHP_SELF'];?>?act=delete&del_id[]=<?=$id;?>" onclick="return window.confirm('Are you sure, you want to delete this record?');"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a></td>
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
                        <option value="status">update status</option>
                        <option value="delete">delete</option>
                      </select>
                      <input type="submit" value="Apply" id="submit1" class="submit fl-space" onclick="if(this.form.act.value == ''){ alert('Please select action to continue.'); this.form.act.focus(); return false; } ; if(this.form.act.value == 'delete') return validate_delete(this.form);" />
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
<!-- InstanceEnd --></html>
