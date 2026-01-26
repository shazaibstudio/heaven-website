<?php
include('includes/open_con.php');
$page_title = 'Restaurant';
$bread_crumb = '<li><a href="index.html">Home</a></li>
              <li class="active">'. $page_title .'</li>';
$page = 'restaurant';
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

<!-- Filter -->
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <ul class="nav nav-pills" id="filters">
      </ul>
    </div>
  </div>
</div>

<!-- Gallery -->
<section id="gallery" class="mt50">
  <div class="container">
    <div class="row gallery"> 
      <!-- Restaurant -->
      <div class="col-sm-3 restaurant fadeIn appear"> <a href="images/gallery/restaurant/1.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/restaurant/1.jpg" alt="image" class="img-responsive zoom-img" /><i class="fa fa-search"></i></a> </div>

      <div class="col-sm-3 restaurant fadeIn appear"> <a href="images/gallery/restaurant/2.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/restaurant/2.jpg" alt="image" class="img-responsive zoom-img" /><i class="fa fa-search"></i></a> </div>

      <div class="col-sm-3 restaurant fadeIn appear"> <a href="images/gallery/restaurant/3.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/restaurant/3.jpg" alt="image" class="img-responsive zoom-img" /><i class="fa fa-search"></i></a> </div>

      <div class="col-sm-3 restaurant fadeIn appear"> <a href="images/gallery/restaurant/4.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/gallery/restaurant/4.jpg" alt="image" class="img-responsive zoom-img" /><i class="fa fa-search"></i></a> </div>


    </div>
  </div>
</section>

<div class="container">
  <div class="row"> 
<!-- Contact form -->
    <section id="contact-form" class="mt50">
      <div class="col-md-12">
        <h2 class="lined-heading"><span>Book a table now in our restaurant</span></h2>
        <p>Enjoyment is key with Heaven Restaurant, which clearly shows in our restaurant. Our friendly staff is happy to serve you a typical Continental, Chinese, Pakistani, turkish dishes, which are carefully prepared from our 100% hygienic kitchen.</p>
        <div id="message"></div>
        <!-- Error message display -->
        <form class="clearfix mt50" role="form" method="post" action="php/contact.php" name="contactform" id="contactform">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="name" accesskey="U"><span class="required">*</span> Name</label>
                <input name="name" type="text" id="name" class="form-control" value=""/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="phone" accesskey="U"><span class="required">*</span> Phone No.</label>
                <input name="phone" type="text" id="phone" class="form-control" value=""/>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="email" accesskey="E"><span class="required">*</span> E-mail</label>
                <input name="email" type="text" id="email" value="" class="form-control"/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="subject" accesskey="S">Subject</label>
            <select name="subject" id="subject" class="form-control">
              <option value="Booking">Booking</option>
              <option value="a Room">Information</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="comments" accesskey="C"><span class="required">*</span> Your Booking Details</label>
            <textarea name="comments" rows="9" id="comments" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label><span class="required">*</span> Spam Filter: &nbsp;&nbsp;&nbsp;3 + 1 =</label>		  
            <input name="verify" type="text" id="verify" value="" class="form-control" placeholder="Please enter the outcome" />
          </div>
          <button type="submit" class="btn  btn-lg btn-primary">Send</button>
        </form>
      </div>
    </section>

     </div>
      </div>
  
<?php include('includes/inc.footer.php'); ?>

</body>
</html>