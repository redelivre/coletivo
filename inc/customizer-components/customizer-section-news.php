<?php
/**
 * Customizer Section News
 *
 * @package Coletivo
 */

namespace Coletivo;

defined( 'ABSPATH' ) || exit;

/**
 * Section: News
 */
$wp_customize->add_panel(
	'coletivo_news',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_news' ),
		'title'           => esc_html__( 'Section: News', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_news_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_news',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_news_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_news_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_news_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_news_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'news', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_news_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_news_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_news_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Latest News', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_news_title',
	array(
		'label'       => esc_html__( 'Section Title', 'coletivo' ),
		'section'     => 'coletivo_news_settings',
		'description' => '',
	)
);

// Sub Title.
$wp_customize->add_setting(
	'coletivo_news_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Section subtitle', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_news_subtitle',
	array(
		'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
		'section'     => 'coletivo_news_settings',
		'description' => '',
	)
);

// Description.
$wp_customize->add_setting(
	'coletivo_news_desc',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new Editor_Custom_Control(
		$wp_customize,
		'coletivo_news_desc',
		array(
			'label'       => esc_html__( 'Section Description', 'coletivo' ),
			'section'     => 'coletivo_news_settings',
			'description' => '',
		)
	)
);

// hr.
$wp_customize->add_setting(
	'coletivo_news_settings_hr',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
	)
);

$wp_customize->add_control(
	new Misc_Control(
		$wp_customize,
		'coletivo_news_settings_hr',
		array(
			'section' => 'coletivo_news_settings',
			'type'    => 'hr',
		)
	)
);

// Number of post to show.
$wp_customize->add_setting(
	'coletivo_news_number',
	array(
		'sanitize_callback' => 'coletivo_sanitize_number',
		'default'           => '3',
	)
);

$wp_customize->add_control(
	'coletivo_news_number',
	array(
		'label'       => esc_html__( 'Number of post to show', 'coletivo' ),
		'section'     => 'coletivo_news_settings',
		'description' => '',
	)
);

// Blog Button.
$wp_customize->add_setting(
	'coletivo_news_more_link',
	array(
		'sanitize_callback' => 'esc_url',
		'default'           => '#',
	)
);

$wp_customize->add_control(
	'coletivo_news_more_link',
	array(
		'label'       => esc_html__( 'More News button link', 'coletivo' ),
		'section'     => 'coletivo_news_settings',
		'description' => esc_html__( 'It should be your blog page link.', 'coletivo' ),
	)
);

$wp_customize->add_setting(
	'coletivo_news_more_text',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Read Our Blog', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_news_more_text',
	array(
		'label'       => esc_html__( 'More News Button Text', 'coletivo' ),
		'section'     => 'coletivo_news_settings',
		'description' => '',
	)
);
