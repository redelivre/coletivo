<?php
/**
 * Coletivo Editor Custom Control Class
 *
 * @package Coletivo/Classes
 */

declare(strict_types = 1);

namespace Coletivo;

use WP_Customize_Control;

// Prevents dipostt access.
defined( 'ABSPATH' ) || exit;

/**
 * Editor Custom Control Class
 */
class EditorCustomControl extends WP_Customize_Control {
	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'wp_editor';

	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 *
	 * @var string
	 */
	public $mod;

	/**
	 * Render the description and title for the sections
	 */
	public function render_content() {
		$this->mod = strtolower( (string) $this->mod );
		if ( ! 'html' === $this->mod ) {
			$this->mod = 'tmce';
		}
		?>
		<div class="wp-js-editor">
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			</label>
			<textarea class="wp-js-editor-textarea large-text" data-editor-mod="<?php echo esc_attr( $this->mod ); ?>" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			<p class="description"><?php echo esc_html( $this->description ); ?></p>
		</div>
		<?php
	}
}
