<?php
/**
 * Customizer Hero Options
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero Options
 */
$wp_customize->add_section(
	'coletivo_hero_options',
	array(
		'title'    => __( 'Hero Options', 'coletivo' ),
		'panel'    => 'theme_options',
		'priority' => 20,
	)
);

$wp_customize->add_setting(
	'coletivo_hero_option_animation',
	array(
		'default'           => 'flipInX',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

/**
 * Animate CSS
 *
 * @see https://github.com/daneden/animate.css
 */
$animations_css = 'bounce flash pulse rubberBand shake headShake swing tada wobble jello bounceIn bounceInDown bounceInLeft bounceInRight bounceInUp bounceOut bounceOutDown bounceOutLeft bounceOutRight bounceOutUp fadeIn fadeInDown fadeInDownBig fadeInLeft fadeInLeftBig fadeInRight fadeInRightBig fadeInUp fadeInUpBig fadeOut fadeOutDown fadeOutDownBig fadeOutLeft fadeOutLeftBig fadeOutRight fadeOutRightBig fadeOutUp fadeOutUpBig flipInX flipInY flipOutX flipOutY lightSpeedIn lightSpeedOut rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut zoomIn zoomInDown zoomInLeft zoomInRight zoomInUp zoomOut zoomOutDown zoomOutLeft zoomOutRight zoomOutUp slideInDown slideInLeft slideInRight slideInUp slideOutDown slideOutLeft slideOutRight slideOutUp';
$animations_css = explode( ' ', $animations_css );
$animations     = array();

foreach ( $animations_css as $v ) {
	$v = trim( $v );
	if ( $v ) {
		$animations[ $v ] = $v;
	}
}

$wp_customize->add_control(
	'coletivo_hero_option_animation',
	array(
		'label'   => __( 'Text animation', 'coletivo' ),
		'section' => 'coletivo_hero_options',
		'type'    => 'select',
		'choices' => $animations,
	)
);

$wp_customize->add_setting(
	'coletivo_hero_option_speed',
	array(
		'default'           => '5000',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'coletivo_hero_option_speed',
	array(
		'label'       => __( 'Speed', 'coletivo' ),
		'description' => esc_html__( 'The delay between the changing of each phrase in milliseconds.', 'coletivo' ),
		'section'     => 'coletivo_hero_options',
	)
);
