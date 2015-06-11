<?php /* Template Name: Insert Posts */


$postTitleError = '';

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

	if(trim($_POST['postTitle']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$postTitle = trim($_POST['postTitle']);
	}

	$post_information = array(
		'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
		'post_content' => esc_attr(strip_tags($_POST['postContent'])),
		'post-type' => 'post',
		'post_status' => 'pending'
	);

	$post_id = wp_insert_post($post_information);

	if($post_id)
	{

		// Update Custom Meta
		update_post_meta($post_id, 'vsip_custom_one', esc_attr(strip_tags($_POST['customMetaOne'])));
		update_post_meta($post_id, 'vsip_custom_two', esc_attr(strip_tags($_POST['customMetaTwo'])));
		update_post_meta($post_id, 'vsip_custom_three', esc_attr(strip_tags($_POST['customMetaThree'])));

		// Redirect
		wp_redirect( home_url() ); exit;
	}

} ?>

<?php get_header(); ?>

<?php if ( is_user_logged_in()  && is_page($page_title) ) { ?>
	<main id="insert">
		<h1>Create a new Case Study</h1>
		<form action="" id="primaryPostForm" method="POST">
			<h2>Overview</h2>
			<fieldset>

				<input type="text" name="postTitle" id="postTitle" placeholder="Title" value="<?php if(isset($_POST['postTitle'])) echo $_POST['postTitle'];?>" class="required" />

			</fieldset>

			<?php if($postTitleError != '') { ?>
				<span class="error"><?php echo $postTitleError; ?></span>
			<?php } ?>

			<fieldset>
						
				<label for="postContent"><?php _e('Intro', 'framework') ?></label>

				<textarea name="postContent" id="postContent" rows="8" cols="30"><?php if(isset($_POST['postContent'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['postContent']); } else { echo $_POST['postContent']; } } ?></textarea>

			</fieldset>
			<h2>Challenge/Theory</h2>
			<fieldset>

				<label for="customMetaOne"><?php _e('Description ', 'framework') ?></label>

				<textarea type="text" name="customMetaOne" id="customMetaOne"> 
		
					<?php if(isset($_POST['customMetaOne'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['customMetaOne']); } else { echo $_POST['customMetaOne']; } } ?>

				</textarea>

			</fieldset>
			<h2>Approach/Methods</h2>
			<fieldset>

				<label for="customMetaTwo"><?php _e('Overview', 'framework') ?></label>

				<textarea type="text" name="customMetaTwo" id="customMetaOne"> 
		
					<?php if(isset($_POST['customMetaTwo'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['customMetaTwo']); } else { echo $_POST['customMetaTwo']; } } ?>

				</textarea>
			</fieldset>
			<h2>Results/Take Away</h2>
			<fieldset>

				<label for="customMetaThree"><?php _e('Explanation of success', 'framework') ?></label>

				<textarea type="text" name="customMetaThree" id="customMetaThree"> 
		
					<?php if(isset($_POST['customMetaThree'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['customMetaThree']); } else { echo $_POST['customMetaThree']; } } ?>

				</textarea>

			</fieldset>

			<fieldset>
				
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>

				<input type="hidden" name="submitted" id="submitted" value="true" />
				<button type="submit"><?php _e('Add Post', 'framework') ?></button>

			</fieldset>

		</form>

	</main>
<?php } else {
	echo 'Please Log in <a href=' . wp_login_url() . '> Go to Login page</a>';

	wp_redirect( wp_login_url() );
	exit;
} ?>

<?php get_footer(); ?>