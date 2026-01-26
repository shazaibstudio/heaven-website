<?php
include('includes/open_con.php');

if($cmd == 'save-order')
{
  if(isset($btn_submit) && $btn_submit == 'Book Now Pay on Arrival')
  {
    $pay_later = true;
    $order_type = 'pay-later';
    $req_reference_number = $req_card_number = $req_card_expiry_date = $transaction_id = $message = '';
  }
  else
  {
    $pay_later = false;
    $order_type = 'reservation';
  }

  $db->Execute("UPDATE ".DB_TABLE_PREFIX."orders SET reference_number = '{$req_reference_number}', cc_number = '{$req_card_number}', cc_expiry = '{$req_card_expiry_date}', transaction_id = '{$transaction_id}', merchant_message = '{$message}', order_type = '$order_type', status = '1' WHERE session_id = '". session_id() ."'");
  $order = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."orders WHERE session_id = '". session_id() ."'");
  if($order['id'] != '')
  {
    $email_hh = 'Dear Admin,<br><br>You have just received a reservation from Heaven Hotel website, following are the details:';
    $email_cl = 'Dear '. $order['bl_first_name'] . ' ' . $order['bl_last_name'] .',<br><br>Thank you for your reservation at Heaven Hotel, following are the details of your reservation:';

    if($pay_later)
    {
      $payment_info = '
        <table width="100%" cellpadding="6" border="0" style="font-family: verdana,sans-serif; font-size;12px; border:solid 1px #CCC;border-collapse:collapse;">
          <tr>
            <td style="border:solid 1px #CCC;"><strong>Pay on Arrival</strong></td>
          </tr>
        </table>
      ';
    }
    else
    {
      $payment_info = '
        <table width="100%" cellpadding="6" border="0" style="font-family: verdana,sans-serif; font-size;12px; border:solid 1px #CCC;border-collapse:collapse;">
        <tr>
          <td width="35%" style="border:solid 1px #CCC;">Payment Date: </td>
          <td width="65%" style="border:solid 1px #CCC;">'. date('M d, Y H:i:s', strtotime($order['order_date'])) .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Credit Card Number: </td>
          <td style="border:solid 1px #CCC;">'. $req_card_number .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Amount Paid: </td>
          <td style="border:solid 1px #CCC;">$'. number_format($order['amount'], 2) .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Transaction ID: </td>
          <td style="border:solid 1px #CCC;">'. $transaction_id .'</td>
        </tr>
      </table>
      ';
    }

    $reservation_info = '
      <h2>Payment Details</h2>
      '. $payment_info .'
      <h2>Billing Details</h2>
      <table width="100%" cellpadding="6" border="0" style="font-family: verdana,sans-serif; font-size;12px; border:solid 1px #CCC;border-collapse:collapse;">
        <tr>
          <td width="35%" style="border:solid 1px #CCC;">Name: </td>
          <td width="65%" style="border:solid 1px #CCC;">'. $order['bl_first_name'].' '.$order['bl_last_name'] .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Email: </td>
          <td style="border:solid 1px #CCC;">'. $order['bl_email'] .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Phone: </td>
          <td style="border:solid 1px #CCC;">'. $order['bl_phone'] .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Address: </td>
          <td style="border:solid 1px #CCC;">'. $order['bl_address'] .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">City: </td>
          <td style="border:solid 1px #CCC;">'. $order['bl_city'] .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Zip Code: </td>
          <td style="border:solid 1px #CCC;">'. $order['bl_zip'] .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Country: </td>
          <td style="border:solid 1px #CCC;">'. $order['bl_country'] .'</td>
        </tr>
        <tr>
          <td style="border:solid 1px #CCC;">Notes / Instructions: </td>
          <td style="border:solid 1px #CCC;">'. $order['notes'] .'</td>
        </tr>
        
      </table>
      <h2>Reservation Details</h2>
    ';


    $reservation_info .= '
      <table width="100%" cellpadding="6" border="0" style="font-family: verdana,sans-serif; font-size;12px; #CCC;border-collapse:collapse;">
                <thead>
                    <tr>
                        <td style="border:solid 1px #CCC;" width="55%"><strong>Reservation Detail</strong></td>
                        <td style="border:solid 1px #CCC;" width="15%" class="text-center"><strong>Price</strong></td>
                        <td style="border:solid 1px #CCC;" width="15%" class="text-center"><strong>Nights</strong></td>
                        <td style="border:solid 1px #CCC;" width="15%" class="text-center"><strong>Total</strong></td>
                    </tr>
                </thead>
                <tbody>';
                    
                    $sub_total = 0;
                    foreach($_SESSION['ses_cart'] as $cart)
                    {
                      $room = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."rooms WHERE id = '". $cart['room_id'] ."'");
                      $nights = $cart['nights'];
                      $total = $room['price'] * $nights;
                    $reservation_info .= '
                    <tr>
                        <td style="border:solid 1px #CCC;">
                        <div class="media">
                            <div class="media-body">
                                <div style="font-weight:bold;">'. $room['name'] .'</div>
                                <div style="font-style: italic;">Checkin: '. date('M d, Y', strtotime($cart['checkin'])) .'<br>
                                Checkout: '. date('M d, Y', strtotime($cart['checkout'])) .'<br>
                                <span>Adults: '.$cart['adults']; 
                                  if(isset($cart['childern']) && $cart['childern'] > 0)
                                  {
                                    $reservation_info .= ', Children: '.$cart['childern'];
                                  }
                                  $reservation_info .= '
                                </span></div>
                            </div>
                        </div></td>
                        <td style="border:solid 1px #CCC;" class="text-center"><strong>$'.$room['price'].'</strong></td>
                        <td style="border:solid 1px #CCC;" class="text-center">'.$nights.'</td>
                        <td style="border:solid 1px #CCC;" class="text-center">$'.$total.'</strong></td>
                    </tr>';

                      $sub_total += $total;
                    }

                    
                    $reservation_info .= '
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="border:solid 1px #CCC;"><h5>Subtotal</h5></td>
                        <td style="border:solid 1px #CCC;" class="text-right"><h5><strong>$'.$sub_total.'</strong></h5></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="border:solid 1px #CCC;"><h5>Tax</h5></td>
                        <td style="border:solid 1px #CCC;" class="text-right"><h5><strong>$0</strong></h5></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="border:solid 1px #CCC;"><h3>Total</h3></td>
                        <td style="border:solid 1px #CCC;" class="text-right"><h3><strong>$'.$sub_total.'</strong></h3></td>
                    </tr>
                    
                </tbody>
            </table>';

            $footer_hh = '<br><br>--<br>Best Regards,<br>Heaven Hotel Team.';
            $footer_cl = '<br><br>Thank you for choosing Heaven Hotel.<br><br>--<br>Best Regards,<br>Heaven Hotel Team.';

            $email_client = '<div style="font-family: verdana,sans-serif; font-size;12px; ">'.$email_cl.$reservation_info.$footer_cl.'</div>';
            $email_hotel = '<div style="font-family: verdana,sans-serif; font-size;12px; ">'.$email_hh.$reservation_info.$footer_hh.'</div>';

            include('mailer/class.phpmailer.php');

            $mail             = new PHPMailer();

            $mail->IsSMTP();
            $mail->Host       = $G_MAIL_SETTINGS['SERVER'];

            $mail->Username   = $G_MAIL_SETTINGS['USERNAME'];
            $mail->Password   = $G_MAIL_SETTINGS['PASSWORD'];

            $mail->AddReplyTo("no-reply@heavenhotel.com.pk","No Reply");

            $mail->From       = "reservations@heavenhotel.com.pk";
            $mail->FromName   = "Reservations";

            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap   = 50; // set word wrap

            $mail->IsHTML(true); // send as HTML

            $mail->AddAddress($order['bl_email'], $order['bl_first_name'].' '.$order['bl_last_name']);
            $mail->Subject    = 'Thank you for your reservation at '.COMPANY_NAME;
            $mail->MsgHTML($email_client);

            $mail->Send();

            $mail->ClearAllRecipients();

            $mail->AddAddress(COMPANY_INFO);
            $mail->Subject    = 'New reservation received at '.COMPANY_NAME;
            $mail->MsgHTML($email_hotel);

            $mail->Send();

            send_mail($order['bl_email'], 'Thank you for your reservation at '.COMPANY_NAME, $email_client);
            send_mail(COMPANY_INFO, 'New reservation received at '.COMPANY_NAME, $email_hotel);

            unset($_SESSION['ses_cart'], $_SESSION['ses_billing'], $_SESSION['ses_total'], $_SESSION['ses_bill_notes']);
            session_regenerate_id(true);

            redirect('thank-you.html?oid='.$order['id']);
  }

}

$order = $db->GetRow("SELECT * FROM ". DB_TABLE_PREFIX ."orders WHERE id = '{$oid}'");

$page_title = 'Order Placed';
$bread_crumb = '<li><a href="index.html">Home</a></li>
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





<div class="col-sm-12 col-md-12">
    <br>
  <div class="alert alert-success">
    <strong>Congratulations!</strong>
        We have received your reservation, thank you so much for choosing Heaven Hotel.
    </div>
    <?php if($order['order_type'] == 'online-payment') { ?>
    Your payment Transaction ID is <strong><?php echo $order['transaction_id']; ?></strong> and your reference number is
        <strong><?php echo $order['reference_number']; ?></strong>, please save these for future reference.</strong>
    <?php } ?>
    <br>
    <br>
    Thank you once again for your reservation with us.
</div>






  </div>
</div>
</section>

<?php include('includes/inc.footer.php'); ?>

</body>
</html>