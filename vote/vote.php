<div class="vote_btn">
  <?php $post_id = get_the_ID(); ?>
  <button id="vote_submit" value="<?php echo $post_id; ?>">いいね</button>
  <span id="vote_count_num">
    <?php
      $query = "SELECT * FROM wp_vote WHERE post_id = %d";
      $prepared = $wpdb->prepare($query, $post_id);
      $row = $wpdb->get_row($prepared);
      echo $row->count;
    ?>
  </span>
</div>

<script type="text/javascript">
  (function ($) {
    $( '#vote_submit' ).on( 'click', function(){
      var vote_post_id = $('#vote_submit').val();
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          'action' : 'vote_count',
          'vote_post_id' : vote_post_id,
        },
        success: function( response ){
          $('#vote_count_num').text(response);
        }
      });
      return false;
    });
  })(jQuery);
</script>