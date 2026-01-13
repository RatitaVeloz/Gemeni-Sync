‹<?php
require_once('../../../wp-load.php');

$post_id = 3427;

// Obtener comentarios aprobados
$comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'approve',
    'type' => 'comment',
    'number' => -1
));

echo "=== DEBUG REVIEWS ===\n";
echo "Post ID: $post_id\n";
echo "Total approved comments: " . count($comments) . "\n\n";

if (!empty($comments)) {
    $chunks = array_chunk($comments, 4);
    echo "Total chunks (grupos de 4): " . count($chunks) . "\n\n";

    foreach ($chunks as $index => $chunk) {
        echo "Chunk #" . ($index + 1) . " (" . count($chunk) . " reviews):\n";
        foreach ($chunk as $comment) {
            echo "  - ID: " . $comment->comment_ID . " | Author: " . $comment->comment_author . " | Status: " . $comment->comment_approved . "\n";
        }
        echo "\n";
    }
} else {
    echo "NO COMMENTS FOUND!\n";
}
‹2Vfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/debug_chunks.php