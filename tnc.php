<?php
include('includes/open_con.php');
$page_title = 'Terms and Conditions';
$bread_crumb = '<li><a href="index.html">Home</a></li>
              <li class="active">'. $page_title .'</li>';
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

<div class="container">
  <div class="row"> 
<!-- Contact form -->
    <section id="contact-form" class="mt20">
      <div class="col-md-12">

        <h2 style="margin-bottom:20px;" class="lined-heading"><span>Terms and Conditions</span></h2>

          1. Check-in time is at 1400 hrs.
          <br>
          2. Please note Check-out time is at 12:00 noon.

          <br>3. Buffet breakfast is complimentary in Heaven Restaurant at 06:00am to 10:00am.
          <br>4. Late checkout will be charged.
          <br>5. Guest will be responsible for any damage done in the room.
          <br>6. Hotel prohibits all food supplies from outside caterers as well as cooking in Hotel room.
          <br> 7. The management reserves all rights of admission.
          <br>8. Hotel Management holds no responsibility of any loss of valuables & currency left in the room
          <br>9. Kindly deposit Room Key at the Front Desk while leaving hotel.
          <br>10. Guest with confirmed booking if leave earlier will be charged first night room rent.


        <br>
        <br>
        <br>
        <h2 style="margin-bottom:20px;"  class="lined-heading"><span>Refund Policy</span></h2>

        <p>
          If customer will not arrive on the date of chicken then Noshow will be charged, If guest informs two days before checkin for cancellation, then his amount can be carried forward for his next stay, when he desire to stay.
        </p>

      </div>
    </section>

     </div>
      </div>
  
<?php include('includes/inc.footer.php'); ?>

</body>
</html>