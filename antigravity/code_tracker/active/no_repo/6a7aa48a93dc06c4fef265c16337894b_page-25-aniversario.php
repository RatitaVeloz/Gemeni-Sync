›∆<?php
/**
 * Template Name: 25 Aniversario
 * Description: P√°gina especial para el 25 aniversario con hero de antes/despu√©s interactivo
 */

get_header();

// Helper para obtener im√°genes desde ACF
if (!function_exists('egp_get_image_html')) {
    function egp_get_image_html($img, $size = 'full', $attrs = array()) {
        if (empty($img)) return '';

        if (is_array($img)) {
            if (isset($img['ID'])) {
                return wp_get_attachment_image($img['ID'], $size, false, $attrs);
            }
            if (isset($img['id'])) {
                return wp_get_attachment_image($img['id'], $size, false, $attrs);
            }
            if (isset($img['url'])) {
                $url = esc_url($img['url']);
                $alt = isset($img['alt']) ? esc_attr($img['alt']) : '';
                $class = isset($attrs['class']) ? esc_attr($attrs['class']) : '';
                return '<img src="'.$url.'" alt="'.$alt.'" class="'.$class.'" />';
            }
        }

        if (is_numeric($img)) {
            return wp_get_attachment_image((int)$img, $size, false, $attrs);
        }

        if (is_string($img)) {
            $url = esc_url($img);
            $class = isset($attrs['class']) ? esc_attr($attrs['class']) : '';
            return '<img src="'.$url.'" alt="" class="'.$class.'" />';
        }

        return '';
    }
}

// Helper para obtener URL de imagen
if (!function_exists('egp_get_image_url')) {
    function egp_get_image_url($img, $size = 'full') {
        if (empty($img)) return '';
        
        if (is_array($img)) {
            if (isset($img['sizes'][$size])) {
                return esc_url($img['sizes'][$size]);
            }
            if (isset($img['url'])) {
                return esc_url($img['url']);
            }
        }
        
        if (is_numeric($img)) {
            $url = wp_get_attachment_image_url((int)$img, $size);
            return $url ? esc_url($url) : '';
        }
        
        if (is_string($img)) {
            return esc_url($img);
        }
        
        return '';
    }
}

// Obtener campos ACF
$hero_titulo = get_field('hero_titulo') ?: '25 A√±os de Evoluci√≥n';
$hero_subtitulo = get_field('hero_subtitulo') ?: 'Desliza para ver nuestra transformaci√≥n';
?>

