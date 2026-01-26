<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
	if($name == '')
		$errors .= '- Please enter item name.<br />';
	if($slug == '')
		$errors .= '- Please enter permalink name.<br />';
	if($title == '')
    $errors .= '- Please enter title.<br />';
  if($price == '')
    $errors .= '- Please enter price.<br />';
  elseif(!is_numeric($price))
		$errors .= '- Please enter only numeric value for price.<br />';
  if($price_pk == '')
		$errors .= '- Please enter price for Pakistani visitors.<br />';
  elseif(!is_numeric($price_pk))
		$errors .= '- Please enter only numeric value for price for Pak visitors.<br />';
  if($_FILES['picture']['tmp_name'] == '')
    $errors .= '- Please upload room picture.<br />';
  else
  {
    $ext = strtolower(strrchr($_FILES['picture']['name'], '.'));
    if(!in_array($ext, $G_IMG_EXTS))
      $errors .= '- Please upload only .JGP, .PNG or .GIF images.<br />';
  }
	if($pos == '')
		$errors .= '- Please enter position.<br />';
	elseif(!ctype_digit($pos))
		$errors .= '- Please enter only numeric value for position.<br />';
	
	if($errors == '')
	{
    $picture = time().'_'.generate_file_name($_FILES['picture']['name']);
    move_uploaded_file($_FILES['picture']['tmp_name'], '../../up_data/pictures/'.$picture);

    if(isset($features) && is_array($features))
      $features = json_encode($features);
    else
      $features = '';

    if(isset($features_paid) && is_array($features_paid))
      $features_paid = json_encode($features_paid);
    else
      $features_paid = '';

		$db->Execute("insert into ".DB_TABLE_PREFIX."rooms set 
                  name = ".$db->qstr($name).", 
                  slug = ".$db->qstr($slug).", 
                  title = ".$db->qstr($title).", 
                  short_detail = ".$db->qstr($short_detail).",  
                  detail = ".$db->qstr($detail).", 
                  features = '". $features ."',
                  features_paid = '". $features_paid ."',
                  price = ".$db->qstr($price).", 
                  price_pk = ".$db->qstr($price_pk).", 
                  pos = ".$db->qstr($pos).", 
                  picture = '". $picture ."',
                  active = ".$db->qstr($status)."");
		
		if($db->ErrorNo() == 1062)
			$errors .= '- Room permalink name already exists.<br />';
		else
		{
			$msg = urlencode('Room added successfully.');
			redirect("rooms.php?msg=$msg");
		}
	}
	foreach($_POST as $k => $v)
		$$k = stripslashes($v);

  $features = $_POST['features'];
  $features_paid = $_POST['features_paid'];
}
else
{
  $pos = 0;
} 

$g_page_heading = 'Manage Rooms';
$g_section_heading = 'Add Room';
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
                  <td width="25%" align="left" class="data_row">Name:  * </td>
                  <td width="75%" align="left"><input name="name" type="text" class="text" id="name" size="30" maxlength="255" value="<?=$name?>" onchange="gen_seo_name(this.value);" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Permalink Name: *</td>
                  <td align="left"><input name="slug" type="text" class="text" id="slug" size="30" maxlength="255" value="<?=$slug?>" />
                  <input type="hidden" name="table_name" id="table_name" value="rooms" />
                  <input type="hidden" name="action" id="action" value="add" />
                  Must be unique and without any special characters and spaces</td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row">Title:  * </td>
                  <td width="75%" align="left"><input name="title" type="text" class="text" id="title" size="30" maxlength="255" value="<?=$title?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Short Description:</td>
                  <td align="left">
                  <textarea name="short_detail" cols="60" rows="8" class="text" id="short_detail"><?=$short_detail;?></textarea></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Description:</td>
                  <td align="left">
                  <? include('tiny_mce_config.php'); ?>
                  <textarea name="detail" cols="60" rows="8" class="text mce" id="detail"><?=$detail;?></textarea></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Price: *</td>
                  <td align="left"><input name="price" type="text" class="text" id="price" size="30" maxlength="128" value="<?=$price?>" /><br>Price for Foreign Visitors, should be in USD</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Price (PK): *</td>
                  <td align="left"><input name="price_pk" type="text" class="text" id="price_pk" size="30" maxlength="128" value="<?=$price_pk?>" onchange="calc_pk_price(this.value);" /> &nbsp; <span id="sp_price_pk" style="color:red;"></span><br>Price for Pakistani Visitors, should be in USD</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Features (Free):</td>
                  <td align="left">
                    <div style="width: 400px; height: 150px; overflow: scroll; overflow-x: hidden;">
                    <?php
                      foreach($G_SERVICES as $key => $value)
                      {
                        if(isset($features) && is_array($features) && in_array($key, $features))
                          $checked = 'checked="checked"';
                        else
                          $checked = '';
                      ?>
                        <label><input <?php echo $checked; ?> name="features[]" type="checkbox" value="<?php echo $key; ?>" /> <?php echo $value; ?></label><br>
                      <?php
                      }
                    ?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Features (Paid):</td>
                  <td align="left">
                    <div style="width: 400px; height: 150px; overflow: scroll; overflow-x: hidden;">
                    <?php
                      foreach($G_SERVICES as $key => $value)
                      {
                        if(isset($features_paid) && is_array($features_paid) && in_array($key, $features_paid))
                          $checked = 'checked="checked"';
                        else
                          $checked = '';
                      ?>
                        <label><input <?php echo $checked; ?> name="features_paid[]" type="checkbox" value="<?php echo $key; ?>" /> <?php echo $value; ?></label><br>
                      <?php
                      }
                    ?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Picture: *</td>
                  <td align="left"><input name="picture" type="file" class="text" id="picture" size="30" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Position: *</td>
                  <td align="left"><input name="pos" type="text" class="text" id="pos" size="30" maxlength="128" value="<?=$pos?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="data_row">Status:</td>
                  <td align="left">
                  	<label>
                    <input type="radio" name="status" id="status" value="Y" <? if($status == '' || $status == 'Y') echo 'checked="checked"'; ?> />
                    Active</label>
                    <label>
                    <input type="radio" name="status" id="status" value="N" <? if($status == 'N') echo 'checked="checked"'; ?> />
                    In-active</label>
</td>
                </tr>
                <tr>
                  <td align="left" class="data_row">* required
                    <input name="save" type="hidden" id="save" value="yes" /></td>
                  <td align="left"><input name="Submit" type="submit" class="submit" value="Submit" />                    </td>
                </tr>
				
              </table>
            </form>


                      <script>
                        function calc_pk_price(price_pk)
                        {
                              var conv = <?php echo USD_RATE; ?>;
                              var price = Math.round(Number(price_pk) * conv);
                              $('#sp_price_pk').html('PKR ' + price);
                        }
                      </script>

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
