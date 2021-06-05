<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vladpitomnik
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php language_attributes(); ?>">
	<title><?php bloginfo( 'name' ); ?></title>
	<meta name="description" content="Startup HTML template OptimizedHTML 5">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="icon" href="images/favicon.png">
	<meta property="og:image" content="images/dist/preview.jpg">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
	<?
	define("TURI",     get_template_directory_uri().'/');
	?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<header class="header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
			<?$custom_logo__url = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )?>
			<img src="<?=$custom_logo__url[0]?>" alt="">
			<?php bloginfo( 'name' ); ?>
		</a>
		<div id="mobnav">
			<span></span>
		</div>
		<div class="nav_wrap">
			<nav class="top_nav">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
						)
					);
				?>
			</nav>
			<ul class="contact_list">
				<li><a href="tel:+7(918) 833-55-16"><i class="far fa-phone"></i> +7(918) 833-55-16 </a></li>
				<li><a href="#"><i class="far fa-map-marker-alt"></i> п. Заводской, ул. Пролетарская, 3</a></li>
			</ul>
		</div>
	</header>
	<div class="wrapper"><!-- begin wrapper -->