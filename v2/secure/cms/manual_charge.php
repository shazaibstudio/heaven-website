<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

if(post('save') == 'yes')
{
  $errors = '';

  if($amount == '')
    $errors .= '- Please enter amount.<br>';
  elseif(!is_numeric($amount) || $amount <= 0)
    $errors .= '- Please enter a valid amount.<br>';
  if($checkin_date == '')
    $errors .= '- Please enter check-in date.<br>';
  if($checkout_date == '')
    $errors .= '- Please enter check-out date.<br>';
  if($bill_to_forename == '')
    $errors .= '- Please enter first name.<br>';
  if($bill_to_surname == '')
    $errors .= '- Please enter last name.<br>';
  if($bill_to_email == '')
    $errors .= '- Please enter email address.<br>';
  elseif(!filter_var($bill_to_email, FILTER_VALIDATE_EMAIL))
    $errors .= '- Please enter a valid email address.<br>';
  if($bill_to_phone == '')
    $errors .= '- Please enter phone number.<br>';
  if($bill_to_address_line1 == '')
    $errors .= '- Please enter address.<br>';
  if($bill_to_address_city == '')
    $errors .= '- Please enter city.<br>';
  if($bill_to_address_postal_code == '')
    $errors .= '- Please enter zip code.<br>';
  if($bill_to_address_country == '')
    $errors .= '- Please select country.<br>';

  if($errors == '')
  {

    $amount = number_format($amount, 2, '.', '');

    $sql = "INSERT INTO ". DB_TABLE_PREFIX ."orders SET
          session_id    = '". session_id() ."',
          bl_first_name = '". $bill_to_forename ."',
          bl_last_name  = '". $bill_to_surname ."',
          bl_email      = '". $bill_to_email ."',
          bl_phone      = '". $bill_to_phone ."',
          bl_address    = '". $bill_to_address_line1 ."',
          bl_city       = '". $bill_to_address_city ."',
          bl_zip        = '". $bill_to_address_postal_code ."',
          bl_country    = '". $bill_to_address_country ."',
          bl_state      = '". $bill_to_address_state ."',
          reference_number = '". $reference_number ."',
          amount        = '". $amount."',
          notes         = '". addslashes($bill_notes) ."',
          customer_ip   = '". $_SERVER['REMOTE_ADDR'] ."',
          order_type    = 'manual',
          order_date    = NOW()
          ";

   $db->Execute($sql);
   $order_id = $db->Insert_ID();

   $_POST['consumer_id'] = $order_id;

    $html = '<!DOCTYPE html>
  <html>
  <head>
    <title>Processsing ...</title>
  </head>
  <body>
  <form name="frm_pay" id="frm_pay" action="https://secureacceptance.cybersource.com/pay" method="post">';
  
    $skip = array('checkin_date', 'checkin_hh', 'checkin_mm', 'checkout_date', 'checkout_hh', 'checkout_mm', 'save', 'bill_notes', 'Submit');

    if($bill_to_address_state != '')
      $_POST['signed_field_names'] = $_POST['signed_field_names'].',bill_to_address_state';
    else
      unset($_POST['signed_field_names']);

    foreach($_POST as $k => $v)
    {
      if(in_array($k, $skip)) continue;

      $params[$k] = $v;
    
      $html .= '<input type="hidden" name="'. $k .'" value="'. $v .'"><br>';
    }


    $html .= "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . sign($params) . "\"/>\n";



  $html .= '</form>
  <script>document.getElementById("frm_pay").submit();</script>
  </body>
  </html>';
  echo $html;
  exit;


  }  

  foreach($_POST as $k => $v) 
    $$k = stripslashes($v);
}

