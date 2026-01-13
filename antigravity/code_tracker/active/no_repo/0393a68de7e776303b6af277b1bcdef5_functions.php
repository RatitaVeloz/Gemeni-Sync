�[<?php

/**
 *  Borrar metaboxes por default:
*/

// Permitir subir imágenes WebP
function my_custom_mime_types( $mimes ) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter( 'upload_mimes', 'my_custom_mime_types' );

// Arreglar detección del tipo de archivo en algunas instalaciones
function my_file_types_webp_fix( $data, $file, $filename, $mimes ) {
    $ext = pathinfo( $filename, PATHINFO_EXTENSION );

    if ( strtolower( $ext ) === 'webp' ) {
        $data['ext']  = 'webp';
        $data['type'] = 'image/webp';
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'my_file_types_webp_fix', 10, 4 );


function remove_woo_boxes() {
    remove_meta_box( 'tipo_capacitaciondiv', 'capacitaciones', 'side' );
}
add_action( 'admin_menu', 'remove_woo_boxes' );


//aceptar imagenes svg en la biblioteca de medios:
function cc_mime_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


//soporte para google maps en ACF:
function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyBvQ5nktZrdXGfnSuhDvGbs4WkfnP6KZ_c');
}
add_action('acf/init', 'my_acf_init');


//Añadir CPT a la busqueda de wordpress:
function my_custom_searchengine($query) {
  if ($query->is_search && !is_admin()) {
    $query->set('post_type', array('post', 'productos', 'capacitaciones', 'novedades', 'servicios'));
  }
  return $query;
}
add_filter('pre_get_posts', 'my_custom_searchengine');



function count_post_visits() {
 if( is_single() ) {
 global $post;
 $views = get_post_meta( $post->ID, 'my_post_viewed', true );
 if( $views == '' ) {
 update_post_meta( $post->ID, 'my_post_viewed', '1' );
 } else {
 $views_no = intval( $views );
 update_post_meta( $post->ID, 'my_post_viewed', ++$views_no );
 }
 }
}
add_action( 'wp_head', 'count_post_visits' );


function add_custom_post_type_to_query( $query ) {
    if ( $query->is_main_query() && is_category()  ) {
        $query->set( 'post_type', array('post', 'productos') );
    }
}
add_action( 'pre_get_posts', 'add_custom_post_type_to_query' );


/* Cargar hojas de estilo y scripts dinamicamente: */
function ss_scripts() {

    if (!is_admin()) {

        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri() . '/js/vendor/jquery-2.1.4.min.js', false, '2.1.4', false);
        wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.7', true );

        //wp_register_script( 'elast1', get_template_directory_uri() . '/js/vendor/jquerypp.custom.js', array('jquery'), '1.0', true );
        //wp_register_script( 'elast2', get_template_directory_uri() . '/js/vendor/jquery.elastislide.js', array('jquery'), '1.0', true );
        wp_register_script( 'navAccordion', get_template_directory_uri() . '/js/vendor/navAccordion.js', array('jquery'), '1.0', true );
        wp_register_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr.custom.17475.js', array(), '1.0', false );
        wp_register_script( 'slick', get_template_directory_uri() . '/js/vendor/slick.min.js', array('jquery'), '1.0', true );
        wp_register_script( 'jmain', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', true );

        // Una vez que registramos el script debemos colocarlo en la cola de WordPress, antes encolamos la hojas de estilo:
        wp_enqueue_style( 'style', get_stylesheet_uri() );
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
        wp_enqueue_style( 'hover', get_template_directory_uri() . '/css/hover-min.css', array('bootstrap'), '1.0', 'all');
        //wp_enqueue_style( 'elastcss', get_template_directory_uri() . '/css/elastislide.css', array('bootstrap'), '1.0', 'all');
		wp_enqueue_style( 'fonts', get_template_directory_uri() . '/css/fonts.css', array(), '1.0', 'all');
        wp_enqueue_style( 'custom-hovers', get_template_directory_uri() . '/css/custom-hovers.css', array('bootstrap'), '1.0', 'all');
        wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.0', 'all');
        wp_enqueue_style( 'slickt', get_template_directory_uri() . '/css/slick-theme.css', array(), '1.0', 'all');
        wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css', array('bootstrap'), '1.0', 'all');

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'bootstrap' );
        //wp_enqueue_script( 'elast1' );
        //wp_enqueue_script( 'elast2' );
        wp_enqueue_script( 'navAccordion' );
        wp_enqueue_script( 'modernizr' );
        wp_enqueue_script( 'slick');
        wp_enqueue_script( 'jmain');

	}

}

// Agregamos la función a la lista de cargas de WordPress.
add_action( 'wp_enqueue_scripts', 'ss_scripts' );


// REMOVE WP EMOJI
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );


/* Cut Strings: */
function limitar_texto($string, $n){
	$stg = strip_tags($string);

	if ( strlen ($stg) > $n )
	{
	echo substr($stg, 0, $n) . '…';
	}
	else { echo $stg; }
}


/*
-- ===================================================
-- Funcion para quitar todos los acentos de una cadena
-- ===================================================
*/
function quitar_tildes($cadena) {
$no_permitidas = array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
$texto = str_replace($no_permitidas, $permitidas ,$cadena);
return $texto;
}


