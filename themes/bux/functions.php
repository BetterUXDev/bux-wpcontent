<?php
/**
 * Bux functions and definitions
 *
 * @package Bux
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'bux_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bux_setup() {

	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Bux, use a find and replace
	 * to change 'bux' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bux', get_template_directory() . '/languages' );

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
		'primary' => __( 'Primary Menu', 'bux' ),
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
	add_theme_support( 'custom-background', apply_filters( 'bux_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // bux_setup
add_action( 'after_setup_theme', 'bux_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function bux_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'bux' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'bux_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bux_scripts() {
	wp_enqueue_style( 'dropzonecss', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css' );
	wp_enqueue_style( 'bux-style', get_stylesheet_uri() );


	wp_enqueue_script( 'bux-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'dropzonejs', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js',array(),'v4.0.1', true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), 'v3.3.2', true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array(), 'v1.0', true );

}
add_action( 'wp_enqueue_scripts', 'bux_scripts' );



// function save_buxcs_title( $post_id ){
//   if ( ! wp_is_post_revision( $post_id ) && get_post_type('post')){
  
//     // unhook this function so it doesn't loop infinitely
//     remove_action('save_post', 'save_buxcs_title');
  
//     $my_post = array(
//       'ID'      => $post_id,
//       'post_title'  => get_field('buxcs_title', $post_id),
//       'post_content'  => get_field('buxcs_description', $post_id)
//       );
//     // update the post, which calls save_post again
//     wp_update_post( $my_post );

//     // re-hook this function
//     add_action('save_post', 'save_buxcs_title');
//   }
// }
// add_action('save_post', 'save_buxcs_title');


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

/**
* Bootstrap integration
*/
require get_template_directory() . '/inc/functions-strap.php';