<!-- Hero Antes y Despu√©s Interactivo -->
<section class="aniversario-hero-interactive">
    <div class="container-fluid">
        <?php if (have_rows('hero_comparador')): ?>
            <!-- Carousel Container -->
            <div class="hero-carousel-wrapper">
                <!-- Flecha Izquierda -->
                <button class="carousel-arrow carousel-arrow-left" aria-label="Anterior">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M25 10L15 20L25 30" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <!-- Comparaciones Carousel -->
                <div class="comparisons-carousel">
                    <?php 
                    $index = 0;
                    while (have_rows('hero_comparador')): the_row();
                        $tipo = get_sub_field('tipo_media') ?: 'imagen';
                        $img_antes = get_sub_field('imagen_antes');
                        $img_despues = get_sub_field('imagen_despues');
                        $video_antes = get_sub_field('video_antes');
                        $video_despues = get_sub_field('video_despues');
                        $descripcion = get_sub_field('descripcion');
                        $anio = get_sub_field('anio');
                        
                        if (($tipo === 'imagen' && $img_antes && $img_despues) || 
                            ($tipo === 'video' && $video_antes && $video_despues)):
                    ?>
                        <div class="comparison-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                        <div class="comparison-container" data-type="<?php echo esc_attr($tipo); ?>">
                            
                            <?php if ($tipo === 'imagen'): ?>
                                <!-- IM√ÅGENES -->
                                <?php 
                                $url_despues = egp_get_image_url($img_despues, 'large');
                                $url_antes = egp_get_image_url($img_antes, 'large');
                                ?>
                                
                                <!-- Imagen BASE (Antes) - Define el tama√±o del contenedor -->
                                <div class="comparison-base">
                                    <?php if ($url_antes): ?>
                                        <img src="<?php echo $url_antes; ?>" 
                                             alt="Antes" 
                                             class="comparison-media base-image"
                                             loading="lazy">
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Capa DESPU√âS (se revela desde la izquierda) -->
                                <div class="after-container">
                                    <?php if ($url_despues): ?>
                                        <img src="<?php echo $url_despues; ?>" 
                                             alt="Despu√©s" 
                                             class="comparison-media"
                                             loading="lazy">
                                    <?php endif; ?>
                                    <div class="label label-after">Despu√©s</div>
                                </div>
                                
                                <!-- Capa ANTES (visible del lado derecho) -->
                                <div class="before-container">
                                    <?php if ($url_antes): ?>
                                        <img src="<?php echo $url_antes; ?>" 
                                             alt="Antes" 
                                             class="comparison-media" 
                                             loading="lazy">
                                    <?php endif; ?>
                                    <div class="label label-before">Antes</div>
                                </div>
                                
                            <?php else: ?>
                                <!-- VIDEOS -->
                                <div class="comparison-base">
                                    <video class="comparison-media base-image" 
                                           muted 
                                           loop 
                                           playsinline
                                           autoplay>
                                        <source src="<?php echo esc_url($video_antes); ?>" type="video/mp4">
                                    </video>
                                </div>
                                
                                <div class="after-container">
                                    <video class="comparison-media" 
                                           muted 
                                           loop 
                                           playsinline
                                           autoplay>
                                        <source src="<?php echo esc_url($video_despues); ?>" type="video/mp4">
                                    </video>
                                    <div class="label label-after">Despu√©s</div>
                                </div>

                                <div class="before-container">
                                    <video class="comparison-media" 
                                           muted 
                                           loop 
                                           playsinline
                                           autoplay>
                                        <source src="<?php echo esc_url($video_antes); ?>" type="video/mp4">
                                    </video>
                                    <div class="label label-before">Antes</div>
                                </div>
                            <?php endif; ?>

                            <!-- Slider Handle -->
                            <div class="slider-line"></div>
                            <div class="slider-handle">
                                <span class="handle-arrows"></span>
                            </div>

                            <?php if ($descripcion || $anio): ?>
                                <div class="comparison-info">
                                    <?php if ($anio): ?>
                                        <span class="info-year"><?php echo esc_html($anio); ?></span>
                                    <?php endif; ?>
                                    <?php if ($descripcion): ?>
                                        <p class="info-desc"><?php echo esc_html($descripcion); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php 
                        $index++;
                        endif;
                    endwhile; ?>
                </div>

                <!-- Flecha Derecha -->
                <button class="carousel-arrow carousel-arrow-right" aria-label="Siguiente">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M15 10L25 20L15 30" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                
                <!-- Indicadores de posici√≥n - DENTRO del wrapper -->
                <div class="carousel-indicators">
                    <?php for ($i = 0; $i < $index; $i++): ?>
                        <button class="indicator-dot <?php echo $i === 0 ? 'active' : ''; ?>" 
                                data-slide="<?php echo $i; ?>" 
                                aria-label="Ir a comparaci√≥n <?php echo $i + 1; ?>"></button>
                    <?php endfor; ?>
                </div>
            </div>
            <!-- FIN hero-carousel-wrapper -->
            
            <div class="hero-instructions">
                <p>üí° Arrastra el control o haz clic para comparar</p>
            </div>

            <!-- T√≠tulo y subt√≠tulo debajo de todo -->
            <div class="hero-header hero-header-bottom">
                <h1 class="hero-title"><?php echo esc_html($hero_titulo); ?></h1>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Agrega comparaciones en el campo "hero_comparador" para mostrar el antes y despu√©s</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Timeline -->
<section class="aniversario-timeline">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="section-title">25 A√±os de Historia</h2>
            </div>
        </div>
        
        <?php if (have_rows('timeline')): ?>
            <div class="timeline-slider">
                <?php while (have_rows('timeline')): the_row();
                    $anio = get_sub_field('anio');
                    $titulo = get_sub_field('titulo');
                    $desc = get_sub_field('descripcion');
                    $foto = get_sub_field('foto');
                ?>
                    <div class="timeline-item">
                        <?php if ($foto): ?>
                            <div class="timeline-thumb">
                                <?php echo egp_get_image_html($foto, 'medium', array('class'=>'img-responsive')); ?>
                            </div>
                        <?php endif; ?>
                        <div class="timeline-content">
                            <?php if ($anio): ?>
                                <div class="timeline-year"><?php echo esc_html($anio); ?></div>
                            <?php endif; ?>
                            <?php if ($titulo): ?>
                                <h4 class="timeline-title"><?php echo esc_html($titulo); ?></h4>
                            <?php endif; ?>
                            <?php if ($desc): ?>
                                <p class="timeline-desc"><?php echo wp_kses_post($desc); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Agrega hitos en la repetidora "timeline".</p>
        <?php endif; ?>
    </div>
