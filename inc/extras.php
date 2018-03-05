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
	if ( $coletivo_sticky_header == '' ) {
		$classes[] = 'sticky-header';
	} else {
        $classes[] = 'no-sticky-header';
    }
    // coletivo_header_transparent
    if ( is_front_page() && is_page_template( 'template-frontpage.php' ) ) {
        if ( get_theme_mod( 'coletivo_header_transparent' ) ) {
            $classes[] = 'header-transparent';
        }
    }
    // blog page
    if ( 'list' === get_theme_mod( 'coletivo_blog_page_style', false ) ) {
        $classes[] = 'blog-list-style';
    }

	return $classes;
}
add_filter( 'body_class', 'coletivo_body_classes' );


if ( ! function_exists( 'coletivo_custom_excerpt_length' ) ) :
/**
 * Custom excerpt length for the theme
 */
function coletivo_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'coletivo_custom_excerpt_length', 999 );
endif;


if ( ! function_exists( 'coletivo_new_excerpt_more' ) ) :
/**
 * Remove […] string using Filters
 */
function coletivo_new_excerpt_more( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'coletivo_new_excerpt_more');
endif;


/**
 * Get media from a variable
 *
 * @param array $media
 * @return false|string
 */
if ( ! function_exists( 'coletivo_get_media_url' ) ) {
    function coletivo_get_media_url($media = array())
    {
        $media = wp_parse_args($media, array('url' => '', 'id' => ''));
        $url = '';
        if ($media['id'] != '') {
            $url = wp_get_attachment_url($media['id']);
        }
        if ($url == '' && $media['url'] != '') {
            $url = $media['url'];
        }
        return $url;
    }
}


/**
 * Get theme actions required
 *
 * @return array|mixed|void
 */
function coletivo_get_actions_required( ) {

    $actions = array();
    $front_page = get_option( 'page_on_front' );
    $actions['page_on_front'] = 'dismiss';
    $actions['page_template'] = 'dismiss';
    if ( $front_page <= 0  ) {
        $actions['page_on_front'] = 'active';
        $actions['page_template'] = 'active';

    } else {
        if ( get_post_meta( $front_page, '_wp_page_template', true ) == 'template-frontpage.php' ) {
            $actions['page_template'] = 'dismiss';
        } else {
            $actions['page_template'] = 'active';
        }
    }

    $actions = apply_filters( 'coletivo_get_actions_required', $actions );
    $actions_dismiss =  get_option( 'coletivo_actions_dismiss' );

    if (  $actions_dismiss && is_array( $actions_dismiss ) ) {
        foreach ( $actions_dismiss as $k => $v ) {
            if ( isset ( $actions[ $k ] ) ) {
                $actions[ $k ] = 'dismiss';
            }
        }
    }

    return $actions;
}

add_action('switch_theme', 'coletivo_reset_actions_required');
function coletivo_reset_actions_required () {
    delete_option('coletivo_actions_dismiss');
}

/**
 * Set the initial configs in theme activation
 * Add in hook 'after_setup_theme' in functions.php
 */
function coletivo_initial_config() {
    $coletivo_initial_config = get_option( 'coletivo_initial_config' );
    if ( isset( $_GET['activated'] ) && is_admin() && $coletivo_initial_config == false ) {
        $page_title = 'Página Inicial';
        $page_template = 'template-frontpage.php';
        $page_check = get_page_by_title( $page_title );
        $page = array(
            'post_type'     => 'page',
            'post_title'    => $page_title,
            'post_status'   => 'publish',
            'post_author'   => 1,
        );
        if ( ! isset( $page_check->ID ) ) {
            $page_id = wp_insert_post( $page );
            update_post_meta( $page_id, '_wp_page_template', $page_template );
            update_option( 'page_on_front', $page_id );
            update_option( 'show_on_front', 'page' );
            update_option( 'coletivo_initial_config', true );
        }
    }
}