<!-- Top header -->
<div id="top-header">
  <div class="container">
    <div class="row">
      <div class="col-xs-6">
        <div class="th-text pull-left">
          <div class="th-item"> <a href="tel:<?php echo PHONE; ?>"><i class="fa fa-phone"></i> <?php echo PHONE; ?></a> </div>
          <div class="th-item"> <a href="mailto:<?php echo COMPANY_INFO; ?>"><i class="fa fa-envelope"></i> <?php echo COMPANY_INFO; ?></a></div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="th-text pull-right">
          <div class="th-item">
            <div class="btn-group">
              <button class="btn btn-default btn-xs dropdown-toggle js-activated" type="button" data-toggle="dropdown"> English <span class="caret"></span> </button>
              <ul class="dropdown-menu">
                <li> <a href="#">ENGLISH</a> </li>
                <li> <a href="#">FRANCE</a> </li>
                <li> <a href="#">GERMAN</a> </li>
                <li> <a href="#">SPANISH</a> </li>
              </ul>
            </div>
          </div>
          <div class="th-item">
            <div class="social-icons"> 
            <?php if(FACEBOOK != '') { ?>
            <a href="<?php echo FACEBOOK; ?>" target="_blank"><i class="fa fa-facebook"></i></a> 
            <?php } if(TWITTER != '') { ?>
            <a href="<?php echo TWITTER; ?>" target="_blank"><i class="fa fa-twitter"></i></a> 
            <?php } if(YOUTUBE != '') { ?>
            <a href="<?php echo YOUTUBE; ?>" target="_blank"><i class="fa fa-youtube-play"></i></a> 
            <?php } if(INSTAGRAM != '') { ?>
            <a href="<?php echo INSTAGRAM; ?>" target="_blank"><i class="fa fa-instagram"></i></a> 
            <?php } if(LINKEDIN != '') { ?>
            <a href="<?php echo LINKEDIN; ?>" target="_blank"><i class="fa fa-linkedin"></i></a> 
            <?php } if(FLICKER != '') { ?>
            <a href="<?php echo FLICKER; ?>" target="_blank"><i class="fa fa-flickr"></i></a> 
            <?php } ?>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>




<!-- Header -->
<header>
  <!-- Navigation -->
  <div class="navbar yamm navbar-default" id="sticky">
    <div class="container">
      <div class="navbar-header">
        <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid" class="navbar-toggle"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="index.html" class="navbar-brand">         
        <!-- Logo -->
        <div id="logo"> <img id="default-logo" src="images/logo.png" alt="Heaven Hotel" style="height:44px;"> <img id="retina-logo" src="images/logo-retina.png" alt="Starhotel" style="height:44px;"> </div>
        </a> </div>
      <div id="navbar-collapse-grid" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="<?php if($page == 'index') echo 'active'; ?>"> <a href="index.html">Home</a>
          </li>
          </li>
          <li class="<?php if($page == 'room_list') echo 'active'; ?>"> <a href="room-list.html">Rooms</a></li>
          <li class="<?php if($page == 'restaurant') echo 'active'; ?>"> <a href="restaurant.html">Restaurant</a></li>
          <li class="<?php if($page == 'business') echo 'active'; ?>"> <a href="business.html">Business Meeting</a></li>          
          <li class="<?php if($page == 'event') echo 'active'; ?>"> <a href="event.html">Event Organizer</a></li>          
          <li class="<?php if($page == 'contact') echo 'active'; ?>"> <a href="contact.html">Contact us</a></li>
          <li class="<?php if($page == 'cart') echo 'active'; ?>"> <a style="color:#BA3538;" href="reservation-overview.html">Proceed Checkout</a></li>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>