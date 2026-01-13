�$<?php
require_once('../../../wp-load.php');

global $wpdb;

$post_id = 3427;

// Primero, ELIMINAR comentarios existentes para este post
$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->commentmeta} WHERE comment_id IN (SELECT comment_ID FROM {$wpdb->comments} WHERE comment_post_ID = %d)", $post_id));
$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->comments} WHERE comment_post_ID = %d", $post_id));

echo "=== LIMPIEZA COMPLETADA ===\n";
echo "Comentarios eliminados para Post ID: $post_id\n\n";

$reviews_data = array(
    array('author' => 'Mariana G.', 'rating' => 5, 'content' => 'El departamento es exactamente como se ve en las fotos, muy luminoso y cómodo. La ubicación es ideal, cerca de todo. Súper recomendado.'),
    array('author' => 'Lucas R.', 'rating' => 5, 'content' => 'Nos encantó la estadía, todo muy limpio, moderno y bien equipado. El balcón es un plus increíble. Sin dudas volveríamos.'),
    array('author' => 'Sofía M.', 'rating' => 4, 'content' => 'Excelente atención y el espacio es tal cual lo describen. Muy tranquilo, perfecto para descansar y también para trabajar.'),
    array('author' => 'Diego P.', 'rating' => 5, 'content' => 'Muy buena relación precio-calidad. El departamento es amplio, cómodo y bien ubicado. Todo funcionó perfecto.'),
    array('author' => 'Valentina S.', 'rating' => 4, 'content' => 'Muy lindo lugar. La piscina genial. Solo un pequeño detalle con el check-in que se resolvió rápido, pero en general impecable.'),
    array('author' => 'Juan Carlos B.', 'rating' => 5, 'content' => 'Impecable todo. La limpieza de 10, las camas súper cómodas. La vista del balcón es hermosa. Gracias por todo.'),
    array('author' => 'Carolina T.', 'rating' => 4, 'content' => 'Uno de los mejores alojamientos en los que he estado. Detalles de categoría, cocina completa y host súper atento.'),
    array('author' => 'Andrés L.', 'rating' => 4, 'content' => 'Todo muy bien, el departamento es muy funcional y moderno. La zona es segura y tiene muchos servicios cerca.'),
);

echo "=== CREANDO COMENTARIOS DIRECTAMENTE EN BD ===\n\n";

foreach ($reviews_data as $review) {
    $email = strtolower(str_replace(' ', '', $review['author'])) . '@example.com';
    $date = date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days'));

    // Insertar directamente en la tabla de comentarios
    $wpdb->insert(
        $wpdb->comments,
        array(
            'comment_post_ID' => $post_id,
            'comment_author' => $review['author'],
            'comment_author_email' => $email,
            'comment_author_url' => '',
            'comment_author_IP' => '127.0.0.1',
            'comment_date' => $date,
            'comment_date_gmt' => get_gmt_from_date($date),
            'comment_content' => $review['content'],
            'comment_karma' => 0,
            'comment_approved' => '1', // APROBADO
            'comment_agent' => 'Seed Script',
            'comment_type' => 'comment',
            'comment_parent' => 0,
            'user_id' => 0,
        ),
        array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d', '%d')
    );

    $comment_id = $wpdb->insert_id;

    if ($comment_id) {
        // Agregar rating como meta
        $wpdb->insert(
            $wpdb->commentmeta,
            array(
                'comment_id' => $comment_id,
                'meta_key' => 'rating',
                'meta_value' => $review['rating']
            ),
            array('%d', '%s', '%d')
        );

        echo "✓ Creado comentario ID: $comment_id | {$review['author']} | {$review['rating']} estrellas\n";
    } else {
        echo "✗ Error creando comentario para {$review['author']}\n";
    }
}

// Actualizar contador de comentarios del post
$comment_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_post_ID = %d AND comment_approved = '1'", $post_id));
$wpdb->update($wpdb->posts, array('comment_count' => $comment_count), array('ID' => $post_id), array('%d'), array('%d'));

echo "\n=== ACTUALIZANDO PROMEDIOS ===\n";
if (function_exists('ocean_update_average_rating')) {
    ocean_update_average_rating($post_id);
    echo "✓ Promedio recalculado.\n";
}

echo "\n=== VERIFICACIÓN FINAL ===\n";
$approved = get_comments(array('post_id' => $post_id, 'status' => 'approve'));
echo "Total comentarios APROBADOS: " . count($approved) . "\n";

foreach ($approved as $c) {
    $rating = get_comment_meta($c->comment_ID, 'rating', true);
    echo "  - ID {$c->comment_ID}: {$c->comment_author} ({$rating} ★)\n";
}
�$2Ufile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/seed_direct.php