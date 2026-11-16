<!-- Custom loop testimonials -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'testimonials',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>


<section class="section testimonials__v2" id="testimonials">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-5 mx-auto text-center">
                <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">
                    <?php echo get_the_excerpt(); ?>
                </span>
                <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">
                    <?php echo get_the_title(); ?>
                </h2>
                <div data-aos="fade-up" data-aos-delay="200">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="row g-4" data-masonry='{"percentPosition": true }'>
            
            <?php 
            if( have_rows('testimonios_repeater') ): 
                $i = 0;
                while( have_rows('testimonios_repeater') ) : the_row(); 
                    $texto  = get_sub_field('testimonio');
                    $foto_array = get_sub_field('foto_autor');
$foto_url = $foto_array['url'];
                    $nombre = get_sub_field('nombre_autor');
                    $cargo  = get_sub_field('cargo_autor');
                    $delay  = $i * 100;
            ?>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="testimonial rounded-4 p-4">
                    <blockquote class="mb-3">
                        &ldquo;<?php echo esc_html($texto); ?>&rdquo;
                    </blockquote>
                    <div class="testimonial-author d-flex gap-3 align-items-center">
                        <div class="author-img">
                            <img class="rounded-circle img-fluid" 
                                 src="<?php echo esc_url($foto_url); ?>" 
                                 alt="<?php echo esc_attr($nombre); ?>">
                        </div>
                        <div class="lh-base">
                            <strong class="d-block"><?php echo esc_html($nombre); ?></strong>
                            <span><?php echo esc_html($cargo); ?></span>
                        </div>
                    </div>
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