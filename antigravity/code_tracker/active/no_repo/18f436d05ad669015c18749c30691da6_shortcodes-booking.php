«P<?php

/**
 * Shortcode for Dynamic Booking Form on Single Property Pages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function ocean_dynamic_booking_shortcode($atts)
{
    // 1. Get Current Post ID (Dynamic)
    $post_id = get_the_ID();

    // Ensure we are on a valid post
    if (!$post_id) {
        return '';
    }

    // 2. Define defaults
    // Default redirection to English form /formulario/ or Spanish /formulario/ depending on WPML or logic? 
    // User mentioned: "la version en ingles tiene otro link... pero utiliza el mismo id"
    // For now, we default to '/formulario/', but allow override via shortcode attr.
    // If strict multi-language is needed later, we can check ICL_LANGUAGE_CODE.
    $atts = shortcode_atts([
        'redirection_url' => '/formulario/', // Logic: User implies redirection works regardless of design state
    ], $atts, 'ocean_dynamic_booking');

    // 3. Construct HBook Shortcode
    // Note: HBook automatically detects search params (check_in, check_out, adults, children) from URL if present.
    $hb_shortcode = sprintf(
        '[hb_booking_form accom_id="%d" redirection_url="%s"]',
        $post_id,
        esc_url($atts['redirection_url'])
    );

    // 4. Output Buffering (Wrapper + Form)
    ob_start();
?>
    <div class="ocean-booking-widget">
        <h3 class="ocean-widget-title">
            <?php
            // Dynamic Title: "Consultar precio y disponibilidad para [Nombre]"
            printf(esc_html__('Consultar precio y disponibilidad para %s', 'hello-elementor-child'), get_the_title($post_id));
            ?>
        </h3>

        <div class="ocean-widget-form">
            <?php echo do_shortcode($hb_shortcode); ?>
        </div>
    </div>

    <style>
        /* Widget Styling */
        .ocean-booking-widget {
            background: #F6F6F6;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            border: 1px solid #ECECF2;
        }

        .ocean-widget-title {
            font-family: "Alexandria", sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: #0062E6;
            margin-bottom: 20px;
            line-height: 1.3;
            text-align: left;
        }

        /* Labels */
        .ocean-booking-widget label,
        .ocean-booking-widget .hb-form-field-label {
            font-family: "Alexandria", sans-serif;
            font-size: 15px !important;
            font-weight: 500 !important;
            color: #504E5C !important;
            margin-bottom: 6px !important;
            display: block;
            text-align: left;
        }

        /* Inputs & Selects */
        .ocean-booking-widget input[type="text"],
        .ocean-booking-widget input[type="date"],
        .ocean-booking-widget select {
            background-color: #FFFFFF !important;
            border: 1px solid #DCDCEA !important;
            border-radius: 8px !important;
            padding: 10px 12px !important;
            font-family: "Alexandria", sans-serif;
            font-size: 14px;
            color: #374151;
            width: 100%;
            box-sizing: border-box;
            height: auto !important;
        }

        /* Forces Stacking of ALL fields (Check-in, Check-out, Adults, Children) */
        .ocean-booking-widget .hb-form-field,
        .ocean-booking-widget .hb-form-field-input-group,
        .ocean-booking-widget .hb-people-wrapper,
        .ocean-booking-widget .hb-accom-number-wrapper,
        .ocean-booking-widget .hb-check-dates-wrapper {
            width: 100% !important;
            display: block !important;
            float: none !important;
            margin-right: 0 !important;
            margin-bottom: 15px !important;
            clear: both !important;
        }

        /* Helper to clean up HBook floats */
        .ocean-booking-widget .hb-booking-search-form:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Submit Button Wrapper (Alignment) */
        .ocean-booking-widget .hb-search-submit-wrapper,
        .ocean-booking-widget .hb-search-button-wrapper {
            text-align: left !important;
            width: 100% !important;
            clear: both !important;
        }

        /* Submit Button */
        .ocean-booking-widget input[type="submit"],
        .ocean-booking-widget button.hb-search-submit {
            background-color: #0062E6 !important;
            color: #FFFFFF !important;
            border-radius: 50px !important;
            padding: 10px 25px !important;
            font-family: "Alexandria", sans-serif;
            font-size: 15px !important;
            font-weight: 600 !important;
            border: none !important;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            width: 30% !important;
            /* 30% Width */
            min-width: 140px;
            /* Min width para m√≥viles */
            display: inline-block !important;
        }

        .ocean-booking-widget input[type="submit"]:hover,
        .ocean-booking-widget button.hb-search-submit:hover {
            background-color: #0051C3 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 98, 230, 0.3);
        }

        /* HBook Overrides */
        .ocean-booking-widget .hb-booking-search-form h3 {
            display: none !important;
        }

        /* Ocultar labels vacios si existen */
        .ocean-booking-widget label:empty {
            display: none !important;
        }

        /* Ocultar campo de numero de alojamientos */
        .ocean-booking-widget .hb-accom-number-wrapper {
            display: none !important;
        }

        .ocean-booking-widget .hb-form-field-input-group {
            margin-bottom: 20px !important;
        }
    </style>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            let checkIn = urlParams.get('check_in');
            let checkOut = urlParams.get('check_out');
            const guests = urlParams.get('guests');
            const adults = urlParams.get('adults');
            const children = urlParams.get('children');

            // Helper: Convert YYYY-MM-DD to DD/MM/YYYY
            function formatDateToHBook(dateStr) {
                if (!dateStr) return '';
                // Match YYYY-MM-DD
                if (dateStr.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    const parts = dateStr.split('-');
                    return `${parts[2]}/${parts[1]}/${parts[0]}`;
                }
                return dateStr;
            }

            // Format dates if present
            checkIn = formatDateToHBook(checkIn);
            checkOut = formatDateToHBook(checkOut);

            function setHBookValue(selector, value) {
                const el = document.querySelector(selector);
                if (el && value) {
                    el.value = value;
                    el.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                    el.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
            }

            // Standard HBook Classes/Names
            if (checkIn) setHBookValue('.ocean-booking-widget .hb-check-in-date', checkIn);
            if (checkOut) setHBookValue('.ocean-booking-widget .hb-check-out-date', checkOut);

            // Map guests -> adults if adults is missing
            const finalAdults = adults || guests;
            if (finalAdults) setHBookValue('.ocean-booking-widget select[name="hb-adults"]', finalAdults);
            if (children) setHBookValue('.ocean-booking-widget select[name="hb-children"]', children);

            // Force HBook update (sometimes needed for prices to appear)
            setTimeout(() => {
                const form = document.querySelector('.ocean-booking-widget form');
                if (form && checkIn && checkOut) {
                    // Trigger internal HBook update if method exists, else change event is usually enough
                }
            }, 800);
        });
    </script>
