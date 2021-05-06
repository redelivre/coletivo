<?php
/**
 * Customizer Site Options
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site Options
 */
$wp_customize->add_panel(
	'theme_options',
	array(
		'priority'       => 22,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Theme Options', 'coletivo' ),
		'description'    => '',
	)
);
