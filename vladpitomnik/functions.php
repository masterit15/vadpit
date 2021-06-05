<?php
/**
 * vladpitomnik functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vladpitomnik
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}
function PR($var, $all = false, $die = false) {
	$bt = debug_backtrace();
	$bt = $bt[0];
	$dRoot = $_SERVER["DOCUMENT_ROOT"];
	$dRoot = str_replace("/", "\\", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	$dRoot = str_replace("\\", "/", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	?>
		<div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;z-index: 999'>
		<div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?=$bt["file"]?> [<?=$bt["line"]?>]</div>
		<pre style='padding:10px;'><?print_r($var)?></pre>
		</div>
		<?
	if ($die) {
		die;
	}
}
if ( ! function_exists( 'vladpitomnik_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vladpitomnik_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on vladpitomnik, use a find and replace
		 * to change 'vladpitomnik' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vladpitomnik', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'vladpitomnik' ),
			)
		);
		register_nav_menus(
			array(
				'menu-socicon' => esc_html__( 'Socicon', 'vladpitomnik' ),
			)
		);
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'vladpitomnik_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'vladpitomnik_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vladpitomnik_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vladpitomnik_content_width', 640 );
}
add_action( 'after_setup_theme', 'vladpitomnik_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vladpitomnik_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'vladpitomnik' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'vladpitomnik' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'vladpitomnik_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vladpitomnik_scripts() {
	wp_enqueue_style( 'vladpitomnik-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'vladpitomnik-main', get_template_directory_uri() . '/css/main.min.css');
	wp_style_add_data( 'vladpitomnik-style', 'rtl', 'replace' );

	wp_enqueue_script( 'vladpitomnik-app', get_template_directory_uri() . '/js/app.min.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vladpitomnik_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Posts filter.
 */
require get_template_directory() . '/inc/filterPosts.php';
/**
 * custom posts pets.
 */
require get_template_directory() . '/inc/pets.php';

/**
 * dublicate posts function.
 */
require get_template_directory() . '/inc/dublicatePost.php';

/**
 * dublicate posts function.
 */
require get_template_directory() . '/inc/viewPostCounter.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


function register_my_session()
{
  if( !session_id() )
  {
    session_start();
  }
}

add_action('init', 'register_my_session');