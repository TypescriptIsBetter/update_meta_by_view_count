global $wpdb;
$post_ids = $wpdb->get_results ("SELECT id FROM  $wpdb->posts WHERE post_type = 'post'");
// For type, 4 is all time views, 3 is for year, 2 is for month, 1 is weekly, and 0 is for day
$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}post_views WHERE type=4");

$new_post_metas = array();

foreach ($result as $key => $row) {
	$new_post_metas[$row->id] = (int) $row->count;
}

foreach ($post_ids as $key => $row) {
	if (isset($new_post_metas[$row->id])) {
		// DO NOT USE A VARIABLE TO STORE THE KEY NAME
		// I'm unsure why but it doesn't set the data that way.
		update_post_meta((int) $row->id, 'view_count', $new_post_metas[$row->id]);
	} else {
		// Don't forget to change this one if you change the one above.
		update_post_meta((int) $row->id, 'view_count', 0);
	}
}
