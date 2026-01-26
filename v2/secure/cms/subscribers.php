<?php

include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if($cmd == 'export')
{
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=ciao_italia_subscribers.xls ");
	?>
	<table width="100%" border="1" cellspacing="2" cellpadding="5">
      <tr>
        <td>Name</td>
        <td>E-mail Address</td>
      </tr>
      <?
      $rs = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."subscribers WHERE deleted = 'N' ORDER BY name ASC");
	  while(!$rs->EOF)
	  {
	  ?>
      <tr>
        <td><?=stripslashes($rs->fields('name'));?></td>
        <td><?=stripslashes($rs->fields('email'));?></td>
      </tr>
     <?
     		$rs->MoveNext();
	  }	$rs->Close();
	  ?>
    </table>
	<?
	exit;
}

if($act == 'delete')
{
	$ids = req('del_id');
	for($i = 0 ; $i < sizeof($ids) ; $i++)
		$db->Execute("update ".DB_TABLE_PREFIX."subscribers set deleted = 'Y', date_deleted = '". date('Y-m-d H:i:s') ."', deleted_by = 'admin' where id = '".$ids[$i]."'");		
	$msg = urlencode('Subscribers deleted successfully.');
	redirect("subscribers.php?msg=$msg&page=".post('page'));
}

$g_page_heading = 'Newsletters';
$g_section_heading = 'Manage Subscribers';
$g_page_title = $g_section_heading.' - '.$g_page_heading;
$add_link = array('caption' => 'Add Subscriber', 'link' => 'subscribers_add.php');
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
                  
				  <form action="" method="post" name="form1" id="form1">
				  <?
				  $sql = "select * from ".DB_TABLE_PREFIX."subscribers where deleted = 'N' order by id asc LIMIT 500";

				  $result = $db->Execute($sql);

				  ?>
				    <table width="100%" border="0" cellspacing="1" cellpadding="1">
                      <tr>
					  	<td width="50%" align="left"><a href="subscribers.php?cmd=export" target="_blank">Export Subscribers</a> | <a href="subscribers_deleted.php">Click here to see deleted/un-subscribed subscribers</a></td>                        
                      </tr>
                    </table>
                  <?
                  if($result->RecordCount() > 0)
				  {
				  ?>
                    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="datatable">
                      <thead>
                      <tr>
                        <th class="bSortable"><input name="select_all" type="checkbox" id="select_all" value="1" onclick="make_selection(this.form, this);" /></th>
                        <th width="28%" height="24" class="td_heading">Subscriber Name </th>
                        <th width="24%" class="td_heading">E-mail Address </th>
                        <th width="19%" align="center" class="td_heading">Phone</th>
                        <th width="15%" align="center" class="td_heading">Date Joined </th>
                        <th width="10%" align="left"  class="bSortable">Actions</th>
                      </tr>
                      </thead>
                      <?
					  $inc = 0;
					  while(!$result->EOF)
					  {
					  	if($inc%2 == 1) $class = ' class="data_row" '; else $class = '';
						$inc++;
						$id = $result->fields('id');			
						if($result->fields('phone') == '') $phone = 'N/A';
						else $phone = $result->fields('phone');
					  ?>
					  <tr <?=$class?>>
					    <td width="4%"><input name="del_id[]" type="checkbox" id="del_id[]" value="<?=$id;?>" class="checkbox" />
                    <input name="id[]" type="hidden" id="id[]" value="<?=$id;?>"  /></td>
                        <td><? echo $result->fields('name') == '' ? 'Unknown User' : stripslashes($result->fields('name')) ; ?></td>
                        <td><?=stripslashes($result->fields('email'));?></td>
                        <td align="left"><?=stripslashes($phone);?></td>
                        <td align="left"><?=date('M d, Y H:i:s', strtotime($result->fields('date_added')));?></td>
                        <td align="left"><a href="subscribers_edit.php?id=<?=$id;?>&amp;page=<?=get('page')?>"><img src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a> <a href="<?=$_SERVER['PHP_SELF'];?>?act=delete&del_id[]=<?=$id;?>" onclick="return window.confirm('Are you sure, you want to delete this record?');"><img src="images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a></td>
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
