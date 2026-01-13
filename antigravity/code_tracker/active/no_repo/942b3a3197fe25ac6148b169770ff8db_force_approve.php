¡	<?php
require_once('../../../wp-load.php');

$post_id = 3427;

// Get ALL comments for this post, regardless of status
$all_comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'all',
    'type' => 'comment',
));

echo "=== FORCING COMMENT APPROVAL ===\n";
echo "Total comments found: " . count($all_comments) . "\n\n";

foreach ($all_comments as $comment) {
    echo "Comment ID: {$comment->comment_ID} | Author: {$comment->comment_author} | Current status: {$comment->comment_approved}\n";

    if ($comment->comment_approved != '1') {
        // Force approve using wp_update_comment
        $result = wp_update_comment(array(
            'comment_ID' => $comment->comment_ID,
            'comment_approved' => 1,
        ));

        if ($result) {
            echo "  âœ“ APPROVED!\n";
        } else {
            echo "  âœ— Failed to approve\n";
        }
    } else {
        echo "  â†’ Already approved\n";
    }
}

echo "\n=== VERIFICATION ===\n";
$approved = get_comments(array(
    'post_id' => $post_id,
    'status' => 'approve',
));
echo "Total APPROVED comments after update: " . count($approved) . "\n";
¡	2Wfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/force_approve.php