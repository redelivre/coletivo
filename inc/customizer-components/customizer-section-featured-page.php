<?php
/**
 * Customizer Section Featured Page
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Section: Featured Page
 */
$wp_customize->add_panel(
	'coletivo_featuredpage',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_featuredpage' ),
		'title'           => esc_html__( 'Section: Page Featured', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_featuredpage_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_featuredpage',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_featuredpage_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_featuredpage_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_featuredpage_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_featuredpage_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_featuredpage_title',
	array(
		'label'       => esc_html__( 'Title section in customizer', 'coletivo' ),
		'section'     => 'coletivo_featuredpage_settings',
		'description' => esc_html__( 'This title is only showed in customizer', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_featuredpage_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'featuredpage', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_featuredpage_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_featuredpage_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

$wp_customize->add_section(
	'coletivo_featuredpage_content',
	array(
		'priority' => 6,
		'title'    => esc_html__( 'Section Content', 'coletivo' ),
		'panel'    => 'coletivo_featuredpage',
	)
);

// Select Page.
$wp_customize->add_setting(
	'coletivo_featuredpage_content',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'coletivo_featuredpage_content',
	array(
		'label'       => esc_html__( 'Featured Page', 'coletivo' ),
		'section'     => 'coletivo_featuredpage_content',
		'description' => esc_html__( 'You need to select a Featured Image for a background in full size.', 'coletivo' ),
		'type'        => 'select',
		'choices'     => $option_pages,
		'fields'      => array(
			'options' => $option_pages,
		),
	)
);

// Featured page content source.
$wp_customize->add_setting(
	'coletivo_featuredpage_content_source',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 'content',
	)
);

$wp_customize->add_control(
	'coletivo_featuredpage_content_source',
	array(
		'label'   => esc_html__( 'Content source', 'coletivo' ),
		'section' => 'coletivo_featuredpage_content',
		'type'    => 'select',
		'choices' => array(
			'content' => esc_html__( 'Full Page Content', 'coletivo' ),
			'excerpt' => esc_html__( 'Page Excerpt', 'coletivo' ),
		),
	)
);

// More Button.
$wp_customize->add_setting(
	'coletivo_featuredpage_more_text',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Discover', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_featuredpage_more_text',
	array(
		'label'       => esc_html__( 'Featured Page Button Text', 'coletivo' ),
		'section'     => 'coletivo_featuredpage_content',
		'description' => '',
	)
);

// Overlay color.
$wp_customize->add_setting(
	'coletivo_featuredpage_overlay_color',
	array(
		'sanitize_callback' => 'coletivo_sanitize_color_alpha',
		'default'           => 'rgba(0,0,0,.3)',
		'transport'         => 'refresh', // refresh or postMessage.
	)
);

$wp_customize->add_control(
	new coletivo_Alpha_Color_Control(
		$wp_customize,
		'coletivo_featuredpage_overlay_color',
		array(
			'label'    => esc_html__( 'Background Overlay Color', 'coletivo' ),
			'section'  => 'coletivo_featuredpage_content',
			'priority' => 30,
		)
	)
);
