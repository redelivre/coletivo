<?php
/**
 * coletivo functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package coletivo
 */

if ( ! function_exists( 'coletivo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function coletivo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on coletivo, use a find and replace
		 * to change 'coletivo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'coletivo', get_template_directory() . '/languages' );

		/*
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Excerpt for page
		 */
		add_post_type_support( 'page', 'excerpt' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'coletivo-blog-small', 300, 150, true );
		add_image_size( 'coletivo-small', 480, 300, true );
		add_image_size( 'coletivo-medium', 640, 400, true );

		/*
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary'      => esc_html__( 'Primary Menu', 'coletivo' ),
			'secondary'      => esc_html__( 'Page Menu', 'coletivo' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * This theme styles the visual editor to resemble the theme style.
		 */
		add_editor_style( array( 'assets/css/editor-style.css', coletivo_fonts_url() ) );

		/*
		 * WooCommerce support.
		 */
		add_theme_support( 'woocommerce' );

        /**
         * Add theme Support custom logo
         * @since WP 4.5
         * @sin 1.2.1
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 36,
            'width'       => 160,
            'flex-height' => true,
            'flex-width'  => true,
            //'header-text' => array( 'site-title',  'site-description' ), //
        ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
endif;
add_action( 'after_setup_theme', 'coletivo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function coletivo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'coletivo_content_width', 800 );
}
add_action( 'after_setup_theme', 'coletivo_content_width', 0 );

/**
* Add theme support for Portfolio Custom Post Type.
*/
add_action( 'after_setup_theme', slug_jetpack_portfolio_cpt );
function slug_jetpack_portfolio_cpt() {
add_theme_support( 'jetpack-portfolio' );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
add_action( 'widgets_init', 'coletivo_widgets_init' );
function coletivo_widgets_init() {
	register_sidebar( 

		array(
		'name'          => esc_html__( 'Sidebar', 'coletivo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__('Default sidebar for blog template', 'coletivo'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		) );

	register_sidebar(
		array(
		'name'          => esc_html__( 'Page', 'coletivo' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__('Sidebar for template With Sidebar', 'coletivo'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		) );

}

/**
 * Enqueue scripts and styles.
 */
function coletivo_scripts() {
	wp_enqueue_style( 'coletivo-fonts', coletivo_fonts_url(), array(), null );
	wp_enqueue_style( 'coletivo-animate', get_template_directory_uri() .'/assets/css/animate.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'coletivo-fa', get_template_directory_uri() .'/assets/css/font-awesome.min.css', array(), '4.4.0' );
	wp_enqueue_style( 'coletivo-bootstrap', get_template_directory_uri() .'/assets/css/bootstrap.min.css', false, '4.0.0' );
	wp_enqueue_style( 'coletivo-style', get_template_directory_uri().'/style.css' );
	if ( is_child_theme() ) {
		wp_enqueue_style( 'coletivo-style-child', get_stylesheet_directory_uri() .'/style.css' );
	}
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'coletivo-js-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array(), '1.0.0', true );
	wp_enqueue_script( 'coletivo-js-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '4.0.0', true );
	wp_enqueue_script( 'coletivo-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), '20120206', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Animation from settings.
	$coletivo_js_settings = array(
		'coletivo_disable_animation'     => get_theme_mod( 'coletivo_animation_disable' ),
		'coletivo_disable_sticky_header' => get_theme_mod( 'coletivo_sticky_header_disable' ),
		'coletivo_vertical_align_menu'   => get_theme_mod( 'coletivo_vertical_align_menu' ),
		'hero_animation'   				 => get_theme_mod( 'coletivo_hero_option_animation', 'flipInX' ),
		'hero_speed'   					 => intval( get_theme_mod( 'coletivo_hero_option_speed', 5000 ) ),
	);
	wp_localize_script( 'jquery', 'coletivo_js_settings', $coletivo_js_settings );

	  // Load gallery scripts
    $galley_disable  = get_theme_mod( 'coletivo_gallery_disable' ) ==  1 ? true : false;
    if ( ! $galley_disable || is_customize_preview() ) {
        $coletivo_js_settings['gallery_enable'] = 1;
        $display = get_theme_mod( 'coletivo_gallery_display', 'grid' );
        if ( ! is_customize_preview() ) {
            switch ( $display ) {
                case 'masonry':
                    wp_enqueue_script('coletivo-gallery-masonry', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js');
                    break;
                case 'justified':
                    wp_enqueue_script('coletivo-gallery-justified', get_template_directory_uri() . '/assets/js/jquery.justifiedGallery.min.js');
                    break;
                case 'slider':
                case 'carousel':
                    wp_enqueue_script('coletivo-gallery-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js');
                    break;
                default:
                    break;
            }
        } else {
            wp_enqueue_script('coletivo-gallery-masonry', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js');
            wp_enqueue_script('coletivo-gallery-justified', get_template_directory_uri() . '/assets/js/jquery.justifiedGallery.min.js');
            wp_enqueue_script('coletivo-gallery-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js');
        }

    }

    wp_enqueue_style( 'coletivo-gallery-lightgallery', get_template_directory_uri().'/assets/css/lightgallery.css' );
	wp_enqueue_script( 'coletivo-theme', get_template_directory_uri() . '/assets/js/theme.js' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    if ( is_front_page() && is_page_template( 'template-frontpage.php' ) ) {
        if ( get_theme_mod( 'coletivo_header_scroll_logo' ) ) {
            $coletivo_js_settings['is_home'] = 1;
        }
    }
	wp_localize_script( 'jquery', 'coletivo_js_settings', $coletivo_js_settings );

}
add_action( 'wp_enqueue_scripts', 'coletivo_scripts' );


if ( ! function_exists( 'coletivo_fonts_url' ) ) :
	/**
	 * Register default Google fonts
	 */
	function coletivo_fonts_url() {
	    $fonts_url = '';

	 	/* Translators: If there are characters in your language that are not
	    * supported by Open Sans, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $open_sans = _x( 'on', 'Open Sans font: on or off', 'coletivo' );

	    /* Translators: If there are characters in your language that are not
	    * supported by Raleway, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $raleway = _x( 'on', 'Raleway font: on or off', 'coletivo' );

	    if ( 'off' !== $raleway || 'off' !== $open_sans ) {
	        $font_families = array();

	        if ( 'off' !== $raleway ) {
	            $font_families[] = 'Raleway:400,500,600,700,300,100,800,900';
	        }

	        if ( 'off' !== $open_sans ) {
	            $font_families[] = 'Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic';
	        }

	        $query_args = array(
	            'family' => urlencode( implode( '|', $font_families ) ),
	            'subset' => urlencode( 'latin,latin-ext' ),
	        );

	        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	    }

	    return esc_url_raw( $fonts_url );
	}
endif;

if ( ! function_exists( 'coletivo_admin_scripts' ) ) :
	/**
	 * Enqueue scripts for admin page only: Theme info page
	 */
	function coletivo_admin_scripts( $hook ) {
		if ( $hook === 'widgets.php' || $hook === 'appearance_page_ft_coletivo'  ) {
			wp_enqueue_style( 'coletivo-admin-css', get_template_directory_uri() . '/assets/css/admin.css' );
		}
	}
endif;
add_action( 'admin_enqueue_scripts', 'coletivo_admin_scripts' );


if ( ! function_exists( 'coletivo_register_required_plugins' ) ) :
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function coletivo_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'               => 'Contact Form 7', // The plugin name.
				'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
				'source'             => '', // The plugin source.
				'required'           => false, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '4.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => false,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.

			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'coletivo' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'coletivo' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'coletivo' ), // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'coletivo' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %1$s plugin.', 'Sorry, but you do not have the correct permissions to install the %1$s plugins.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_ask_to_update_maybe'      => _n_noop( 'There is an update available for: %1$s.', 'There are updates available for the following plugins: %1$s.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %1$s plugin.', 'Sorry, but you do not have the correct permissions to update the %1$s plugins.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'coletivo' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %1$s plugin.', 'Sorry, but you do not have the correct permissions to activate the %1$s plugins.', 'coletivo' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'coletivo' ),
				'update_link' 					  => _n_noop( 'Begin updating plugin', 'Begin updating plugins', 'coletivo' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'coletivo' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'coletivo' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'coletivo' ),
				'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'coletivo' ),
				'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'coletivo' ),  // %1$s = plugin name(s).
				'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'coletivo' ),  // %1$s = plugin name(s).
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'coletivo' ), // %s = dashboard link.
				'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'coletivo' ),
				'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			),

		);

		tgmpa( $plugins, $config );
	}

endif;
add_action( 'tgmpa_register', 'coletivo_register_required_plugins' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Update customizer fields from version < 1.5.1.
 */
require get_template_directory() . '/inc/customizer-update-fields.php';

/**
 * Load TGM class plugin activation.
 */
// require get_template_directory() . '/inc/tgm-plugin-activation.php';

/**
 * Add theme info page
 */
// require get_template_directory() . '/inc/dashboard.php';
