<?php
/**
 * Template Name: inicio
 *
 * Página de Inicio: solo estructura y llamadas a los componentes.
 * Cada loop administra su propio SCF, consultas y marcado.
 *
 * @package eleam-theme
 */

defined('ABSPATH') || exit;
get_header();
?>
<main id="primary" class="site-main">
    <?php while (have_posts()): the_post(); ?>
        <div id="contenido">
            <?php get_template_part('assets/modulos/modulo-inicio/loop-hero'); ?>
            <?php get_template_part('assets/modulos/modulo-inicio/loop-nuestro-compromiso'); ?>
            <?php get_template_part('assets/modulos/modulo-inicio/loop-infraestructura'); ?>
            <?php get_template_part('assets/modulos/modulo-inicio/loop-actividades'); ?>
            <?php get_template_part('assets/modulos/modulo-inicio/loop-capellania'); ?>
            <?php get_template_part('assets/modulos/modulo-inicio/loop-contacto'); ?>
            <?php get_template_part('assets/modulos/modulo-inicio/loop-banner'); ?>
        </div>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
