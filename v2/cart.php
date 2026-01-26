<?php
include('includes/open_con.php');

if(isset($cmd) && $cmd == 'remove')
{
  unset($_SESSION['ses_cart'][$index]);
  redirect("reservation-overview.html?removed=yes");
}

$page_title = 'Reservation Overview';
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




<?php
if(is_array($_SESSION['ses_cart']) && sizeof($_SESSION['ses_cart']) > 0)
{
?>

<div class="container">
    
        
            <div class="row bs-wizard" style="border-bottom:0;">
                
                <div class="col-xs-4 bs-wizard-step">
                  <div class="text-center bs-wizard-stepnum">Step 1</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">Overview of Reservation</div>
                </div>
                
                <div class="col-xs-4 bs-wizard-step disabled"><!-- complete -->
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

<?php
}
?>

<div class="mt30"></div>




    <?php if(isset($removed)) { ?>
        <div class="col-sm-12 col-md-12">
        <div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Room removed from your reservation list.</div>
        </div>
        <?php } 
        if(is_array($_SESSION['ses_cart']) && sizeof($_SESSION['ses_cart']) > 0)
        {
        ?>
        <div class="col-sm-12 col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Reservation Detail</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Nights</th>
                        <th class="text-center">Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 0;
                    $sub_total = 0;
                    $sub_total_pk = 0;
                    foreach($_SESSION['ses_cart'] as $cart)
                    {
                      $room = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."rooms WHERE id = '". $cart['room_id'] ."'");
                      $nights = $cart['nights'];
                      $total = $room['price'] * $nights;
                      $total_pk = $room['price_pk'] * $nights;

                        // if(get_session('ses_visitor_country') == 'PK')
                        // {
                        //     $total = number_format(($room['price_pk'] * $nights) * USD_RATE);
                        //     $total_cap = 'PKR ' . $total;
                        // }                            
                        // else 
                        // {
                        //     $total = number_format($room['price'] * $nights);
                        //     $total_cap = '$ ' . $total;
                        // }
                            

                    ?>
                    <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="detail-<?php echo $room['slug']; ?>.html"> <img class="media-object" src="<?php echo $room['picture'];?>" style="width: 72px;">  </a>
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
                        <td class="col-sm-1 col-md-1 text-center"><strong><?php echo get_price($room['price'], $room['price_pk']);?></strong></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center"><?php echo $nights; ?></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?php echo get_price($total, $total_pk);?></strong></td>
                        <td class="col-sm-1 col-md-1">
                        <a onclick="return window.confirm('Are you sure, you want to remove this room from your reservation list?'); " href="remove-room-<?php echo $index; ?>.html" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </a></td>
                    </tr>
                    <?
                        if(get_session('ses_visitor_country') == 'PK')
                            $sub_total_pk += $total_pk;
                        else
                            $sub_total += $total;
                      $index++;
                    }

                    if(get_session('ses_visitor_country') == 'PK')
                        $_SESSION['ses_total'] = $sub_total_pk;
                    else
                        $_SESSION['ses_total'] = $sub_total;
                    ?>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong><?php echo get_price($sub_total, $sub_total_pk);?></strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Tax</h5></td>
                        <td class="text-right"><h5><strong><?php echo get_price(0, 0);?></strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong><?php echo get_price($sub_total, $sub_total_pk);?></strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <a href="room-list.html" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Reserve Another Room
                        </a></td>
                        <td>
                        <a href="billing-details.html" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </a></td>
                    </tr>
                </tbody>
            </table>
        </div>


<? } else {?>

<div class="col-sm-12 col-md-12">
  <div class="alert alert-warning">
    <strong>Error!</strong> You don't have anything in your reservation list, click here to go to <a href="index.html">home page</a> or click here to go to <a href="room-list.html">list of our rooms</a>.
  </div>
</div>

<?php } ?>







  </div>
</div>
</section>

<?php include('includes/inc.footer.php'); ?>

</body>
</html>