<?php /* Template Name: View Posts */ ?>

<?php get_header(); ?>

<?php if ( is_user_logged_in()  && is_page($page_title) ) { ?>
	<!-- #primary BEGIN -->
	<main>
	<?php if(isset($_GET['result'])): ?>
		<?php if($_GET['result'] == 'success') : ?>
		<!-- .client_success BEGIN -->
		<div class="client_success">
			<span class="success">Successfully Added<span class="cross"><a href="#">X</a></span></span>
		</div><!-- .client_success END -->
		<?php endif; ?>
	<?php endif; ?>
		<div class="panel panel-default">
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
			<div class="panel-heading"><?php echo 'Posts By ' . $current_user->user_login ?></div>
			<div class="panel-body">
				<p>This list contains all the the case studies created by the logged in user</p>
				<div role="tabpanel">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs nav-justified" role="tablist">
						<li role="presentation" class="active"><a href="#studies" aria-controls="studies" role="tab" data-toggle="tab">Studies</a></li>
						<li role="presentation"><a href="#drafts" aria-controls="drafts" role="tab" data-toggle="tab">Draft</a></li>
					</ul>
					<!-- Tab panes -->  
					<?php 
						$custom_one = get_post_meta(get_the_ID(), 'vsip_custom_one', true);
						$custom_two = get_post_meta(get_the_ID(), 'vsip_custom_two', true);
						$custom_three = get_post_meta(get_the_ID(), 'vsip_custom_three', true);
					?>
					<div class="tab-content">
		   			<div role="tabpanel" class="tab-pane active" id="studies">
		   				<div class="panel panel-default">
		   				<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
		   				<?php if (get_post_status( get_the_ID() ) === "publish"): ?>
								<div class="panel-body">
			    				<h3 class="panel-title"><?php echo get_the_title(); ?></h3>
			    				<ul class="list-inline">
			    					<li><span class="fa">&#xf073;</span><?php the_time('l, F jS, Y') ?></li>
			    					<li><span class="fa">&#xf007;</span><?php the_author(); ?></li>
			    					<li><span class="fa"></span>
			    						<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ).' ago'; ?>
			    					</li>
			    					<li><?php echo getPostLikeLink(get_the_ID());?></li>
			    				</ul>
			    				<p><?php the_excerpt(); ?></p>
			    				<ul>
				    				<li><?php $custom_one; ?></li>
				    				<li><?php $custom_two; ?></li>
				    				<li><?php $custom_three; ?></li>
			    				</ul>
			    				<p><?php echo get_post_status( get_the_ID() ); ?></p>

			    				<?php 
			    					$edit_post = add_query_arg( 
			    						'post', 
			    						get_the_ID(), 
			    						get_permalink( 12 + $_POST['_wp_http_referer'] ) 
			    					); 
			    				?>

			    				<a href="<?php echo $edit_post; ?>">Edit</a>

			    				<?php if( !(get_post_status() == 'trash') ): ?>

									<a onclick="return confirm('Are you sure you wish to delete post: <?php echo get_the_title() ?>?')"href="<?php echo get_delete_post_link( get_the_ID() ); ?>">Delete</a>

									<?php endif; ?>
								</div>

								<?php endif; ?>
								<?php endwhile; endif; ?>
							</div>
		    		</div> <!-- tab-pane -->
		    		<div role="tabpanel" class="tab-pane" id="drafts">
		    			<div class="panel panel-default">
			    			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
			    			<?php if (get_post_status( get_the_ID() ) === "draft") :?>

								<div class="panel-body">

			    				<h3 class="panel-title"><?php echo get_the_title(); ?></h3>
			    				<ul class="list-inline">
			    					<li><span class="fa">&#xf073;</span><?php the_time('l, F jS, Y') ?></li>
			    					<li><span class="fa">&#xf007;</span><?php the_author(); ?></li>
			    					<li><span class="fa"></span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ).' ago'; ?></li>
			    					<li><?php echo getPostLikeLink(get_the_ID());?></li>
			    				</ul>
			    				<p><?php the_excerpt(); ?></p>
			    				<ul>
				    				<li><?php $custom_one; ?></li>
				    				<li><?php $custom_two; ?></li>
				    				<li><?php $custom_three; ?></li>
			    				</ul>
									<p><?php echo get_post_status( get_the_ID() ); ?></p>

			    				<?php $edit_post = add_query_arg( 'post', get_the_ID(), get_permalink( 12 + $_POST['_wp_http_referer'] ) ); ?>
			    				<a href="<?php echo $edit_post; ?>">Edit</a>
			    				<?php if( !(get_post_status() == 'trash') ) : ?>
									<a onclick="return confirm('Are you sure you wish to delete post: <?php echo get_the_title() ?>?')" href="<?php echo get_delete_post_link( get_the_ID() ); ?>">Delete</a>
									<?php endif; ?>	
								</div>

								<?php endif; ?>
								<?php endwhile; endif; ?>
							</div> <!-- panel panel-default -->
		    		</div> <!-- tab-pane -->
		  		</div> <!-- tab-content -->
				</div> <!-- tabpanel -->
			</div> <!-- panel-body -->	
		</div> <!-- panel panel-default -->
	</main>
				
<?php } else {
	echo 'Please Log in <a href=' . wp_login_url() . '> Go to Login page</a>';

	wp_redirect( wp_login_url() );
	exit;
} ?>


<?php get_footer(); ?>