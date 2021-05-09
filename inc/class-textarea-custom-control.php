<?php
/**
 * Coletivo Text Area Custom Control Class
 *
 * @package Coletivo/Classes
 */

declare(strict_types = 1);

namespace Coletivo;

use WP_Customize_Control;

// Prevents dipostt access.
defined( 'ABSPATH' ) || exit;

/**
 * Text Area Custom Control Class
 */
class Textarea_Custom_Control extends WP_Customize_Control {
	/**
	 * Render the description and title for the sections
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
				<?php echo esc_textarea( $this->value() ); ?>
			</textarea>
			<p class="description"><?php echo esc_html( $this->description ); ?></p>
		</label>
		<?php
	}
}
