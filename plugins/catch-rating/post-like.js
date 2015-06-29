jQuery('.post-like a').click(function() {
  heart = jQuery(this);

  // Retrieve post ID from data attribute
  postId = heart.data('post_id');

  // Ajax call
  jQuery.ajax({
    type: 'post',
    url: ajax_var.url,
    data: 'action=post-like&nonce=' + ajax_var.nonce + '&post_like=&post_id=' + postId,
    success: function(count) {
      // If vote successful
      if (count != 'already') {
        heart.addClass('voted');
        heart.siblings('.count').text(count);
      }
    }
  });

  return false;
})
