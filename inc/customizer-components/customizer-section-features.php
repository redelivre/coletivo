<?php
/**
 * Customizer Section Features
 *
 * @package Coletivo
 */

namespace Coletivo;

defined( 'ABSPATH' ) || exit;

/**
 * Section: Features
 */
$wp_customize->add_panel(
	'coletivo_features',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_features' ),
		'title'           => esc_html__( 'Section: Features', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_features_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_features',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_features_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_features_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_features_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_features_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'features', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_features_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_features_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_features_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Features', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_features_title',
	array(
		'label'       => esc_html__( 'Section Title', 'coletivo' ),
		'section'     => 'coletivo_features_settings',
		'description' => '',
	)
);

// Sub Title.
$wp_customize->add_setting(
	'coletivo_features_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Section subtitle', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_features_subtitle',
	array(
		'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
		'section'     => 'coletivo_features_settings',
		'description' => '',
	)
);

// Description.
$wp_customize->add_setting(
	'coletivo_features_desc',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new EditorCustomControl(
		$wp_customize,
		'coletivo_features_desc',
		array(
			'label'       => esc_html__( 'Section Description', 'coletivo' ),
			'section'     => 'coletivo_features_settings',
			'description' => '',
		)
	)
);

// Features layout.
$wp_customize->add_setting(
	'coletivo_features_layout',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '3',
	)
);

$wp_customize->add_control(
	'coletivo_features_layout',
	array(
		'label'       => esc_html__( 'Features Layout Setting', 'coletivo' ),
		'section'     => 'coletivo_features_settings',
		'description' => '',
		'type'        => 'select',
		'choices'     => array(
			'3' => esc_html__( '4 Columns', 'coletivo' ),
			'4' => esc_html__( '3 Columns', 'coletivo' ),
			'6' => esc_html__( '2 Columns', 'coletivo' ),
		),
	)
);

$wp_customize->add_section(
	'coletivo_features_content',
	array(
		'priority'    => 6,
		'title'       => esc_html__( 'Section Content', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_features',
	)
);

// Order & Styling.
$wp_customize->add_setting(
	'coletivo_features_boxes',
	array(
		'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
		'transport'         => 'refresh', // refresh or postMessage.
	)
);

$wp_customize->add_control(
	new CustomizeRepeatableControl(
		$wp_customize,
		'coletivo_features_boxes',
		array(
			'label'         => esc_html__( 'Features content', 'coletivo' ),
			'description'   => '',
			'section'       => 'coletivo_features_content',
			'live_title_id' => 'title', // apply for unput text and textarea only.
			'title_format'  => esc_html__( '[live_title]', 'coletivo' ),
			'max_item'      => 12, // Maximum item can add.
			'limited_msg'   => esc_html__( 'Only 12 features allowed', 'coletivo' ),
			'fields'        => array(
				'title'     => array(
					'title' => esc_html__( 'Title', 'coletivo' ),
					'type'  => 'text',
				),
				'icon_type' => array(
					'title'   => esc_html__( 'Custom icon', 'coletivo' ),
					'type'    => 'select',
					'options' => array(
						'icon'  => esc_html__( 'Icon', 'coletivo' ),
						'image' => esc_html__( 'image', 'coletivo' ),
					),
				),
				'icon'      => array(
					'title'    => esc_html__( 'Icon', 'coletivo' ),
					'type'     => 'icon',
					'required' => array( 'icon_type', '=', 'icon' ),
				),
				'image'     => array(
					'title'    => esc_html__( 'Image', 'coletivo' ),
					'type'     => 'media',
					'required' => array( 'icon_type', '=', 'image' ),
				),
				'desc'      => array(
					'title' => esc_html__( 'Description', 'coletivo' ),
					'type'  => 'editor',
				),
				'link'      => array(
					'title' => esc_html__( 'Custom Link', 'coletivo' ),
					'type'  => 'text',
				),
			),
		)
	)
);
