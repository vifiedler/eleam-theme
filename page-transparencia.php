<?php
/**
 * Template Name: Transparencia
 *
 * Página de Transparencia: exclusivamente estructura y llamadas a loops.
 * La recuperación de SCF y el marcado se mantienen en los módulos.
 *
 * @package eleam-theme
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="primary" class="site-main">
    <?php while (have_posts()): the_post(); ?>
        <div id="contenido">
            <?php get_template_part('assets/modulos/modulo-transparencia/loop-hero'); ?>
            <?php get_template_part('assets/modulos/modulo-transparencia/loop-documentacion'); ?>
            <?php get_template_part('assets/modulos/modulo-transparencia/loop-aportes'); ?>
            <?php get_template_part('assets/modulos/modulo-transparencia/loop-transferencias'); ?>
            <?php get_template_part('assets/modulos/modulo-transparencia/loop-directorio'); ?>
            <!--<?php get_template_part('assets/modulos/modulo-transparencia/loop-profesionales'); ?>-->
            <?php get_template_part('assets/modulos/modulo-transparencia/loop-banner'); ?>
        </div>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
