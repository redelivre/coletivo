<?php
/**
 * Customizer Section Sliders
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Section: Your Slider
 */
$wp_customize->add_panel(
	'coletivo_yourslider',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_yourslider' ),
		'title'           => esc_html__( 'Section: Your Slider', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_yourslider_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_yourslider',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_yourslider_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_yourslider_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_yourslider_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_yourslider_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'yourslider', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_yourslider_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_yourslider_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

$wp_customize->add_section(
	'coletivo_yourslider_content',
	array(
		'priority'    => 6,
		'title'       => esc_html__( 'Section Content', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_yourslider',
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_yourslider_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Your Slider', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_yourslider_title',
	array(
		'label'       => esc_html__( 'Section Title', 'coletivo' ),
		'section'     => 'coletivo_yourslider_content',
		'description' => '',
	)
);

// Sub Title.
$wp_customize->add_setting(
	'coletivo_yourslider_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'See all we Do', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_yourslider_subtitle',
	array(
		'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
		'section'     => 'coletivo_yourslider_content',
		'description' => '',
	)
);

// Description.
$wp_customize->add_setting(
	'coletivo_yourslider_shortcode',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_yourslider_shortcode',
	array(
		'label'       => esc_html__( 'Slider Shortcode', 'coletivo' ),
		'section'     => 'coletivo_yourslider_content',
		'description' => __( 'In order to display a Slider install the plugin of your preference and then copy the shortcode and paste it here, the shortcode will be like this <code>[metaslider id=XXX]</code> or this <code>[brasa_slider id="123"]</code>', 'coletivo' ),
	)
);
