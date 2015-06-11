<?php
/*
Plugin Name: Case Study Ratings
Description: Catch Case Study Ratings is a simple and light weight plugin to show the Case Study Ratings in the Admin Section Table.
Version: 1.0
License: GNU General Public License, version 3 (GPLv3)
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
Author: Better UX
*/


/**
 * @package Better UX Catch Case Study Ratings
 * @subpackage Case Study Rating Ratings
 * @since Case Study Rating Ratings 1.0 
 */


// Rating System

add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');

add_action( 'wp_enqueue_scripts', 'like_post_enqueue' );
function like_post_enqueue () 
{
	//wp_localize_script can't work outside a function
	wp_enqueue_script('like_post',  plugin_dir_url( __FILE__ ) . 'post-like.js' , array('jquery'), '1.0', true );
	wp_localize_script('like_post', 'ajax_var', array(
	    'url' => admin_url('admin-ajax.php'),
	    'nonce' => wp_create_nonce('ajax-nonce')
	));
}

function post_like()
{
    // Check for nonce security
    $nonce = $_POST['nonce'];
  
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
     
    if(isset($_POST['post_like']))
    {
        // Retrieve user IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        $post_id = $_POST['post_id'];
         
        // Get voters'IPs for the current post
        $meta_IP = get_post_meta($post_id, "voted_IP");
        $voted_IP = $meta_IP[0];
 
        if(!is_array($voted_IP))
            $voted_IP = array();
         
        // Get votes count for the current post
        $meta_count = get_post_meta($post_id, "votes_count", true);
 
        // Use has already voted ?
        if(!hasAlreadyVoted($post_id))
        {
            $voted_IP[$ip] = time();
 
            // Save IP and increase votes count
            update_post_meta($post_id, "voted_IP", $voted_IP);
            update_post_meta($post_id, "votes_count", ++$meta_count);
             
            // Display count (ie jQuery return value)
            echo $meta_count;
        }
        else
            echo "already";
    }
    exit;
}

$timebeforerevote = 120; // = 2 hours

function hasAlreadyVoted($post_id)
{
    global $timebeforerevote;
 
    // Retrieve post votes IPs
    $meta_IP = get_post_meta($post_id, "voted_IP");
    $voted_IP = $meta_IP[0];
     
    if(!is_array($voted_IP))
        $voted_IP = array();
         
    // Retrieve current user IP
    $ip = $_SERVER['REMOTE_ADDR'];
     
    // If user has already voted
    if(in_array($ip, array_keys($voted_IP)))
    {
        $time = $voted_IP[$ip];
        $now = time();
         
        // Compare between current time and vote time
        if(round(($now - $time) / 60) > $timebeforerevote)
            return false;
             
        return true;
    }
     
    return false;
}


function getPostLikeLink($post_id)
{
    $themename = "twentyeleven";
 
    $vote_count = get_post_meta($post_id, "votes_count", true);
 
    $output = '<p class="post-like">';
    if(hasAlreadyVoted($post_id))
        $output .= ' <span title="'.__('I like this article', $themename).'" class="like alreadyvoted fa">&#xf087;</span>';
    else
        $output .= '<a href="#" data-post_id="'.$post_id.'">
                    <span  title="'.__('I like this article', $themename).'"class="qtip like fa">&#xf087;</span>
                </a>';
    $output .= '<span class="count">'.$vote_count.'</span></p>';
     
    return $output;
}

// Custom Admin Column

if ( ! function_exists( 'csratings_column' ) ):
/**
 * Prepend the new column to the columns array
 */
function csratings_column($cols) {
	$cols['csratings'] = 'Rating';
	return $cols;
}
endif; // csratings_column


if ( ! function_exists( 'csratings_value' ) ) :
/**
 * Echo the ID for the new column
 */ 
function csratings_value( $column_name, $id ) {
	if ( $column_name == 'csratings' )
		$vote_count = get_post_meta($id, "votes_count", true);
		// echo $id;
		echo $vote_count;
}
endif; // csratings_value


if ( ! function_exists( 'csratings_return_value' ) ) :
function csratings_return_value( $value, $column_name, $id ) {
	if ( $column_name == 'csratings' )
		$value = $id;
	return $value;
}
endif; // csratings_return_value


if ( ! function_exists( 'csratings_css' ) ) :
/**
 * Output CSS for width of new column
 */ 
function csratings_css() {
?>
<style type="text/css">
	#csratings { 
		width: 50px; 
	}
</style>
<?php	
}
endif; // csratings_css


if ( ! function_exists( 'csratings_add' ) ) :
/**
 * Actions/Filters for various tables and the css output
 */ 
function csratings_add() {
	add_action( 'admin_head', 'csratings_css');

	// For Post Management
	add_filter( 'manage_posts_columns', 'csratings_column' );
	add_action( 'manage_posts_custom_column', 'csratings_value', 10, 2 );
}
endif; // csratings_add

add_action( 'admin_init', 'csratings_add' );