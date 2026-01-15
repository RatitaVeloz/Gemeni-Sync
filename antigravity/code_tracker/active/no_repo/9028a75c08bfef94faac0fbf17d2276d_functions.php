ñ]<?php
add_action('wp_enqueue_scripts', 'rappod_child_css', 1001);
// Load CSS
function rappod_child_css()
{
    wp_deregister_style('styles-child');
    wp_register_style('styles-child', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('styles-child');
}

/* Font Awesome */
add_action('wp_enqueue_scripts', 'child_enqueue_fontawesome');
function child_enqueue_fontawesome()
{
    wp_enqueue_style(
        'font-awesome-brands',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );
}

// Cierra comentarios y pings en TODO
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// No mostrar comentarios existentes
add_filter('comments_array', '__return_empty_array', 20, 2);

// Quitar soporte de comentarios en todos los tipos de post
add_action('admin_init', function () {
    foreach (get_post_types() as $pt) {
        if (post_type_supports($pt, 'comments')) {
            remove_post_type_support($pt, 'comments');
            remove_post_type_support($pt, 'trackbacks');
        }
    }
});

// Limpiar menÃº y barra de admin
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
add_action('wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
});

// registrar footer y social
add_action('after_setup_theme', 'child_register_footer_and_social_menus');
function child_register_footer_and_social_menus()
{
    register_nav_menu('footer_menu', __('Footer Menu', 'tu-textdomain'));
    register_nav_menu('social_menu', __('Social Menu', 'tu-textdomain'));
}


//Forzar el estilo de encabezado 'header-1'
add_filter('get_post_metadata', 'rappod_child_override_page_header_style', 20, 4);
function rappod_child_override_page_header_style($value, $object_id, $meta_key, $single)
{
    if ('page_header_style' === $meta_key && is_front_page()) {
        return '1';
    }
    return $value;
}

/* Botones al espaÃ±ol */
function rappod_child_translate_read_more($translated_text, $text, $domain)
{
    if ('rappod' === $domain && 'Read More' === $text) {
        $translated_text = __('Leer mÃ¡s', 'rappod');
    }
    return $translated_text;
}
add_filter('gettext', 'rappod_child_translate_read_more', 20, 3);


/* CatÃ¡logo */
function rappod_child_change_shop_title($title)
{
    if (is_shop()) {
        return get_the_title(get_option('woocommerce_shop_page_id'));
    }
    return $title;
}
add_filter('woocommerce_page_title', 'rappod_child_change_shop_title');

function rappod_child_translate_theme_strings($translated_text, $text, $domain)
{
    if (is_shop() && $domain === 'rappod' && $text === 'Shop') {
        $translated_text = get_the_title(get_option('woocommerce_shop_page_id'));
    }
    return $translated_text;
}
add_filter('gettext', 'rappod_child_translate_theme_strings', 20, 3);

add_filter('woof_clear_all_text', function ($text) {
    return 'Borrar todo'; // o "Quitar todo", como prefieras
});

function redirigir_enlaces_categoria_a_husky()
{
    // Solo ejecutamos este script si estamos en la pÃ¡gina de inicio.
    if (is_front_page()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                // Seleccionamos todos los enlaces que contienen '/categoria-producto/' en su URL.
                $('a[href*="/categoria-producto/"]').on('click', function (event) {

                    // Prevenimos que el navegador siga el enlace original.
                    event.preventDefault();

                    var urlOriginal = $(this).attr('href');

                    // Extraemos el 'slug' de la categorÃ­a de la URL original.
                    // Ejemplo: de ".../categoria-producto/coloreo/", extrae "coloreo".
                    var slugCategoria = urlOriginal.split('/categoria-producto/')[1].replace(/\//g, '');

                    // Construimos la nueva URL con el formato de HUSKY.
                    // Â¡ASEGÃšRATE DE QUE LA URL BASE SEA CORRECTA!
                    var urlBase = '<?php echo esc_js(site_url("/catalogo/")); ?>';
                    var nuevaUrl = urlBase + 'swoof/product_cat-' + slugCategoria + '/';

                    // Redirigimos al usuario a la nueva URL.
                    window.location.href = nuevaUrl;
                });
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'redirigir_enlaces_categoria_a_husky');



add_action('wp_enqueue_scripts', function () {
    if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())) {
        wp_enqueue_script(
            'td-product-tilt',
            get_stylesheet_directory_uri() . '/assets/js/td-product-tilt.js',
            [],
            '1.0.0',
            true
        );
    }
}, 20);

