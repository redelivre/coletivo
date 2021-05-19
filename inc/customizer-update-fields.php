<?php
/**
 * Coletivo Update Customizer
 *
 * @package    Coletivo
 * @subpackage WP_Update_Customizer
 * @author     Matheus Gimenez <contato@matheusgimenez.com.br>
 * @license    GPL-2.0+
 * @copyright  2017 Matheus Gimenez
 *
 * @wordpress-plugin
 * Description:       ColetivoWP_Update_Customizer
 * Version:           0.1
 * Author:            Matheus Gimenez
 * Text Domain:       custom-roles
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

/**
 * Coletivo Update Customizer class
 */
class ColetivoWP_Update_Customizer {
	/**
	 *
	 * Init Plugin class
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'update_theme_mod' ) );
	}
	/**
	 * Change "onepress" to "coletivo" in customizer fields
	 *
	 * @return type
	 */
	public function update_theme_mod() {
		if ( 'true' === get_option( 'tema_coletivo_updated_customizer', 'false' ) ) {
			return;
		}
		$customizer_fields = get_option( 'theme_mods_coletivo' );

		if ( is_array( $customizer_fields ) ) {
			foreach ( $customizer_fields as $key => $value ) {
				if ( false === strpos( $key, 'onepress' ) ) {
					continue;
				}
				$new_key                       = str_replace( 'onepress', 'coletivo', $key );
				$customizer_fields[ $new_key ] = $value;
				unset( $customizer_fields[ $key ] );
			}
			update_option( 'theme_mods_coletivo', $customizer_fields );
			update_option( 'tema_coletivo_updated_customizer', 'true' );
		}
	}
}
new ColetivoWP_Update_Customizer();
