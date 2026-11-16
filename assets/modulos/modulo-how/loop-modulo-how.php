<?php
$temp = $wp_query;
$args = array(
    'post_type'      => 'how',
    'orderby'        => 'date',
    'order'          => 'ASC',
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);

if ($wp_query->have_posts()):
    while ($wp_query->have_posts()): $wp_query->the_post(); ?>

    <section class="section howitworks__v1" id="how-it-works">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6 text-center mx-auto">
                    <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">
                        <?php echo get_the_excerpt(); ?>
                    </span>
                    <h2 data-aos="fade-up" data-aos-delay="100"><?php the_title(); ?></h2>
                    <div data-aos="fade-up" data-aos-delay="200"><?php the_content(); ?></div>
                </div>
            </div>

            <div class="row g-md-5">
                <?php
                // INICIO DEL REPETIDOR
                if( have_rows('pasos_how') ):
                    $i = 0; // Contador para manejar clases y delays
                    while( have_rows('pasos_how') ) : the_row(); 
                        
                        $i++;
                        $delay_card = ($i - 1) * 600; // 0, 600, 1200, 1800...
                        $delay_line = $delay_card + 500;
                        
                        // Lógica de clases especiales
                        $class_special = '';
                        if ($i == 2) { $class_special = 'reverse'; }
                        if ($i == 4) { $class_special = 'last'; } // Opcional: podrías usar if(get_row_index() == count(get_field('pasos_how'))) para que sea siempre el último
                        
                        // Subcampos
                        $image = get_sub_field('imagen_rayita');
                        $num   = get_sub_field('numero');
                        $tt    = get_sub_field('titulo');
                        $txt   = get_sub_field('contenido');
                ?>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo $delay_card; ?>">
                    <div class="step-card <?php echo $class_special; ?> text-center h-100 d-flex flex-column justify-content-start position-relative">
                        
                        <?php if( !empty($image) ): ?>
                            <div data-aos="fade-right" data-aos-delay="<?php echo $delay_line; ?>">
                                <img class="arch-line" 
                                     src="<?php echo esc_url($image['url']); ?>" 
                                     alt="<?php echo esc_attr($image['alt']); ?>">
                            </div>
                        <?php endif; ?>

                        <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">
                            <?php echo esc_html($num); ?>
                        </span>

                        <div>
                            <h3 class="fs-5 mb-4"><?php echo esc_html($tt); ?></h3>
                            <p><?php echo esc_html($txt); ?></p>
                        </div>
                    </div>
                </div>

                <?php endwhile; endif; // FIN DEL REPETIDOR ?>
            </div>
        </div>
    </section>

    <?php endwhile;
endif;
wp_reset_query();
$wp_query = $temp;
?>