/* =============================
   BANNER PERSONALIZADO POR PÃGINA
   ============================= */
function rappod_child_get_context_banner_url()
{
    $url = '';
    $post_id = 0;

    // CategorÃ­a de producto (ACF en product_cat, campo "banner_bg")
    if (function_exists('is_product_category') && is_product_category()) {
        $term = get_queried_object();
        if ($term && isset($term->term_id)) {
            if (function_exists('get_field')) {
                $acf_term_img = get_field('banner_bg', 'product_cat_' . $term->term_id);
                if (is_array($acf_term_img) && !empty($acf_term_img['url'])) {
                    return esc_url($acf_term_img['url']);
                } elseif (is_string($acf_term_img) && filter_var($acf_term_img, FILTER_VALIDATE_URL)) {
                    return esc_url($acf_term_img);
                }
            }
        }
    }

    // PÃ¡gina de Tienda
    if (function_exists('is_shop') && is_shop() && function_exists('wc_get_page_id')) {
        $post_id = wc_get_page_id('shop');
    }

    // PÃ¡gina de entradas (blog)
    if (is_home() && !is_front_page()) {
        $post_id = (int) get_option('page_for_posts');
    }

    // Cualquier singular
    if (is_singular() && !$post_id) {
        $post_id = get_the_ID();
    }

    if ($post_id) {
        // ACF imagen "banner_bg"
        if (function_exists('get_field')) {
            $acf_img = get_field('banner_bg', $post_id);
            if (is_array($acf_img) && !empty($acf_img['url'])) {
                return esc_url($acf_img['url']);
            } elseif (is_string($acf_img) && filter_var($acf_img, FILTER_VALIDATE_URL)) {
                return esc_url($acf_img);
            }
        }

        // Meta personalizada con URL
        $meta_url = get_post_meta($post_id, '_rappod_banner_bg', true);
        if ($meta_url && filter_var($meta_url, FILTER_VALIDATE_URL)) {
            return esc_url($meta_url);
        }

        // Imagen destacada
        if (has_post_thumbnail($post_id)) {
            $thumb = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'full');
            if ($thumb) {
                return esc_url($thumb);
            }
        }
    }

    return $url;
}

add_action('wp_head', function () {
    $banner_url = rappod_child_get_context_banner_url();
    if (!$banner_url)
        return;

    // Evitar que reemplace en single posts si no querÃ©s
    if (is_single())
        return;

    $css = ".page-title.bwp-title{background-image:url('" . esc_url($banner_url) . "') !important;}";
    echo "<style id='rappod-child-page-title-bg'>" . $css . "</style>";
}, 99);

add_action('admin_init', 'fix_elementor_permissions');
function fix_elementor_permissions()
{
    if (current_user_can('administrator')) {
        add_filter('user_has_cap', function ($caps) {
            $caps['edit_elementor'] = true;
            return $caps;
        });
    }
}

/* ====== TÃ­tulo de la pÃ¡gina de entradas: "Novedades" ====== */

// Usar el tÃ­tulo de la pÃ¡gina asignada como "PÃ¡gina de entradas".
// Si no hubiera, cae en "Novedades".
function koby_blog_title()
{
    $page_for_posts = (int) get_option('page_for_posts');
    return $page_for_posts ? get_the_title($page_for_posts) : 'Novedades';
}

// 1) Si el theme imprime el tÃ­tulo vÃ­a archive title
add_filter('get_the_archive_title', function ($title) {
    if (is_home() && !is_front_page()) {
        return koby_blog_title();
    }
    return $title;
});

// 2) Por si el theme usa single_post_title() en la pÃ¡gina de entradas
add_filter('single_post_title', function ($title) {
    if (is_home() && !is_front_page()) {
        return koby_blog_title();
    }
    return $title;
});

