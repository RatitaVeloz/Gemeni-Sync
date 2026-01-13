¤<?php
require_once('../../../wp-load.php');

// ID from previous context (property page) or just pick one
$args = array(
    'post_type' => 'hb_accommodation', // or 'hbook_property' ? defaults usually 'hb_accommodation'
    'posts_per_page' => 1,
);
$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        echo "Post ID: " . $id . "\n";
        echo "Post Title: " . get_the_title() . "\n";

        $meta = get_post_meta($id);
        foreach ($meta as $key => $values) {
            // Filter only hbook related or likely description fields
            if (strpos($key, 'desc') !== false || strpos($key, 'hbook') !== false) {
                echo "Key: " . $key . " => " . substr($values[0], 0, 100) . "...\n";
            }
        }
    }
} else {
    echo "No hb_accommodation posts found.\n";
}
¤2Zfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/debug_meta_hbook.php