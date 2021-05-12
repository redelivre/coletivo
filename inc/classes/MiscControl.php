<?php
/**
 * Coletivo Misc Control Class
 *
 * @package Coletivo/Classes
 */

declare(strict_types = 1);

namespace Coletivo;

use WP_Customize_Control;

// Prevents dipostt access.
defined( 'ABSPATH' ) || exit;

/**
 * Misc Control Class
 */
class MiscControl extends WP_Customize_Control {

	/**
	 * Settings
	 *
	 * @var string
	 */
	public $settings = 'blogname';

	/**
	 * Description
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Group
	 *
	 * @var string
	 */
	public $group = '';

	/**
	 * Render the description and title for the sections
	 */
	public function render_content() {
		switch ( $this->type ) {
			case 'heading':
				echo '<span class="customize-control-title">' . esc_html( $this->title ) . '</span>';
				break;

			case 'custom_message':
				echo '<p class="description">' . esc_html( $this->description ) . '</p>';
				break;

			case 'hr':
				echo '<hr />';
				break;
		}
	}
}
