<?php
include('includes/open_con.php');
if(!isset($_SESSION['ses_billing']) || sizeof($_SESSION['ses_billing']) == 0)
{
  redirect('billing-details.html');
}

$page_title = 'Confirm Reservation Details';
$bread_crumb = '<li><a href="index.html">Home</a></li>
              <li><a href="reservation-overview.html">Reservation Overview</a></li>
              <li><a href="billing-details.html">Billing Details</a></li>
              <li class="active">'.$page_title.'</li>';
$page = 'cart';

foreach($_SESSION['ses_billing'] as $k => $v)
{
    $$k = stripslashes($v);
}

$order_id = $db->GetOne("SELECT id FROM ". DB_TABLE_PREFIX ."orders WHERE session_id = '". session_id() ."'");
if($order_id == '') // order exists, so update it
{
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
          reference_number = '". $reference_number ."',
          amount        = '". $_SESSION['ses_total'] ."',
          notes         = '". $_SESSION['ses_bill_notes'] ."',
          customer_ip   = '". $_SERVER['REMOTE_ADDR'] ."',
          order_date    = NOW()
          ";

   $db->Execute($sql);
   $order_id = $db->Insert_ID();
}
else // insert order with 0 status, means pending
{
  $sql = "UPDATE ". DB_TABLE_PREFIX ."orders SET
          bl_first_name = '". $bill_to_forename ."',
          bl_last_name  = '". $bill_to_surname ."',
          bl_email      = '". $bill_to_email ."',
          bl_phone      = '". $bill_to_phone ."',
          bl_address    = '". $bill_to_address_line1 ."',
          bl_city       = '". $bill_to_address_city ."',
          bl_zip        = '". $bill_to_address_postal_code ."',
          bl_country    = '". $bill_to_address_country ."',
          reference_number = '". $reference_number ."',
          amount        = '". $_SESSION['ses_total'] ."',
          notes         = '". $_SESSION['ses_bill_notes'] ."',
          customer_ip   = '". $_SERVER['REMOTE_ADDR'] ."',
          order_date    = NOW()
          WHERE session_id = '". session_id() ."'
          ";

  $db->Execute($sql);        
}

$_SESSION['ses_billing']['consumer_id'] = $order_id;

$db->Execute("DELETE FROM ". DB_TABLE_PREFIX ."orders_rooms WHERE order_id = '{$order_id}'");

foreach($_SESSION['ses_cart'] as $cart)
{
  $room = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."rooms WHERE id = '". $cart['room_id'] ."'");
  $nights = $cart['nights'];    
  $sql = "INSERT INTO ". DB_TABLE_PREFIX ."orders_rooms SET
          order_id      = '{$order_id}',
          room_id       = '". $room['id'] ."',
          room_name     = '". $room['name'] ."',
          price         = '". $room['price'] ."',
          checkin_date  = '". $cart['checkin'] ."',
          checkout_date = '". $cart['checkout'] ."',
          nights        = '". $nights ."',
          adults        = '". $cart['adults'] ."',
          children      = '". $cart['childern'] ."'
          ";
  $db->Execute($sql);
}
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
                
                <div class="col-xs-4 bs-wizard-step complete"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Step 2</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Enter Billing Details</div>
                </div>
                
                <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Step 3</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Confirm Reservation</div>
                </div>
                
            </div>
   
</div>

<div class="mt30"></div>

<form action="https://secureacceptance.cybersource.com/pay" method="post">

<div class="col-sm-12 col-md-12">

<h2>Confirm Reservation</h2>

