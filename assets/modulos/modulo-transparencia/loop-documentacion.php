<?php
/** Navegación de anclas y documentación institucional desde SCF. */
defined('ABSPATH') || exit;
$titulo = eleam_transparencia_texto('titulo_documentacion', false, 'Documentación para consultar');
$texto = eleam_transparencia_texto('contenido_area_documentacion');
$etiqueta_nav = eleam_transparencia_texto('titulo_navegacion_transparencia', false, 'Navegación de transparencia');
$documentos = eleam_transparencia_filas('elementos_documentacion');
$texto_ver = eleam_transparencia_texto('texto_ver_pdf', false, 'Ver PDF');
$texto_descargar = eleam_transparencia_texto('texto_descargar_pdf', false, 'Descargar');
?>
<section class="seccion" aria-labelledby="titulo-documentos">
    <div class="container">
        <nav class="transparencia-navegacion" aria-label="<?php echo esc_attr($etiqueta_nav); ?>">
            <a class="btn boton boton-secundario" href="#documentos">Documentación</a>
            <a class="btn boton boton-secundario" href="#aportes">Uso de aportes</a>
            <a class="btn boton boton-secundario" href="#transferencias">Transferencias</a>
            <a class="btn boton boton-secundario" href="#directorio">Directorio</a>
            <a class="btn boton boton-secundario" href="#profesionales">Equipo profesional</a>
        </nav>
        <div id="documentos" class="transparencia-bloque-documentos">
            <header class="encabezado-seccion">
                <h2 id="titulo-documentos"><?php echo esc_html($titulo); ?></h2>
                <?php if ($texto !== ''): ?><p><?php echo esc_html($texto); ?></p><?php endif; ?>
            </header>
            <?php if ($documentos): ?>
                <div class="transparencia-lista-documentos">
                    <?php foreach ($documentos as $documento):
                        $nombre = isset($documento['titulo_documento']) ? trim((string) $documento['titulo_documento']) : '';
                        $descripcion = isset($documento['descripcion_documento']) ? trim((string) $documento['descripcion_documento']) : '';
                        $url = eleam_transparencia_archivo_url(isset($documento['archivo_pdf_institucional']) ? $documento['archivo_pdf_institucional'] : null);
                        if ($nombre === '') { continue; }
                    ?>
                        <article class="documento">
                            <div class="documento-texto">
                                <h3 class="documento-titulo"><?php echo esc_html($nombre); ?></h3>
                                <?php if ($descripcion !== ''): ?><p><?php echo esc_html($descripcion); ?></p><?php endif; ?>
                            </div>
                            <?php if ($url !== ''): ?>
                                <div class="documento-acciones">
                                    <a class="btn boton boton-secundario" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php echo esc_html($texto_ver); ?> <span class="bi bi-box-arrow-up-right" aria-hidden="true"></span>
                                    </a>
                                    <a class="btn boton boton-secundario" href="<?php echo esc_url($url); ?>" download>
                                        <?php echo esc_html($texto_descargar); ?> <span class="bi bi-download" aria-hidden="true"></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="transparencia-sin-datos">Todavía no hay documentos institucionales publicados.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
