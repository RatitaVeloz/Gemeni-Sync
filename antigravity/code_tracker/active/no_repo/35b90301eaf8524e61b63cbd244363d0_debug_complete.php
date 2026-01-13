�<?php
require_once('../../../wp-load.php');

$post_id = 3427;

echo "=== LIMPIANDO CACHE ===\n";
wp_cache_flush();
clean_comment_cache(range(1, 1000)); // Limpiar caché de comentarios
echo "✓ Caché limpiado\n\n";

echo "=== CONSULTA DIRECTA EN BASE DE DATOS ===\n";
global $wpdb;
$db_comments = $wpdb->get_results($wpdb->prepare(
    "SELECT comment_ID, comment_author, comment_approved FROM {$wpdb->comments} WHERE comment_post_ID = %d",
    $post_id
));

echo "Total en BD: " . count($db_comments) . "\n";
foreach ($db_comments as $c) {
    echo "  - ID {$c->comment_ID}: {$c->comment_author} (Approved: {$c->comment_approved})\n";
}

echo "\n=== CONSULTA CON get_comments() ===\n";
$comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'all', // Traer TODOS para verificar
    'type' => 'comment',
    'number' => -1
));

echo "Total con get_comments (status=all): " . count($comments) . "\n";
foreach ($comments as $c) {
    echo "  - ID {$c->comment_ID}: {$c->comment_author} (Status: {$c->comment_approved})\n";
}

echo "\n=== SOLO APROBADOS ===\n";
$approved = get_comments(array(
    'post_id' => $post_id,
    'status' => 'approve',
    'type' => 'comment',
    'number' => -1
));

echo "Total APROBADOS: " . count($approved) . "\n";
foreach ($approved as $c) {
    $rating = get_comment_meta($c->comment_ID, 'rating', true);
    echo "  - ID {$c->comment_ID}: {$c->comment_author} ({$rating} ★)\n";
}
�2Xfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/debug_complete.php