<?php
/**
 * Customizer Section Portfolio
 *
 * @package Coletivo
 */

namespace Coletivo;

defined( 'ABSPATH' ) || exit;

/**
 * Section: Portfolio
 */
$wp_customize->add_panel(
	'coletivo_portfolio',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_portfolio' ),
		'title'           => esc_html__( 'Section: Portfolio', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_is_jetpack_active',
	)
);

$wp_customize->add_section(
	'coletivo_portfolio_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_portfolio',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_portfolio_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_portfolio_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_portfolio_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_portfolio_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'portfolio', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_portfolio_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_portfolio_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Number of projects to show..
$wp_customize->add_setting(
	'coletivo_portfolio_number',
	array(
		'sanitize_callback' => 'coletivo_sanitize_number',
		'default'           => '3',
	)
);

$wp_customize->add_control(
	'coletivo_portfolio_number',
	array(
		'label'       => esc_html__( 'Number of projects to show', 'coletivo' ),
		'section'     => 'coletivo_portfolio_settings',
		'description' => '',
	)
);

$wp_customize->add_section(
	'coletivo_portfolio_content',
	array(
		'priority'    => 6,
		'title'       => esc_html__( 'Section Content', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_portfolio',
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_portfolio_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Our Work', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_portfolio_title',
	array(
		'label'       => esc_html__( 'Section Title', 'coletivo' ),
		'section'     => 'coletivo_portfolio_content',
		'description' => '',
	)
);

// Sub Title.
$wp_customize->add_setting(
	'coletivo_portfolio_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Section subtitle', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_portfolio_subtitle',
	array(
		'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
		'section'     => 'coletivo_portfolio_content',
		'description' => '',
	)
);

// Description.
$wp_customize->add_setting(
	'coletivo_portfolio_desc',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new EditorCustomControl(
		$wp_customize,
		'coletivo_portfolio_desc',
		array(
			'label'       => esc_html__( 'Section Description', 'coletivo' ),
			'section'     => 'coletivo_portfolio_content',
			'description' => '',
		)
	)
);

// Portfolio Button.
$wp_customize->add_setting(
	'coletivo_portfolio_more_link',
	array(
		'sanitize_callback' => 'esc_url',
		'default'           => '#',
	)
);

$wp_customize->add_control(
	'coletivo_portfolio_more_link',
	array(
		'label'       => esc_html__( 'Portfolio Button Link', 'coletivo' ),
		'section'     => 'coletivo_portfolio_content',
		'description' => esc_html__( 'It should be your portfolio page link.', 'coletivo' ),
	)
);

$wp_customize->add_setting(
	'coletivo_portfolio_more_text',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'See Our Portfolio', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_portfolio_more_text',
	array(
		'label'       => esc_html__( 'Portfolio Button Text', 'coletivo' ),
		'section'     => 'coletivo_portfolio_content',
		'description' => '',
	)
);
