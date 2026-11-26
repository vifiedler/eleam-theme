<?php
$info_sitio = [
    'direccion'         => 'Los Libertadores 234, El Monte. Región Metropolitana',
    'telefono'          => 'por confirmar', 
    'correo'            => 'por confirmar', 
    'resolucion_seremi' => '[N.º y fecha por confirmar]',
    'folio_senama'      => '[Folio por confirmar]',
    'respaldo'          => 'Fundación Cáritas Melipilla',
    'anio_actual'       => date('Y')
];

$menu_footer = [
    'contacto.php'      => 'Contacto',
    'capellania.php'    => 'Capellanía',
    'nosotros.php'      => 'Nosotros',
    'transparencia.php' => 'Transparencia',
    'actividades.php'   => 'Actividades'
];

$pagina_actual = basename($_SERVER['PHP_SELF']);
?>

<footer class="pie-sitio">
    <div class="container-fluid contenedor-amplio">
        <div class="pie-sitio-rejilla">
            <a href="index.php" aria-label="ELEAM San Francisco, inicio">
                <img src="assets/images/logo-eleam.avif"
                     alt="ELEAM San Francisco de El Monte · Cáritas Melipilla"
                     class="img-fluid"
                     loading="lazy"
                     decoding="async">
            </a>

            <div>
                <h2>Ubicación</h2>
                <address><?= htmlspecialchars($info_sitio['direccion']) ?></address>
                <h3>Teléfono</h3>
                <div class="pila-contenido">
                    <p>
                        Teléfono: 
                        <?php if ($info_sitio['telefono'] !== 'por confirmar'): ?>
                            <a href="tel:<?= preg_replace('/[^0-9+]/', '', $info_sitio['telefono']) ?>">
                                <?= htmlspecialchars($info_sitio['telefono']) ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($info_sitio['telefono']) ?>
                        <?php endif; ?>
                    </p>
                    <p>
                        Correo: 
                        <?php if ($info_sitio['correo'] !== 'por confirmar'): ?>
                            <a href="mailto:<?= htmlspecialchars($info_sitio['correo']) ?>">
                                <?= htmlspecialchars($info_sitio['correo']) ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($info_sitio['correo']) ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <nav class="pie-sitio-navegacion" aria-label="Navegación del pie">
                <h2>Navegación</h2>
                <ul>
                    <?php foreach ($menu_footer as $url => $titulo): ?>
                        <li>
                            <a href="<?= htmlspecialchars($url) ?>"<?= $pagina_actual === $url ? ' aria-current="page"' : '' ?>>
                                <?= htmlspecialchars($titulo) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <div>
                <h2>Marco legal y calidad</h2>
                <div class="pie-sitio-legal">
                    <p>Resolución sanitaria SEREMI de Salud<span><?= htmlspecialchars($info_sitio['resolucion_seremi']) ?></span></p>
                    <p>Registro Nacional ELEAM · SENAMA<span><?= htmlspecialchars($info_sitio['folio_senama']) ?></span></p>
                    <p class="texto-secundario">Respaldo institucional: <?= htmlspecialchars($info_sitio['respaldo']) ?>.</p>
                    <a href="transparencia.php">Ver informes y balances <span class="bi bi-arrow-right" aria-hidden="true"></span></a>
                </div>
            </div>
        </div>

        <p class="pie-sitio-creditos">&copy; <?= $info_sitio['anio_actual'] ?> Diseñado por Adaby · Todos los derechos reservados.</p>
    </div>
</footer>