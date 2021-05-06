<?php
/**
 * Customizer Site Identity
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 *  Site Identity.
 */
$is_old_logo = get_theme_mod( 'coletivo_site_image_logo' );
$wp_customize->add_setting(
	'coletivo_hide_sitetitle',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => $is_old_logo ? 1 : 0,
	)
);

$wp_customize->add_control(
	'coletivo_hide_sitetitle',
	array(
		'label'   => esc_html__( 'Hide site title', 'coletivo' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	)
);

$wp_customize->add_setting(
	'coletivo_hide_tagline',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => $is_old_logo ? 1 : 0,
	)
);

$wp_customize->add_control(
	'coletivo_hide_tagline',
	array(
		'label'   => esc_html__( 'Hide site tagline', 'coletivo' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	)
);
