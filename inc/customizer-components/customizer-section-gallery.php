<?php
/**
 * Customizer Section Gallery
 *
 * @package Coletivo
 */

namespace Coletivo;

defined( 'ABSPATH' ) || exit;

/**
 * Section: Gallery
 */
$wp_customize->add_panel(
	'coletivo_gallery',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_gallery' ),
		'title'           => esc_html__( 'Section: Gallery', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_gallery_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_gallery',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_gallery_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => 1,
	)
);

$wp_customize->add_control(
	'coletivo_gallery_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_gallery_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_gallery_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'gallery', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_gallery_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_gallery_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_gallery_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Gallery', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_gallery_title',
	array(
		'label'       => esc_html__( 'Section Title', 'coletivo' ),
		'section'     => 'coletivo_gallery_settings',
		'description' => '',
	)
);

// Sub Title.
$wp_customize->add_setting(
	'coletivo_gallery_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Section subtitle', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_gallery_subtitle',
	array(
		'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
		'section'     => 'coletivo_gallery_settings',
		'description' => '',
	)
);

// Description.
$wp_customize->add_setting(
	'coletivo_gallery_desc',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new Editor_Custom_Control(
		$wp_customize,
		'coletivo_gallery_desc',
		array(
			'label'       => esc_html__( 'Section Description', 'coletivo' ),
			'section'     => 'coletivo_gallery_settings',
			'description' => '',
		)
	)
);

$wp_customize->add_section(
	'coletivo_gallery_content',
	array(
		'priority'    => 6,
		'title'       => esc_html__( 'Section Content', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_gallery',
	)
);

// Source page settings.
$wp_customize->add_setting(
	'coletivo_gallery_source_page',
	array(
		'sanitize_callback' => 'coletivo_sanitize_number',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_gallery_source_page',
	array(
		'label'       => esc_html__( 'Select Gallery Page', 'coletivo' ),
		'section'     => 'coletivo_gallery_content',
		'type'        => 'select',
		'priority'    => 10,
		'choices'     => $option_pages,
		'description' => esc_html__( 'Select a page which have content contain [gallery] shortcode.', 'coletivo' ),
	)
);

// Gallery Layout.
$wp_customize->add_setting(
	'coletivo_gallery_layout',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 'default',
	)
);

$wp_customize->add_control(
	'coletivo_gallery_layout',
	array(
		'label'    => esc_html__( 'Layout', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'type'     => 'select',
		'priority' => 40,
		'choices'  => array(
			'default'    => esc_html__( 'Default, inside container', 'coletivo' ),
			'full-width' => esc_html__( 'Full Width', 'coletivo' ),
		),
	)
);

// Gallery Display.
$wp_customize->add_setting(
	'coletivo_gallery_display',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 'default',
	)
);

$wp_customize->add_control(
	'coletivo_gallery_display',
	array(
		'label'    => esc_html__( 'Display', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'type'     => 'select',
		'priority' => 50,
		'choices'  => array(
			'grid'      => esc_html__( 'Grid', 'coletivo' ),
			'carousel'  => esc_html__( 'Carousel', 'coletivo' ),
			'slider'    => esc_html__( 'Slider', 'coletivo' ),
			'justified' => esc_html__( 'Justified', 'coletivo' ),
		),
	)
);

// Gallery grid spacing.
$wp_customize->add_setting(
	'coletivo_g_spacing',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 20,
	)
);

$wp_customize->add_control(
	'coletivo_g_spacing',
	array(
		'label'    => esc_html__( 'Item Spacing', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'priority' => 55,
	)
);

// Gallery grid spacing.
$wp_customize->add_setting(
	'coletivo_g_row_height',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 120,
	)
);

$wp_customize->add_control(
	'coletivo_g_row_height',
	array(
		'label'    => esc_html__( 'Row Height', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'priority' => 57,
	)
);

// Gallery grid gird col.
$wp_customize->add_setting(
	'coletivo_g_col',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '4',
	)
);

$wp_customize->add_control(
	'coletivo_g_col',
	array(
		'label'    => esc_html__( 'Layout columns', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'priority' => 60,
		'type'     => 'select',
		'choices'  => array(
			'1' => 1,
			'2' => 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
			'6' => 6,
		),
	)
);

// Gallery max number.
$wp_customize->add_setting(
	'coletivo_g_number',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 10,
	)
);

$wp_customize->add_control(
	'coletivo_g_number',
	array(
		'label'    => esc_html__( 'Number items', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'priority' => 65,
	)
);

// Gallery grid spacing.
$wp_customize->add_setting(
	'coletivo_g_lightbox',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => 1,
	)
);

$wp_customize->add_control(
	'coletivo_g_lightbox',
	array(
		'label'    => esc_html__( 'Enable Lightbox', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'priority' => 70,
		'type'     => 'checkbox',
	)
);

// Gallery readmore link.
$wp_customize->add_setting(
	'coletivo_g_readmore_link',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_g_readmore_link',
	array(
		'label'    => esc_html__( 'Read More Link', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'priority' => 90,
		'type'     => 'text',
	)
);

$wp_customize->add_setting(
	'coletivo_g_readmore_text',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'View More', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_g_readmore_text',
	array(
		'label'    => esc_html__( 'Read More Text', 'coletivo' ),
		'section'  => 'coletivo_gallery_content',
		'priority' => 100,
		'type'     => 'text',
	)
);
