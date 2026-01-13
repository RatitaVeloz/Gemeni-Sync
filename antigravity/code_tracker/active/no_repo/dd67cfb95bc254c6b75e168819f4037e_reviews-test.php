ÙT<?php
// TEMPORAL: Shortcode de prueba que usa SQL directa
function ocean_reviews_grid_test_shortcode($atts)
{
    global $wpdb, $post;

    // Get post ID
    $post_id = 0;
    if ($post && isset($post->ID)) {
        $post_id = $post->ID;
    }
    if (!$post_id) {
        $post_id = get_queried_object_id();
    }
    $atts = shortcode_atts(array('post_id' => 0), $atts);
    if (!$post_id && $atts['post_id']) {
        $post_id = intval($atts['post_id']);
    }

    if (!$post_id) {
        return '<!-- No post ID -->';
    }

    // CONSULTA SQL DIRECTA
    $comments = $wpdb->get_results($wpdb->prepare(
        "SELECT c.*, cm.meta_value as rating
        FROM {$wpdb->comments} c
        LEFT JOIN {$wpdb->commentmeta} cm ON c.comment_ID = cm.comment_id AND cm.meta_key = 'rating'
        WHERE c.comment_post_ID = %d AND c.comment_approved = '1' AND c.comment_type = 'comment'
        ORDER BY c.comment_date DESC",
        $post_id
    ));

    if (empty($comments)) {
        return '<!-- No reviews found for post ' . $post_id . ' -->';
    }

    $chunks = array_chunk($comments, 4);
    $arrow_left = 'https://staging.oprealty.biz/wp-content/uploads/flecha-izquierda.svg';
    $arrow_right = 'https://staging.oprealty.biz/wp-content/uploads/flecha-1.svg';

    ob_start();
?>
    <div class="ocean-reviews-section">
        <div class="ocean-reviews-slider-wrapper">
            <?php if (count($chunks) > 1): ?>
                <button class="ocean-reviews-arrow prev" title="Anterior">
                    <img src="<?php echo esc_url($arrow_left); ?>" alt="Anterior">
                </button>
            <?php endif; ?>

            <div class="ocean-reviews-track">
                <?php foreach ($chunks as $index => $chunk): ?>
                    <div class="ocean-reviews-slide">
                        <?php foreach ($chunk as $comment):
                            $rating = $comment->rating ? intval($comment->rating) : 5;
                            $author = $comment->comment_author;
                            $content = $comment->comment_content;
                        ?>
                            <div class="ocean-review-card">
                                <div class="ocean-review-header">
                                    <div class="ocean-review-stars">
                                        <?php for ($i = 0; $i < 5; $i++):
                                            $fill = ($i < $rating) ? '#0062E6' : '#E0E0E0';
                                        ?>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.0827 3.32832C11.4124 2.50269 12.5876 2.50269 12.9173 3.32832L14.7385 7.89069C14.88 8.24522 15.223 8.4907 15.6062 8.51139L20.4682 8.77382C21.3533 8.8216 21.7143 9.92348 21.0427 10.5273L17.3308 13.8643C17.0543 14.1128 16.9427 14.4952 17.034 14.8584L18.176 19.4147C18.3853 20.2494 17.4379 20.9332 16.6698 20.4328L12.5828 17.7705C12.2384 17.5461 11.7616 17.5461 11.4172 17.7705L7.33022 20.4328C6.56208 20.9332 5.61473 20.2494 5.82397 19.4147L6.96599 14.8584C7.05731 14.4952 6.94569 14.1128 6.66923 13.8643L2.95729 10.5273C2.28574 9.92348 2.64672 8.8216 3.53178 8.77382L8.3938 8.51139C8.77696 8.4907 9.12003 8.24522 9.26154 7.89069L11.0827 3.32832Z" fill="<?php echo $fill; ?>" />
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="ocean-review-text">
                                    "<?php echo esc_html(wp_strip_all_tags($content)); ?>"
                                </div>
                                <div class="ocean-review-footer">
                                    <div class="ocean-author-name">
                                        &mdash; <?php echo esc_html($author); ?>.
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($chunks) > 1): ?>
                <button class="ocean-reviews-arrow next" title="Siguiente">
                    <img src="<?php echo esc_url($arrow_right); ?>" alt="Siguiente">
                </button>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .ocean-reviews-section {
            position: relative;
            padding: 0 60px;
        }

        .ocean-reviews-slider-wrapper {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .ocean-reviews-track {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .ocean-reviews-track::-webkit-scrollbar {
            display: none;
        }

        .ocean-reviews-slide {
            flex: 0 0 100%;
            width: 100%;
            scroll-snap-align: center;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto;
            gap: 20px;
            padding-bottom: 20px;
        }

        /* Base Styles (Default / > 1500px) */
        .ocean-review-card {
            background: #F6F6F6;
            border: 1px solid #ECECF2;
            border-radius: 16px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-sizing: border-box;
            text-align: left;
        }

        .ocean-review-text {
            font-family: 'Alexandria', sans-serif;
            font-weight: 300;
            font-size: 20px;
            line-height: 1.5;
            color: #000000;
            flex-grow: 1;
            text-align: left;
        }

        .ocean-author-name {
            font-family: 'Alexandria', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: #504E5C;
            text-align: left;
        }

        .ocean-review-stars {
            display: flex;
            gap: 4px;
        }

        .ocean-reviews-arrow {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            cursor: pointer;
            padding: 0;
            z-index: 10;
            transition: transform 0.2s;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ocean-reviews-arrow:hover,
        .ocean-reviews-arrow:focus {
            transform: translateY(-50%) scale(1.1);
            background: transparent !important;
            outline: none;
        }

        .ocean-reviews-arrow.prev {
            left: -60px;
        }

        .ocean-reviews-arrow.next {
            right: -60px;
        }

        .ocean-reviews-arrow img {
            width: 40px;
            height: 40px;
            display: block;
        }

        /* --- RESPONSIVE BREAKPOINTS --- */

        /* Laptop (1251px - 1500px) */
        @media (max-width: 1500px) {
            .ocean-review-card {
                padding: 35px;
            }
            .ocean-review-text {
                font-size: 18px;
            }
            /* Author keeps 20px as per plan/base */

            /* Adjust arrows slightly */
            .ocean-reviews-arrow.prev { left: -45px; }
            .ocean-reviews-arrow.next { right: -45px; }
            .ocean-reviews-section { padding: 0 45px; }
        }

        /* Tablet (768px - 1250px) */
        @media (max-width: 1250px) {
            .ocean-review-card {
                padding: 30px;
            }
            .ocean-review-text {
                font-size: 17px;
            }
            .ocean-author-name {
                font-size: 18px;
            }
            
            .ocean-reviews-section {
                padding: 0 40px;
            }
             .ocean-reviews-arrow.prev { left: -30px; }
             .ocean-reviews-arrow.next { right: -30px; }
        }

        /* Mobile (< 767px) */
        @media (max-width: 767px) {
             .ocean-reviews-slide {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .ocean-reviews-section {
                padding: 0;
            }

            /* Restore arrows and position them at the bottom */
            .ocean-reviews-slider-wrapper {
                padding-bottom: 60px;
            }

            .ocean-reviews-arrow {
                display: flex;
                top: auto;
                bottom: 0;
                transform: none;
            }

            .ocean-reviews-arrow:hover,
            .ocean-reviews-arrow:focus {
                transform: scale(1.1);
            }

            .ocean-reviews-arrow.prev {
                left: calc(50% - 60px);
                bottom: 10px;
            }
            .ocean-reviews-arrow.next {
                right: calc(50% - 60px);
                left: auto; /* Reset left property */
                bottom: 10px;
            }

            .ocean-review-card {
                padding: 20px;
            }

            .ocean-review-text {
                font-size: 14px;
            }
            
            .ocean-author-name {
                font-size: 14px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrappers = document.querySelectorAll('.ocean-reviews-slider-wrapper');

            wrappers.forEach(wrapper => {
                const prevBtn = wrapper.querySelector('.prev');
                const nextBtn = wrapper.querySelector('.next');
                const track = wrapper.querySelector('.ocean-reviews-track');

                if (!track || !prevBtn || !nextBtn) return;

                prevBtn.addEventListener('click', () => {
                    const w = track.offsetWidth;
                    track.scrollBy({
                        left: -w,
                        behavior: 'smooth'
                    });
                });

                nextBtn.addEventListener('click', () => {
                    const w = track.offsetWidth;
                    track.scrollBy({
                        left: w,
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('ocean_reviews_grid_test', 'ocean_reviews_grid_test_shortcode');ﬂC *cascade08ﬂCÅE*cascade08ÅE±E *cascade08±EàF*cascade08àFåF *cascade08åF√I*cascade08√I‡J *cascade08‡J·J·JΩK *cascade08ΩKæKæKÙT *cascade082Zfile:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/inc/reviews-test.php