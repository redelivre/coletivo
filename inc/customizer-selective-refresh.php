<?php

/**
 * Load section template
 *
 * @since 1.2.1
 *
 * @param $template_names
 * @return string
 */
function coletivo_customizer_load_template( $template_names ){
    $located = '';

    $is_child =  get_stylesheet_directory() != get_template_directory() ;
    foreach ( (array) $template_names as $template_name ) {
        if (  !$template_name )
            continue;
        if ( false === strpos( $template_name, '.php' ) ) {
            $template_name .= '.php';
        }
        $template_name = trim( $template_name );
        if ( $is_child && file_exists( get_stylesheet_directory() . '/' . $template_name ) ) {  // Child them
            $located = get_stylesheet_directory() . '/' . $template_name;
            break;

        } elseif ( defined( 'coletivo_PLUS_PATH' ) && file_exists( coletivo_PLUS_PATH  . $template_name ) ) { // Check part in the plugin
            $located = coletivo_PLUS_PATH . $template_name;
            break;
        } elseif ( file_exists( get_template_directory() . '/' . $template_name) ) { // current_theme
            $located =  get_template_directory() . '/' . $template_name;
            break;
        }
    }
    
    return $located;
}

/**
 * Render customizer section
 * @since 1.2.1
 *
 * @param $section_tpl
 * @param array $section
 * @return string
 */
function coletivo_get_customizer_section_content( $section_tpl, $section = array() ){
    ob_start();
    $GLOBALS['coletivo_is_selective_refresh'] = true; 
    $file = coletivo_customizer_load_template( $section_tpl );
    if ( $file ) {
        include $file;
    }
    $content = ob_get_clean();
    return trim( $content );
}


/**
 * Add customizer selective refresh
 *
 * @since 1.2.1
 *
 * @param $wp_customize
 */
