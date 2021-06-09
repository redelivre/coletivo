<?php
/**
 * Customizer Footer
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer
 */
$wp_customize->add_section(
	'coletivo_footer_settings',
	array(
		'priority'    => 10,
		'title'       => esc_html__( 'Footer', 'coletivo' ),
		'description' => '',
		'panel'       => 'theme_options',
	)
);

// Footer custom Text.
$wp_customize->add_setting(
	'coletivo_footer_text',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Few Rights Reserved', 'coletivo' ),
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	'coletivo_footer_text',
	array(
		'type'        => 'text',
		'label'       => esc_html__( 'Footer Text', 'coletivo' ),
		'section'     => 'coletivo_footer_settings',
		'description' => '',
	)
);

// Footer custom Link.
$wp_customize->add_setting(
	'coletivo_footer_text_link',
	array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( home_url( '/' ) ),
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	'coletivo_footer_text_link',
	array(
		'type'        => 'text',
		'label'       => esc_html__( 'Footer Link', 'coletivo' ),
		'section'     => 'coletivo_footer_settings',
		'description' => '',
	)
);

// Footer Info BG Color.
$wp_customize->add_setting(
	'coletivo_footer_info_bg',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '',
		'transport'            => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_footer_info_bg',
		array(
			'label'       => esc_html__( 'Footer Info Background', 'coletivo' ),
			'section'     => 'coletivo_footer_settings',
			'description' => '',
		)
	)
);

// Disable Back to top.
$wp_customize->add_setting(
	'coletivo_btt_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'coletivo_btt_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide footer back to top?', 'coletivo' ),
		'section'     => 'coletivo_footer_settings',
		'description' => esc_html__( 'Check this box to hide footer back to top button.', 'coletivo' ),
	)
);
