<?php
/**
 * thanks to Chris McCoy for sharing his pjax-ified theme with me.
 * https://github.com/chrismccoy 
 *
 * PJAX-Theme functions and definitions
 *
 * @package undercores-pjaxified
 *
 *
 
 *
 * Checks for PJAX Request
 *
*/
function is_pjax(){
	return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
}
/**
 * Enqueues the jquery.twelve.pjax.js script.
 *
*/
function pjax_scripts(){
	wp_enqueue_script('pjax', get_stylesheet_directory_uri() . '/js/jquery.pjax.js', array('jquery'), '1.0', true);
	$pjaxvars = array(
		'pjaxHomeUrl' => home_url(),
		'pjaxTitleSuffix' =>  ' | ' . get_bloginfo('name'),
		'pjaxUseStorage' => "true",
		'pjaxCacheTime' => "true",
		'pjaxFx' => "fade",
	);
	
	wp_localize_script('pjax', pjaxData, $pjaxvars);
}
/**
 * Hook script into footer
 *
*/
add_action('wp_enqueue_scripts', 'pjax_scripts');


/**
 * Check for PJAX call and decide which header content to render
 *
*/
function pjax_header() {
	if (!is_pjax()) {
		get_header();
	}
}
/**
 * Check for PJAX call and decide which footer content to render
 *
*/
function pjax_footer() {
	if (!is_pjax()) {
		get_sidebar();
		get_footer();
	}
}



/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'bscphoto_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bscphoto_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on bscphoto, use a find and replace
	 * to change 'bscphoto' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bscphoto', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bscphoto' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bscphoto_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // bscphoto_setup
add_action( 'after_setup_theme', 'bscphoto_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function bscphoto_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'bscphoto' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'bscphoto_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bscphoto_scripts() {
	wp_enqueue_style( 'bscphoto-style', get_stylesheet_uri() );

wp_enqueue_script('jquery');
	wp_enqueue_script( 'bscphoto-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	
//		wp_enqueue_script( 'bscphoto-pjax', get_template_directory_uri() . '/js/jquery.pjax.js', array(), '1', false );

	wp_enqueue_script( 'bscphoto-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bscphoto_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
