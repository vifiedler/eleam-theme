<!-- Custom loop testimonials -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'stats',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>


<section class="stats__v3 section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap content rounded-4" data-aos="fade-up" data-aos-delay="0">
                    
                    <div class="rounded-borders">
                        <div class="rounded-border-1"></div>
                        <div class="rounded-border-2"></div>
                        <div class="rounded-border-3"></div>
                    </div>

                    <?php 
                    if( have_rows('stats_section') ): 
                        $i = 1;
                        while( have_rows('stats_section') ) : the_row(); 
                            
                            $num    = get_sub_field('numero_final');
                            $sufijo = get_sub_field('sufijo');
                            $titulo = get_sub_field('titulo_stat');
                            $delay  = $i * 100;
                    ?>

                    <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="stat-item">
                            <h3 class="fs-1 fw-bold">
                                <span class="purecounter" 
                                      data-purecounter-start="0" 
                                      data-purecounter-end="<?php echo esc_attr($num); ?>" 
                                      data-purecounter-duration="2">0</span><span><?php echo esc_html($sufijo); ?></span>
                            </h3>
                            <p class="mb-0"><?php echo esc_html($titulo); ?></p>
                        </div>
                    </div>

                    <?php 
                        $i++;
                        endwhile; 
                    endif; 
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>









    <?php endwhile;
endif;
wp_reset_query();
$wp_query = $temp; ?>