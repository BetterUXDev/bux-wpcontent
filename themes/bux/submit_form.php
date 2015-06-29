  <?php 
    function display()
	{	
		$user_ID = get_current_user_id();
		$title = $_POST["buxcs_title"];
		$slug = sanitize_title_with_dashes($title);
	    var_dump($slug)
	 //    $my_post = array(
		//  'post_title' => ,
		//  'post_content' => 'This is my post.',
		//  'post_status' => 'pending',
		//  'post_type' => 'post'
		// );

		// // Insert the post into the database
		// $post_id = wp_insert_post( $my_post );
	}

	if(isset($_POST['submit']))
	{
	    $user_ID = get_current_user_id();
		$title = $_POST["buxcs_title"];
		$slug = sanitize_title_with_dashes($title);
	    var_dump($title)
	} 
  ?>