// 3) Y como tu theme lo hardcodea con esc_html_e('Blogs','rappod'),
// lo reemplazamos vÃ­a gettext SIN tocar el tema padre.
add_filter('gettext', function ($translated, $text, $domain) {
    if ($domain === 'rappod' && ($text === 'Blogs' || $text === 'Blog')) {
        return koby_blog_title();
    }
    return $translated;
}, 10, 3);


// KOBY: Iconos globales de presentaciones en el Customizer
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('koby_icons_section', [
        'title' => 'KOBY: Iconos de PresentaciÃ³n',
        'priority' => 30,
        'description' => 'SubÃ­ los iconos que se usarÃ¡n por defecto para Caja individual / Caja madre (y Caja intermedia opcional).'
    ]);

    // Caja individual
    $wp_customize->add_setting('koby_icon_caja_individual', ['type' => 'theme_mod']);
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'koby_icon_caja_individual',
        ['label' => 'Icono: Caja individual', 'section' => 'koby_icons_section']
    ));

    // Caja madre
    $wp_customize->add_setting('koby_icon_caja_madre', ['type' => 'theme_mod']);
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'koby_icon_caja_madre',
        ['label' => 'Icono: Caja madre', 'section' => 'koby_icons_section']
    ));

    // Caja intermedia (opcional)
    $wp_customize->add_setting('koby_icon_caja_intermedia', ['type' => 'theme_mod']);
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'koby_icon_caja_intermedia',
        ['label' => 'Icono: Caja intermedia (opcional)', 'section' => 'koby_icons_section']
    ));
});


/* =============================
   SHORTCODE BOTÃ“N PDF CATÃLOGO
   ============================= */
// Uso: [koby_boton_pdf url="http://..." texto="Descargar"]
add_shortcode('koby_boton_pdf', function ($atts) {
    $a = shortcode_atts(array(
        'url' => '#',
        'texto' => 'Descargar CatÃ¡logo',
        'target' => '_blank'
    ), $atts);

    // Estilos inline para asegurar consistencia si Elementor no carga
    // Usamos las clases de Elementor + una custom para el icono
    $html = sprintf(
        '<a href="%s" class="elementor-button koby-pdf-btn" target="%s">
            <span class="elementor-button-content-wrapper">
                <span class="elementor-button-icon align-icon-left">
                    <i class="fa-solid fa-download"></i>
                </span>
                <span class="elementor-button-text">%s</span>
            </span>
        </a>',
        esc_url($a['url']),
        esc_attr($a['target']),
        esc_html($a['texto'])
    );

    return $html;
});

/* INYECTAR BOTÃ“N EN LA PÃGINA DE TIENDA (CATÃLOGO) */
// Se inserta antes del listado de productos, en la descripciÃ³n del archivo.
add_action('woocommerce_archive_description', function () {
    if (is_shop()) {
        // CAMBIAR ESTA URL POR LA DEL PDF REAL
        $pdf_url = 'https://koby.com.ar/home/wp-content/uploads/2026/01/CATALOGO-KOBY-2026-1.pdf';

        // Usamos clase CSS para manejar la respuesta mÃ³vil
        echo '<div class="koby-catalog-btn-container">';
        echo do_shortcode('[koby_boton_pdf url="' . $pdf_url . '"]');
        echo '</div>';
    }
}, 15); // Prioridad 15 para salir despuÃ©s de la descripciÃ³n normal (si la hay)
i *cascade08ij*cascade08jŠ *cascade08Š‹*cascade08‹’ *cascade08’“*cascade08“»	 *cascade08»	¼	*cascade08¼	À	 *cascade08À	Ä	*cascade08Ä	ë	 *cascade08ë	ì	*cascade08ì	¡
 *cascade08¡
