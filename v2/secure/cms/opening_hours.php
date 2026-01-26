<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if($save == 'yes')
{
		for($i = 1 ; $i <= 7 ; $i++)
		{
			$e = $i - 1;
			if($timing[$e] == '')
				$errors = '- Please enter opening hours for every day.<br />';
		}
		
		if($errors == '')
		{
			$db->Execute("TRUNCATE ".DB_TABLE_PREFIX."openinghours");
			
			for($i = 1 ; $i <= 7 ; $i++)
			{
				$e = $i - 1;
				$db->Execute("INSERT INTO ".DB_TABLE_PREFIX."openinghours SET timing = ".$db->qstr($timing[$e])."");
			}
			
			$msg = urlencode('Opening hours updated successfully.');
			redirect("opening_hours.php?msg=$msg");
		}
	
}

if($tab == '') $tab = 1;

$g_page_heading = 'Content Management';
$g_section_heading = 'Opening Hours';
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
            
                <form action="" method="post" id="form1">
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	<?
					$hrs = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."openinghours ORDER BY id ASC");
                    while(!$hrs->EOF)
					{
					?>
                    <tr>
                	    <td width="26%"><?=$G_WEEK_DAYS[$hrs->fields('id')].': *';?></td>
                	    <td width="74%"><input name="timing[]" type="text" class="text" id="timing[]" size="30" maxlength="128" value="<?=stripslashes($hrs->fields('timing'));?>" /></td>
              	    </tr>
                    <?
						$hrs->MoveNext();
					}	$hrs->Close();
					?>
                	  <tr>
                	    <td>* required
                	      <input name="save" type="hidden" id="save" value="yes" />
                        <input name="tab" type="hidden" id="tab" value="2" /></td>
                	    <td><input name="Submit2" type="submit" class="submit" value="Submit" /></td>
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
