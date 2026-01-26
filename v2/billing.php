<?php
include('includes/open_con.php');

if(!is_array($_SESSION['ses_cart']) || sizeof($_SESSION['ses_cart']) == 0)
{
  redirect('reservation-overview.html');
}

if(isset($save) && $save == 'yes')
{
  $_SESSION['ses_bill_notes'] = $_POST['bill_notes'];
  unset($_POST['save'], $_POST['bill_notes']);

  if($bill_to_address_state != '')
    $_POST['signed_field_names'] = $_POST['signed_field_names'].',bill_to_address_state';
  else
      unset($_POST['signed_field_names']);

  $_SESSION['ses_billing'] = $_POST;
  redirect('confirm-reservation.html');
}

if(is_array($_SESSION['ses_billing']) && sizeof($_SESSION['ses_billing']) > 0)
{
  foreach($_SESSION['ses_billing'] as $k => $v)
  {
      $$k = stripslashes($v);
  }  
}
else
{
    $bill_to_forename = $bill_to_surname = $bill_to_email = $bill_to_phone = 
    $bill_to_address_line1 = $bill_to_address_city = $bill_to_address_postal_code = 
    $bill_to_address_country = '';
}

$page_title = 'Billing Details';
$bread_crumb = '<li><a href="index.html">Home</a></li>
              <li><a href="reservation-overview.html">Reservation Overview</a></li>
              <li class="active">'.$page_title.'</li>';
$page = 'cart';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Heaven Hotel </title>
<?=$base_tag;?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="shortcut icon" href="favicon.ico">

<!-- Stylesheets -->
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/owl.carousel.css">
<link rel="stylesheet" href="css/owl.theme.css">
<link rel="stylesheet" href="css/prettyPhoto.css">
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.min.css">
<link rel="stylesheet" href="rs-plugin/css/settings.css">
<link rel="stylesheet" href="css/theme.css">
<link rel="stylesheet" href="css/colors/turquoise.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600,700">

<!-- Javascripts --> 
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script> 
<script type="text/javascript" src="js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/bootstrap-hover-dropdown.min.js"></script> 
<script type="text/javascript" src="js/owl.carousel.min.js"></script> 
<script type="text/javascript" src="js/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="js/jquery.nicescroll.js"></script>  
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script> 
<script type="text/javascript" src="js/jquery.jigowatt.js"></script> 
<script type="text/javascript" src="js/jquery.sticky.js"></script> 
<script type="text/javascript" src="js/waypoints.min.js"></script> 
<script type="text/javascript" src="js/jquery.isotope.min.js"></script> 
<script type="text/javascript" src="js/jquery.gmap.min.js"></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="rs-plugin/js/jquery.themepunch.plugins.min.js"></script> 
<script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script> 
<script type="text/javascript" src="js/custom.js"></script> 
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<?php include('includes/inc.header.php'); ?>
<?php include('includes/inc.bread_crumb.php'); ?>

<!-- Standard Rooms -->
<section class="rooms">
  <div class="container">
    <div class="row fadeIn appear"> 






<div class="container">
    
        
            <div class="row bs-wizard" style="border-bottom:0;">
                
                <div class="col-xs-4 bs-wizard-step complete">
                  <div class="text-center bs-wizard-stepnum">Step 1</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Overview of Reservation</div>
                </div>
                
                <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Step 2</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Enter Billing Details</div>
                </div>
                
                <div class="col-xs-4 bs-wizard-step disabled"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Step 3</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Confirm Reservation</div>
                </div>
                
            </div>
   
</div>

<div class="mt30"></div>




    <?php if(isset($removed)) { ?>
        <div class="col-sm-12 col-md-12">
        <div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Room removed from your reservation list.</div>
        </div>
        <?php } ?>
        

<div class="col-sm-12 col-md-10 col-md-offset-1">

