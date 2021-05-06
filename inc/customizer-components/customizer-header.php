<?php
/**
 * Customizer Header
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Header
 */
$wp_customize->add_section(
	'coletivo_header_settings',
	array(
		'priority'    => 5,
		'title'       => esc_html__( 'Header', 'coletivo' ),
		'description' => '',
		'panel'       => 'theme_options',
	)
);

// Hidden field to reorder home sections.
$wp_customize->add_setting(
	'coletivo_sections_order',
	array(
		'default' => apply_filters( 'coletivo_sections_order_default_value', 'hero,features,yourslider,featuredpage,services,portfolio,videolightbox,gallery,team,news,contact,social' ),
	)
);

$wp_customize->add_control(
	'coletivo_sections_order',
	array(
		'type'    => 'hidden',
		'section' => 'coletivo_header_settings',
	)
);

// Header BG Color.
$wp_customize->add_setting(
	'coletivo_header_bg_color',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_header_bg_color',
		array(
			'label'       => esc_html__( 'Background Color', 'coletivo' ),
			'section'     => 'coletivo_header_settings',
			'description' => '',
		)
	)
);

// Site Title Color.
$wp_customize->add_setting(
	'coletivo_logo_text_color',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_logo_text_color',
		array(
			'label'       => esc_html__( 'Site Title Color', 'coletivo' ),
			'section'     => 'coletivo_header_settings',
			'description' => esc_html__( 'Only set if you don\'t use an image logo.', 'coletivo' ),
		)
	)
);

// Header Menu Color.
$wp_customize->add_setting(
	'coletivo_menu_color',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_menu_color',
		array(
			'label'       => esc_html__( 'Menu Link Color', 'coletivo' ),
			'section'     => 'coletivo_header_settings',
			'description' => '',
		)
	)
);

// Header Menu Hover Color.
$wp_customize->add_setting(
	'coletivo_menu_hover_color',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_menu_hover_color',
		array(
			'label'       => esc_html__( 'Menu Link Hover/Active Color', 'coletivo' ),
			'section'     => 'coletivo_header_settings',
			'description' => '',
		)
	)
);

// Header Menu Hover BG Color.
$wp_customize->add_setting(
	'coletivo_menu_hover_bg_color',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_menu_hover_bg_color',
		array(
			'label'       => esc_html__( 'Menu Link Hover/Active BG Color', 'coletivo' ),
			'section'     => 'coletivo_header_settings',
			'description' => '',
		)
	)
);

// Reponsive Mobile button color.
$wp_customize->add_setting(
	'coletivo_menu_toggle_button_color',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_menu_toggle_button_color',
		array(
			'label'       => esc_html__( 'Responsive Menu Button Color', 'coletivo' ),
			'section'     => 'coletivo_header_settings',
			'description' => '',
		)
	)
);

// Vertical align menu.
$wp_customize->add_setting(
	'coletivo_vertical_align_menu',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_vertical_align_menu',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Center vertical align for menu', 'coletivo' ),
		'section'     => 'coletivo_header_settings',
		'description' => esc_html__( 'If you use logo and your logo is too tall, check this box to auto vertical align menu.', 'coletivo' ),
	)
);

// Disable Sticky Header.
$wp_customize->add_setting(
	'coletivo_sticky_header_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_sticky_header_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Disable Sticky Header?', 'coletivo' ),
		'section'     => 'coletivo_header_settings',
		'description' => esc_html__( 'Check this box to disable sticky header when scroll.', 'coletivo' ),
	)
);
