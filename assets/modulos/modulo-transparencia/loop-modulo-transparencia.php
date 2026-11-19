<!-- Custom loop pricing -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'pricing',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>


<section class="section pricing__v2" id="pricing">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-5 mx-auto text-center"><span class="subtitle text-uppercase mb-3" data-aos="fade-up"
                    data-aos-delay="0"><?php echo get_the_excerpt();?></span>
                <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100"><?php echo get_the_title();?></h2>
                <p data-aos="fade-up" data-aos-delay="200"><?php the_content();?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                <div class="p-5 rounded-4 price-table h-100">
                    <h3><?php echo esc_html( get_field('titulo_uno_pricing') ); ?></h3>
                    <p><?php echo esc_html( get_field('texto_uno_pricing') ); ?></p>
                    <div class="price mb-4">
                        <strong>$<?php echo esc_html( get_field('precio_uno_pricing') ); ?></strong><span><?php echo esc_html( get_field('mes_uno_pricing') ); ?></span>
                    </div>
                    <div><a class="btn"
                            href="<?php echo esc_attr( get_field('link_uno_pricing') ); ?>"><?php echo esc_html( get_field('texto_boton_uno_pricing') ); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
                <div class="p-5 rounded-4 price-table popular h-100">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="mb-3"><?php echo esc_html( get_field('titulo_dos_pricing') ); ?></h3>
                            <p><?php echo esc_html( get_field('texto_dos_pricing') ); ?></p>
                            <div class="price mb-4"><strong
                                    class="me-1">$<?php echo esc_html( get_field('precio_dos_pricing') ); ?></strong><span><?php echo esc_html( get_field('mes_dos_pricing') ); ?></span>
                            </div>
                            <div><a class="btn btn-white hover-outline"
                                    href="<?php echo esc_attr( get_field('link_dos_pricing') ); ?>"><?php echo esc_html( get_field('texto_boton_dos_pricing') ); ?></a>
                            </div>
                        </div>
                        <div class="col-md-6 pricing-features">
                            <h4 class="text-uppercase fw-bold mb-3"><?php echo esc_html( get_field('texto_repeater_pricing') ); ?></h4>
                            <ul class="list-unstyled d-flex flex-column gap-3">
                                <?php

                            // Check rows exists.
                            if( have_rows('caja_pricing') ):

                                // Loop through rows.
                                while( have_rows('caja_pricing') ) : the_row();

                                    // Load sub field value.
                                    
                                    // Do something, but make sure you escape the value if outputting directly...

                                    ?>
                                <li class="d-flex gap-2 align-items-start mb-0"><span
                                        class="icon rounded-circle position-relative mt-1"><i
                                            class="bi bi-check"></i></span><span><?php echo esc_html( get_sub_field('texto_caja_pricing'));?></span>
                                </li><?php
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
            </div>
        </div>
    </div>
</section>









<?php endwhile;
endif;
wp_reset_query();
$wp_query = $temp; ?>