/*
-- ====================================================
-- Cambiar el logo de wordpress en la pantalla de login
-- ====================================================

function custom_loginlogo() {
echo '<style type="text/css">
h1 a {
    background-image: url('.get_bloginfo('template_directory').'/images/logo.png) !important;
    height:95px !important;
    font-size:35px !important;
    width:100% !important;
    margin-bottom:7px !important;
    background-size:contain;
    background-color:#23503f;
    background-repeat:no-repeat;
    background-position: center center !important;
}
.login form {margin-top:10px !important;}
</style>';
}
add_action('login_head', 'custom_loginlogo');
*/


/*
-- =======================================================================
-- Funcion para Obtener coordenadas partir de una dirección en Google Maps
-- =======================================================================
*/
function getCoordinates($address){
    $address = urlencode($address);
    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
    $response = file_get_contents($url);
    $json = json_decode($response,true);

    $lat = $json['results'][0]['geometry']['location']['lat'];
    $lng = $json['results'][0]['geometry']['location']['lng'];

    return array($lat, $lng);
}


/**
 * Filters for the_title()
 */
function gp121028_filter_title( $title ) {
    $substrings = explode( ' ', $title );
    $title = ( ! empty( $substrings[0] ) ) ? $substrings[0] . '<span>' . $substrings[1] . '</span>' : $title;
    return $title;
}

function team_filter_title( $title ) {
    $lines = explode( ' ', $title);
	$output = false;
	$count = 0;

	foreach( $lines as $line ) {
		$count++;
		$output .= '<span class="line-'.$count.'">'.$line.'</span> ';
	}

	return $output;
}


add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
/*
 * Modify TinyMCE editor to remove H1.
 */
function tiny_mce_remove_unused_formats($init) {
    // Add block format elements you want to show in dropdown
    $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5';
    return $init;
}


/**
 * void debug ( mixed Var [, bool Exit] )
 *
 */

if (!function_exists("debug")) {

    function debug($var, $exit = false) {
        echo "\n<pre>";

        if (is_array($var) || is_object($var)) {
            echo htmlentities(print_r($var, true));
        }
        elseif (is_string($var)) {
            echo "string(" . strlen($var) . ") \"" . htmlentities($var) . "\"\n";
        }
        else {
            var_dump($var);
        }
        echo "</pre>";

        if ($exit) {
            exit;
        }
    }
}

//Add thumbnail, automatic feed links and title tag support
if (function_exists('add_theme_support')) {

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support('post-thumbnails');

	add_image_size( 'thumbnail-servicio', 1400 );
	add_image_size( 'thumbnail-carrusel-capacitacion', 280, 150, false );
	add_image_size( 'thumbnail-sub-linea', 540, 410, true );
    add_image_size( 'thumbnail-novedad', 1400 );
    add_image_size( 'thumbnail-galeria-single', 184, 184, true );
}


//Add content width (desktop default)
if ( ! isset( $content_width ) ) {
	$content_width = 768;
}


register_nav_menus( array(
    'primary' => __( 'Menu Principal' ),
    'foomenu' => __( 'Menu al Pie' )
) );



//Add menu support and register main menu
if ( ! file_exists( get_template_directory() . '/wp-bootstrap-navwalker.php' ) ) {
    // file does not exist... return an error.
    return new WP_Error( 'wp-bootstrap-navwalker-missing', __( 'It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
   // file exists... require it.
   require_once get_template_directory() . '/wp-bootstrap-navwalker.php';
}



// Remove the admin bar from the front end
add_filter( 'show_admin_bar', '__return_false' );



// Register sidebar
add_action('widgets_init', 'theme_register_sidebar');
function theme_register_sidebar() {
	if ( function_exists('register_sidebar') ) {
		// Widgets Zones:
		register_sidebar(array(
			'name'=>'Categorias de Productos',
			'id'=>'cats-sidebar',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4 class="widgettitle hidden">',
			'after_title' => '</h4>',
			));
	}
}


function wpfme_has_sidebar($classes) {
    if (is_active_sidebar('sidebar')) {
        // add 'class-name' to the $classes array
        $classes[] = 'has_sidebar';
    }
    // return the $classes array
    return $classes;
}
add_filter('body_class','wpfme_has_sidebar');


// Disable the theme / plugin text editor in Admin
define('DISALLOW_FILE_EDIT', true);


function la_fecha($la_date) {
$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$elementos = explode("-", $la_date);
$mes = $meses[$elementos[2]];
$fecha = $elementos[1]." de ".$mes." de ".$elementos[3];
return $fecha;
}


//Desactivar nuevo editor Gutenberg:
add_filter( 'gutenberg_can_edit_post_type', '__return_false' );


// Hide "add new" on wp-admin menu:
function hd_add_box() {
global $submenu;
unset($submenu['edit.php?post_type=contact'][10]);
}
// hide "add new" button on edit page
function hd_add_buttons() {
global $pagenow;
if(is_admin()){
if($pagenow == 'edit.php' && $_GET['post_type'] == 'contacto'){
echo '.add-new-h2{display: none;}';
}
}
}
add_action('admin_menu', 'hd_add_box');
add_action('admin_head','hd_add_buttons');
?>
0 01 1�
�� 
��[ 2Mfile:///c:/xampp/htdocs/elgalpon/wp-content/themes/galpon-theme/functions.php