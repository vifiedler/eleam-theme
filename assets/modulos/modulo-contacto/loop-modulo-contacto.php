<!-- Custom loop hero -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'services',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>


<section class="section services__v3" id="services">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">
                    <?php echo get_the_excerpt(); ?>
                </span>
                <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">
                    <?php echo get_the_title(); ?>
                </h2>
            </div>
        </div>

        <div class="row g-4">
            <?php 
            if( have_rows('servicios_repeater') ): 
                $i = 0;
                while( have_rows('servicios_repeater') ) : the_row(); 
                    
                    // Variables de subcampos
                    $svg    = get_sub_field('icono_svg');
                    $tt     = get_sub_field('titulo');
                    $desc   = get_sub_field('descripcion');
                    $link   = get_sub_field('enlace_boton');
                    
                    // Cálculo dinámico del delay de AOS (0, 200, 300, 400...)
                    // El primero es 0, los siguientes aumentan de 100 en 100 o como prefieras
                    $delay = ($i === 0) ? 0 : ($i + 1) * 100;
            ?>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                    <div>
                        <span class="icon mb-4">
                            <?php echo $svg; // Imprime el SVG inline ?>
                        </span>
                        <h3 class="fs-5 mb-3"><?php echo esc_html($tt); ?></h3>
                        <p class="mb-4"><?php echo esc_html($desc); ?></p>
                    </div>

                    <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" 
                       href="<?php echo esc_url($link); ?>">
                        <span class="icons">
                            <i class="icon-1 bi bi-arrow-right-short"></i>
                            <i class="icon-2 bi bi-arrow-right-short"></i>
                        </span>
                        <span>Read more</span>
                    </a>
                </div>
            </div>

            <?php 
                $i++;
                endwhile; 
            endif; 
            ?>
        </div>
    </div>
</section>









    <?php endwhile;
endif;
wp_reset_query();
$wp_query = $temp; ?>