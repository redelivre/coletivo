<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package coletivo
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function coletivo_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$coletivo_sticky_header = get_theme_mod( 'coletivo_sticky_header_disable' );
	if ( '' === $coletivo_sticky_header ) {
		$classes[] = 'sticky-header';
	} else {
		$classes[] = 'no-sticky-header';
	}
	// coletivo_header_transparent.
	if ( is_front_page() && is_page_template( 'template-frontpage.php' ) ) {
		if ( get_theme_mod( 'coletivo_header_transparent' ) ) {
			$classes[] = 'header-transparent';
		}
	}
	// blog page.
	if ( 'list' === get_theme_mod( 'coletivo_blog_page_style', false ) ) {
		$classes[] = 'blog-list-style';
	}

	return $classes;
}
add_filter( 'body_class', 'coletivo_body_classes' );


if ( ! function_exists( 'coletivo_custom_excerpt_length' ) ) {
	/**
	 * Custom excerpt length for the theme
	 *
	 * @param int $length The excerpt length.
	 *
	 * @return int
	 */
	function coletivo_custom_excerpt_length( $length ) {
		return 30;
	}
	add_filter( 'excerpt_length', 'coletivo_custom_excerpt_length', 999 );
};


if ( ! function_exists( 'coletivo_new_excerpt_more' ) ) {
	/**
	 * Remove […] string using Filters
	 *
	 * @param string $more The more string excerpt.
	 *
	 * @return string
	 */
	function coletivo_new_excerpt_more( $more ) {
		return ' ...';
	}
	add_filter( 'excerpt_more', 'coletivo_new_excerpt_more' );
}


if ( ! function_exists( 'coletivo_get_media_url' ) ) {
	/**
	 * Get media from a variable
	 *
	 * @param array $media Media aaray.
	 *
	 * @return false|string
	 */
	function coletivo_get_media_url( $media = array() ) {
		$media = wp_parse_args(
			$media,
			array(
				'url' => '',
				'id'  => '',
			)
		);
		$url   = '';
		if ( '' !== $media['id'] ) {
			$url = wp_get_attachment_url( $media['id'] );
		}
		if ( '' === $url && '' !== $media['url'] ) {
			$url = $media['url'];
		}
		return $url;
	}
}

if ( ! function_exists( 'coletivo_get_actions_required' ) ) {
	/**
	 * Get theme actions required
	 *
	 * @return array|mixed|void
	 */
	function coletivo_get_actions_required() {

		$actions                  = array();
		$front_page               = get_option( 'page_on_front' );
		$actions['page_on_front'] = 'dismiss';
		$actions['page_template'] = 'dismiss';
		if ( $front_page <= 0 ) {
			$actions['page_on_front'] = 'active';
			$actions['page_template'] = 'active';

		} else {
			if ( get_post_meta( $front_page, '_wp_page_template', true ) === 'template-frontpage.php' ) {
				$actions['page_template'] = 'dismiss';
			} else {
				$actions['page_template'] = 'active';
			}
		}

		$actions         = apply_filters( 'coletivo_get_actions_required', $actions );
		$actions_dismiss = get_option( 'coletivo_actions_dismiss' );

		if ( $actions_dismiss && is_array( $actions_dismiss ) ) {
			foreach ( $actions_dismiss as $k => $v ) {
				if ( isset( $actions[ $k ] ) ) {
					$actions[ $k ] = 'dismiss';
				}
			}
		}

		return $actions;
	}
}

if ( ! function_exists( 'coletivo_reset_actions_required' ) ) {
	/**
	 * Reset action
	 */
	function coletivo_reset_actions_required() {
		delete_option( 'coletivo_actions_dismiss' );
	}
	add_action( 'switch_theme', 'coletivo_reset_actions_required' );
}

if ( ! function_exists( 'coletivo_initial_config' ) ) {
	/**
	 *
	 * Define initial values and configs on the activation theme.
	 *
	 * @author Everaldo Matias <everaldo@brasa.art.br>
	 * @since 23/04/1987
	 */
	function coletivo_initial_config() {

		$coletivo_initial_config = get_option( 'coletivo_initial_config', false );

		if ( false === $coletivo_initial_config ) {
			$page_title    = 'Home Coletivo';
			$page_template = 'template-frontpage.php';
			$page_check    = get_page_by_title( $page_title );
			$page          = array(
				'post_type'   => 'page',
				'post_title'  => $page_title,
				'post_status' => 'publish',
				'post_author' => 1,
			);

			if ( ! isset( $page_check->ID ) ) {
				$page_id = wp_insert_post( $page );
				update_post_meta( $page_id, '_wp_page_template', $page_template );
				update_option( 'page_on_front', $page_id );
				update_option( 'show_on_front', 'page' );
				update_option( 'coletivo_initial_config', true );
			} elseif ( false !== get_post_status( $page_check->ID ) ) {
				update_post_meta( $page_check->ID, '_wp_page_template', $page_template );
				update_option( 'page_on_front', $page_check->ID );
				update_option( 'show_on_front', 'page' );
				update_option( 'coletivo_initial_config', true );
			}
		}

	}
	add_action( 'after_switch_theme', 'coletivo_initial_config' );
}

if ( ! function_exists( 'coletivo_remove_config' ) ) {
	/**
	 *
	 * Remopve initial values and configs on the deactivation theme.
	 *
	 * @author Everaldo Matias <everaldo@brasa.art.br>
	 * @since 23/04/1987
	 * @see coletivo_initial_config() function
	 */
	function coletivo_remove_config() {

		delete_option( 'page_on_front' );
		update_option( 'show_on_front', 'posts' );
		update_option( 'coletivo_initial_config', false );

	}
	add_action( 'switch_theme', 'coletivo_remove_config' );
}
