<?php
/**
* Template Name: Triumph
* @package  WordPress Landing Pages
* @author   Inbound Template Generator
*/

/* Declare Template Key */
$key = basename(dirname(__FILE__));
$path = LANDINGPAGES_UPLOADS_URLPATH ."$key/";
$url = plugins_url();


/* Include ACF Field Definitions  */
include_once(LANDINGPAGES_PATH.'templates/'.$key.'/config.php');

/* Enqueue Styles and Scripts */
function triumph_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'triumph-bootstrap-js', plugins_url('assets/js/bootstrap.min.js', __FILE__),'','', true );
	wp_enqueue_script( 'triumph-retina-js', plugins_url('assets/js/retina-1.1.0.js', __FILE__),'','', true );
	wp_enqueue_script( 'triumph-ie-bug-js', plugins_url('assets/js/ie10-viewport-bug-workaround.js', __FILE__),'','', true );
	wp_enqueue_script( 'triumph-classie-js', plugins_url('assets/js/classie.js', __FILE__),'','', true );
	wp_enqueue_script( 'triumph-smoothscroll-js', plugins_url('assets/js/smoothscroll.js', __FILE__),'','', true );
	
	wp_enqueue_style( 'triumph-bootstrap-css', plugins_url('assets/css/bootstrap.css', __FILE__) );
	wp_enqueue_style( 'triumph-css', plugins_url('assets/css/style.css', __FILE__) );
	wp_enqueue_style( 'triumph-fontawesome', plugins_url('assets/css/font-awesome.min.css', __FILE__) );
}

add_action('wp_enqueue_scripts', 'triumph_enqueue_scripts');

/* Define Landing Pages's custom pre-load hook for 3rd party plugin integration */
do_action('wp_head');

if (have_posts()) : while (have_posts()) : the_post();

$post_id = get_the_ID();
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>  <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>  <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php wp_title(); ?></title>

    <!-- Bootstrap core CSS 
    <link href="assets/css/bootstrap.css" rel="stylesheet"> -->

    <!-- Custom styles for this template 
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet"> -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body data-spy="scroll" data-offset="0" data-target="#navbar-main">

<?php 

	$header_logo				 = get_field("header_logo", $post_id);
	$header_logo_link			 = get_field("header_logo_link", $post_id);
	$header_bg_color			 = get_field("header_bg_color", $post_id);
	$navigation_links_text_color = get_field("navigation_links_text_color", $post_id);
	?>
	<section id="navbar-main">
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color:<?php echo $header_bg_color; ?>">
		<div class="container">
			<div class="navbar-header">

		<?php
		/* Start header_nav_links Repeater Output Mobile */
		if ( have_rows( "header_nav_links" ) )  { ?>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<?php $first = true;

			while ( have_rows( "header_nav_links" ) ) : the_row();
					$navbar_link_text = get_sub_field("navbar_link_text");
					$navbar_link_url = get_sub_field("navbar_link_url");
					if ( $first ) {
						?>
						<span class="sr-only">Toggle navigation</span>
						<?php
						$first = false;
					} else {
						?>
						<span class="icon-bar"></span>
						<?php
					}
			?>

			<?php endwhile; ?>
					</button>
		<?php } /* end if have_rows(header_nav_links) */
		/* End header_nav_links Repeater Output Mobile */
		?>			
					<a class="navbar-brand" href="<?php echo $header_logo_link; ?>"><img src="<?php echo $header_logo; ?>"/></a>
				</div>
		<?php

		/* Start header_nav_links Repeater Output */
		if ( have_rows( "header_nav_links" ) )  {
			$first = true; ?>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">

			<?php while ( have_rows( "header_nav_links" ) ) : the_row();
					$navbar_link_text = get_sub_field("navbar_link_text");
					$navbar_link_url = get_sub_field("navbar_link_url");
					if ( $first ) {
						?>
						<li class="active"><a href="<?php echo $navbar_link_url; ?>" class="smoothScroll"><?php echo $navbar_link_text; ?></a></li>
						<?php
						$first = false;
					} else {
						?>
						<li><a href="<?php echo $navbar_link_url; ?>" class="smoothScroll"><?php echo $navbar_link_text; ?></a></li>
						<?php
					}
			?>

			<?php endwhile; ?>
						</ul>
					</div><!--/.nav-collapse -->

		<?php } /* end if have_rows(header_nav_links) */
		/* End header_nav_links Repeater Output */
