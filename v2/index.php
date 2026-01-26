<?php
include('includes/open_con.php');
$page = 'index';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Heaven Hotel, DHA-Lahore </title>
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
<?php include('includes/inc.slider.php'); ?>

<!-- Rooms -->
<section class="rooms mt50">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="lined-heading"><span>Guests Favorite Rooms</span></h2>
      </div>
      <!-- Room -->
      
      <?php
$rooms = $db->Execute("SELECT * FROM ". DB_TABLE_PREFIX ."rooms WHERE active = 'Y' ORDER BY RAND() LIMIT 3");
while(!$rooms->EOF)
{
  $features = json_decode($rooms->fields('features'), true);

?>
      <!-- Room -->
      <div class="col-sm-4 standard">
        <div class="room-thumb"> <img src="up_data/pictures/<?php echo $rooms->fields('picture'); ?>" alt="room 1" class="img-responsive" />
          <div class="mask">
            <div class="main">
              <h5><?php echo $rooms->fields('name'); ?></h5>
              <div class="price"><?php echo get_price($rooms->fields('price'), $rooms->fields('price_pk'));?><span>Per Night</span></div>
            </div>
            <div class="content">
              <p><span><?php echo $rooms->fields('title'); ?></span><?php echo $rooms->fields('short_detail'); ?></p>
              <div class="row">
                <div class="col-xs-6">
                  <ul class="list-unstyled">
                    <li><i class="fa fa-check-circle"></i> <span title="<?php echo $G_SERVICES[$features[0]];?>"><?php echo substr($G_SERVICES[$features[0]], 0, 15).'...'; ?></span></li>
                    <li><i class="fa fa-check-circle"></i> <span title="<?php echo $G_SERVICES[$features[1]];?>"><?php echo substr($G_SERVICES[$features[1]], 0, 15).'...'; ?></span></li>
                    <li><i class="fa fa-check-circle"></i> <span title="<?php echo $G_SERVICES[$features[2]];?>"><?php echo substr($G_SERVICES[$features[2]], 0, 15).'...'; ?></span></li>
                  </ul>
                </div>
                <div class="col-xs-6">
                  <ul class="list-unstyled">
                    <li><i class="fa fa-check-circle"></i> <span title="<?php echo $G_SERVICES[$features[3]];?>"><?php echo substr($G_SERVICES[$features[3]], 0, 15).'...'; ?></span></li>
                    <li><i class="fa fa-check-circle"></i> <span title="<?php echo $G_SERVICES[$features[4]];?>"><?php echo substr($G_SERVICES[$features[4]], 0, 15).'...'; ?></span></li>
                    <li><i class="fa fa-check-circle"></i> <span title="<?php echo $G_SERVICES[$features[5]];?>"><?php echo substr($G_SERVICES[$features[5]], 0, 15).'...'; ?></span></li>
                  </ul>
                </div>
              </div>
              <?php /* <a href="book-<?php echo $rooms->fields('slug'); ?>.html" class="btn btn-primary btn-block">Book Now</a> */ ?>
              <a href="detail-<?php echo $rooms->fields('slug'); ?>.html" class="btn btn-success btn-block">View Details</a>
              </div>
          </div>
        </div>
      </div>
    <!-- Room Content -->
<?php
$rooms->MoveNext();
}  $rooms->Close();
?>   

      <!-- Room -->      
    </div>
  </div>
</section>

<!-- USP's -->
<section class="usp mt100">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="lined-heading"><span>Our Unique Services</span></h2>
      </div>
      <div class="col-sm-3 bounceIn appear" data-start="0">
      <div class="box-icon">
        <div class="circle"><i class="fa fa-glass fa-lg"></i></div>
        <h3>Beverages included</h3>
        <p>Complete details are mentioned later here, please stay in touch.</p>
        <a href="#">Read more<i class="fa fa-angle-right"></i></a> </div>
        </div>
      <div class="col-sm-3 bounceIn appear" data-start="400">
      <div class="box-icon">
        <div class="circle"><i class="fa fa-credit-card fa-lg"></i></div>
        <h3>Stay First, Pay After!</h3>
        <p>Complete details are mentioned later here, please stay in touch with us.</p>
        <a href="#">Read more<i class="fa fa-angle-right"></i></a> </div>
        </div>
      <div class="col-sm-3 bounceIn appear" data-start="800">
      <div class="box-icon">      
        <div class="circle"><i class="fa fa-cutlery fa-lg"></i></div>
        <h3>24 Hour Restaurant</h3>
        <p>Complete details are mentioned later here, please stay in touch with us.</p>
        <a href="#">Read more<i class="fa fa-angle-right"></i></a> </div>
        </div>
      <div class="col-sm-3 bounceIn appear" data-start="1200">
      <div class="box-icon">
        <div class="circle"><i class="fa fa-tint fa-lg"></i></div>
        <h3>Gym Included!</h3>
        <p>Complete details are mentioned later here, please stay in touch with us.</p>
        <a href="#">Read more<i class="fa fa-angle-right"></i></a> </div>
    </div>
    </div>
  </div>