<h2>Please Enter Your Billing Details</h2>
  <form action="" method="post">
  <div class="form-group">
    <label for="bill_to_forename">First Name:</label>
    <input type="text" class="form-control" id="bill_to_forename" name="bill_to_forename" required="required" value="<?php echo $bill_to_forename; ?>">
  </div>
  <div class="form-group">
    <label for="bill_to_surname">Last Name:</label>
    <input type="text" class="form-control" id="bill_to_surname" name="bill_to_surname" required="required" value="<?php echo $bill_to_surname; ?>">
  </div>
  <div class="form-group">
    <label for="bill_to_email">Email Address:</label>
    <input type="email" class="form-control" id="bill_to_email" name="bill_to_email" required="required" value="<?php echo $bill_to_email; ?>">
  </div>
  <div class="form-group">
    <label for="bill_to_phone">Phone Number:</label>
    <input type="text" class="form-control" id="bill_to_phone" name="bill_to_phone" required="required" value="<?php echo $bill_to_phone; ?>">
  </div>
  <div class="form-group">
    <label for="bill_to_address_line1">Address:</label>
    <input type="text" class="form-control" id="bill_to_address_line1" name="bill_to_address_line1" required="required" value="<?php echo $bill_to_address_line1; ?>">
  </div>
  <div class="form-group">
    <label for="bill_to_address_city">City:</label>
    <input type="text" class="form-control" id="bill_to_address_city" name="bill_to_address_city" required="required" value="<?php echo $bill_to_address_city; ?>">
  </div>
  <div class="form-group">
    <label for="bill_to_address_postal_code">Zip Code:</label>
    <input type="text" class="form-control" id="bill_to_address_postal_code" name="bill_to_address_postal_code" required="required" value="<?php echo $bill_to_address_postal_code; ?>">
  </div>
  <div class="form-group">
    <label for="bill_to_address_country">Country:</label>
    <select id="bill_to_address_country" name="bill_to_address_country" class="form-control" onchange="check_country(this.value);">
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
  </div>
  
  <div class="form-group <?php if(!($bill_to_address_country == 'CA' || $bill_to_address_country == 'US')) echo 'hidden'; ?>" id="div_states">
    <label for="bill_to_address_state">State:</label>
    <div id="states_box">

      <?php
        if($bill_to_address_country == 'CA' || $bill_to_address_country == 'US')
        {
          $states = $db->Execute("SELECT s.name, s.abbrev 
                                FROM  ".DB_TABLE_PREFIX."states s,  ".DB_TABLE_PREFIX."countries c
                                WHERE s.country_id = c.id
                                AND c.iso_code_2 = '{$bill_to_address_country}'
                                ORDER BY name ASC ");
          echo '<select class="form-control" name="bill_to_address_state" id="bill_to_address_state">';
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
  </div>

  <div class="form-group">
    <label for="bill_to_address_postal_code">Notes / Instructions:</label>
    <textarea class="form-control" id="bill_notes" name="bill_notes" rows="5"><?php echo stripslashes($_SESSION['ses_bill_notes']); ?></textarea>
  </div>
  <button type="submit" class="btn btn-success">Submit</button>
  <input type="hidden" name="save" value="yes">

    <input type="hidden" name="access_key" value="<?php echo ACCESS_KEY; ?>">
  <input type="hidden" name="profile_id" value="<?php echo PROFILE_ID; ?>">
  <input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
  <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_address_line1,bill_to_address_city,bill_to_address_country,bill_to_email,bill_to_forename,bill_to_surname,bill_to_address_postal_code,bill_to_phone,customer_ip_address,merchant_defined_data1,merchant_defined_data2,merchant_defined_data13,merchant_defined_data14,merchant_defined_data15,merchant_defined_data16,merchant_defined_data20,override_custom_receipt_page,consumer_id">
  <input type="hidden" name="unsigned_field_names">
  <input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
  <input type="hidden" name="locale" value="en">
  <input type="hidden" name="transaction_type" value="sale" size="25"><br/>
  <input type="hidden" name="reference_number" value="<?php echo time(); ?>" size="25"><br/>
  <input type="hidden" name="amount" size="25" value="<?php echo number_format($_SESSION['ses_total'], 2, '.', ''); ?>"><br/>
  <input type="hidden" name="currency" value="usd" size="25"><br/>
  <input type="hidden" name="customer_ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" size="25"><br/>
  <input type="hidden" name="merchant_defined_data1" value="WC" size="25"><br/>
    <input type="hidden" name="merchant_defined_data2" value="YES" size="25"><br/>
    <input type="hidden" name="merchant_defined_data13" value="Heaven Hotel" size="25"><br/>
    <input type="hidden" name="merchant_defined_data14" value="<?php echo date('d-m-y H:i'); ?>" size="25"><br/>
    <input type="hidden" name="merchant_defined_data15" value="<?php echo date('d-m-y', strtotime($_SESSION['ses_cart'][0]['checkin'])).' 10:00'; ?>" size="25"><br/>
    <input type="hidden" name="merchant_defined_data16" value="<?php echo date('d-m-y', strtotime($_SESSION['ses_cart'][0]['checkout'])).' 17:00'; ?>" size="25"><br/>
    <input type="hidden" name="merchant_defined_data20" value="NO" size="25"><br/>
  <input type="hidden" name="override_custom_receipt_page" size="25" value="<?php echo BASE_PATH; ?>payment-successful.html">



</form>

</div>


  </div>
</div>
</section>

<?php include('includes/inc.footer.php'); ?>

</body>
</html>