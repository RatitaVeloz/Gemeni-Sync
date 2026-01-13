Ä<?php
require_once('../../../wp-load.php');

$post_id = 3427;
$comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'all', // Get all to check status
));

echo "Total comments found: " . count($comments) . "\n";

foreach ($comments as $comment) {
    if ($comment->comment_approved != '1') {
        echo "Approving comment ID: " . $comment->comment_ID . "\n";
        wp_set_comment_status($comment->comment_ID, 'approve');
    } else {
        echo "Comment ID " . $comment->comment_ID . " is already approved.\n";
    }
}
echo "Done.";
Ä2Zfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/approve_comments.php