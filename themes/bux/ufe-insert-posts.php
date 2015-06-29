<?php /* Template Name: Insert Posts */

$postTitleError = '';

	$post_information = array(
		'post_title' => esc_attr(strip_tags($_POST['csTitle'])),
	);

	$post_id = wp_insert_post($post_information);

?>

<?php get_header(); ?>

<?php if ( is_user_logged_in() && is_page($page_title) ) { ?>
	<main id="insert">
		<h1>Create a new Case Study</h1>
		<form action="" id="primaryPostForm" method="POST">
			<h2>Overview</h2>

			<!-- Proven? -->
			<label for="buxcs_proven"><?php _e('Proven?', 'framework') ?></label>
			<input type="radio" name="buxcs_proven" <?php if (isset($_POST['buxcs_proven'])) echo "checked";?> value="true">

			<!-- Title -->
			<input type="text" name="csTitle" id="csTitle" placeholder="Title" value="<?php if(isset($_POST['csTitle'])) echo $_POST['csTitle'];?>" class="required" />

			<?php if($postTitleError != '') { ?>
				<span class="error"><?php echo $postTitleError; ?></span>
			<?php } ?>
			<!-- Modal Trigger -->
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
			Upload Image
			</button>

			<!-- Description -->
			<label for="postContent"><?php _e('Description', 'framework') ?></label>

			<textarea name="postContent" id="postContent" rows="8" cols="30">
				<?php if(isset($_POST['postContent'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['postContent']); } else { echo $_POST['postContent']; } } ?>
			</textarea>
		

			<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>

				<input type="hidden" name="submitted" id="submitted" value="true" />
				<button type="submit"><?php _e('Add Post', 'framework') ?></button>

		</form>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
		      </div>
		      <div class="modal-body">
		        <form action="upload.php" class="dropzone" id="bux-dropzone" enctype="multipart/form-data">		
					<input type="file" name="bux_multiple_attachments[]" multiple >
				</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary">Save changes</button>
		      </div>
		    </div>
		  </div>
		</div>

	</main>
<?php } else {
	echo 'Please Log in <a href=' . wp_login_url() . '> Go to Login page</a>';

	wp_redirect( wp_login_url() );
	exit;
} ?>

<?php get_footer(); ?>