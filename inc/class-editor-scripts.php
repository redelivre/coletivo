<?php
/**
 * Coletivo Editor Script Class
 *
 * @package Coletivo/Classes
 */

declare(strict_types = 1);

namespace Coletivo;

// Prevents dipostt access.
defined( 'ABSPATH' ) || exit;

/**
 * Editor Script Class
 */
class Editor_Scripts {

	/**
	 * Init function
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'customize_controls_enqueue_scripts', array( __CLASS__, 'enqueue' ), 95 );
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public static function enqueue() {

		if ( ! class_exists( '_WP_Editors' ) ) {
			require ABSPATH . WPINC . '/class-wp-editor.php';
		}

		add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'enqueue_editor' ), 2 );
		add_action( 'customize_controls_print_footer_scripts', array( '_WP_Editors', 'editor_js' ), 50 );
		add_action( 'customize_controls_print_footer_scripts', array( '_WP_Editors', 'enqueue_scripts' ), 1 );
	}

	/**
	 * Enqueue Editor
	 *
	 * @access public
	 *
	 * @return void
	 */
	public static function enqueue_editor() {
		if ( ! isset( $GLOBALS['__wp_mce_editor__'] ) || ! $GLOBALS['__wp_mce_editor__'] ) {
			$GLOBALS['__wp_mce_editor__'] = true;
			?>
			<script id="_wp-mce-editor-tpl" type="text/html">
				<?php wp_editor( '', '__wp_mce_editor__' ); ?>
			</script>
			<?php
		}
	}
}
