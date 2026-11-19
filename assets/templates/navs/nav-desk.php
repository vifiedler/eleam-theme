<?php
/**
 * Navegación principal del ELEAM.
 * Un solo menú responsive; los <li>, <a> y <button> los genera ELEAM_Nav_Walker.
 */
$ubicaciones_menu = get_nav_menu_locations();
$menu_configuracion = array(
    'theme_location' => 'menu-nav',
    // El XML existente contiene el menú «menu-nav». Permite utilizarlo aun antes
    // de asignar explícitamente la ubicación en Apariencia > Menús.
    'menu'           => empty( $ubicaciones_menu['menu-nav'] ) ? 'menu-nav' : '',
    'container'      => false,
    'menu_id'        => 'eleam-menu-lista',
    'menu_class'     => 'navegacion-enlaces navbar-nav',
    'depth'          => 2,
    'fallback_cb'    => false,
    'walker'         => new ELEAM_Nav_Walker(),
    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'echo'           => true,
);
?>
<nav class="navbar navbar-expand-xl navegacion-principal container-fluid contenedor-amplio"
     aria-label="<?php esc_attr_e( 'Navegación principal', 'eleam-theme' ); ?>">
    <a class="navbar-brand marca-sitio"
       href="<?php echo esc_url( home_url( '/' ) ); ?>"
       aria-label="<?php esc_attr_e( 'ELEAM San Francisco, inicio', 'eleam-theme' ); ?>">
        <img class="img-fluid"
             src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo-eleam.avif' ) ); ?>"
             alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
             decoding="async">
    </a>

    <button class="navbar-toggler boton-menu-movil" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#eleam-menu-colapsable"
            aria-controls="eleam-menu-colapsable"
            aria-expanded="false"
            aria-label="<?php esc_attr_e( 'Abrir menú de navegación', 'eleam-theme' ); ?>">
        <span class="bi bi-list" aria-hidden="true"></span>
    </button>

    <div class="collapse navbar-collapse" id="eleam-menu-colapsable">
        <?php wp_nav_menu( $menu_configuracion ); ?>
    </div>
</nav>