</section>

<!-- Productos -->
<section class="aniversario-productos">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="section-title">Conoc√© nuestros Productos</h2>
            </div>
        </div>
        
        <ul class="productos-grid">
            <?php
            $args = array(
                'orderby'    => 'ID',
                'order'      => 'ASC',
                'parent'     => 0,
                'hide_empty' => 0
            );
            $categories = get_categories($args);
            foreach($categories as $category):
                $imagen_cat = get_term_meta($category->term_id, 'imagen_de_categoria', true);
                $imagen_url = $imagen_cat ? wp_get_attachment_url($imagen_cat) : '';
            ?>
                <li class="producto-item">
                    <a href="<?php echo esc_url(get_category_link($category)); ?>" class="producto-link">
                        <?php if ($imagen_url): ?>
                            <div class="producto-icon">
                                <img src="<?php echo esc_url($imagen_url); ?>" 
                                     alt="<?php echo esc_attr($category->name); ?>" 
                                     class="svg">
                            </div>
                        <?php endif; ?>
                        <span class="producto-name"><?php echo esc_html($category->name); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- Aliados -->
<section class="aniversario-aliados">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="section-title">Nuestros Aliados</h2>
            </div>
        </div>

        <div class="aliados-carousel">
            <div class="aliados-track">
                <?php
                $front_id = (int) get_option('page_on_front');
                $marcas = $front_id ? get_field('galeria_de_marcas', $front_id) : array();

                if ($marcas && is_array($marcas)):
                    foreach ($marcas as $marca):
                        $url = isset($marca['url']) ? $marca['url'] : '';
                        $title = isset($marca['title']) ? $marca['title'] : '';
                        $link = isset($marca['description']) ? $marca['description'] : '';
                ?>
                    <div class="aliado-item">
                        <?php if ($link): ?>
                            <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
                                <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($title); ?>">
                            </a>
                        <?php else: ?>
                            <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($title); ?>">
                        <?php endif; ?>
                    </div>
                <?php 
                    endforeach;
                else:
                    echo '<p class="text-center">Agrega logos en la Home (galeria_de_marcas).</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Historias / Galer√≠a -->
<section class="aniversario-historias">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="section-title">Juntos Construimos Historias</h2>
            </div>
        </div>
        
        <div class="historias-grid">
            <?php if (have_rows('historias')): 
                while (have_rows('historias')): the_row();
                    $tipo = get_sub_field('media_tipo');
                    $img = get_sub_field('imagen');
                    $video_url = get_sub_field('video_url');
                    $cliente = get_sub_field('cliente');
                    $testimonio = get_sub_field('testimonio');
            ?>
                <div class="historia-item">
                    <div class="historia-media">
                        <?php if ($tipo === 'video' && $video_url): ?>
                            <div class="video-wrapper">
                                <iframe src="<?php echo esc_url($video_url); ?>" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen></iframe>
                            </div>
                        <?php else: ?>
                            <?php echo egp_get_image_html($img, 'large', array('class'=>'img-responsive')); ?>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($cliente || $testimonio): ?>
                        <div class="historia-overlay">
                            <?php if ($cliente): ?>
                                <h4 class="historia-cliente"><?php echo esc_html($cliente); ?></h4>
                            <?php endif; ?>
                            <?php if ($testimonio): ?>
                                <p class="historia-testimonio"><?php echo wp_kses_post($testimonio); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; else: ?>
                <div class="col-xs-12">
                    <p class="text-center">Agrega historias en el repetidor "historias".</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Formulario de Contacto -->
