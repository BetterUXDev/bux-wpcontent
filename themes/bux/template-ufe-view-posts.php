<?php /* Template Name: View Posts */ ?>

<?php get_header(); ?>

	<?php if ( is_user_logged_in()  && is_page($page_title) ) { ?>
	<!-- #primary BEGIN -->
	<main>
	
		<?php if(isset($_GET['result'])) : ?>

			<?php if($_GET['result'] == 'success') : ?>

				<!-- .client_success BEGIN -->
				<div class="client_success">

					<span class="success">Successfully Added<span class="cross"><a href="#">X</a></span></span>

				</div><!-- .client_success END -->

			<?php endif; ?>

		<?php endif; ?>

		<table>

			<tr>
				<th>Post Title</th>
				<th>Post Excerpt</th>
				<th>Post Status</th>
				<th>Actions</th>
			</tr>

		
		<?php 

		
			global $current_user;
			get_currentuserinfo();
			$userid = $current_user->ID;

			$query = new WP_Query(
				array(
					'author' => $userid, 
					'post_type' => 'post', 
					'posts_per_page' =>'-1', 
					'post_status' => array(
						'publish', 'pending', 'draft', 'private', 'trash'
					) 
				) 
			); 
		?>
		
			<h1><?php echo 'Posts By ' . $current_user->user_login ?></h1>

			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
			
			<tr>
				<td><?php echo get_the_title(); ?></td>
				<td>
					<?php the_excerpt(); ?>
					<?php 
						$custom_one = get_post_meta(get_the_ID(), 'buxcs_title', true);
						$custom_two = get_post_meta(get_the_ID(), 'buxcs_custom_two', true);
						$custom_three = get_post_meta(get_the_ID(), 'buxcs_custom_three', true);
					?>
					<ul>
						<li><?php echo $custom_one ?></li>
						<li><?php echo $custom_two ?></li>
						<li><?php echo $custom_three ?></li>
					</ul>
				</td>
				<td><?php echo get_post_status( get_the_ID() ) ?></td>

				<?php $edit_post = add_query_arg('post', get_the_ID(), get_permalink(22 + $_POST['_wp_http_referer'])); ?>

				<td>
					<a href="<?php echo $edit_post; ?>">Edit</a>

					<?php if( !(get_post_status() == 'trash') ) : ?>

						<a onclick="return confirm('Are you sure you wish to delete post: <?php echo get_the_title() ?>?')"href="<?php echo get_delete_post_link( get_the_ID() ); ?>">Delete</a>

			<?php endif; ?>
				</td>
			</tr>

			<?php endwhile; endif; ?>
		<?php } else {
			echo 'Please Log in <a href=' . wp_login_url() . '> Go to Login page</a>';

			wp_redirect( wp_login_url() );
			exit;
		} ?>
			</table>

	</main>


<?php get_footer(); ?>