<div class="col-sm-12 col-md-6">

  

  <h3>Billing Details</h3>    
    <table class="table table-striped">
    <tbody>
      <tr>
        <th>First Name:</th>
        <td><?php echo $bill_to_forename; ?></td>
      </tr>
      <tr>
        <th>Last Name:</th>
        <td><?php echo $bill_to_surname; ?></td>
      </tr>

      <tr>
        <th>Email Address:</th>
        <td><?php echo $bill_to_email; ?></td>
      </tr>
      <tr>
        <th>Phone Number:</th>
        <td><?php echo $bill_to_phone; ?></td>
      </tr>
      <tr>
        <th>Address:</th>
        <td><?php echo $bill_to_address_line1; ?></td>
      </tr>
      <tr>
        <th>City:</th>
        <td><?php echo $bill_to_address_city; ?></td>
      </tr>
      <tr>
        <th>Zip Code:</th>
        <td><?php echo $bill_to_address_postal_code; ?></td>
      </tr>
      <tr>
        <th>Country:</th>
        <td>
            <?php
              echo $db->GetOne("SELECT country_name FROM ".DB_TABLE_PREFIX."countries WHERE iso2 = '". $bill_to_address_country ."'");
            ?>
        </td>
      </tr>
      <tr>
        <th>Notes / Instructions:</th>
        <td>
            <?php echo stripslashes(nl2br($_SESSION['ses_bill_notes'])); ?>
        </td>
      </tr>
    </tbody>
  </table>






</div>


<div class="col-sm-12 col-md-6">

  <h3>Reservation Details</h3>    

 
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="55%">Reservation Detail</th>
                        <th width="15%" class="text-center">Price</th>
                        <th width="15%" class="text-center">Nights</th>
                        <th width="15%" class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    $sub_total = 0;
                    foreach($_SESSION['ses_cart'] as $cart)
                    {
                      $room = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."rooms WHERE id = '". $cart['room_id'] ."'");
                      $nights = $cart['nights'];
                      $total = $room['price'] * $nights;
                    ?>
                    <tr>
                        <td>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><a href="detail-<?php echo $room['slug']; ?>.html"><?php echo $room['name']; ?></a></h4>
                                <h5 class="media-heading">Checkin: <?php echo date('M d, Y', strtotime($cart['checkin'])); ?></h5>
                                <h5 class="media-heading">Checkout: <?php echo date('M d, Y', strtotime($cart['checkout'])); ?></h5>
                                <span>
                                  <?php 
                                  echo 'Adults: '.$cart['adults']; 
                                  if(isset($cart['childern']) && $cart['childern'] > 0)
                                  {
                                    echo ', Children: '.$cart['childern'];
                                  }
                                  ?>

                                </span>
                            </div>
                        </div></td>
                        <td class="text-center"><strong><?php echo '$'.$room['price']; ?></strong></td>
                        <td class="text-center"><?php echo $nights; ?></td>
                        <td class="text-center"><strong><?php echo '$'.$total; ?></strong></td>
                    </tr>
                    <?
                      $sub_total += $total;
                      $index++;
                    }

                    $_SESSION['ses_total'] = $sub_total;
                    ?>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong><?php echo '$'.$sub_total;?></strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Tax</h5></td>
                        <td class="text-right"><h5><strong>$0</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong><?php echo '$'.$sub_total;?></strong></h3></td>
                    </tr>
                    
                </tbody>
            </table>
        









 </div>


<div class="col-sm-12 col-md-12">
  <button onclick="this.form.action='https://secureacceptance.cybersource.com/pay';" name="btn_submit" type="submit" class="pull-right btn btn-success" value="Book Now and Make Payment Online">Book Now and Make Payment Online</button>
  <button onclick="this.form.action='payment-successful.html';" name="btn_submit" style="margin-right:10px;" type="submit" class="pull-right btn btn-primary" value="Book Now Pay on Arrival">Book Now AND Pay on Arrival</button>
</div>


</div>

<?php
foreach($_SESSION['ses_billing'] as $k => $v)
{
  $params[$k] = $v;
?>
<input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>">
<?php
}
echo "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . sign($params) . "\"/>\n";
?>

</form>


  </div>
</div>
</section>

<?php include('includes/inc.footer.php'); ?>

</body>
</html>