<section class="aniversario-contacto">
    <div class="container-fluid">
        <?php $frase = get_field('cierre_frase'); ?>
        <div class="row">
            <div class="col-xs-12">
                <h2 class="section-title">
                    <?php echo $frase ? esc_html($frase) : 'Vos tambi√©n pod√©s ser parte de los pr√≥ximos 25 a√±os'; ?>
                </h2>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?php 
                $form_shortcode = get_field('form_shortcode');
                if ($form_shortcode) {
                    echo do_shortcode($form_shortcode);
                } else {
                    echo '<p class="text-center">Agrega el shortcode del formulario en "form_shortcode".</p>';
                }
                ?>
            </div>
        </div>

        <?php
        $wa = get_field('whatsapp_url');
        $ig = get_field('instagram_url');
        $fb = get_field('facebook_url');
        ?>
        <?php if ($wa || $ig || $fb): ?>
            <div class="social-buttons">
                <?php if ($wa): ?>
                    <a href="<?php echo esc_url($wa); ?>" 
                       class="btn btn-whatsapp" 
                       target="_blank" 
                       rel="noopener">WhatsApp</a>
                <?php endif; ?>
                <?php if ($ig): ?>
                    <a href="<?php echo esc_url($ig); ?>" 
                       class="btn btn-instagram" 
                       target="_blank" 
                       rel="noopener">Instagram</a>
                <?php endif; ?>
                <?php if ($fb): ?>
                    <a href="<?php echo esc_url($fb); ?>" 
                       class="btn btn-facebook" 
                       target="_blank" 
                       rel="noopener">Facebook</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
jQuery(function($){
    // ========================================
    // CAROUSEL NAVIGATION
    // ========================================
    let currentSlide = 0;
    const $slides = $('.comparison-slide');
    const $indicators = $('.indicator-dot');
    const totalSlides = $slides.length;
    
    function showSlide(index) {
        // Normalizar √≠ndice (loop)
        if (index >= totalSlides) index = 0;
        if (index < 0) index = totalSlides - 1;
        
        currentSlide = index;
        
        // Ocultar todos y mostrar actual
        $slides.removeClass('active');
        $slides.eq(index).addClass('active');
        
        // Actualizar indicadores
        $indicators.removeClass('active');
        $indicators.eq(index).addClass('active');
    }
    
    // Flechas de navegaci√≥n
    $('.carousel-arrow-left').on('click', function() {
        showSlide(currentSlide - 1);
    });
    
    $('.carousel-arrow-right').on('click', function() {
        showSlide(currentSlide + 1);
    });
    
    // Indicadores (dots)
    $indicators.on('click', function() {
        const slideIndex = $(this).data('slide');
        showSlide(slideIndex);
    });
    
    // Navegaci√≥n con teclado
    $(document).on('keydown', function(e) {
        if ($('.aniversario-hero-interactive').length) {
            if (e.key === 'ArrowLeft') {
                showSlide(currentSlide - 1);
            } else if (e.key === 'ArrowRight') {
                showSlide(currentSlide + 1);
            }
        }
    });
    
    // ========================================
    // COMPARISON SLIDER (cada slide individual)
    // ========================================
    $('.comparison-container').each(function() {
        const container = $(this);
        const afterContainer = container.find('.after-container');
        const handle = container.find('.slider-handle');
        const sliderLine = container.find('.slider-line');
        let isDragging = false;

        function updateSlider(x) {
            const rect = container[0].getBoundingClientRect();
            const position = Math.max(0, Math.min(x - rect.left, rect.width));
            const percentage = (position / rect.width) * 100;
            
            // Actualizar ancho del contenedor "despu√©s"
            afterContainer.css('width', percentage + '%');
            
            // Mover el handle Y la l√≠nea juntos
            handle.css('left', percentage + '%');
            sliderLine.css('left', percentage + '%');
        }

        // Mouse events
        handle.on('mousedown', function(e) {
            isDragging = true;
            e.preventDefault();
        });

        container.on('click', function(e) {
            if (!$(e.target).closest('.slider-handle').length) {
                updateSlider(e.clientX);
            }
        });

        $(document).on('mousemove', function(e) {
            if (isDragging) {
                updateSlider(e.clientX);
            }
        });

        $(document).on('mouseup', function() {
            isDragging = false;
        });

        // Touch events
        handle.on('touchstart', function(e) {
            isDragging = true;
            e.preventDefault();
        });

        $(document).on('touchmove', function(e) {
            if (isDragging && e.originalEvent.touches.length > 0) {
                updateSlider(e.originalEvent.touches[0].clientX);
            }
        });

        $(document).on('touchend', function() {
            isDragging = false;
        });

        // Reproducir videos si existen
        if (container.data('type') === 'video') {
            container.find('video').each(function() {
                this.play().catch(function() {
                    // Ignorar errores de autoplay
                });
            });
        }
    });

    // Timeline Slider
    if ($('.timeline-slider').length && $.fn.slick) {
        $('.timeline-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            infinite: false,
            adaptiveHeight: true,
            responsive: [
                { breakpoint: 1200, settings: { slidesToShow: 3 } },
                { breakpoint: 992, settings: { slidesToShow: 2 } },
                { breakpoint: 576, settings: { slidesToShow: 1 } }
            ]
        });
    }

    // Aliados carousel (si no usas slick, pod√©s usar este simple auto-scroll)
    const track = $('.aliados-track');
    if (track.length) {
        const items = track.html();
        track.html(items + items); // Duplicar para loop infinito
    }
});
</script>

