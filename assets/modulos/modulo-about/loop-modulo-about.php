<!-- Custom loop about -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'about',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>


<!-- ======= About =======-->
<section class="about__v4 section" id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-2">
                <div class="row justify-content-end">
                    <div class="col-md-11 mb-4 mb-md-0"><span class="subtitle text-uppercase mb-3" data-aos="fade-up"
                            data-aos-delay="0"><?php echo get_the_excerpt();?></span>
                        <h2 class="mb-4" data-aos="fade-up" data-aos-delay="100"><?php echo get_the_title();?></h2>
                        <div data-aos="fade-up" data-aos-delay="200">
                            <p><?php echo the_content();?></p>
                        </div>
                        <h4 class="small fw-bold mt-4 mb-3" data-aos="fade-up" data-aos-delay="300">
                            <?php echo esc_html( get_field('titulo_lista_about') ); ?></h4>
                        <ul class="d-flex flex-row flex-wrap list-unstyled gap-3 features" data-aos="fade-up"
                            data-aos-delay="400">
                            <?php

                            // Check rows exists.
                            if( have_rows('caja_about') ):

                                // Loop through rows.
                                while( have_rows('caja_about') ) : the_row();

                                    // Load sub field value.
                                    
                                    // Do something, but make sure you escape the value if outputting directly...

                                    ?>
                                    <li class="d-flex align-items-center gap-2">
                                        <span class="icon rounded-circle text-center"><i
                                        class="bi bi-check"></i></span>
                                        <span class="text"><?php echo esc_html( get_sub_field('texto_caja_about'));?></span></li>
                                    <?php
                                // End loop.
                                endwhile;

                            // No value.
                            else :
                                // Do something...
                            endif;?>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="img-wrap position-relative"><img class="img-fluid rounded-4"
                        src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full');?>"
                        alt="<?php echo get_the_title(); ?>" data-aos="fade-up" data-aos-delay="0">
                    <div class="mission-statement p-4 rounded-4 d-flex gap-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="mission-icon text-center rounded-circle"><i class="bi bi-lightbulb fs-4"></i></div>
                        <div>
                            <h3 class="text-uppercase fw-bold"><?php echo esc_html( get_field('titulo_statement') ); ?>
                            </h3>
                            <p class="fs-5 mb-0"><?php echo esc_html( get_field('titulo_texto_statement') ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About-->



<?php endwhile;
endif;
wp_reset_query();
$wp_query = $temp; ?>