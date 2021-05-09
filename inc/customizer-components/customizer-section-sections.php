<?php
/**
 * Customizer Section Sections ordering
 *
 * @package Coletivo
 */

namespace Coletivo;

defined( 'ABSPATH' ) || exit;

/**
 * Section: Sections
 */
$wp_customize->add_section(
	'coletivo_sections_options',
	array(
		'priority'    => 130,
		'title'       => esc_html__( 'Sections', 'coletivo' ),
		'description' => '',
	)
);

// Sections ordering.
$wp_customize->add_setting(
	'coletivo_section_order',
	array(
		'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
		'transport'         => 'refresh', // refresh or postMessage.
	)
);

$wp_customize->add_control(
	new Customize_Repeatable_Control(
		$wp_customize,
		'coletivo_section_order',
		array(
			'label'          => esc_html__( 'Sections', 'coletivo' ),
			'is_order_field' => true,
			'description'    => esc_html__( 'Organize with drag and drop to define sections order, open it to customize each one', 'coletivo' ),
			'section'        => 'coletivo_sections_options',
			'live_title_id'  => 'section_order', // apply for unput text and textarea only.
			'title_format'   => __( '[live_title] <a>(Edit Section)</a>', 'coletivo' ),
			'max_item'       => 200, // Maximum item can add.
			'limited_msg'    => '',
			'fields'         => array(),

		)
	)
);

// Hidden field to reorder home sections.
$wp_customize->add_setting(
	'coletivo_sections_order',
	array(
		'default' => apply_filters( 'coletivo_sections_order_default_value', 'hero,features,yourslider,featuredpage,services,portfolio,videolightbox,gallery,team,news,contact,social' ),
	)
);

$wp_customize->add_control(
	'coletivo_sections_order',
	array(
		'type'    => 'hidden',
		'section' => 'coletivo_sections_options',
	)
);
