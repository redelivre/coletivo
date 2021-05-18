<?php
/**
 * Coletivo Customizer Controls
 *
 * @package Coletivo
 */

/* Autoload */
if ( version_compare( PHP_VERSION, '5.6.0', '>=' ) ) {
	require get_template_directory() . '/vendor/autoload.php';
}

if ( ! class_exists( 'MiscControl' ) ) {
	require_once get_template_directory() . '/inc/classes/MiscControl.php';
}

if ( ! class_exists( 'TextareaCustomControl' ) ) {
	require_once get_template_directory() . '/inc/classes/TextareaCustomControl.php';
}

if ( ! class_exists( 'EditorCustomControl' ) ) {
	require_once get_template_directory() . '/inc/classes/EditorCustomControl.php';
}

if ( ! class_exists( 'AlphaColorControl' ) ) {
	require_once get_template_directory() . '/inc/classes/AlphaColorControl.php';
}

if ( ! class_exists( 'CustomizeRepeatableControl' ) ) {
	require_once get_template_directory() . '/inc/classes/CustomizeRepeatableControl.php';
}

if ( ! class_exists( 'EditorScripts' ) ) {
	require_once get_template_directory() . '/inc/classes/EditorScripts.php';
}

/**
 * Customizer control scripts
 *
 * @since  1.7.0
 * @access public
 *
 * @return void
 */
function customizer_control_scripts() {
	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );

	wp_enqueue_script( 'coletivo-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-controls', 'wp-color-picker' ), VERSION, true );
	wp_enqueue_style( 'coletivo-customizer', get_template_directory_uri() . '/assets/css/customizer.css', false, VERSION );
	wp_localize_script( 'coletivo-customizer', 'coletivo_customizer', array( 'before_section_title' => __( 'Section: ', 'coletivo' ) ) );
}
add_action( 'customize_controls_enqueue_scripts', 'customizer_control_scripts', 99 );
