<?php
/**
 * Customizer Section Team
 *
 * @package Coletivo
 */

namespace Coletivo;

defined( 'ABSPATH' ) || exit;

/**
 * Section: Team
 */
$wp_customize->add_panel(
	'coletivo_team',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_team' ),
		'title'           => esc_html__( 'Section: Team', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_team_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_team',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_team_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_team_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_team_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_team_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'team', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_team_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_team_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_team_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Our Team', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_team_title',
	array(
		'label'       => esc_html__( 'Section Title', 'coletivo' ),
		'section'     => 'coletivo_team_settings',
		'description' => '',
	)
);

// Sub Title.
$wp_customize->add_setting(
	'coletivo_team_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Section subtitle', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_team_subtitle',
	array(
		'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
		'section'     => 'coletivo_team_settings',
		'description' => '',
	)
);

// Description.
$wp_customize->add_setting(
	'coletivo_team_desc',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new EditorCustomControl(
		$wp_customize,
		'coletivo_team_desc',
		array(
			'label'       => esc_html__( 'Section Description', 'coletivo' ),
			'section'     => 'coletivo_team_settings',
			'description' => '',
		)
	)
);

// Team layout.
$wp_customize->add_setting(
	'coletivo_team_layout',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '3',
	)
);

$wp_customize->add_control(
	'coletivo_team_layout',
	array(
		'label'       => esc_html__( 'Team Layout Setting', 'coletivo' ),
		'section'     => 'coletivo_team_settings',
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
	'coletivo_team_content',
	array(
		'priority'    => 6,
		'title'       => esc_html__( 'Section Content', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_team',
	)
);

// Team member settings.
$wp_customize->add_setting(
	'coletivo_team_members',
	array(
		'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
		'transport'         => 'refresh', // refresh or postMessage.
	)
);

$wp_customize->add_control(
	new CustomizeRepeatableControl(
		$wp_customize,
		'coletivo_team_members',
		array(
			'label'        => esc_html__( 'Team members', 'coletivo' ),
			'description'  => '',
			'section'      => 'coletivo_team_content',
			'title_format' => esc_html__( '[live_title]', 'coletivo' ),
			'max_item'     => 12, // Maximum item can add.
			'limited_msg'  => esc_html__( 'Only 12 members allowed', 'coletivo' ),
			'fields'       => array(
				'user_id' => array(
					'title' => esc_html__( 'User media', 'coletivo' ),
					'type'  => 'media',
					'desc'  => '',
				),
				'link'    => array(
					'title' => esc_html__( 'Custom Link', 'coletivo' ),
					'type'  => 'text',
					'desc'  => '',
				),
			),
		)
	)
);
