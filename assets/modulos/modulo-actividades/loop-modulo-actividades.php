<!-- Custom loop features -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'features',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>


<section class="section features__v2" id="features">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-lg-flex p-5 rounded-4 content" data-aos="fade-in" data-aos-delay="0">
                    <div class="row">
                        <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="0">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="h-100 flex-column justify-content-between d-flex">
                                        <div>
                                            <h2 class="mb-4"><?php echo get_the_excerpt();?></h2>
                                            <p class="mb-5"><?php echo the_content();?></p>
                                        </div>
                                        <div class="align-self-start"><a data-gallery="video"
                                                class="glightbox btn btn-play d-inline-flex align-items-center gap-2"
                                                href="<?php echo esc_attr( get_field('link_boton_feature') ); ?>"><?php echo esc_html( get_field('texto_boton_feature') ); ?>
                                                <i class="bi bi-play-fill"></i></a>

                                                

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="row justify-content-end">
                                <div class="col-lg-11">
                                    <div class="row">
                                        <div class="col-sm-6" data-aos="fade-up" data-aos-delay="0">
                                            <div class="icon text-center mb-4"><i class="bi bi-person-check fs-4"></i>
                                            </div>
                                            <h3 class="fs-6 fw-bold mb-3"><?php echo esc_html( get_field('titulo_uno_feature') ); ?></h3>
                                            <p><?php echo esc_html( get_field('texto_uno_feature') ); ?></p>
                                        </div>
                                        <div class="col-sm-6" data-aos="fade-up" data-aos-delay="100">
                                            <div class="icon text-center mb-4"><i class="bi bi-graph-up fs-4"></i></div>
                                            <h3 class="fs-6 fw-bold mb-3"><?php echo esc_html( get_field('titulo_dos_feature') ); ?></h3>
                                            <p><?php echo esc_html( get_field('texto_dos_feature') ); ?></p>
                                        </div>
                                        <div class="col-sm-6" data-aos="fade-up" data-aos-delay="200">
                                            <div class="icon text-center mb-4"><i class="bi bi-headset fs-4"></i></div>
                                            <h3 class="fs-6 fw-bold mb-3"><?php echo esc_html( get_field('titulo_tres_feature') ); ?></h3>
                                            <p><?php echo esc_html( get_field('texto_tres_feature') ); ?></p>
                                        </div>
                                        <div class="col-sm-6" data-aos="fade-up" data-aos-delay="300">
                                            <div class="icon text-center mb-4"><i class="bi bi-shield-lock fs-4"></i>
                                            </div>
                                            <h3 class="fs-6 fw-bold mb-3"><?php echo esc_html( get_field('titulo_cuatro_feature') ); ?></h3>
                                            <p><?php echo esc_html( get_field('texto_cuatro_feature') ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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