</section>


<!-- Gallery -->
<section class="gallery-slider mt100">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="lined-heading"><span>Gallery</span></h2>
      </div>
    </div>
  </div>
  <div id="owl-gallery" class="owl-carousel">
    <div class="item"><a href="images/gallery/main/file1.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file1.jpg" alt="Image 1"><i class="fa fa-search"></i></a></div>
    <div class="item"><a href="images/gallery/main/file2.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file2.jpg" alt="Image 2"><i class="fa fa-search"></i></a></div>
    <div class="item"><a href="images/gallery/main/file3.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file3.jpg" alt="Image 3"><i class="fa fa-search"></i></a></div>
    <div class="item"><a href="images/gallery/main/file4.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file4.jpg" alt="Image 4"><i class="fa fa-search"></i></a></div>
    <div class="item"><a href="images/gallery/main/file5.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file5.jpg" alt="Image 1"><i class="fa fa-search"></i></a></div>
    <div class="item"><a href="images/gallery/main/file6.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file6.jpg" alt="Image 2"><i class="fa fa-search"></i></a></div>
    <div class="item"><a href="images/gallery/main/file2.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file1.jpg" alt="Image 3"><i class="fa fa-search"></i></a></div>
    <div class="item"><a href="images/gallery/main/file1.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/main/file2.jpg" alt="Image 4"><i class="fa fa-search"></i></a></div>
  </div>
</section>

<div class="container">
  <div class="row"> 
    <!-- Testimonials -->
    <section class="testimonials mt100">
      <div class="col-md-6">
        <h2 class="lined-heading bounceInLeft appear" data-start="0"><span>What Other Visitors Experienced</span></h2>
        <div id="owl-reviews" class="owl-carousel">
          <div class="item">
            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12"> <img src="images/reviews/muhammad-a.jpg" alt="Review 1" class="img-circle img-responsive" /></div>
              <div class="col-lg-9 col-md-8 col-sm-10 col-xs-12">
                <div class="text-balloon">
                  <strong>One of Best Hotels with Prime Location</strong>
                  <br>Located on entrance of DHA Lahore. Room rent varies between 4500 to 7000. The rooms are well furnished and beautifully decorated. The hotel has a saloon on to floor with spa facilities. A restaurant in basement is also nice. A standby generator and 24 hour Wifi connectivity.<span>Muhammad A, <a href="https://www.tripadvisor.com/ShowUserReviews-g295413-d7592021-r271823088-Heaven_Hotel-Lahore_Punjab_Province.html#CHECK_RATES_CONT" target="_blank">TripAdvisor</a></span> </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12"> <img src="images/reviews/avatar068.jpg" alt="Review 2" class="img-circle img-responsive" /></div>
              <div class="col-lg-9 col-md-8 col-sm-10 col-xs-12">
                <div class="text-balloon">
                  <strong>Awsum staff...</strong><br>
                  I really enjoyed my stay at heaven hotel...comfortable environment+tasty food...staff is very cooperative nd polite. ..room is also good...heaven hotel is on perfect location....everything which we want it's easily accessible...whenever we get a chance we will again stay here...InshaAllah... <span>Khushboo A, <a href="https://www.tripadvisor.com/ShowUserReviews-g295413-d7592021-r307470641-Heaven_Hotel-Lahore_Punjab_Province.html#CHECK_RATES_CONT" target="_blank">TripAdvisor</a> </span> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- About -->
    <section class="about mt100">
      <div class="col-md-6">
        <h2 class="lined-heading bounceInRight appear" data-start="800"><span>Heaven Hotel</span></h2>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#hotel" data-toggle="tab">Our hotel</a></li>
          <li><a href="#events" data-toggle="tab">Events</a></li>
          <li><a href="#kids" data-toggle="tab">Kids</a></li>
          <li><a href="#business" data-toggle="tab">Business</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane fade in active" id="hotel">
            <p>Welcome to one of the most innovative hotel, where art and originality, elegantly combine to offer you some rare spectacles.</p>
            <p><img src="images/tab/197x147.gif" alt="food" class="pull-right"> Located in a busy district, the sparkling facade and chill environment will fill you with wonder. Imagine an experience created to meet your every desire, where you are much more than a name - where service is not just a word - it is a way of being.  Prime location of Khayaban-e-Jinnah, DHA, Lahore Cantt., and distance from Airport is just 7km.
            </p>
          </div>
          <div class="tab-pane fade" id="events">We arrange all kind of events, Corporate Meeting, Seminar, Training Session, Wedding, Birthday or any other kind of get together.</div>
          <div class="tab-pane fade" id="kids"> Birthday party with beautiful ballon arrangments and well decorated cake with your desired requirement.</div>
          <div class="tab-pane fade" id="business">...</div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php include('includes/inc.footer.php'); ?>

</body>
</html>


