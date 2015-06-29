<?php /* Template Name: Create BUX Case Study*/ ?>

<?php acf_form_head(); ?>
<?php get_header(); ?>

  <main>
    <?php /* The loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>
      <?php acf_form(array(
          'post_id'   => 'new_post',
          'new_post'    => array(
            'post_type'   => 'post',
            'post_status'   => 'publish',
            'post_title'  => true,
            'post_content'  => true
          ),
          'submit_value'    => 'Submit'
        )); ?>
      <?php endwhile; ?>

  </main>


  <?php get_footer(); ?>