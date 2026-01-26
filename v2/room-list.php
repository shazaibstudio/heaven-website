<?php
include('includes/open_con.php');
$page_title = 'Rooms List';
$bread_crumb = '<li><a href="index.html">Home</a></li>
              <li class="active">'.$page_title.'</li>';
$page = 'room_list';
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
<?php /*
<!-- Filter -->
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <ul class="nav nav-pills" id="filters">
        <li class="active"><a href="#" data-filter="*">All</a></li>
        <li><a href="#" data-filter=".standard">Standard Room</a></li>
        <li><a href="#" data-filter=".standardp">Standard Plus Room</a></li>
        <li><a href="#" data-filter=".deluxe">Deluxe Room</a></li>
        <li><a href="#" data-filter=".mini">Mini Suite</a></li>
        <li><a href="#" data-filter=".executive">Executive Suite</a></li>
        <li><a href="#" data-filter=".family">Family Room</a></li>
        <li><a href="#" data-filter=".honey">Honey Moon Room</a></li>

      </ul>
    </div>
  </div>
</div>
 */ ?>
<!-- Standard Rooms -->
<section class="rooms mt100">
  <div class="container">
    <div class="row room-list fadeIn appear"> 
<?php
$rooms = $db->Execute("SELECT * FROM ". DB_TABLE_PREFIX ."rooms WHERE active = 'Y' ORDER BY pos ASC");
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
  </div>
</div>
</section>

<?php include('includes/inc.footer.php'); ?>

</body>
</html>