¢
*cascade08¢
‹ *cascade08‹Œ*cascade08Œı *cascade08ış*cascade08şÕ *cascade08ÕÖ*cascade08Öï *cascade08ïğ*cascade08ğ€ *cascade08€*cascade08¬ *cascade08¬­*cascade08­· *cascade08·¹*cascade08¹§ *cascade08§¨*cascade08¨ê *cascade08êë*cascade08ë *cascade08*cascade08Ş *cascade08ŞŞ*cascade08Şğ *cascade08ğğ*cascade08ğ«! *cascade08«!«!*cascade08«!ß# *cascade08ß#á#*cascade08á#Ø$ *cascade08Ø$Ü$*cascade08Ü$ó$ *cascade08ó$õ$*cascade08õ$û$ *cascade08û$ÿ$*cascade08ÿ$’% *cascade08’%˜%*cascade08˜%à% *cascade08à%á%*cascade08á%ç% *cascade08ç%ì%*cascade08ì%ğ% *cascade08ğ%ñ%*cascade08ñ%÷% *cascade08÷%ü%*cascade08ü%…& *cascade08…&†&*cascade08†&Œ& *cascade08Œ&‘&*cascade08‘&–& *cascade08–&—&*cascade08—&›& *cascade08›&&*cascade08&¡& *cascade08¡&£&*cascade08£&Ç' *cascade08Ç'È'*cascade08È'İ8 *cascade08İ8â8â8ã8 *cascade08ã8æ8*cascade08æ8½9 *cascade08½9Å9Å9‰: *cascade08‰:Š:*cascade08Š:¢: *cascade08¢:£:*cascade08£:è: *cascade08è:é:*cascade08é:ê: *cascade08ê:ë:*cascade08ë:ï: *cascade08ï:ğ:*cascade08ğ:ñ: *cascade08ñ:ò:*cascade08ò:â; *cascade08â;ã;*cascade08ã;½< *cascade08½<¾<*cascade08¾<í> *cascade08í>î>*cascade08î>ğF *cascade08ğFñF*cascade08ñF€G *cascade08€GG*cascade08GƒG *cascade08ƒG…G*cascade08…G¾G *cascade08¾GÂG*cascade08ÂGòG *cascade08òGöG*cascade08öGˆH *cascade08ˆH‰H*cascade08‰HH *cascade08HH*cascade08H‘I *cascade08‘I“I*cascade08“I˜I *cascade08˜IšI*cascade08šI¯I *cascade08¯I±I*cascade08±I…J *cascade08…J‡J*cascade08‡JÈJ *cascade08ÈJÌJ*cascade08ÌJÛJ *cascade08ÛJßJ*cascade08ßJ€K *cascade08€KƒK*cascade08ƒK‡K *cascade08‡KˆK*cascade08ˆKÓK *cascade08ÓKÕK*cascade08ÕKÚK *cascade08ÚKÜK*cascade08ÜKìK *cascade08ìKíK*cascade08íKïK *cascade08ïKğK*cascade08ğK¿L *cascade08¿LÁL*cascade08ÁLüL *cascade08üLşL*cascade08şL‚M *cascade08‚M„M*cascade08„M“M *cascade08“M—M*cascade08—M³M *cascade08³M·M*cascade08·MÿM *cascade08ÿM€N*cascade08€N‚N *cascade08‚NƒN*cascade08ƒNˆN *cascade08ˆNŠN*cascade08ŠNªN *cascade08ªN¬N*cascade08¬N€O *cascade08€OO*cascade08OƒO *cascade08ƒO„O*cascade08„O¿O *cascade08¿OÃO*cascade08ÃOÚO *cascade08ÚOŞO*cascade08ŞOûO *cascade08ûOÿO*cascade08ÿO×P *cascade08×PÙP*cascade08ÙP°R *cascade08°R±R*cascade08±R—Z *cascade08—Z˜Z*cascade08˜ZöZ *cascade08öZÂ[*cascade08Â[Î[ *cascade08
Î[‹\ ‹\–\ *cascade08–\™\™\š\ *cascade08š\›\›\\ *cascade08\¤\¤\¥\ *cascade08
¥\«\ «\¬\ *cascade08
¬\®\ ®\¯\ *cascade08¯\²\²\µ\ *cascade08µ\·\·\í\ *cascade08í\î\*cascade08î\ï\ *cascade08ï\ğ\*cascade08ğ\ø\ *cascade08ø\ù\*cascade08ù\ú\ *cascade08ú\û\*cascade08û\ñ] *cascade082Ifile:///c:/xampp/htdocs/koby/wp-content/themes/rappod-child/functions.php