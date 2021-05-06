<?php
/**
 * Customizer Section Social
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Section: Social
 */
$wp_customize->add_panel(
	'coletivo_social_panel',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_social_panel' ),
		'title'           => esc_html__( 'Section: Social', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

// Social settings.
$wp_customize->add_section(
	'coletivo_social_settings',
	array(
		'priority'    => 1,
		'title'       => esc_html__( 'Social Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_social_panel',
	)
);

// Disable Social.
$wp_customize->add_setting(
	'coletivo_social_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '1',
	)
);

$wp_customize->add_control(
	'coletivo_social_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide Footer Social?', 'coletivo' ),
		'section'     => 'coletivo_social_settings',
		'description' => esc_html__( 'Check this box to hide footer social section.', 'coletivo' ),
	)
);

$wp_customize->add_setting(
	'coletivo_social_footer_guide',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
	)
);

$wp_customize->add_setting(
	'coletivo_social_footer_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Keep Updated', 'coletivo' ),
		'transport'         => 'postMessage',
	)
);

// Social Title.
$wp_customize->add_control(
	'coletivo_social_footer_title',
	array(
		'label'       => esc_html__( 'Social Footer Title', 'coletivo' ),
		'section'     => 'coletivo_social_settings',
		'description' => '',
	)
);

// Social BG color.
$wp_customize->add_setting(
	'coletivo_footer_bg',
	array(
		'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
		'default'              => '#939393',
		'transport'            => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'coletivo_footer_bg',
		array(
			'label'       => esc_html__( 'Footer Background', 'coletivo' ),
			'section'     => 'coletivo_social_settings',
			'description' => '',
		)
	)
);

$wp_customize->add_section(
	'coletivo_social',
	array(
		'priority'    => 2,
		'title'       => esc_html__( 'Social Profiles', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_social_panel',
	)
);

// Custom Message.
$wp_customize->add_control(
	new coletivo_Misc_Control(
		$wp_customize,
		'coletivo_social_footer_guide',
		array(
			'section'     => 'coletivo_social',
			'type'        => 'custom_message',
			'description' => esc_html__( 'These social profiles setting below will display at the footer of your site.', 'coletivo' ),
		)
	)
);

// Social Profiles.
$wp_customize->add_setting(
	'coletivo_social_profiles',
	array(
		'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
		'transport'         => 'postMessage', // refresh or postMessage.
	)
);

$wp_customize->add_control(
	new coletivo_Customize_Repeatable_Control(
		$wp_customize,
		'coletivo_social_profiles',
		array(
			'label'         => esc_html__( 'Socials', 'coletivo' ),
			'description'   => '',
			'section'       => 'coletivo_social',
			'live_title_id' => 'network', // apply for unput text and textarea only.
			'title_format'  => esc_html__( '[live_title]', 'coletivo' ),
			'max_item'      => 9, // Maximum item can add.
			'limited_msg'   => esc_html__( 'Only 9 social networks allowed', 'coletivo' ),
			'fields'        => array(
				'network' => array(
					'title' => esc_html__( 'Social network', 'coletivo' ),
					'type'  => 'text',
				),
				'icon'    => array(
					'title' => esc_html__( 'Icon', 'coletivo' ),
					'type'  => 'icon',
				),
				'link'    => array(
					'title' => esc_html__( 'URL', 'coletivo' ),
					'type'  => 'text',
				),
			),
		)
	)
);
