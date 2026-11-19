<?php
/** Transferencias desde SCF; CSV real disponible solo cuando existen registros. */
defined('ABSPATH') || exit;
$titulo = eleam_transparencia_texto('titulo_tabla_transferencias', false, 'Transferencias recibidas');
$texto = eleam_transparencia_texto('contenido_tabla_transparencia');
$subtitulo = eleam_transparencia_texto('subtitulo_registro_transferencias', false, 'Registro de transferencias recibidas');
$texto_descargar = eleam_transparencia_texto('texto_descargar_transferencias', false, 'Descargar registro');
$filas = eleam_transparencia_transferencias();
$total = 0;
$hay_montos = false;
foreach ($filas as $fila) {
    if (isset($fila['monto_transferencia']) && is_numeric($fila['monto_transferencia'])) {
        $total += (float) $fila['monto_transferencia'];
        $hay_montos = true;
    }
}
?>
<section id="transferencias" class="seccion" aria-labelledby="titulo-transferencias">
    <div class="container">
        <header class="encabezado-seccion">
            <h2 id="titulo-transferencias"><?php echo esc_html($titulo); ?></h2>
            <?php if ($texto !== ''): ?><p><?php echo esc_html($texto); ?></p><?php endif; ?>
        </header>
        <div class="table-responsive">
            <table class="tabla-transferencias">
                <caption class="visually-hidden"><?php echo esc_html($subtitulo); ?></caption>
                <thead>
                    <tr>
                        <th scope="col">Código Proyecto</th>
                        <th scope="col">Programa</th>
                        <th scope="col">N.º Transferencia</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Monto Transferencia</th>
                        <th scope="col">Período</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($filas): ?>
                        <?php foreach ($filas as $fila): ?>
                            <tr>
                                <td><?php echo esc_html(isset($fila['codigo_proyecto_transferencia']) ? $fila['codigo_proyecto_transferencia'] : ''); ?></td>
                                <td><?php echo esc_html(isset($fila['programa_transferencia']) ? $fila['programa_transferencia'] : ''); ?></td>
                                <td><?php echo esc_html(isset($fila['numero_transferencia']) ? $fila['numero_transferencia'] : ''); ?></td>
                                <td><?php echo esc_html(eleam_transparencia_fecha(isset($fila['fecha_transferencia']) ? $fila['fecha_transferencia'] : '')); ?></td>
                                <td><?php echo esc_html(eleam_transparencia_monto(isset($fila['monto_transferencia']) ? $fila['monto_transferencia'] : '')); ?></td>
                                <td><?php echo esc_html(isset($fila['periodo_transferencia']) ? $fila['periodo_transferencia'] : ''); ?></td>
                                <td><?php echo esc_html(isset($fila['estado_transferencia']) ? $fila['estado_transferencia'] : ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="transparencia-tabla-vacia">Todavía no hay transferencias registradas para consultar.</td></tr>
                    <?php endif; ?>
                </tbody>
                <?php if ($filas && $hay_montos): ?>
                    <tfoot>
                        <tr><th scope="row" colspan="4">Total de montos registrados</th><td><?php echo esc_html('$' . number_format($total, 0, ',', '.')); ?></td><td colspan="2"></td></tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
        <?php if ($filas): ?>
            <a class="btn boton boton-secundario transparencia-descarga"
                href="<?php echo esc_url(add_query_arg(array('action' => 'eleam_transparencia_csv', 'pagina' => get_the_ID()), admin_url('admin-post.php'))); ?>">
                <?php echo esc_html($texto_descargar); ?> <span class="bi bi-download" aria-hidden="true"></span>
            </a>
        <?php endif; ?>
    </div>
</section>