<?php get_footer(); ?> *cascade08* *cascade08*ää‹
 *cascade08‹
·
·
‚
 *cascade08‚
„
„
‰
 *cascade08‰
Â
Â
Ê
 *cascade08Ê
Á
Á
È
 *cascade08È
Í
Í
Î
 *cascade08Î


Ú
 *cascade08Ú
ˆ
ˆ
˜
 *cascade08˜
¯
¯
˙
 *cascade08˙
ÄÄÅ *cascade08Åààâ *cascade08âããå *cascade08åèèê *cascade08êííì *cascade08ìüü¢ *cascade08¢¶¶ß *cascade08ß´´≤ *cascade08≤µµ∂ *cascade08∂∏∏ª *cascade08ªΩΩæ *cascade08æ≈≈∆ *cascade08∆ŒŒœ *cascade08œ––— *cascade08—““” *cascade08”ÿÿŸ *cascade08Ÿ⁄⁄€ *cascade08€‚‚„ *cascade08„ÂÂÏ *cascade08ÏÌÌÓ *cascade08ÓÔÔ *cascade08ÒÒÚ *cascade08ÚÛÛÙ *cascade08Ù˛˛Å *cascade08ÅÑÑÖ *cascade08Öààç *cascade08çêêñ *cascade08ñõõù *cascade08ùûûü *cascade08ü°°¢ *cascade08¢££§ *cascade08§••¶ *cascade08¶™™´ *cascade08´≠≠π *cascade08π»»  *cascade08 ’’◊ *cascade08◊ÿÿŸ *cascade08Ÿ‹‹„ *cascade08„ÔÔÒ *cascade08ÒˇˇÄ *cascade08ÄÑÑÜ *cascade08Üááà *cascade08àééè *cascade08èììô *cascade08ôúúù *cascade08ù¢¢ß *cascade08ßµµ∂ *cascade08∂∑∑∏ *cascade08∏∫∫ª *cascade08ª¿¿¬ *cascade08¬»»Õ *cascade08ÕŸŸ€ *cascade08€››ﬁ *cascade08ﬁÂÂÊ *cascade08ÊÈÈÍ *cascade08ÍÓÓÔ *cascade08ÔÙÙ˚ *cascade08˚ÉÉå *cascade08åççû *cascade08ûüü† *cascade08†°°¢ *cascade08¢££§ *cascade08§¶¶ß *cascade08ß±±≤ *cascade08≤¥¥µ *cascade08µ∂∂ª *cascade08ª  À *cascade08ÀŒŒ– *cascade08–——“ *cascade08“‘‘÷ *cascade08÷ÿÿŸ *cascade08Ÿ‹‹› *cascade08›‰‰Â *cascade08ÂÁÁË *cascade08ËÈÈÍ *cascade08ÍÒ *cascade08ÒÛÛÙ *cascade08Ùııˆ *cascade08ˆ˜˜˝ *cascade08˝ÄÄÖ *cascade08Öááà *cascade08àââå *cascade08åééè *cascade08èîîï *cascade08ïôôõ *cascade08õüü† *cascade08†••ß *cascade08ßØØ± *cascade08±µµ∂ *cascade08∂ππæ *cascade08æ¬¬√ *cascade08√  À *cascade08ÀÃÃŒ *cascade08Œ‰‰Ë *cascade08ËÏÏÌ *cascade08Ì˘˘˚ *cascade08˚˛˛É *cascade08ÉÑÑå *cascade08åççé *cascade08éëëï *cascade08ïòòô *cascade08ôúúù *cascade08ùüü• *cascade08•¡¡√ *cascade08√««» *cascade08»œœ– *cascade08–⁄⁄€ *cascade08€ﬂﬂ‡ *cascade08‡‚‚„ *cascade08„‰‰Â *cascade08ÂÁÁË *cascade08ËÍÍÎ *cascade08ÎÓÓÔ *cascade08ÔÙÙˆ *cascade08ˆ˜˜¯ *cascade08¯˚˚¸ *cascade08¸˝˝˛ *cascade08˛ÉÉÖ *cascade08Öîîï *cascade08ïññó *cascade08óôôö *cascade08ö§§• *cascade08•ßß® *cascade08®™™¨ *cascade08¨ØØ∞ *cascade08∞¥¥∂ *cascade08∂øø¡ *cascade08¡««» *cascade08»ÀÀÃ *cascade08Ãœœ– *cascade08–““” *cascade08”‘‘’ *cascade08’‡‡‚ *cascade08‚‰‰Â *cascade08ÂÍÍÎ *cascade08ÎÏÏÌ *cascade08ÌÔÔˆ *cascade08ˆ˜˜¯ *cascade08¯˘˘˚ *cascade08˚ÉÉÖ *cascade08Öááà *cascade08àââä *cascade08äããç *cascade08çììñ *cascade08ñóóò *cascade08òôôö *cascade08ö°°¢ *cascade08¢®®´ *cascade08´¨¨≠ *cascade08≠ÆÆØ *cascade08Ø∞∞± *cascade08±∂∂∑ *cascade08∑ººΩ *cascade08Ωøøƒ *cascade08ƒ∆∆« *cascade08«»»… *cascade08…ÀÀÃ *cascade08ÃÕÕŒ *cascade08Œ——“ *cascade08“””‘ *cascade08‘◊◊ÿ *cascade08ÿ··Í *cascade08
ÍÌ ÌÓ *cascade08ÓÚÚÛ *cascade08ÛÙÙı *cascade08ıˆˆ¯ *cascade08¯˘˘˙ *cascade08˙¸¸˝ *cascade08˝ÄÄÅ *cascade08ÅÑÑÖ *cascade08ÖÜÜá *cascade08áååç *cascade08çííì *cascade08ìññò *cascade08ò°°¢ *cascade08
¢Õ Õœ *cascade08œ––“ *cascade08
“€ €‹ *cascade08‹ááà *cascade08àΩΩø *cascade08øîîï *cascade08ïËËÈ *cascade08È††° *cascade08
°Ë ËÈ *cascade08ÈÌÌ˝ *cascade08˝ˇˇÄ *cascade08ÄÇÇÑ *cascade08ÑÜÜî *cascade08
îô ôö *cascade08ö††§ *cascade08§®®¨ *cascade08¨∑∑∏ *cascade08∏∫∫ª *cascade08ªººΩ *cascade08Ω¿¿¡ *cascade08¡ƒƒ≈ *cascade08≈ÃÃŒ *cascade08Œ––— *cascade08—““” *cascade08”‘‘÷ *cascade08÷€€‹ *cascade08‹››ﬂ *cascade08ﬂ‚‚„ *cascade08„ÊÊÈ *cascade08ÈÌÌÅ *cascade08ÅÖÖá *cascade08áààâ *cascade08âããå *cascade08åççé *cascade08éííì *cascade08ìòòö *cascade08öõõú *cascade08ú¶¶® *cascade08®©©™ *cascade08™∞∞∂ *cascade08
∂À ÀÃ *cascade08Ã––’ *cascade08’ÿÿ⁄ *cascade08⁄··„ *cascade08„ÊÊÁ *cascade08ÁÈÈÏ *cascade08ÏÔÔÒ *cascade08ÒÙÙˆ *cascade08ˆ˙˙Ñ *cascade08ÑÖÖé *cascade08éîîï *cascade08ïññõ *cascade08õûû† *cascade08†¶¶ß *cascade08ß®®© *cascade08©∞∞± *cascade08
±¡ ¡∆ *cascade08∆  ‘ *cascade08‘ÿÿŸ *cascade08Ÿ€€‹ *cascade08‹ﬁﬁﬂ *cascade08ﬂ‚‚„ *cascade08„ÊÊË *cascade08ËÓÓÔ *cascade08ÔÙÙı *cascade08ı˜˜¯ *cascade08¯ÅÅÉ *cascade08Éááã *cascade08ãèèõ *cascade08õüü° *cascade08°££• *cascade08•ßß® *cascade08®©©™ *cascade08™´´¨ *cascade08¨ÆÆØ *cascade08Ø∞∞± *cascade08±µµ∑ *cascade08∑∆∆« *cascade08«  Ã *cascade08Ã––Ÿ *cascade08Ÿ‹‹‰ *cascade08‰ÂÂÊ *cascade08ÊÁÁË *cascade08ËÍÍÎ *cascade08ÎÌÌÓ *cascade08ÓÔÔ *cascade08ÙÙı *cascade08ı˘˘˙ *cascade08˙˛˛ˇ *cascade08ˇÖÖÜ *cascade08Üèè¢ *cascade08
¢™ ™¨ *cascade08¨≠≠Ø *cascade08Ø≤≤≥ *cascade08≥ªªΩ *cascade08Ω¿¿¡ *cascade08¡¬¬√ *cascade08√»»‹ *cascade08‹‡‡· *cascade08·„„Á *cascade08ÁÏÏ˜ *cascade08˜˙˙˚ *cascade08˚ˇˇÅ *cascade08ÅÉÉÑ *cascade08Ñááà *cascade08àääã *cascade08ãççé *cascade08éêêë *cascade08ëññó *cascade08óôôö *cascade08ö££§ *cascade08§ßß® *cascade08®™™´ *cascade08´ÆÆ∞ *cascade08∞≥≥∏ *cascade08∏∆∆Ã *cascade08Ã÷÷◊ *cascade08◊⁄⁄€ *cascade08€ﬂﬂ· *cascade08·ÁÁË *cascade08ËÍÍÎ *cascade08ÎÌÌÓ *cascade08ÓÔÔÒ *cascade08ÒÚÚÛ *cascade08Ûııˆ *cascade08ˆ˚˚¸ *cascade08¸ˇˇÄ *cascade08ÄÇÇÉ *cascade08ÉÜÜá *cascade08
áì ìî *cascade08îõõú *cascade08úùùü *cascade08ü∑∑√ *cascade08√««» *cascade08»ÃÃÕ *cascade08Õ––— *cascade08—ÙÙı *cascade08
ıÇ ÇÉ *cascade08ÉÜÜá *cascade08áêêë *cascade08ëììî *cascade08îññó *cascade08óööõ *cascade08õ¢¢• *cascade08•ππ  *cascade08 ’’› *cascade08›„„‰ *cascade08‰Ä Ä Å  *cascade08Å à à ã  *cascade08ã é é ó  *cascade08ó õ õ ß  *cascade08ß Ü!Ü!á! *cascade08
á!ä$ ä$ã$ *cascade08
ã$Å. Å.Ç. *cascade08
Ç.ù. ù.°. *cascade08°.±.±.Õ. *cascade08Õ.Œ.Œ.œ. *cascade08œ.–.–.—. *cascade08—.”.”.‘. *cascade08‘.’.’.÷. *cascade08÷.◊.◊.ÿ. *cascade08ÿ.Ÿ.Ÿ.⁄. *cascade08⁄.€.€.‹. *cascade08‹.›.›.‡. *cascade08‡.‰.‰.¯. *cascade08¯.Ñ/Ñ/Ö/ *cascade08Ö/á/á/à/ *cascade08à/å/å/ç/ *cascade08
ç/ú/ ú/û/ *cascade08û/¶/¶/∫/ *cascade08
∫/⁄X ⁄XòY *cascade08òY°Y°YÎ\ *cascade08	Î\ùôùô√ô *cascade08
√ôƒôƒô⁄ô *cascade08
⁄ôª°ª°É¢ *cascade08É¢›∆ 2Wfile:///c:/xampp/htdocs/elgalpon/wp-content/themes/galpon-theme/page-25-aniversario.php