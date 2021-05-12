<?php
/**
 * Customizer Section Video Lightbox
 *
 * @package Coletivo
 */

namespace Coletivo;

use WP_Customize_Image_Control;
defined( 'ABSPATH' ) || exit;

/**
 * Section: Video Lightbox
 */
$wp_customize->add_panel(
	'coletivo_videolightbox',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_videolightbox' ),
		'title'           => esc_html__( 'Section: Video Lightbox', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_videolightbox_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_videolightbox',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_videolightbox_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_videolightbox_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_videolightbox_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_videolightbox_section_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_videolightbox_section_title',
	array(
		'label'       => esc_html__( 'Title section in customizer', 'coletivo' ),
		'section'     => 'coletivo_videolightbox_settings',
		'description' => esc_html__( 'This title is only showed in customizer', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_videolightbox_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => 'videolightbox',
	)
);

$wp_customize->add_control(
	'coletivo_videolightbox_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_videolightbox_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_videolightbox_title',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new EditorCustomControl(
		$wp_customize,
		'coletivo_videolightbox_title',
		array(
			'label'       => esc_html__( 'Section heading', 'coletivo' ),
			'section'     => 'coletivo_videolightbox_settings',
			'description' => '',
		)
	)
);

// Video URL.
$wp_customize->add_setting(
	'coletivo_videolightbox_url',
	array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_videolightbox_url',
	array(
		'label'       => esc_html__( 'Video url', 'coletivo' ),
		'section'     => 'coletivo_videolightbox_settings',
		'description' => esc_html__( 'Paste Youtube or Vimeo url here', 'coletivo' ),
	)
);

// Parallax image.
$wp_customize->add_setting(
	'coletivo_videolightbox_image',
	array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'coletivo_videolightbox_image',
		array(
			'label'   => esc_html__( 'Background image', 'coletivo' ),
			'section' => 'coletivo_videolightbox_settings',
		)
	)
);
