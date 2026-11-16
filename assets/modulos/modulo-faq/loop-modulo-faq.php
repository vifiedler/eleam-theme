<!-- Custom loop hero -->
<?php
$temp = $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'faq',
    'orderby' => 'date',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => 1
);
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()):
        $wp_query->the_post(); ?>

<section class="section faq__v2" id="faq">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6 col-lg-7 mx-auto text-center">
                <span class="subtitle text-uppercase mb-3"><?php echo get_the_excerpt(); ?></span>
                <h2 class="h2 fw-bold mb-3"><?php echo get_the_title(); ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="accordion custom-accordion" id="faqParent"> <?php 
                    if( have_rows('faq_repeater') ): 
                        $i = 1; // Inicializamos un contador en 1
                        while( have_rows('faq_repeater') ) : the_row(); 
                            
                            $pregunta  = get_sub_field('pregunta');
                            $respuesta = get_sub_field('respuesta');
                            
                            // Lógica para que el primero aparezca abierto y los demás cerrados
                            $clase_boton = ($i == 1) ? '' : 'collapsed';
                            $clase_cuerpo = ($i == 1) ? 'show' : '';
                            $aria_exp    = ($i == 1) ? 'true' : 'false';
                    ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php echo $clase_boton; ?>" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#item-<?php echo $i; ?>" 
                                    aria-expanded="<?php echo $aria_exp; ?>" 
                                    aria-controls="item-<?php echo $i; ?>">
                                <?php echo esc_html($pregunta); ?>
                            </button>
                        </h2>

                        <div id="item-<?php echo $i; ?>" 
                             class="accordion-collapse collapse <?php echo $clase_cuerpo; ?>" 
                             data-bs-parent="#faqParent"> <div class="accordion-body">
                                <?php echo $respuesta;?>
                            </div>
                        </div>
                    </div>

                    <?php 
                        $i++; // Suma 1 en cada vuelta
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