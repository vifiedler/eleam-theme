<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eleam-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'eleam-theme' ); ?></a>

	<header class="cabecera-sitio">
	<nav class="navbar navegacion-principal container-fluid contenedor-amplio" aria-label="<?php esc_attr_e( 'Navegación principal', 'eleam-theme' ); ?>">

		<a class="navbar-brand marca-sitio" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'ELEAM San Francisco, inicio', 'eleam-theme' ); ?>">
			<img class="img-fluid"
				src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo-eleam.avif' ) ); ?>"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
				decoding="async">
		</a>

		<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-nav',
					'menu_id'        => 'primary-menu',
					'container'      => 'div',
				)
			);
			?>
	</nav>
</header>



 
  