?>
			</div>
		</div>
	</section>

	          
	<section id="home"></section>
	<div id="w">
	    <div class="container">
			<div class="row centered">
				<h4>THE WORLD'S BEST LANDING PAGES</h4>
				<h1>LANDING SUMO</h1>
				<hr class="aligncenter">
			</div><! --/row -->
	    </div><!-- /.container -->
	</div><! --/W Header -->
	
	<section id="about">
		<div id="gs">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-4 centered">
						<img src="assets/img/phone.png" height="450">
						<h4>ALL IN ONE PACKAGE</h4>
						<p class="intro">Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
						<hr class="aligncenter">
						<div class="mt">
							<button class="btn btn-lg btn-dark">See more about this</button>
						</div>
					</div><! --/col-md-4 -->
				</div><! --/row -->
			</div><! --/container -->
		</div><! --/GS -->
	</section>
	
	<section id="news" class="news">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-6 section-bg-color">
					<h3>Is Lorem Ipsum Really Important?</h3>
					<p class="hidden-sm">Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
					<p class="hidden-sm">Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas. Ut non enim eleifend felis pretium feugiat.</p>
					<p><button class="btn btn-dark">Read Full Article</button></p>
				</div>
			</div><! --/row -->
		</div><! --/container -->
	</section><! --/news section -->
	
	<div id="gs">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4 centered">
					<h4>A GREAT PLACE FOR YOU</h4>
					<p class="intro">Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
					<hr class="aligncenter">
				</div><! --/ col-md-4 -->
			</div><! --/row -->		
		</div><! --/container -->
		
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<img class="img-responsive" src="assets/img/pic01.jpg" alt="">
					<div class="social-icons centered">
						<a href="#"><i class="fa fa-apple"></i></a>
						<a href="#"><i class="fa fa-android"></i></a>
						<a href="#"><i class="fa fa-windows"></i></a>
					</div>
				</div>
			</div><! --/row -->
		</div><! --/ container -->
	</div><! --/ GS -->
	
	
	<div class="container ptb">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 centered">
				<h4>A NEW KIND OF PRODUCT</h4>
				<p class="intro">Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
				<p class="intro">Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas. Ut non enim eleifend felis pretium feugiat. Vivamus quis mi. Dummy text of the printing and typesetting.</p>
				<hr class="aligncenter">
			</div><! --/ col-md-4 -->
		</div><! --/row -->
		
		<div class="row mt">
			<div class="col-md-6 centered mb">
				<img src="assets/img/phone-white.png" height="600">
			</div>
			<div class="col-md-6 centered people">
				<img src="assets/img/ui-sherman.jpg" class="img-circle" height="60">
				<h5>SHERMAN WILLIANS</h5>
				<p>Dummy text of the printing and typesetting industry.<br/> Lorem Ipsum has been the industry's standard.</p>

				<img src="assets/img/ui-divya.jpg" class="img-circle mt" height="60">
				<h5>DIVYA MURRAY</h5>
				<p>Dummy text of the printing and typesetting industry.<br/> Lorem Ipsum has been the industry's standard.</p>


				<img src="assets/img/ui-zac.jpg" class="img-circle mt" height="60">
				<h5>ZAC ROBBEN</h5>
				<p>Dummy text of the printing and typesetting industry.<br/> Lorem Ipsum has been the industry's standard.</p>

			</div>
		</div><! --/row -->
	</div><! --/container -->
	
	<div id="pf">
		<div class="container">
			<div class="row centered">
				<h1>SHARE YOUR PASSION</h1>
				<h4>Dummy text of the printing and typesetting industry.<br> Lorem Ipsum has been the industry's standard.</h4>
			</div><! --/row -->
		</div><! --/container -->
	</div>
	
	<section id="contact" name="contact">
		<! -- FOOTER -->
		<div id="f">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
						<form role="form" action="register.php" method="post" enctype="plain"> 
		    				<input type="email" name="email" class="subscribe-input" placeholder="Enter your e-mail address..." required>
							<button class='btn btn-lg btn-gold subscribe-submit' type="submit">Subscribe</button>
						</form>
					</div>
				</div><! --/row -->
				<div class="row mt">
					<div class="social-icons centered mt">
						<a href="#"><i class="fa fa-apple"></i></a>
						<a href="#"><i class="fa fa-android"></i></a>
						<a href="#"><i class="fa fa-windows"></i></a>
					</div>
					<h4 class="centered">GET THE APP</h4>
				</div><! --/row -->
			</div><! --/container -->
		</div><! --/ F -->
	</section>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/classie.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/retina-1.1.0.js"></script>
    <script type="text/javascript" src="assets/js/smoothscroll.js"></script>
	-->
	<?php 
	do_action('lp_footer');
	do_action('wp_footer');
	?>
</body>
</html>
<?php

endwhile; endif;