$g_page_heading = 'Manual Transaction';
$g_section_heading = 'Charge Credit Card';
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
           
            <form action="" method="post">
              <table width="100%" border="0" cellpadding="3" cellspacing="1" class="one_px_bdr">
                <tr>
                  <td width="25%" align="left" class="data_row"> Amount:  * </td>
                  <td width="75%" align="left"><input name="amount" type="text" class="text" id="amount" size="30" maxlength="128" value="<?=$amount?>" /> USD</td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Check-in:  * </td>
                  <td width="75%" align="left">
                    <input name="checkin_date" type="date" class="text" id="checkin_date" size="30" maxlength="128" value="<?=$checkin_date?>" />
                    <select name="checkin_hh" id="checkin_hh">
                      <?php
                        for($i = 0 ; $i <= 23 ; $i++)
                        {
                          $hh = $i;
                          if($hh < 10) $hh = '0'.$hh;
                          ?>
                            <option value="<?php echo $hh; ?>"><?php echo $hh; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                    <select name="checkin_mm" id="checkin_mm">
                      <?php
                        for($i = 0 ; $i <= 59 ; $i++)
                        {
                          $mm = $i;
                          if($mm < 10) $mm = '0'.$mm;
                          ?>
                            <option value="<?php echo $mm; ?>"><?php echo $mm; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Check-out:  * </td>
                  <td width="75%" align="left">
                    <input name="checkout_date" type="date" class="text" id="checkout_date" size="30" maxlength="128" value="<?=$checkout_date?>" />
                    <select name="checkout_hh" id="checkout_hh">
                      <?php
                        for($i = 0 ; $i <= 23 ; $i++)
                        {
                          $hh = $i;
                          if($hh < 10) $hh = '0'.$hh;
                          ?>
                            <option value="<?php echo $hh; ?>"><?php echo $hh; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                    <select name="checkout_mm" id="checkout_mm">
                      <?php
                        for($i = 0 ; $i <= 59 ; $i++)
                        {
                          $mm = $i;
                          if($mm < 10) $mm = '0'.$mm;
                          ?>
                            <option value="<?php echo $mm; ?>"><?php echo $mm; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><hr size="1"></td>                  
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> First Name:  * </td>
                  <td width="75%" align="left"><input name="bill_to_forename" type="text" class="text" id="bill_to_forename" size="30" maxlength="128" value="<?=$bill_to_forename?>" /></td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Last Name:  * </td>
                  <td width="75%" align="left"><input name="bill_to_surname" type="text" class="text" id="bill_to_surname" size="30" maxlength="128" value="<?=$bill_to_surname?>" /></td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Email Address:  * </td>
                  <td width="75%" align="left"><input name="bill_to_email" type="text" class="text" id="bill_to_email" size="30" maxlength="128" value="<?=$bill_to_email?>" /></td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Phone Number:  * </td>
                  <td width="75%" align="left"><input name="bill_to_phone" type="text" class="text" id="bill_to_phone" size="30" maxlength="128" value="<?=$bill_to_phone?>" /></td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Address:  * </td>
                  <td width="75%" align="left"><input name="bill_to_address_line1" type="text" class="text" id="bill_to_address_line1" size="30" maxlength="128" value="<?=$bill_to_address_line1?>" /></td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> City:  * </td>
                  <td width="75%" align="left"><input name="bill_to_address_city" type="text" class="text" id="bill_to_address_city" size="30" maxlength="128" value="<?=$bill_to_address_city?>" /></td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Zip Code:  * </td>
                  <td width="75%" align="left"><input name="bill_to_address_postal_code" type="text" class="text" id="bill_to_address_postal_code" size="30" maxlength="128" value="<?=$bill_to_address_postal_code?>" /></td>
                </tr>
                <tr>
                  <td width="25%" align="left" class="data_row"> Country:  * </td>
                  <td width="75%" align="left">
                    
                    <select id="bill_to_address_country" name="bill_to_address_country" class="text" onchange="check_country(this.value);">
                        <option value="" selected="selected">(please select a country)</option>
                        <?php

                        $cn = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."countries ORDER BY name ASC");
                        while(!$cn->EOF)
                        {
                          if($bill_to_address_country == $cn->fields('iso_code_2')) $sl = 'selected="selected"'; else $sl = '';

                          echo '<option value="'. $cn->fields('iso_code_2') .'" '.$sl.'>'. $cn->fields('name') .'</option>';
                          $cn->MoveNext();
                        } $cn->Close();

                        ?>
                    </select>

                  </td>
                </tr>

                <tr id="div_states" <?php if(!($bill_to_address_country == 'CA' || $bill_to_address_country == 'US')) echo 'style="display:none;"'; ?>">
                  <td width="25%" align="left" class="data_row"> State:  * </td>
                  <td width="75%" align="left">
                    
                    <div id="states_box">

                        <?php
                          if($bill_to_address_country == 'CA' || $bill_to_address_country == 'US')
                          {
                            $states = $db->Execute("SELECT s.name, s.abbrev 
                                                  FROM  ".DB_TABLE_PREFIX."states s,  ".DB_TABLE_PREFIX."countries c
                                                  WHERE s.country_id = c.id
                                                  AND c.iso_code_2 = '{$bill_to_address_country}'
                                                  ORDER BY name ASC ");
                            echo '<select class="text" name="bill_to_address_state" id="bill_to_address_state">';
                            while(!$states->EOF)
                            {
                              if($bill_to_address_state == $states->fields('abbrev')) $sl = 'selected="selected"'; else $sl = '';
                              echo '<option value="'. $states->fields('abbrev') .'" '. $sl .'>'. $states->fields('name') .'</option>';
                              $states->MoveNext();
                            } $states->Close();
                            echo '</select>';
                          }

                        ?>

                      </div>

                  </td>
                </tr>


                <tr>
                  <td width="25%" align="left" class="data_row"> Notes: </td>
                  <td width="75%" align="left">
                   <textarea class="form-control" id="bill_notes" name="bill_notes" cols="60" rows="5"><?php echo $bill_notes; ?></textarea>
                  </td>
                </tr>
                
                <tr>
                  <td align="left" class="data_row">* required
                    <input name="save" type="hidden" id="save" value="yes" /></td>
                  <td align="left"><input name="Submit" type="button" class="submit" value="Submit" onclick="manual_charge(this.form);" />                    </td>
                </tr>
				
              </table>



<input type="hidden" name="access_key" value="<?php echo ACCESS_KEY; ?>">
  <input type="hidden" name="profile_id" value="<?php echo PROFILE_ID; ?>">
  <input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
  <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_address_line1,bill_to_address_city,bill_to_address_country,bill_to_email,bill_to_forename,bill_to_surname,bill_to_address_postal_code,bill_to_phone,customer_ip_address,merchant_defined_data1,merchant_defined_data2,merchant_defined_data13,merchant_defined_data14,merchant_defined_data15,merchant_defined_data16,merchant_defined_data20,override_custom_receipt_page,consumer_id">
  <input type="hidden" name="unsigned_field_names">
  <input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
  <input type="hidden" name="locale" value="en">
  <input type="hidden" name="transaction_type" value="sale" size="25"><br/>
  <input type="hidden" name="reference_number" value="<?php echo time(); ?>" size="25"><br/>
  <?php /* ?><input type="hidden" name="amount" size="25" value="<?php echo number_format($_SESSION['ses_total'], 2, '.', ''); ?>"><br/> <?php */ ?>
  <input type="hidden" name="currency" value="usd" size="25"><br/>
  <input type="hidden" name="customer_ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" size="25"><br/>
  <input type="hidden" name="merchant_defined_data1" value="WC" size="25"><br/>
    <input type="hidden" name="merchant_defined_data2" value="YES" size="25"><br/>
    <input type="hidden" name="merchant_defined_data13" value="Heaven Hotel" size="25"><br/>
    <input type="hidden" name="merchant_defined_data14" value="<?php echo date('d-m-y H:i'); ?>" size="25"><br/>    
    <input type="hidden" name="merchant_defined_data20" value="NO" size="25"><br/>

    <input type="hidden" name="merchant_defined_data15" id="merchant_defined_data15" value="" size="25"><br/>
    <input type="hidden" name="merchant_defined_data16" id="merchant_defined_data16" value="" size="25"><br/>

  <input type="hidden" name="override_custom_receipt_page" size="25" value="<?php echo BASE_PATH; ?>payment-successful2.html">


            </form>


<script>
  function manual_charge(frm)
  {
    var checkin = $('#checkin_date').val().split('-');
    var checkout = $('#checkout_date').val().split('-');
    checkin = checkin[2]+'-'+checkin[1]+'-'+checkin[0].substr(2)+' '+$('#checkin_hh').val()+':'+$('#checkin_mm').val();
    checkout = checkout[2]+'-'+checkout[1]+'-'+checkout[0].substr(2)+' '+$('#checkout_hh').val()+':'+$('#checkout_mm').val();
    $('#merchant_defined_data15').val(checkin);
    $('#merchant_defined_data16').val(checkout);
    frm.submit();
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
