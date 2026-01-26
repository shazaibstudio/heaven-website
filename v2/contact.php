<?php
include('includes/open_con.php');
$page_title = 'Contact';
$bread_crumb = '<li><a href="index.html">Home</a></li>
              <li class="active">'. $page_title .'</li>';
$page = 'contact';
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


<div class="container">
  <div class="row"> 
<!-- GMap -->

  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3402.335625843331!2d74.37848390772677!3d31.487457301248018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391905e736c10b35%3A0xd77f189b7844fa99!2sHeaven+Hotel+%26+Restaurant!5e0!3m2!1sen!2s!4v1467280124286" width="1200" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
</div>
<div class="container">
  <div class="row"> 
    <!-- Contact form -->
    <section id="contact-form" class="mt50">
      <div class="col-md-8">
        <h2 class="lined-heading"><span>Send a message</span></h2>
        <p>For room reservation or other information, please feel free to contact us.</p>
        <div id="message"></div>
        <!-- Error message display -->
        <form class="clearfix mt50" role="form" method="post" action="php/contact.php" name="contactform" id="contactform">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" accesskey="U"><span class="required">*</span> Your Name</label>
                <input name="name" type="text" id="name" class="form-control" value=""/>
              </div>
            </div>
            <div class="col-md-6">
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
              <option value="a Room">Room</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="comments" accesskey="C"><span class="required">*</span> Your message</label>
            <textarea name="comments" rows="9" id="comments" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label><span class="required">*</span> Spam Filter: &nbsp;&nbsp;&nbsp;3 + 1 =</label>		  
            <input name="verify" type="text" id="verify" value="" class="form-control" placeholder="Please enter the outcome" />
          </div>
          <button type="submit" class="btn  btn-lg btn-primary">Send message</button>
        </form>
      </div>
    </section>
    
    <!-- Contact details -->
    <section class="contact-details mt50">
      <div class="col-md-4">
        <h2 class="lined-heading"><span>Address</span></h2>
        <a href="images/contact/948x632.gif" data-rel="prettyPhoto"><img src="images/contact/heaven.jpg" alt="Image 1" class="img-thumbnail img-responsive"></a>
        <address class="mt50">
        <strong>Heaven Hotel</strong><br>
        Khayaban-e-Jinnah, Main DHA Gate,<br>
        Lahore Cant. Pakistan.<br>
        <abbr title="Phone">P:</abbr> <a href="#">+92 42 35899815</a><br>
        <abbr title="Email">E:</abbr> <a href="#">info@heavenhotel.com.pk</a><br>
        <abbr title="Website">W:</abbr> <a href="#">www.heavenhotel.com.pk</a><br>
        </address>
        <h2 class="lined-heading mt50"><span>Social</span></h2>
        <div class="row">
          <div class="col-xs-4">
            <div class="box-icon"> <a href="#">
              <div class="circle"><i class="fa fa-facebook fa-lg"></i></div>
              </a> </div>
          </div>
          <div class="col-xs-4">
            <div class="box-icon"> <a href="#">
              <div class="circle"><i class="fa fa-twitter fa-lg"></i></div>
              </a> </div>
          </div>
          <div class="col-xs-4">
            <div class="box-icon"> <a href="#">
              <div class="circle"><i class="fa fa-linkedin fa-lg"></i></div>
              </a> </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>


<?php include('includes/inc.footer.php'); ?>

</body>
</html>