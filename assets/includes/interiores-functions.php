<?php
/** Utilidades compartidas para los heroes de las páginas interiores. */
defined('ABSPATH') || exit;

function eleam_interior_campo($nombre, $post_id = false, $defecto = '') {
	if (!function_exists('get_field')) {
		return $defecto;
	}
	$valor = $post_id ? get_field($nombre, $post_id) : get_field($nombre);
	return ($valor === null || $valor === false || $valor === '') ? $defecto : $valor;
}

function eleam_interior_texto($nombre, $post_id = false, $defecto = '') {
	$valor = eleam_interior_campo($nombre, $post_id, $defecto);
	return is_scalar($valor) ? trim((string) $valor) : $defecto;
}

function eleam_interior_imagen($imagen, $clases = 'img-fluid hero-interior-imagen', $alt = '', $tamano = 'large', $carga = 'lazy') {
	if (function_exists('eleam_inicio_imagen')) {
		return eleam_inicio_imagen($imagen, $clases, $alt, $tamano, $carga);
	}
	return '';
}

function eleam_interior_enlace($nombre, $ruta = '/contribuye/', $rotulo = 'Contribuye') {
	$valor = eleam_interior_campo($nombre);
	$url = '';
	$titulo = $rotulo;
	$target = '_self';

	if (is_array($valor) && !empty($valor['url'])) {
		$url = (string) $valor['url'];
		$titulo = !empty($valor['title']) ? (string) $valor['title'] : $rotulo;
		$target = (!empty($valor['target']) && $valor['target'] === '_blank') ? '_blank' : '_self';
	} elseif (is_string($valor) && trim($valor) !== '') {
		$url = trim($valor);
	}

	if ($url === '') {
		$url = home_url($ruta);
	}

	return array('url' => $url, 'title' => $titulo, 'target' => $target);
}

function eleam_interior_boton($enlace) {
	if (!is_array($enlace) || empty($enlace['url']) || empty($enlace['title'])) {
		return;
	}

	$target = isset($enlace['target']) && $enlace['target'] === '_blank' ? '_blank' : '_self';
	?>
	<a class="btn boton boton-primario"
		href="<?php echo esc_url($enlace['url']); ?>"
		<?php if ($target === '_blank'): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
		<?php echo esc_html($enlace['title']); ?>
		<span class="bi bi-arrow-right" aria-hidden="true"></span>
	</a>
	<?php
}