<?php

    return ob_get_clean();
}
add_shortcode('ocean_dynamic_booking', 'ocean_dynamic_booking_shortcode');

/**
 * Shortcode to generate data-url attribute with HBook Params
 * Use in Elementor Loop: Add this to the container's CSS Classes or as an HTML attribute
 * Then use [ocean_link_params_url] to get the actual URL for the Icon Box link
 */
function ocean_link_with_params_shortcode()
{
    $url = get_permalink();
    $params = ['check_in', 'check_out', 'adults', 'children', 'guests'];
    $query_args = [];

    foreach ($params as $param) {
        if (isset($_GET[$param]) && !empty($_GET[$param])) {
            $query_args[$param] = sanitize_text_field($_GET[$param]);
        }
    }

    if (!empty($query_args)) {
        $url = add_query_arg($query_args, $url);
    }

    // Return data attribute instead of raw URL to prevent container transformation
    return 'data-ocean-url="' . esc_url($url) . '"';
}
add_shortcode('ocean_link_with_params', 'ocean_link_with_params_shortcode');

/**
 * Shortcode to generate just the URL (for Icon Box links)
 */
function ocean_link_params_url_shortcode()
{
    $url = get_permalink();
    $params = ['check_in', 'check_out', 'adults', 'children', 'guests'];
    $query_args = [];

    foreach ($params as $param) {
        if (isset($_GET[$param]) && !empty($_GET[$param])) {
            $query_args[$param] = sanitize_text_field($_GET[$param]);
        }
    }

    if (!empty($query_args)) {
        $url = add_query_arg($query_args, $url);
    }

    return esc_url($url);
}
add_shortcode('ocean_link_params_url', 'ocean_link_params_url_shortcode');
«P*cascade082`file:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/inc/shortcodes-booking.php