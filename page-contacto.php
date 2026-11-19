<?php
/**
 * Template Name: Contacto
 *
 * Diagramación de la página. El marcado y los datos SCF
 * pertenecen a los loops de cada sección.
 *
 * @package eleam-theme
 */

defined('ABSPATH') || exit;
get_header();
?>
<main id="primary" class="site-main">
    <?php while (have_posts()): the_post(); ?>
        <div id="contenido">
            <?php get_template_part('assets/modulos/modulo-contacto/loop-hero'); ?>
            <?php get_template_part('assets/modulos/modulo-contacto/loop-seccion-formulario'); ?>
            <?php get_template_part('assets/modulos/modulo-comun/loop-banner'); ?>
        </div>
    <?php endwhile; ?>
</main>
<?php get_footer();
