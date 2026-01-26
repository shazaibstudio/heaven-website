<?php
include('includes/open_con.php');
$room = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."rooms WHERE slug = '{$slug}'");
$page_title = $room['name'].' Detail';
$bread_crumb = '<li><a href="index.html">Home</a></li>
              <li><a href="room-list.html">Rooms List</a></li>
              <li class="active">'.$page_title.'</li>';
$page = 'room_detail';
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

<div class="container mt50">
  <div class="row"> 
    <!-- Slider -->
    <section class="standard-slider room-slider">
      <div class="col-sm-12 col-md-8">
        <img src="up_data/pictures/<?php echo $room['picture']; ?>" class="img-responsive img-rounded">
        <?php /* ?>
        <div id="owl-standard" class="owl-carousel">
          <div class="item"> <a href="images/rooms/slider/1.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/1.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/2.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/2.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/3.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/3.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/4.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/4.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/5.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/5.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/6.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/6.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/7.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/7.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/8.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/8.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/9.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/9.jpg" alt="Image 2" class="img-responsive"></a> </div>
          <div class="item"> <a href="images/rooms/slider/10.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/rooms/slider/10.jpg" alt="Image 2" class="img-responsive"></a> </div>
        </div>
      <?php */ ?>
      </div>
    </section>
    
    <!-- Reservation form -->
    <section id="reservation-form" class="mt50 clearfix">
      <div class="col-sm-12 col-md-4">
        <form class="reservation-vertical clearfix" role="form" method="post" action="php/reservation.php" name="reservationform" id="reservationform">
          <input type="hidden" name="room" value="<?php echo $room['id'];?>" id="room">
          <h2 class="lined-heading"><span>Reservation</span></h2>
          <div class="price">
          <div id="message"></div>
          <!-- Error message display -->
            <div class="form-group">
              <label for="checkin">Rent Per Night&nbsp;&nbsp;&nbsp;</label>
              <?php echo get_price($room['price'], $room['price_pk']);?>
            </div>
            <hr>
          <div class="form-group">
            <label for="checkin">Check-in</label>
            <div class="popover-icon" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Check-In is from 11:00"> <i class="fa fa-info-circle fa-lg"> </i> </div>
            <i class="fa fa-calendar infield"></i>
            <input name="checkin" type="text" id="checkin" value="" class="form-control" placeholder="Check-in"/>
          </div>
          <div class="form-group">
            <label for="checkout">Check-out</label>
            <div class="popover-icon" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Check-out is from 12:00"> <i class="fa fa-info-circle fa-lg"> </i> </div>
            <i class="fa fa-calendar infield"></i>
            <input name="checkout" type="text" id="checkout" value="" class="form-control" placeholder="Check-out"/>
          </div>
          <div class="form-group">
            <div class="guests-select">
              <label>Guests</label>
              <i class="fa fa-user infield"></i>
              <div class="total form-control" id="test">1</div>
              <div class="guests">
                <div class="form-group adults">
                  <label for="adults">Adults</label>
                  <div class="popover-icon" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="+18 years"> <i class="fa fa-info-circle fa-lg"> </i> </div>
                  <select name="adults" id="adults" class="form-control">
                    <option value="1">1 adult</option>
                    <option value="2">2 adults</option>
                    <option value="3">3 adults</option>
                  </select>
                </div>
                <div class="form-group children">
                  <label for="children">Children</label>
                  <div class="popover-icon" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="0 till 18 years"> <i class="fa fa-info-circle fa-lg"> </i> </div>
                  <select name="children" id="children" class="form-control">
                    <option value="0">0 children</option>
                    <option value="1">1 child</option>
                    <option value="2">2 children</option>
                    <option value="3">3 children</option>
                  </select>
                </div>
                <button type="button" class="btn btn-default button-save btn-block">Save</button>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Book Now</button>
        </form>
      </div>
    </section>
    
    <!-- Room Content -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-7 mt50">
            <h2 class="lined-heading"><span>Room Details</span></h2>
            <p><?php echo stripslashes($room['detail']); ?></p>
            <?php
            if($room['features'] != '')
            {
              $services = json_decode($room['features'], true);
              if(is_array($services) && count($services) > 0) {
                ?>
                <h3 class="mt50">Free Services</h3>
                <table class="table table-striped mt30">
                  <tbody>
                  <?php
                  $room['features'] = '';
                  $inc = 0;
                  foreach ($services as $service) {
                    $inc++;
                    if ($inc == 4) {
                      echo '</tr><tr>';
                      $inc = 1;
                    }
                    ?>

                    <td width="25%"><i class="fa fa-check-circle"></i> <?php echo $G_SERVICES[$service]; ?></td>

                    <?php
                  }
                  ?>

                  </tbody>
                </table>
                <p class="mt50"></p>
                <?php
              }
            }

            if($room['features_paid'] != '')
            {
              $services = json_decode($room['features_paid'], true);
              if(is_array($services) && count($services) > 0) {
                ?>
                <h3 class="mt50">Paid Services</h3>
                <table class="table table-striped mt30">
                  <tbody>
                  <?php
                  $room['features'] = '';
                  $inc = 0;
                  foreach ($services as $service) {
                    $inc++;
                    if ($inc == 4) {
                      echo '</tr><tr>';
                      $inc = 1;
                    }
                    ?>

                    <td width="25%"><i class="fa fa-check-circle"></i> <?php echo $G_SERVICES[$service]; ?></td>

                    <?php
                  }
                  ?>

                  </tbody>
                </table>
                <p class="mt50"></p>
                <?php
              }
            }
            ?>
          </div>
          <div class="col-sm-5 mt50">
            <h2 class="lined-heading"><span>Overview</span></h2>
            
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
              <li class="active"><a href="#overview" data-toggle="tab">Overview</a></li>
              <li><a href="#facilities" data-toggle="tab">Facilities</a></li>
              <li><a href="#extra" data-toggle="tab">Extra</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane fade in active" id="overview">
                <p>Your best staying option is always Heaven Hotel for business or other, the bedrooms are designed to give guests the maximum comfort. </p>
                <p><img src="images/tab/197x147.gif" alt="food" class="pull-right"> Our 44 rooms includes mini suites, executive suites, deluxe, twin, inter-connected & standard rooms.  The rooms have been tastefully decorated and modernized while retaining their unmistakably traditional feel. You will feel at home here.</p>
              </div>
              <div class="tab-pane fade" id="facilities">Luxury en-suite bathrooms with exclusive toiletries, LEDs with satellite channels, WiFi Broadband internet access in all rooms and public areas. Digital telephone, Mini Bar, Safe deposit box, Selection of quality magazines, Plenty of hanging space, 24 hours Room service, same day laundry and dry cleaning service, Individually control thermostat Facilities In room for warm or cool.</div>
              <div class="tab-pane fade" id="extra">Rent a Car facility, Airline Booking.</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php include('includes/inc.footer.php'); ?>

</body>
</html>