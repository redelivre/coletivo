<?php
/**
 * Customizer Page Settings
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Blog Page Settings
 */
$wp_customize->add_section(
	'coletivo_blog_page',
	array(
		'priority'    => 15,
		'title'       => esc_html__( 'Blog Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'theme_options',
	)
);

$wp_customize->add_setting(
	'coletivo_blog_page_style',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_blog_page_style',
	array(
		'label'       => esc_html__( 'Blog style', 'coletivo' ),
		'section'     => 'coletivo_blog_page',
		'description' => '',
		'type'        => 'radio',
		'default'     => 'grid',
		'choices'     => array(
			'grid' => __( 'Grid', 'coletivo' ),
			'list' => __( 'List', 'coletivo' ),
		),
	)
);
