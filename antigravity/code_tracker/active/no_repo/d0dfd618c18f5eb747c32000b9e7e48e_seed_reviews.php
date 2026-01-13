�<?php
require_once('../../../wp-load.php');

$post_id = 3427; // "Sunny Bay" ID

// Temporalmente remover el filtro de moderación forzada
remove_filter('pre_comment_approved', '__return_zero', 10, 2);

$reviews_data = array(
    array(
        'author' => 'Mariana G.',
        'rating' => 5,
        'content' => 'El departamento es exactamente como se ve en las fotos, muy luminoso y cómodo. La ubicación es ideal, cerca de todo. Súper recomendado.',
    ),
    array(
        'author' => 'Lucas R.',
        'rating' => 5,
        'content' => 'Nos encantó la estadía, todo muy limpio, moderno y bien equipado. El balcón es un plus increíble. Sin dudas volveríamos.',
    ),
    array(
        'author' => 'Sofía M.',
        'rating' => 4,
        'content' => 'Excelente atención y el espacio es tal cual lo describen. Muy tranquilo, perfecto para descansar y también para trabajar.',
    ),
    array(
        'author' => 'Diego P.',
        'rating' => 5,
        'content' => 'Muy buena relación precio-calidad. El departamento es amplio, cómodo y bien ubicado. Todo funcionó perfecto.',
    ),
    array(
        'author' => 'Valentina S.',
        'rating' => 4,
        'content' => 'Muy lindo lugar. La piscina genial. Solo un pequeño detalle con el check-in que se resolvió rápido, pero en general impecable.',
    ),
    array(
        'author' => 'Juan Carlos B.',
        'rating' => 5,
        'content' => 'Impecable todo. La limpieza de 10, las camas súper cómodas. La vista del balcón es hermosa. Gracias por todo.',
    ),
    array(
        'author' => 'Carolina T.',
        'rating' => 4,
        'content' => 'Uno de los mejores alojamientos en los que he estado. Detalles de categoría, cocina completa y host súper atento.',
    ),
    array(
        'author' => 'Andrés L.',
        'rating' => 4,
        'content' => 'Todo muy bien, el departamento es muy funcional y moderno. La zona es segura y tiene muchos servicios cerca.',
    ),
);

echo "=== GENERANDO RESEÑAS ===\n";
echo "Post ID: $post_id\n\n";

foreach ($reviews_data as $review) {
    $comment_data = array(
        'comment_post_ID' => $post_id,
        'comment_author' => $review['author'],
        'comment_author_email' => strtolower(str_replace(' ', '', $review['author'])) . '@example.com',
        'comment_content' => $review['content'],
        'comment_type' => 'comment',
        'comment_parent' => 0,
        'user_id' => 0,
        'comment_approved' => 1, // FORZAR APROBADO
        'comment_date' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days')),
    );

    $comment_id = wp_insert_comment($comment_data);

    if ($comment_id) {
        // Agregar rating como meta
        add_comment_meta($comment_id, 'rating', $review['rating'], true);
        echo "✓ Creada reseña ID: $comment_id para Autor: {$review['author']} ({$review['rating']} estrellas)\n";
    } else {
        echo "✗ Error creando reseña para: {$review['author']}\n";
    }
}

echo "\n=== ACTUALIZANDO PROMEDIOS ===\n";
// Llamar función de recalculo
if (function_exists('ocean_update_average_rating')) {
    ocean_update_average_rating($post_id);
    echo "✓ Promedio recalculado.\n";
}

echo "\n=== VERIFICACIÓN ===\n";
$approved_comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'approve',
));
echo "Total comentarios APROBADOS: " . count($approved_comments) . "\n";
�2Vfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/seed_reviews.php