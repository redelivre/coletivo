<?php
/**
 * Customizer Section Hero
 *
 * @package Coletivo
 */

namespace Coletivo;

defined( 'ABSPATH' ) || exit;

/**
 * Section: Hero
 */
$wp_customize->add_panel(
	'coletivo_hero_panel',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_hero_panel' ),
		'title'           => esc_html__( 'Section: Hero', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

// Hero settings.
$wp_customize->add_section(
	'coletivo_hero_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Hero Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_hero_panel',
	)
);

// Show section.
$wp_customize->add_setting(
	'coletivo_hero_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_hero_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_hero_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_hero_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_hero_title',
	array(
		'label'       => esc_html__( 'Title section in customizer', 'coletivo' ),
		'section'     => 'coletivo_hero_settings',
		'description' => esc_html__( 'This title is only showed in customizer', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_hero_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'hero', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_hero_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_hero_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Show hero full screen.
$wp_customize->add_setting(
	'coletivo_hero_fullscreen',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_hero_fullscreen',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Make hero section full screen', 'coletivo' ),
		'section'     => 'coletivo_hero_settings',
		'description' => esc_html__( 'Check this box to make hero section full screen.', 'coletivo' ),
	)
);

// Hero content padding top.
$wp_customize->add_setting(
	'coletivo_hero_pdtop',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( '10', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_hero_pdtop',
	array(
		'label'           => esc_html__( 'Padding Top:', 'coletivo' ),
		'section'         => 'coletivo_hero_settings',
		'description'     => esc_html__( 'The hero content padding top in percent (%).', 'coletivo' ),
		'active_callback' => 'coletivo_hero_fullscreen_callback',
	)
);

// Hero content padding bottom.
$wp_customize->add_setting(
	'coletivo_hero_pdbotom',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( '10', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_hero_pdbotom',
	array(
		'label'           => esc_html__( 'Padding Bottom:', 'coletivo' ),
		'section'         => 'coletivo_hero_settings',
		'description'     => esc_html__( 'The hero content padding bottom in percent (%).', 'coletivo' ),
		'active_callback' => 'coletivo_hero_fullscreen_callback',
	)
);

$wp_customize->add_section(
	'coletivo_hero_images',
	array(
		'priority'    => 6,
		'title'       => esc_html__( 'Hero Background Media', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_hero_panel',
	)
);

$wp_customize->add_setting(
	'coletivo_hero_images',
	array(
		'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
		'transport'         => 'refresh', // refresh or postMessage.
		'default'           => wp_json_encode(
			array(
				array(
					'image' => array(
						'url' => get_template_directory_uri() . '/assets/images/coletivo1.jpg',
						'id'  => '',
					),
				),
			),
		),
	)
);

$wp_customize->add_control(
	new Customize_Repeatable_Control(
		$wp_customize,
		'coletivo_hero_images',
		array(
			'label'        => esc_html__( 'Background Images', 'coletivo' ),
			'description'  => '',
			'priority'     => 40,
			'section'      => 'coletivo_hero_images',
			'title_format' => esc_html__( 'Background', 'coletivo' ),
			'max_item'     => 5, // Maximum item can add.
			'fields'       => array(
				'image' => array(
					'title'   => esc_html__( 'Background Image', 'coletivo' ),
					'type'    => 'media',
					'default' => array(
						'url' => get_template_directory_uri() . '/assets/images/coletivo1.jpg',
						'id'  => '',
					),
				),
			),
		)
	)
);

// Overlay color.
$wp_customize->add_setting(
	'coletivo_hero_overlay_color',
	array(
		'sanitize_callback' => 'coletivo_sanitize_color_alpha',
		'default'           => 'rgba(0,0,0,.3)',
		'transport'         => 'refresh', // refresh or postMessage.
	)
);

$wp_customize->add_control(
	new Alpha_Color_Control(
		$wp_customize,
		'coletivo_hero_overlay_color',
		array(
			'label'    => esc_html__( 'Background Overlay Color', 'coletivo' ),
			'section'  => 'coletivo_hero_images',
			'priority' => 130,
		)
	)
);

// Parallax.
$wp_customize->add_setting(
	'coletivo_hero_parallax',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => 0,
		'transport'         => 'refresh', // refresh or postMessage.
	)
);

$wp_customize->add_control(
	'coletivo_hero_parallax',
	array(
		'label'       => esc_html__( 'Enable parallax effect (apply for first BG image only)', 'coletivo' ),
		'section'     => 'coletivo_hero_images',
		'type'        => 'checkbox',
		'priority'    => 50,
		'description' => '',
	)
);

$wp_customize->add_section(
	'coletivo_hero_content_layout1',
	array(
		'priority'    => 9,
		'title'       => esc_html__( 'Hero Content Layout', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_hero_panel',
	)
);

// Hero Layout.
$wp_customize->add_setting(
	'coletivo_hero_layout',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '1',
	)
);

$wp_customize->add_control(
	'coletivo_hero_layout',
	array(
		'label'       => esc_html__( 'Display Layout', 'coletivo' ),
		'section'     => 'coletivo_hero_content_layout1',
		'description' => '',
		'type'        => 'select',
		'choices'     => array(
			'1' => esc_html__( 'Layout 1', 'coletivo' ),
			'2' => esc_html__( 'Layout 2', 'coletivo' ),
		),
	)
);

// For Hero layout.
// Large Text.
$wp_customize->add_setting(
	'coletivo_hcl1_largetext',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'mod'               => 'html',
		'default'           => __( 'We are <span class="js-rotating">coletivo | One Page | Responsive | Perfection</span>', 'coletivo' ),
	)
);

$wp_customize->add_control(
	new Editor_Custom_Control(
		$wp_customize,
		'coletivo_hcl1_largetext',
		array(
			'label'       => esc_html__( 'Large Text', 'coletivo' ),
			'section'     => 'coletivo_hero_content_layout1',
			'description' => esc_html__( 'Text Rotating Guide: Put your rotate texts separate by "|" into <span class="js-rotating">...</span>, go to Customizer->Site Option->Animate to control rotate animation.', 'coletivo' ),
		)
	)
);

// Small Text.
$wp_customize->add_setting(
	'coletivo_hcl1_smalltext',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => __( 'Morbi tempus porta nunc <strong>pharetra quisque</strong> ligula imperdiet posuere<br> vitae felis proin sagittis leo ac tellus blandit sollicitudin quisque vitae placerat.', 'coletivo' ),
	)
);

$wp_customize->add_control(
	new Editor_Custom_Control(
		$wp_customize,
		'coletivo_hcl1_smalltext',
		array(
			'label'       => esc_html__( 'Small Text', 'coletivo' ),
			'section'     => 'coletivo_hero_content_layout1',
			'mod'         => 'html',
			'description' => esc_html__( 'You can use text rotate slider in this textarea too.', 'coletivo' ),
		)
	)
);

// Button #1 Text.
$wp_customize->add_setting(
	'coletivo_hcl1_btn1_text',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'About Us', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_hcl1_btn1_text',
	array(
		'label'   => esc_html__( 'Button #1 Text', 'coletivo' ),
		'section' => 'coletivo_hero_content_layout1',
	)
);

// Button #1 Link.
$wp_customize->add_setting(
	'coletivo_hcl1_btn1_link',
	array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( home_url( '/' ) ) . esc_html__( '#about', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_hcl1_btn1_link',
	array(
		'label'   => esc_html__( 'Button #1 Link', 'coletivo' ),
		'section' => 'coletivo_hero_content_layout1',
	)
);

// Button #1 Style.
$wp_customize->add_setting(
	'coletivo_hcl1_btn1_style',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => 'btn-theme-primary',
	)
);

$wp_customize->add_control(
	'coletivo_hcl1_btn1_style',
	array(
		'label'   => esc_html__( 'Button #1 style', 'coletivo' ),
		'section' => 'coletivo_hero_content_layout1',
		'type'    => 'select',
		'choices' => array(
			'btn-theme-primary'     => esc_html__( 'Button Primary', 'coletivo' ),
			'btn-secondary-outline' => esc_html__( 'Button Secondary', 'coletivo' ),
			'btn-default'           => esc_html__( 'Button', 'coletivo' ),
			'btn-primary'           => esc_html__( 'Primary', 'coletivo' ),
			'btn-success'           => esc_html__( 'Success', 'coletivo' ),
			'btn-info'              => esc_html__( 'Info', 'coletivo' ),
			'btn-warning'           => esc_html__( 'Warning', 'coletivo' ),
			'btn-danger'            => esc_html__( 'Danger', 'coletivo' ),
		),
	)
);

// Button #2 Text.
$wp_customize->add_setting(
	'coletivo_hcl1_btn2_text',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'Get Started', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_hcl1_btn2_text',
	array(
		'label'   => esc_html__( 'Button #2 Text', 'coletivo' ),
		'section' => 'coletivo_hero_content_layout1',
	)
);

// Button #2 Link.
$wp_customize->add_setting(
	'coletivo_hcl1_btn2_link',
	array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( home_url( '/' ) ) . esc_html__( '#contact', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_hcl1_btn2_link',
	array(
		'label'   => esc_html__( 'Button #2 Link', 'coletivo' ),
		'section' => 'coletivo_hero_content_layout1',
	)
);

// Button #2 Style.
$wp_customize->add_setting(
	'coletivo_hcl1_btn2_style',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => 'btn-secondary-outline',
	)
);

$wp_customize->add_control(
	'coletivo_hcl1_btn2_style',
	array(
		'label'   => esc_html__( 'Button #1 style', 'coletivo' ),
		'section' => 'coletivo_hero_content_layout1',
		'type'    => 'select',
		'choices' => array(
			'btn-theme-primary'     => esc_html__( 'Button Primary', 'coletivo' ),
			'btn-secondary-outline' => esc_html__( 'Button Secondary', 'coletivo' ),
			'btn-default'           => esc_html__( 'Button', 'coletivo' ),
			'btn-primary'           => esc_html__( 'Primary', 'coletivo' ),
			'btn-success'           => esc_html__( 'Success', 'coletivo' ),
			'btn-info'              => esc_html__( 'Info', 'coletivo' ),
			'btn-warning'           => esc_html__( 'Warning', 'coletivo' ),
			'btn-danger'            => esc_html__( 'Danger', 'coletivo' ),
		),
	)
);

// Layout 2.
// Layout 2 content text.
$wp_customize->add_setting(
	'coletivo_hcl2_content',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'mod'               => 'html',
		'default'           => wp_kses_post( '<h1>Business Website' . "\n" . 'Made Simple.</h1>' . "\n" . 'We provide creative solutions to clients around the world,' . "\n" . 'creating things that get attention and meaningful.' . "\n\n" . '<a class="btn btn-secondary-outline btn-lg" href="#">Get Started</a>' ),
	)
);

$wp_customize->add_control(
	new Editor_Custom_Control(
		$wp_customize,
		'coletivo_hcl2_content',
		array(
			'label'       => esc_html__( 'Content Text', 'coletivo' ),
			'section'     => 'coletivo_hero_content_layout1',
			'description' => '',
		)
	)
);

// Layout 2 image.
$wp_customize->add_setting(
	'coletivo_hcl2_image',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'mod'               => 'html',
		'default'           => get_template_directory_uri() . '/assets/images/coletivo_responsive.png',
	)
);

use WP_Customize_Image_Control;

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'coletivo_hcl2_image',
		array(
			'label'       => esc_html__( 'Image', 'coletivo' ),
			'section'     => 'coletivo_hero_content_layout1',
			'description' => '',
		)
	)
);
