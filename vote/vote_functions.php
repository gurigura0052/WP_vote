<?php
function add_my_ajaxurl() {
  ?>
  <script>
    var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
  </script>
  <?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );

/*
 * vote
 */
function vote_count(){
  global $wpdb;

  $post_id = $_POST['vote_post_id'];

  $query = "SELECT * FROM wp_vote WHERE post_id = %d";
  $prepared = $wpdb->prepare($query, $post_id);
  $row = $wpdb->get_row($prepared);

  $count = $row->count;
  $count = ++$count;

  date_default_timezone_set('Asia/Tokyo');
  $updated = date("Y-m-d H:i:s");

  $wpdb->update( 'wp_vote',
    array(
      'post_id' => $post_id,
      'count' => $count,
      'updated' => $updated,
    ),
    array( 'post_id' => $post_id ),
    array(
      '%d',
      '%d',
      '%s',
    ),
    array( '%d' )
  );

  echo $count;

  die();
}
add_action( 'wp_ajax_vote_count', 'vote_count' );
add_action( 'wp_ajax_nopriv_vote_count', 'vote_count' );