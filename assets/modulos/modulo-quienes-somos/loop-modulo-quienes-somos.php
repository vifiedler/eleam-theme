<!-- Custom loop hero -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'hero',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>


        <section class="hero__v6 section" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="row">
                            <div class="col-lg-11"><span class="hero-subtitle text-uppercase" data-aos="fade-up"
                                    data-aos-delay="0"><?php echo get_the_excerpt(); ?></span>
                                <h1 class="hero-title mb-3" data-aos="fade-up" data-aos-delay="100">
                                    <?php echo get_the_title(); ?>
                                </h1>
                                <p class="hero-description mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="200">
                                    <?php the_content(); ?>
                                </p>
                                <div class="cta d-flex gap-2 mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="300"><a
                                        class="btn"
                                        href="<?php echo esc_html(get_field('link_boton_uno_hero')); ?>"><?php echo esc_html(get_field('boton_uno_hero')); ?></a><a
                                        class="btn btn-white-outline"
                                        href="<?php echo esc_html(get_field('link_boton_dos_hero')); ?>"><?php echo esc_html(get_field('boton_dos_hero')); ?>
                                        <i class="bi bi-arrow-up-right"></i></a></div>
                                <div class="logos mb-4" data-aos="fade-up" data-aos-delay="400"><span
                                        class="logos-title text-uppercase mb-4 d-block"><?php echo esc_html(get_field('texto_logo_hero')); ?></span>
                                    <div class="logos-images d-flex gap-4 align-items-center">
                                        <?php

                                        // Check rows exists.
                                        if (have_rows('logos_hero')):

                                            // Loop through rows.
                                            while (have_rows('logos_hero')):
                                                the_row();

                                                // Load sub field value.
                                                $image = get_sub_field('imagen_logo');
                                                echo wp_get_attachment_image($image['ID'], 'full');
                                                // Do something, but make sure you escape the value if outputting directly...
                                
                                                // End loop.
                                            endwhile;

                                            // No value.
                                        else:
                                            // Do something...
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-img">
                            <?php
                            $image = get_field('imagen_tarjeta_hero');
                            if (!empty($image)): ?>
                            <img class="img-card img-fluid" src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>" data-aos="fade-down" data-aos-delay="600">
                            
                            
                            <?php endif; ?>
                            <img class="img-main img-fluid rounded-4" src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full');?>"
                                alt="<?php echo get_the_title(); ?>" data-aos="fade-in" data-aos-delay="500">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Hero-->
        </section>









    <?php endwhile;
endif;
wp_reset_query();
$wp_query = $temp; ?>