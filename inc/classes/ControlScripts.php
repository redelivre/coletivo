<?php
/**
 * Coletivo Control Script Class
 *
 * @package Coletivo/Classes
 */

declare(strict_types = 1);

namespace RedeLivre\Coletivo;

// Prevents dipostt access.
defined( 'ABSPATH' ) || exit;

/**
 * Editor Script Class
 */
class ControlScripts {

	/**
	 * Init function
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'customize_controls_enqueue_scripts', array( __CLASS__, 'customizer_control_scripts', 99 ) );
	}

	/**
	 * Customizer control scripts
	 *
	 * @since  1.7.0
	 * @access public
	 *
	 * @return void
	 */
	public static function customizer_control_scripts() {
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script( 'coletivo-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-controls', 'wp-color-picker' ), VERSION, true );
		wp_enqueue_style( 'coletivo-customizer', get_template_directory_uri() . '/assets/css/customizer.css', false, VERSION );
		wp_localize_script( 'coletivo-customizer', 'coletivo_customizer', array( 'before_section_title' => __( 'Section: ', 'coletivo' ) ) );
	}

}
