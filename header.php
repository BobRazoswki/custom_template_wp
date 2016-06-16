<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" media="screen" title="no title" charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.min.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body>
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
	<header class="header">
		<div class="container">
			<?php $logo_url = get_option('logo_url'); ?>
			<img src="<?php echo $logo_url ?>" alt="logo coding days" class="header__logo" />
			<div class="burger">
				<div class="burger__button-container">
					<div class="burger__button" onclick="openBurger()">
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				  </div>
				</div>
			</div>

			<?php
				wp_nav_menu( array(
					'menu' => 'nav',
					'container' =>false,
					'menu_class' => 'nav',
					'echo' => true,
					'before' => '',
					'after' => '',
					'link_before' => '',
					'link_after' => '',
					'depth' => 0,
					'walker' => new Custom_Menu())
				);
			?>
		</div>
	</header>
