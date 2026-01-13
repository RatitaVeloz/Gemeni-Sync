ê<?php
require_once('../../../wp-load.php');

$post_id = 3427;
$post = get_post($post_id);

echo "Post ID: " . $post_id . "\n";
echo "Post Type: " . $post->post_type . "\n";
echo "Post Status: " . $post->post_status . "\n";
echo "Comments Open: " . (comments_open($post_id) ? 'YES' : 'NO') . "\n";
echo "Post Password: " . $post->post_password . "\n";
ê2_file:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/debug_comments_status.php