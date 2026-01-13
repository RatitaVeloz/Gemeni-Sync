ù<?php
require_once('../../../wp-load.php');

$post_id = 3427;
$post_data = array(
    'ID' => $post_id,
    'comment_status' => 'open',
);
wp_update_post($post_data);

$post = get_post($post_id);
echo "Updated Post 3427. Comments are now: " . $post->comment_status . "\n";
ù2Yfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/enable_comments.php