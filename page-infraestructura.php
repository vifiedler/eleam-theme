<?php
/**
 * Template Name: Infraestructura
 *
 * Esta plantilla organiza las secciones. Cada loop administra su marcado y SCF.
 *
 * @package eleam-theme
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="primary" class="site-main">
    <?php while (have_posts()): the_post(); ?>
        <div id="contenido">
            <?php get_template_part('assets/modulos/modulo-infraestructura/loop-hero'); ?>
            <?php get_template_part('assets/modulos/modulo-infraestructura/loop-galeria'); ?>
            <?php get_template_part('assets/modulos/modulo-comun/loop-banner'); ?>
        </div>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
