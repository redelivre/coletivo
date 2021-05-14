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

if ( ! function_exists( 'coletivo_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox
	 *
	 * @param  int $input The checkbox value.
	 * @return bool
	 */
	function coletivo_sanitize_checkbox( $input ) {
		if ( 1 === $input ) {
			return 1;
		} else {
			return 0;
		}
	}
}

/**
 * Sanitize CSS code
 *
 * @param string $string The CSS code.
 *
 * @return string
 */
function coletivo_sanitize_css( $string ) {
	$string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
	$string = wp_strip_all_tags( $string );
	return trim( $string );
}

/**
 * Sanitize color alpha
 *
 * @param string $color The color value.
 *
 * @return string
 */
function coletivo_sanitize_color_alpha( $color ) {
	$color = str_replace( '#', '', $color );
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', '#' . $color ) ) {
		// convert to rgb.
		$colour = $color;
		if ( 6 === strlen( $colour ) ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( 3 === strlen( $colour ) ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return 'rgba( ' . join(
			',',
			array(
				'r' => $r,
				'g' => $g,
				'b' => $b,
				'a' => 1,
			)
		) . ')';

	}

	return false !== strpos( trim( $color ), 'rgb' ) ? $color : false;
}

/**
 * Sanitize repeatable data
 *
 * @param  string $input   The input string.
 * @param  object $setting $wp_customize.
 *
 * @return bool|mixed|string|void
 */
function coletivo_sanitize_repeatable_data_field( $input, $setting ) {
	$control = $setting->manager->get_control( $setting->id );

	$fields = $control->fields;
	if ( is_string( $input ) ) {
		$input = json_decode( wp_unslash( $input ), true );
	}
	$data = wp_parse_args( $input, array() );

	if ( ! is_array( $data ) ) {
		return false;
	}
	if ( ! isset( $data['_items'] ) ) {
		return false;
	}
	$data = $data['_items'];

	foreach ( $data as $i => $item_data ) {
		foreach ( $item_data as $id => $value ) {

			if ( isset( $fields[ $id ] ) ) {
				switch ( strtolower( $fields[ $id ]['type'] ) ) {
					case 'text':
						$data[ $i ][ $id ] = sanitize_text_field( $value );
						break;
					case 'textarea':
					case 'editor':
						$data[ $i ][ $id ] = wp_kses_post( $value );
						break;
					case 'color':
						$data[ $i ][ $id ] = sanitize_hex_color_no_hash( $value );
						break;
					case 'coloralpha':
						$data[ $i ][ $id ] = coletivo_sanitize_color_alpha( $value );
						break;
					case 'checkbox':
						$data[ $i ][ $id ] = coletivo_sanitize_checkbox( $value );
						break;
					case 'select':
						$data[ $i ][ $id ] = '';
						if ( is_array( $fields[ $id ]['options'] ) && ! empty( $fields[ $id ]['options'] ) ) {
							// if is multiple choices.
							if ( is_array( $value ) ) {
								foreach ( $value as $k => $v ) {
									if ( isset( $fields[ $id ]['options'][ $v ] ) ) {
										$value [ $k ] = $v;
									}
								}
								$data[ $i ][ $id ] = $value;
							} else { // is single choice.
								if ( isset( $fields[ $id ]['options'][ $value ] ) ) {
									$data[ $i ][ $id ] = $value;
								}
							}
						}

						break;
					case 'radio':
						$data[ $i ][ $id ] = sanitize_text_field( $value );
						break;
					case 'media':
						$value = wp_parse_args(
							$value,
							array(
								'url' => '',
								'id'  => false,
							)
						);

						$value['id']              = absint( $value['id'] );
						$data[ $i ][ $id ]['url'] = sanitize_text_field( $value['url'] );

						if ( wp_get_attachment_url( $value['id'] ) === $url ) {
							$data[ $i ][ $id ]['id']  = $value['id'];
							$data[ $i ][ $id ]['url'] = $url;
						} else {
							$data[ $i ][ $id ]['id'] = '';
						}

						break;
					default:
						$data[ $i ][ $id ] = wp_kses_post( $value );
				}
			} else {
				$data[ $i ][ $id ] = wp_kses_post( $value );
			}

			if ( count( $data[ $i ] ) !== count( $fields ) ) {
				foreach ( $fields as $k => $f ) {
					if ( ! isset( $data[ $i ][ $k ] ) ) {
						$data[ $i ][ $k ] = '';
					}
				}
			}
		}
	}

	return $data;
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

/**
 * Enqueue editor
 *
 * @return void
 */
function coletivo_enqueue_editor() {
	if ( ! isset( $GLOBALS['__wp_mce_editor__'] ) || ! $GLOBALS['__wp_mce_editor__'] ) {
		$GLOBALS['__wp_mce_editor__'] = true;
		?>
		<script id="_wp-mce-editor-tpl" type="text/html">
			<?php wp_editor( '', '__wp_mce_editor__' ); ?>
		</script>
		<?php
	}
}

if ( ! class_exists( 'EditorScripts' ) ) {
	require_once get_template_directory() . '/inc/classes/EditorScripts.php';
}

if ( ! class_exists( 'ControlScripts' ) ) {
	require_once get_template_directory() . '/inc/classes/ControlScripts.php';
}
