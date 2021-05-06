<?php
/**
 * Customizer Global Settings
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Global Settings
 */
$wp_customize->add_section(
	'coletivo_global_settings',
	array(
		'priority'    => 1,
		'title'       => esc_html__( 'Global', 'coletivo' ),
		'description' => '',
		'panel'       => 'theme_options',
	)
);

// Primary Color.
$wp_customize->add_setting(
	'coletivo_primary_color',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '#03c4eb',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_primary_color',
		array(
			'label'       => esc_html__( 'Primary Color', 'coletivo' ),
			'section'     => 'coletivo_global_settings',
			'description' => '',
			'priority'    => 1,
		)
	)
);

// Disable Animation.
$wp_customize->add_setting(
	'coletivo_animation_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_animation_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Disable animation effect?', 'coletivo' ),
		'section'     => 'coletivo_global_settings',
		'description' => esc_html__( 'Check this box to disable all element animation when scroll.', 'coletivo' ),
	)
);

// Header Transparent.
$wp_customize->add_setting(
	'coletivo_header_transparent',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
		'active_callback'   => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_control(
	'coletivo_header_transparent',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Header Transparent', 'coletivo' ),
		'section'     => 'coletivo_global_settings',
		'description' => esc_html__( 'Apply for front page template only.', 'coletivo' ),
	)
);
