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
// Buscar el logo por su slug en la Biblioteca de medios de WordPress.
// En el XML actualizado figura como "logo-eleam"; evitamos depender de su ID.
$logo_adjunto = get_page_by_path( 'logo-eleam', OBJECT, 'attachment' );
$logo_id = ( $logo_adjunto instanceof WP_Post ) ? (int) $logo_adjunto->ID : 0;
if ( ! $logo_id ) {
    $logo_id = (int) get_theme_mod( 'custom_logo' );
}
$logo_html = $logo_id ? wp_get_attachment_image(
    $logo_id,
    'medium',
    false,
    array(
        'class'    => 'img-fluid',
        'alt'      => __( 'ELEAM San Francisco', 'eleam-theme' ),
        'decoding' => 'async',
        'loading'  => 'eager',
    )
) : '';
?>
<nav class="navbar navbar-expand-xl navegacion-principal container-fluid contenedor-amplio"
     aria-label="<?php esc_attr_e( 'Navegación principal', 'eleam-theme' ); ?>">
    <a class="navbar-brand marca-sitio"
       href="<?php echo esc_url( home_url( '/' ) ); ?>"
       aria-label="<?php esc_attr_e( 'ELEAM San Francisco, inicio', 'eleam-theme' ); ?>">
        <?php if ( $logo_html ) : ?>
            <?php echo $logo_html; // Imagen procedente de la biblioteca de medios. ?>
        <?php else : ?>
            <span class="marca-sitio-texto"><?php esc_html_e( 'ELEAM San Francisco', 'eleam-theme' ); ?></span>
        <?php endif; ?>
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
