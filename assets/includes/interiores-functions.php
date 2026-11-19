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
