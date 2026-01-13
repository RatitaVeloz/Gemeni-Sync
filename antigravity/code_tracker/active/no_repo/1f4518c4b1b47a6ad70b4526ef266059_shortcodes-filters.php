��<?php

/**
 * Sidebar Filters Shortcode
 * 
 * Renderiza el formulario de filtros laterales (Sidebar).
 * Mantiene los parámetros de fechas existentes y permite filtrar por ACF.
 */

if (!defined('ABSPATH')) {
    exit;
}

function op_sidebar_filters_shortcode($atts)
{
    // Obtener valores actuales de la URL para pre-llenar inputs
    $current_check_in = isset($_GET['check_in']) ? esc_attr($_GET['check_in']) : '';
    $current_check_out = isset($_GET['check_out']) ? esc_attr($_GET['check_out']) : '';
    $current_guests = isset($_GET['guests']) ? esc_attr($_GET['guests']) : '';

    // Valores de filtros existentes
    $current_bedrooms = isset($_GET['bedrooms']) ? esc_attr($_GET['bedrooms']) : '';
    $current_bathrooms = isset($_GET['bathrooms']) ? esc_attr($_GET['bathrooms']) : '';
    $current_view = isset($_GET['view_type']) ? esc_attr($_GET['view_type']) : '';

    // Nuevos filtros
    // Nuevos filtros (pueden ser arrays)
    $current_bed_types = isset($_GET['bed_types']) ? $_GET['bed_types'] : [];
    if (!is_array($current_bed_types)) {
        $current_bed_types = !empty($current_bed_types) ? explode(',', $current_bed_types) : [];
    }
    // Sanear array
    $current_bed_types = array_map('esc_attr', $current_bed_types);

    $current_amenities = isset($_GET['amenities']) ? $_GET['amenities'] : [];
    if (!is_array($current_amenities)) {
        $current_amenities = !empty($current_amenities) ? explode(',', $current_amenities) : [];
    }
    // Sanear array
    $current_amenities = array_map('esc_attr', $current_amenities);

    ob_start();
    ?>
    <!-- Sidebar para DESKTOP (fuera del modal) -->
    <div class="op-sidebar-filters-container op-sidebar-desktop">
        <form action="<?php echo esc_url(get_post_type_archive_link('hb_accommodation')); ?>" method="GET"
            class="op-sidebar-form">

            <!-- Hidden Fields para mantener fechas -->
            <?php if ($current_check_in): ?>
                <input type="hidden" name="check_in" value="<?php echo $current_check_in; ?>">
            <?php endif; ?>
            <?php if ($current_check_out): ?>
                <input type="hidden" name="check_out" value="<?php echo $current_check_out; ?>">
            <?php endif; ?>

            <div class="filter-header">
                <h3>Filtrar por:</h3>
            </div>

            <!-- Sección: Capacidad -->
            <div class="filter-section">
                <h4>Capacidad</h4>

                <div class="filter-group">
                    <label>Habitaciones</label>
                    <select name="bedrooms" class="filter-select">
                        <option value="">Cualquiera</option>
                        <option value="1" <?php selected($current_bedrooms, '1'); ?>>1 Habitación</option>
                        <option value="2" <?php selected($current_bedrooms, '2'); ?>>2 Habitaciones</option>
                        <option value="3" <?php selected($current_bedrooms, '3'); ?>>3+ Habitaciones</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Baños</label>
                    <select name="bathrooms" class="filter-select">
                        <option value="">Cualquiera</option>
                        <option value="1" <?php selected($current_bathrooms, '1'); ?>>1 Baño</option>
                        <option value="2" <?php selected($current_bathrooms, '2'); ?>>2 Baños</option>
                    </select>
                </div>
            </div>

            <!-- Sección: Características -->
            <div class="filter-section">
                <h4>Características</h4>

                <div class="filter-group">
                    <label>Vista</label>
                    <select name="view_type" class="filter-select">
                        <option value="">Cualquiera</option>
                        <option value="Mar (Ocean)" <?php selected($current_view, 'Mar (Ocean)'); ?>>Mar (Ocean)
                        </option>
                        <option value="Ciudad (Collins)" <?php selected($current_view, 'Ciudad (Collins)'); ?>>
                            Ciudad (Collins)</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tipos de camas</label>
                    <select name="bed_types" class="filter-select">
                        <option value="">Cualquiera</option>
                        <option value="King" <?php selected(in_array('King', $current_bed_types), true); ?>>King
                        </option>
                        <option value="Queen" <?php selected(in_array('Queen', $current_bed_types), true); ?>>Queen
                        </option>
                        <option value="Doble / Full" <?php selected(in_array('Doble / Full', $current_bed_types), true); ?>>Doble / Full</option>
                        <option value="Individual / Twin" <?php selected(in_array('Individual / Twin', $current_bed_types), true); ?>>Individual / Twin</option>
                        <option value="Sofa Cama / Futón" <?php selected(in_array('Sofa Cama / Futón', $current_bed_types), true); ?>>Sofa Cama / Futón</option>
                        <option value="Cama Marinera / Literas" <?php selected(in_array('Cama Marinera / Literas', $current_bed_types), true); ?>>Cama Marinera / Literas</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Amenidades</label>
                    <details class="amenities-dropdown">
                        <summary class="amenities-summary">Seleccionar amenidades</summary>
                        <div class="amenities-checkboxes">
                            <?php
                            $amenities_options = [
                                'Aire acondicionado',
                                'WiFi de alta velocidad',
                                'TV con cable/streaming',
                                'Cocina equipada completa',
                                'Microondas',
                                'Cafetera',
                                'Lavavajillas',
                                'Lavadora',
                                'Secadora',
                                'Plancha y tabla de planchar',
                                'Secador de pelo',
                                'Ropa de cama',
                                'Toallas'
                            ];
                            // Asegurar que $current_amenities sea un array para in_array
                            $selected_amenities = is_array($current_amenities) ? $current_amenities : [];

                            foreach ($amenities_options as $option):
                                ?>
                                <div class="amenity-item">
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="<?php echo esc_attr($option); ?>"
                                            <?php checked(in_array($option, $selected_amenities)); ?>>
                                        <?php echo esc_html($option); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </details>
                </div>
            </div>

            <!-- Sección: Precios (Visual por ahora) -->
            <div class="filter-section">
                <!-- Placeholder para futuro sider o select -->
                <?php
                // Obtener Min/Max precio real de las tablas de HBook
                global $wpdb;
                $table_rates = $wpdb->prefix . 'hb_rates';

                // Consultamos la tabla de tarifas directamente
                $db_price_min = $wpdb->get_var("SELECT MIN(amount) FROM $table_rates WHERE type='accom'");
                $db_price_max = $wpdb->get_var("SELECT MAX(amount) FROM $table_rates WHERE type='accom'");

                // Fallbacks si no hay datos
                $db_price_min = $db_price_min ? intval($db_price_min) : 0;
                $db_price_max = $db_price_max ? intval($db_price_max) : 500;

                // Valores seleccionados actuales
                $val_price_min = isset($_GET['price_min']) && $_GET['price_min'] !== '' ? intval($_GET['price_min']) : $db_price_min;
                $val_price_max = isset($_GET['price_max']) && $_GET['price_max'] !== '' ? intval($_GET['price_max']) : $db_price_max;
                ?>
                <div class="filter-group filter-price">
                    <div
                        style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom:15px;">
                        <h4 style="margin: 0; line-height: 1;">Precio por noche</h4>
                        <span class="price-display-values"
                            style="color:#0062E6; font-weight:700; font-family:'Alexandria'; line-height: 1;">
                            $<?php echo $val_price_min; ?> - $<?php echo $val_price_max; ?>
                        </span>
                    </div>

                    <div class="ocean-price-slider" data-min="<?php echo $db_price_min; ?>"
                        data-max="<?php echo $db_price_max; ?>" data-start-min="<?php echo $val_price_min; ?>"
                        data-start-max="<?php echo $val_price_max; ?>">
                    </div>

                    <input type="hidden" name="price_min" class="input-price-min"
                        value="<?php echo $val_price_min; ?>">
                    <input type="hidden" name="price_max" class="input-price-max"
                        value="<?php echo $val_price_max; ?>">
                </div>
            </div>

            <div class="filter-actions filter-section" style="border-bottom:none;">
                <button type="submit" class="btn-filter-apply">Aplicar Filtros</button>
                <a href="<?php echo esc_url(get_post_type_archive_link('hb_accommodation')); ?>"
                    class="btn-filter-reset">Limpiar</a>
            </div>
        </form>
    </div>
    <!-- Fin Sidebar Desktop -->

    <!-- Botón Trigger para Mobile -->
    <button type="button" class="op-filters-trigger-btn">Filtrar por:</button>

    <!-- Modal Wrapper (Overlay) -->
    <div class="op-filters-modal-wrapper">
        <div class="op-filters-modal-content">
            <!-- Botón Cerrar -->
            <button type="button" class="op-modal-close">✕ Cerrar</button>

            <!-- Contenedor del Sidebar (mismo contenido) -->
            <div class="op-sidebar-filters-container op-sidebar-mobile">
                <form action="<?php echo esc_url(get_post_type_archive_link('hb_accommodation')); ?>" method="GET"
                    class="op-sidebar-form">

                    <!-- Hidden Fields para mantener fechas -->
                    <?php if ($current_check_in): ?>
                        <input type="hidden" name="check_in" value="<?php echo $current_check_in; ?>">
                    <?php endif; ?>
                    <?php if ($current_check_out): ?>
                        <input type="hidden" name="check_out" value="<?php echo $current_check_out; ?>">
                    <?php endif; ?>

                    <div class="filter-header">
                        <h3>Filtrar por:</h3>
                    </div>

                    <!-- Sección: Capacidad -->
                    <div class="filter-section">
                        <h4>Capacidad</h4>

                        <div class="filter-group">
                            <label>Habitaciones</label>
                            <select name="bedrooms" class="filter-select">
                                <option value="">Cualquiera</option>
                                <option value="1" <?php selected($current_bedrooms, '1'); ?>>1 Habitación</option>
                                <option value="2" <?php selected($current_bedrooms, '2'); ?>>2 Habitaciones</option>
                                <option value="3" <?php selected($current_bedrooms, '3'); ?>>3+ Habitaciones</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Baños</label>
                            <select name="bathrooms" class="filter-select">
                                <option value="">Cualquiera</option>
                                <option value="1" <?php selected($current_bathrooms, '1'); ?>>1 Baño</option>
                                <option value="2" <?php selected($current_bathrooms, '2'); ?>>2 Baños</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sección: Características -->
                    <div class="filter-section">
                        <h4>Características</h4>

                        <div class="filter-group">
                            <label>Vista</label>
                            <select name="view_type" class="filter-select">
                                <option value="">Cualquiera</option>
                                <option value="Mar (Ocean)" <?php selected($current_view, 'Mar (Ocean)'); ?>>Mar (Ocean)
                                </option>
                                <option value="Ciudad (Collins)" <?php selected($current_view, 'Ciudad (Collins)'); ?>>
                                    Ciudad (Collins)</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Tipos de camas</label>
                            <select name="bed_types" class="filter-select">
                                <option value="">Cualquiera</option>
                                <option value="King" <?php selected(in_array('King', $current_bed_types), true); ?>>King
                                </option>
                                <option value="Queen" <?php selected(in_array('Queen', $current_bed_types), true); ?>>Queen
                                </option>
                                <option value="Doble / Full" <?php selected(in_array('Doble / Full', $current_bed_types), true); ?>>Doble / Full</option>
                                <option value="Individual / Twin" <?php selected(in_array('Individual / Twin', $current_bed_types), true); ?>>Individual / Twin</option>
                                <option value="Sofa Cama / Futón" <?php selected(in_array('Sofa Cama / Futón', $current_bed_types), true); ?>>Sofa Cama / Futón</option>
                                <option value="Cama Marinera / Literas" <?php selected(in_array('Cama Marinera / Literas', $current_bed_types), true); ?>>Cama Marinera / Literas</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Amenidades</label>
                            <details class="amenities-dropdown">
                                <summary class="amenities-summary">Seleccionar amenidades</summary>
                                <div class="amenities-checkboxes">
                                    <?php
                                    $amenities_options = [
                                        'Aire acondicionado',
                                        'WiFi de alta velocidad',
                                        'TV con cable/streaming',
                                        'Cocina equipada completa',
                                        'Microondas',
                                        'Cafetera',
                                        'Lavavajillas',
                                        'Lavadora',
                                        'Secadora',
                                        'Plancha y tabla de planchar',
                                        'Secador de pelo',
                                        'Ropa de cama',
                                        'Toallas'
                                    ];
                                    // Asegurar que $current_amenities sea un array para in_array
                                    $selected_amenities = is_array($current_amenities) ? $current_amenities : [];

                                    foreach ($amenities_options as $option):
                                        ?>
                                        <div class="amenity-item">
                                            <label>
                                                <input type="checkbox" name="amenities[]" value="<?php echo esc_attr($option); ?>"
                                                    <?php checked(in_array($option, $selected_amenities)); ?>>
                                                <?php echo esc_html($option); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Sección: Precios (Visual por ahora) -->
                    <div class="filter-section">
                        <!-- Placeholder para futuro sider o select -->
                        <?php
                        // Obtener Min/Max precio real de las tablas de HBook
                        global $wpdb;
                        $table_rates = $wpdb->prefix . 'hb_rates';

                        // Consultamos la tabla de tarifas directamente
                        $db_price_min = $wpdb->get_var("SELECT MIN(amount) FROM $table_rates WHERE type='accom'");
                        $db_price_max = $wpdb->get_var("SELECT MAX(amount) FROM $table_rates WHERE type='accom'");

                        // Fallbacks si no hay datos
                        $db_price_min = $db_price_min ? intval($db_price_min) : 0;
                        $db_price_max = $db_price_max ? intval($db_price_max) : 500;

                        // Valores seleccionados actuales
                        $val_price_min = isset($_GET['price_min']) && $_GET['price_min'] !== '' ? intval($_GET['price_min']) : $db_price_min;
                        $val_price_max = isset($_GET['price_max']) && $_GET['price_max'] !== '' ? intval($_GET['price_max']) : $db_price_max;
                        ?>
                        <div class="filter-group filter-price">
                            <div
                                style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom:15px;">
                                <h4 style="margin: 0; line-height: 1;">Precio por noche</h4>
                                <span class="price-display-values"
                                    style="color:#0062E6; font-weight:700; font-family:'Alexandria'; line-height: 1;">
                                    $<?php echo $val_price_min; ?> - $<?php echo $val_price_max; ?>
                                </span>
                            </div>

                            <div class="ocean-price-slider" data-min="<?php echo $db_price_min; ?>"
                                data-max="<?php echo $db_price_max; ?>" data-start-min="<?php echo $val_price_min; ?>"
                                data-start-max="<?php echo $val_price_max; ?>">
                            </div>

                            <input type="hidden" name="price_min" class="input-price-min"
                                value="<?php echo $val_price_min; ?>">
                            <input type="hidden" name="price_max" class="input-price-max"
                                value="<?php echo $val_price_max; ?>">
                        </div>
                    </div>

                    <div class="filter-actions filter-section" style="border-bottom:none;">
                        <button type="submit" class="btn-filter-apply">Aplicar Filtros</button>
                        <a href="<?php echo esc_url(get_post_type_archive_link('hb_accommodation')); ?>"
                            class="btn-filter-reset">Limpiar</a>
                    </div>
                </form>
            </div>
            <!-- Fin Contenedor Sidebar -->
        </div>
        <!-- Fin Modal Content -->
    </div>
    <!-- Fin Modal Wrapper -->

    <script>
        (function () {
            // Esperar a que el DOM esté listo
            document.addEventListener('DOMContentLoaded', function () {
                var triggerBtn = document.querySelector('.op-filters-trigger-btn');
                var modalWrapper = document.querySelector('.op-filters-modal-wrapper');
                var modalClose = document.querySelector('.op-modal-close');
                var modalContent = document.querySelector('.op-filters-modal-content');

                if (!triggerBtn || !modalWrapper || !modalClose) return;

                // Abrir modal
                triggerBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    modalWrapper.classList.add('active');
                    document.body.classList.add('modal-open');
                });

                // Cerrar modal con botón X
                modalClose.addEventListener('click', function (e) {
                    e.preventDefault();
                    modalWrapper.classList.remove('active');
                    document.body.classList.remove('modal-open');
                });

                // Cerrar modal al hacer click en el overlay (fuera del contenido)
                modalWrapper.addEventListener('click', function (e) {
                    if (e.target === modalWrapper) {
                        modalWrapper.classList.remove('active');
                        document.body.classList.remove('modal-open');
                    }
                });

                // Prevenir que clicks dentro del modal lo cierren
                modalContent.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            });
        })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('op_sidebar_filters', 'op_sidebar_filters_shortcode');
��*cascade082`file:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/inc/shortcodes-filters.php