function coletivo_customizer_partials( $wp_customize ) {

    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $selective_refresh_keys = array(

        // section hero
        array(
            'id' => 'hero',
            'selector' => '.hero-slideshow-wrapper',
            'settings' => array(
                'coletivo_hero_images',
            ),
        ),

        // section features
        array(
            'id' => 'features',
            'selector' => '.section-features',
            'settings' => array(
                'coletivo_features_boxes',
                'coletivo_features_title',
                'coletivo_features_subtitle',
                'coletivo_features_desc',
                'coletivo_features_layout',
            ),
        ),

        // section yourslider
        array(
            'id' => 'yourslider',
            'selector' => '.section-yourslider',
            'settings' => array(
                'coletivo_yourslider_shortcode',
            ),
        ),

        // section services
        array(
            'id' => 'services',
            'selector' => '.section-services',
            'settings' => array(
                'coletivo_services',
                'coletivo_services_title',
                'coletivo_services_subtitle',
                'coletivo_services_desc',
                'coletivo_service_layout',
            ),
        ),

        // section portfolio
       array(
            'id' => 'portfolio',
            'selector' => '.section-portfolio',
            'settings' => array(
                'coletivo_portfolio_title',
                'coletivo_portfolio_subtitle',
                'coletivo_portfolio_desc',
                'coletivo_portfolio_number',
                'coletivo_portfolio_more_link',
                'coletivo_portfolio_more_text',
            ),
        ),

        // section news
        array(
            'id' => 'news',
            'selector' => '.section-news',
            'settings' => array(
                'coletivo_news_title',
                'coletivo_news_subtitle',
                'coletivo_news_desc',
                'coletivo_news_number',
                'coletivo_news_more_link',
                'coletivo_news_more_text',
            ),
        ),

        // section contact
        array(
            'id' => 'contact',
            'selector' => '.section-contact',
            'settings' => array(
                'coletivo_contact_title',
                'coletivo_contact_subtitle',
                'coletivo_contact_desc',
                'coletivo_contact_cf7',
                'coletivo_contact_cf7_disable',
                'coletivo_contact_text',
                'coletivo_contact_address_title',
                'coletivo_contact_address',
                'coletivo_contact_phone',
                'coletivo_contact_email',
                'coletivo_contact_fax',
            ),
        ),

        // section videolightbox
        array(
            'id' => 'videolightbox',
            'selector' => '.section-videolightbox',
            'settings' => array(
                'coletivo_videolightbox_title',
                'coletivo_videolightbox_url',
            ),
        ),

        // section gallery
        'gallery' => array(
            'id' => 'gallery',
            'selector' => '.section-gallery',
            'settings' => array(
                'coletivo_gallery_source_page',
                'coletivo_gallery_layout',
                'coletivo_gallery_display',
                'coletivo_g_number',
                'coletivo_g_row_height',
                'coletivo_g_col',
                'coletivo_g_readmore_link',
                'coletivo_g_readmore_text',
                'coletivo_gallery_title',
                'coletivo_gallery_subtitle',
                'coletivo_gallery_desc',
            ),
        ),

        // section team
        array(
            'id' => 'team',
            'selector' => '.section-team',
            'settings' => array(
                'coletivo_team_members',
                'coletivo_team_title',
                'coletivo_team_subtitle',
                'coletivo_team_desc',
                'coletivo_team_layout',
            ),
        ),

        // section social
        array(
            'id' => 'social',
            'selector' => '.section-social',
            'settings' => array(
                'coletivo_social_footer_title',
                'coletivo_footer_bg',
                'coletivo_social_profiles',
            ),
        ),

    );

    $selective_refresh_keys = apply_filters( 'coletivo_customizer_partials_selective_refresh_keys', $selective_refresh_keys );

    foreach ( $selective_refresh_keys as $section ) {
        foreach ( $section['settings'] as $key ) {
            if ( $wp_customize->get_setting( $key ) ) {
                $wp_customize->get_setting( $key )->transport = 'postMessage';
            }
        }

        $wp_customize->selective_refresh->add_partial( 'section-'.$section['id'] , array(
            'selector' => $section['selector'],
            'settings' => $section['settings'],
            'render_callback' => 'coletivo_selective_refresh_render_section_content',
        ));
    }
	// Logo, description and favicon
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    $wp_customize->get_setting( 'coletivo_hide_sitetitle' )->transport = 'postMessage';
    $wp_customize->get_setting( 'coletivo_hide_tagline' )->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial( 'header_brand', array(
        'selector' => '.site-header .site-branding',
        'settings' => array( 'blogname', 'blogdescription', 'coletivo_hide_sitetitle', 'coletivo_hide_tagline' ),
        'render_callback' => 'coletivo_site_logo',
    ) );

    // Social heading
    $wp_customize->selective_refresh->add_partial( 'coletivo_social_footer_title', array(
        'selector' => '',
        'settings' => array( 'coletivo_social_footer_title' ),
        'render_callback' => 'coletivo_selective_refresh_social_footer_title',
    ) );

    // Featured Page Content
    $wp_customize->selective_refresh->add_partial( 'coletivo_featuredpage_content_source', array(
        'selector' => '.section-featuredpage',
        'settings' => array( 'coletivo_featuredpage_content_source', 'coletivo_featuredpage_more_text' ),
        'render_callback' => 'coletivo_selective_refresh_featured_page',
    ) );


}
add_action( 'customize_register', 'coletivo_customizer_partials', 50 );



/**
 * Selective render content
 *
 * @param $partial
 * @param array $container_context
 */
function coletivo_selective_refresh_render_section_content( $partial, $container_context = array() ) {
    $tpl = 'section-parts/'.$partial->id.'.php';
    $GLOBALS['coletivo_is_selective_refresh'] = true;
    $file = coletivo_customizer_load_template( $tpl );
    if ( $file ) {
        include $file;
    }
}

function coletivo_selective_refresh_social_footer_title(){
    return get_theme_mod( 'coletivo_social_footer_title' );
}

function coletivo_selective_refresh_featured_page( $partial = '', $container_context = '') {
    return coletivo_get_customizer_section_content( array( '
        section-parts/section-featuredpage.php' ), array() );
}