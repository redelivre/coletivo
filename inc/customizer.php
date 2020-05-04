<?php
/**
 * coletivo Theme Customizer.
 *
 * @package coletivo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function coletivo_customize_register( $wp_customize ) {

	// Load custom controls.
	require get_template_directory() . '/inc/customizer-controls.php';
	// Remove default sections.
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
	// Custom WP default control & settings.
	$wp_customize->get_section( 'title_tagline' )->title = esc_html__('Site Title, Tagline & Logo', 'coletivo');
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	/**
	 * Hook to add other customize
	 */
	do_action( 'coletivo_customize_before_register', $wp_customize );
	$pages  =  get_pages();
	$option_pages = array();
	$option_pages[0] = __( 'Select page', 'coletivo' );
	foreach( $pages as $p ){
		$option_pages[ $p->ID ] = $p->post_title;
	}
	$users = get_users( array(
		'orderby'      => 'display_name',
		'order'        => 'ASC',
		'number'       => '',
	) );
	$option_users[0] = __( 'Select member', 'coletivo' );
	foreach( $users as $user ){
		$option_users[ $user->ID ] = $user->display_name;
	}
	/*------------------------------------------------------------------------*/
    /*  Site Identity.
    /*------------------------------------------------------------------------*/
        $is_old_logo = get_theme_mod( 'coletivo_site_image_logo' );
        $wp_customize->add_setting( 'coletivo_hide_sitetitle',
            array(
                'sanitize_callback' => 'coletivo_sanitize_checkbox',
                'default'           => $is_old_logo ? 1: 0,
            )
        );
        $wp_customize->add_control(
            'coletivo_hide_sitetitle',
            array(
                'label' 		=> esc_html__('Hide site title', 'coletivo'),
                'section' 		=> 'title_tagline',
                'type'          => 'checkbox',
            )
        );
        $wp_customize->add_setting( 'coletivo_hide_tagline',
            array(
                'sanitize_callback' => 'coletivo_sanitize_checkbox',
                'default'           => $is_old_logo ? 1: 0,
            )
        );
        $wp_customize->add_control(
            'coletivo_hide_tagline',
            array(
                'label' 		=> esc_html__('Hide site tagline', 'coletivo'),
                'section' 		=> 'title_tagline',
                'type'          => 'checkbox',
            )
        );
	/*------------------------------------------------------------------------*/
    /*  Site Options
    /*------------------------------------------------------------------------*/
		$wp_customize->add_panel( 'theme_options',
			array(
				'priority'       => 22,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			    'title'          => esc_html__( 'Theme Options', 'coletivo' ),
			    'description'    => '',
			)
		);
		/* Global Settings
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'coletivo_global_settings' ,
			array(
				'priority'    => 1,
				'title'       => esc_html__( 'Global', 'coletivo' ),
				'description' => '',
				'panel'       => 'theme_options',
			)
		);

		// Primary Color
		$wp_customize->add_setting( 'coletivo_primary_color', array('sanitize_callback' => 'sanitize_hex_color_no_hash', 'sanitize_js_callback' => 'maybe_hash_hex_color', 'default' => '#03c4eb' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_primary_color',
			array(
				'label'       => esc_html__( 'Primary Color', 'coletivo' ),
				'section'     => 'coletivo_global_settings',
				'description' => '',
				'priority'    => 1
			)
		));


		// Disable Animation
		$wp_customize->add_setting( 'coletivo_animation_disable',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'coletivo_animation_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Disable animation effect?', 'coletivo'),
				'section'     => 'coletivo_global_settings',
				'description' => esc_html__('Check this box to disable all element animation when scroll.', 'coletivo')
			)
		);

		// Header Transparent
		$wp_customize->add_setting( 'coletivo_header_transparent',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => '',
				'active_callback'   => 'coletivo_showon_frontpage'
			)
		);
		$wp_customize->add_control( 'coletivo_header_transparent',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Header Transparent', 'coletivo'),
				'section'     => 'coletivo_global_settings',
				'description' => esc_html__('Apply for front page template only.', 'coletivo')
			)
		);

		/* Header
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'coletivo_header_settings' ,
			array(
				'priority'    => 5,
				'title'       => esc_html__( 'Header', 'coletivo' ),
				'description' => '',
				'panel'       => 'theme_options',
			)
		);
		// Hidden field to reorder home sections
		$wp_customize->add_setting( 'coletivo_sections_order',
			array(
				'default' => apply_filters( 'coletivo_sections_order_default_value', 'hero,features,yourslider,featuredpage,services,portfolio,videolightbox,gallery,team,news,contact,social' )
			) );
		$wp_customize->add_control( 'coletivo_sections_order',
			array(
				'type'			=> 'hidden',
				'section'		=> 'coletivo_header_settings'
			)
		);
		// Header BG Color
		$wp_customize->add_setting( 'coletivo_header_bg_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_header_bg_color',
			array(
				'label'       => esc_html__( 'Background Color', 'coletivo' ),
				'section'     => 'coletivo_header_settings',
				'description' => '',
			)
		));
		// Site Title Color
		$wp_customize->add_setting( 'coletivo_logo_text_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_logo_text_color',
			array(
				'label'       => esc_html__( 'Site Title Color', 'coletivo' ),
				'section'     => 'coletivo_header_settings',
				'description' => esc_html__( 'Only set if you don\'t use an image logo.', 'coletivo' ),
			)
		));
		// Header Menu Color
		$wp_customize->add_setting( 'coletivo_menu_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_menu_color',
			array(
				'label'       => esc_html__( 'Menu Link Color', 'coletivo' ),
				'section'     => 'coletivo_header_settings',
				'description' => '',
			)
		));
		// Header Menu Hover Color
		$wp_customize->add_setting( 'coletivo_menu_hover_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_menu_hover_color',
			array(
				'label'       => esc_html__( 'Menu Link Hover/Active Color', 'coletivo' ),
				'section'     => 'coletivo_header_settings',
				'description' => '',
			)
		));
		// Header Menu Hover BG Color
		$wp_customize->add_setting( 'coletivo_menu_hover_bg_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_menu_hover_bg_color',
			array(
				'label'       => esc_html__( 'Menu Link Hover/Active BG Color', 'coletivo' ),
				'section'     => 'coletivo_header_settings',
				'description' => '',
			)
		));
		// Reponsive Mobile button color
		$wp_customize->add_setting( 'coletivo_menu_toggle_button_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_menu_toggle_button_color',
			array(
				'label'       => esc_html__( 'Responsive Menu Button Color', 'coletivo' ),
				'section'     => 'coletivo_header_settings',
				'description' => '',
			)
		));
		// Vertical align menu
		$wp_customize->add_setting( 'coletivo_vertical_align_menu',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'coletivo_vertical_align_menu',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Center vertical align for menu', 'coletivo'),
				'section'     => 'coletivo_header_settings',
				'description' => esc_html__('If you use logo and your logo is too tall, check this box to auto vertical align menu.', 'coletivo')
			)
		);

		// Disable Sticky Header
		$wp_customize->add_setting( 'coletivo_sticky_header_disable',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'coletivo_sticky_header_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Disable Sticky Header?', 'coletivo'),
				'section'     => 'coletivo_header_settings',
				'description' => esc_html__('Check this box to disable sticky header when scroll.', 'coletivo')
			)
		);

	/* Footer
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'coletivo_footer_settings' ,
			array(
				'priority'    => 10,
				'title'       => esc_html__( 'Footer', 'coletivo' ),
				'description' => '',
				'panel'       => 'theme_options',
			)
		);

    	// Footer custom Text
		$wp_customize->add_setting( 'coletivo_footer_text',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__( 'Few Rights Reserved', 'coletivo' ),
				'transport'			=> 'refresh',
			)
		);
		$wp_customize->add_control( 'coletivo_footer_text',
			array(
				'type'        => 'text',
				'label'       => esc_html__('Footer Text', 'coletivo'),
				'section'     => 'coletivo_footer_settings',
				'description' => ''
			)
		);
		// Footer custom Link
		$wp_customize->add_setting( 'coletivo_footer_text_link',
			array(
				'sanitize_callback' => 'esc_url',
				'default'           => esc_url( home_url( '/' )),
				'transport'			=> 'refresh',
			)
		);
		$wp_customize->add_control( 'coletivo_footer_text_link',
			array(
				'type'  =>'text',
				'label'       => esc_html__('Footer Link', 'coletivo'),
				'section'     => 'coletivo_footer_settings',
				'description' => ''
			)
		);

        // Footer Info BG Color
        $wp_customize->add_setting( 'coletivo_footer_info_bg', array(
            'sanitize_callback' => 'sanitize_hex_color_no_hash',
            'sanitize_js_callback' => 'maybe_hash_hex_color',
            'default' => '',
            'transport' => 'postMessage'
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_footer_info_bg',
            array(
                'label'       => esc_html__( 'Footer Info Background', 'coletivo' ),
                'section'     => 'coletivo_footer_settings',
                'description' => '',
            )
        ));

        // Disable Back to top
		$wp_customize->add_setting( 'coletivo_btt_disable',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => '',
				'transport'			=> 'postMessage'
			)
		);
		$wp_customize->add_control( 'coletivo_btt_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide footer back to top?', 'coletivo'),
				'section'     => 'coletivo_footer_settings',
				'description' => esc_html__('Check this box to hide footer back to top button.', 'coletivo')
			)
		);

		/* Blog page Settings
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'coletivo_blog_page' ,
			array(
				'priority'		=> 15,
				'title'			=> esc_html__( 'Blog Settings', 'coletivo' ),
				'description'	=> '',
				'panel'			=> 'theme_options'
			)
		);
		$wp_customize->add_setting( 'coletivo_blog_page_style',
			array(
				'sanitize_callback' => 'coletivo_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'coletivo_blog_page_style',
			array(
				'label'     	=> esc_html__( 'Blog style', 'coletivo' ),
				'section' 		=> 'coletivo_blog_page',
				'description'   => '',
				'type' => 'radio',
				'default' => 'grid',
				'choices' => array(
					'grid' => __( 'Grid', 'coletivo'),
					'list'  => __( 'List', 'coletivo' ),
				),
			)
		);

		/* Hero options
		----------------------------------------------------------------------*/
		$wp_customize->add_section(
			'coletivo_hero_options',
			array(
				'title'       => __( 'Hero Options', 'coletivo' ),
				'panel'       => 'theme_options',
				'priority'		=> 20,
			)
		);
		$wp_customize->add_setting(
			'coletivo_hero_option_animation',
			array(
				'default'              => 'flipInX',
				'sanitize_callback'    => 'sanitize_text_field',
			)
		);
		/**
		 * @see https://github.com/daneden/animate.css
		 */
		$animations_css = 'bounce flash pulse rubberBand shake headShake swing tada wobble jello bounceIn bounceInDown bounceInLeft bounceInRight bounceInUp bounceOut bounceOutDown bounceOutLeft bounceOutRight bounceOutUp fadeIn fadeInDown fadeInDownBig fadeInLeft fadeInLeftBig fadeInRight fadeInRightBig fadeInUp fadeInUpBig fadeOut fadeOutDown fadeOutDownBig fadeOutLeft fadeOutLeftBig fadeOutRight fadeOutRightBig fadeOutUp fadeOutUpBig flipInX flipInY flipOutX flipOutY lightSpeedIn lightSpeedOut rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut zoomIn zoomInDown zoomInLeft zoomInRight zoomInUp zoomOut zoomOutDown zoomOutLeft zoomOutRight zoomOutUp slideInDown slideInLeft slideInRight slideInUp slideOutDown slideOutLeft slideOutRight slideOutUp';
		$animations_css = explode( ' ', $animations_css );
		$animations = array();
		foreach ( $animations_css as $v ) {
			$v =  trim( $v );
			if ( $v ){
				$animations[ $v ]= $v;
			}
		}
		$wp_customize->add_control(
			'coletivo_hero_option_animation',
			array(
				'label'    => __( 'Text animation', 'coletivo' ),
				'section'  => 'coletivo_hero_options',
				'type'     => 'select',
				'choices' => $animations,
			)
		);
		$wp_customize->add_setting(
			'coletivo_hero_option_speed',
			array(
				'default'              => '5000',
				'sanitize_callback'    => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'coletivo_hero_option_speed',
			array(
				'label'    => __( 'Speed', 'coletivo' ),
				'description' => esc_html__( 'The delay between the changing of each phrase in milliseconds.', 'coletivo' ),
				'section'  => 'coletivo_hero_options',
			)
		);

	/*------------------------------------------------------------------------*/
    /*  Section: Hero
    /*------------------------------------------------------------------------*/
	$wp_customize->add_panel( 'coletivo_hero_panel' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_hero_panel' ),
			'title'           => esc_html__( 'Section: Hero', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	// Hero settings
	$wp_customize->add_section( 'coletivo_hero_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Hero Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_hero_panel',
		)
	);
	// Show section
	$wp_customize->add_setting( 'coletivo_hero_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_hero_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide this section?', 'coletivo'),
			'section'     => 'coletivo_hero_settings',
			'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
		)
	);

	// Title
    $wp_customize->add_setting( 'coletivo_hero_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'coletivo_hero_title',
        array(
            'label' 		=> esc_html__('Title section in customizer', 'coletivo'),
            'section' 		=> 'coletivo_hero_settings',
            'description'   => esc_html__( 'This title is only showed in customizer', 'coletivo'),
        )
    );


	// Section ID
	$wp_customize->add_setting( 'coletivo_hero_id',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('hero', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_hero_id',
		array(
			'label' 		=> esc_html__('Section ID:', 'coletivo'),
			'section' 		=> 'coletivo_hero_settings',
			'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
		)
	);
	// Show hero full screen
	$wp_customize->add_setting( 'coletivo_hero_fullscreen',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_hero_fullscreen',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Make hero section full screen', 'coletivo'),
			'section'     => 'coletivo_hero_settings',
			'description' => esc_html__('Check this box to make hero section full screen.', 'coletivo'),
		)
	);
	// Hero content padding top
	$wp_customize->add_setting( 'coletivo_hero_pdtop',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('10', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_hero_pdtop',
		array(
			'label'           => esc_html__('Padding Top:', 'coletivo'),
			'section'         => 'coletivo_hero_settings',
			'description'     => esc_html__( 'The hero content padding top in percent (%).', 'coletivo' ),
			'active_callback' => 'coletivo_hero_fullscreen_callback'
		)
	);
	// Hero content padding bottom
	$wp_customize->add_setting( 'coletivo_hero_pdbotom',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('10', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_hero_pdbotom',
		array(
			'label'           => esc_html__('Padding Bottom:', 'coletivo'),
			'section'         => 'coletivo_hero_settings',
			'description'     => esc_html__( 'The hero content padding bottom in percent (%).', 'coletivo' ),
			'active_callback' => 'coletivo_hero_fullscreen_callback'
		)
	);
	$wp_customize->add_section( 'coletivo_hero_images' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Hero Background Media', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_hero_panel',
		)
	);
	$wp_customize->add_setting( 'coletivo_hero_images',
		array(
			'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
			'transport' => 'refresh', // refresh or postMessage
			'default' => json_encode( array(
				array(
					'image'=> array(
						'url' => get_template_directory_uri().'/assets/images/coletivo1.jpg',
						'id' => ''
					)
				)
			) )
		) );
	$wp_customize->add_control(
		new coletivo_Customize_Repeatable_Control(
			$wp_customize,
			'coletivo_hero_images',
			array(
				'label'     => esc_html__('Background Images', 'coletivo'),
				'description'   => '',
				'priority'     => 40,
				'section'       => 'coletivo_hero_images',
				'title_format'  => esc_html__( 'Background', 'coletivo'), // [live_title]
				'max_item'      => 5, // Maximum item can add
				'fields'    => array(
					'image' => array(
						'title' => esc_html__('Background Image', 'coletivo'),
						'type'  =>'media',
						'default' => array(
							'url' => get_template_directory_uri().'/assets/images/coletivo1.jpg',
							'id' => ''
						)
					),
				),
			)
		)
	);
	// Overlay color
	$wp_customize->add_setting( 'coletivo_hero_overlay_color',
		array(
			'sanitize_callback' => 'coletivo_sanitize_color_alpha',
			'default'           => 'rgba(0,0,0,.3)',
			'transport' => 'refresh', // refresh or postMessage
		)
	);
	$wp_customize->add_control( new coletivo_Alpha_Color_Control(
			$wp_customize,
			'coletivo_hero_overlay_color',
			array(
				'label' 		=> esc_html__('Background Overlay Color', 'coletivo'),
				'section' 		=> 'coletivo_hero_images',
				'priority'      => 130,
			)
		)
	);
    // Parallax
    $wp_customize->add_setting( 'coletivo_hero_parallax',
        array(
            'sanitize_callback' => 'coletivo_sanitize_checkbox',
            'default'           => 0,
            'transport' => 'refresh', // refresh or postMessage
        )
    );
    $wp_customize->add_control( 'coletivo_hero_parallax',
        array(
            'label' 		=> esc_html__('Enable parallax effect (apply for first BG image only)', 'coletivo'),
            'section' 		=> 'coletivo_hero_images',
            'type' 		   => 'checkbox',
            'priority'      => 50,
            'description' => '',
        )
    );
	$wp_customize->add_section( 'coletivo_hero_content_layout1' ,
		array(
			'priority'    => 9,
			'title'       => esc_html__( 'Hero Content Layout', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_hero_panel',
		)
	);
	// Hero Layout
	$wp_customize->add_setting( 'coletivo_hero_layout',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '1',
		)
	);
	$wp_customize->add_control( 'coletivo_hero_layout',
		array(
			'label' 		=> esc_html__('Display Layout', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1',
			'description'   => '',
			'type'          => 'select',
			'choices'       => array(
				'1' => esc_html__('Layout 1', 'coletivo' ),
				'2' => esc_html__('Layout 2', 'coletivo' ),
			),
		)
	);
	// For Hero layout ------------------------
	// Large Text
	$wp_customize->add_setting( 'coletivo_hcl1_largetext',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'mod' 				=> 'html',
			'default'           => __('We are <span class="js-rotating">coletivo | One Page | Responsive | Perfection</span>', 'coletivo'),
		)
	);
	$wp_customize->add_control( new coletivo_Editor_Custom_Control(
		$wp_customize,
		'coletivo_hcl1_largetext',
		array(
			'label' 		=> esc_html__('Large Text', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1',
			'description'   => esc_html__('Text Rotating Guide: Put your rotate texts separate by "|" into <span class="js-rotating">...</span>, go to Customizer->Site Option->Animate to control rotate animation.', 'coletivo'),
		)
	));
	// Small Text
	$wp_customize->add_setting( 'coletivo_hcl1_smalltext',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'			=> __('Morbi tempus porta nunc <strong>pharetra quisque</strong> ligula imperdiet posuere<br> vitae felis proin sagittis leo ac tellus blandit sollicitudin quisque vitae placerat.', 'coletivo'),
		)
	);
	$wp_customize->add_control( new coletivo_Editor_Custom_Control(
		$wp_customize,
		'coletivo_hcl1_smalltext',
		array(
			'label' 		=> esc_html__('Small Text', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1',
			'mod' 				=> 'html',
			'description'   => esc_html__('You can use text rotate slider in this textarea too.', 'coletivo'),
		)
	));
	// Button #1 Text
	$wp_customize->add_setting( 'coletivo_hcl1_btn1_text',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('About Us', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_hcl1_btn1_text',
		array(
			'label' 		=> esc_html__('Button #1 Text', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1'
		)
	);
	// Button #1 Link
	$wp_customize->add_setting( 'coletivo_hcl1_btn1_link',
		array(
			'sanitize_callback' => 'esc_url',
			'default'           => esc_url( home_url( '/' )).esc_html__('#about', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_hcl1_btn1_link',
		array(
			'label' 		=> esc_html__('Button #1 Link', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1'
		)
	);
    // Button #1 Style
	$wp_customize->add_setting( 'coletivo_hcl1_btn1_style',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => 'btn-theme-primary',
		)
	);
	$wp_customize->add_control( 'coletivo_hcl1_btn1_style',
		array(
			'label' 		=> esc_html__('Button #1 style', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1',
            'type'          => 'select',
            'choices' => array(
                    'btn-theme-primary' => esc_html__('Button Primary', 'coletivo'),
                    'btn-secondary-outline' => esc_html__('Button Secondary', 'coletivo'),
                    'btn-default' => esc_html__('Button', 'coletivo'),
                    'btn-primary' => esc_html__('Primary', 'coletivo'),
                    'btn-success' => esc_html__('Success', 'coletivo'),
                    'btn-info' => esc_html__('Info', 'coletivo'),
                    'btn-warning' => esc_html__('Warning', 'coletivo'),
                    'btn-danger' => esc_html__('Danger', 'coletivo'),
            )
		)
	);
	// Button #2 Text
	$wp_customize->add_setting( 'coletivo_hcl1_btn2_text',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('Get Started', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_hcl1_btn2_text',
		array(
			'label' 		=> esc_html__('Button #2 Text', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1'
		)
	);
	// Button #2 Link
	$wp_customize->add_setting( 'coletivo_hcl1_btn2_link',
		array(
			'sanitize_callback' => 'esc_url',
			'default'           => esc_url( home_url( '/' )).esc_html__('#contact', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_hcl1_btn2_link',
		array(
			'label' 		=> esc_html__('Button #2 Link', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1'
		)
	);
    // Button #1 Style
    $wp_customize->add_setting( 'coletivo_hcl1_btn2_style',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => 'btn-secondary-outline',
        )
    );
    $wp_customize->add_control( 'coletivo_hcl1_btn2_style',
        array(
            'label' 		=> esc_html__('Button #1 style', 'coletivo'),
            'section' 		=> 'coletivo_hero_content_layout1',
            'type'          => 'select',
            'choices' => array(
                'btn-theme-primary' => esc_html__('Button Primary', 'coletivo'),
                'btn-secondary-outline' => esc_html__('Button Secondary', 'coletivo'),
                'btn-default' => esc_html__('Button', 'coletivo'),
                'btn-primary' => esc_html__('Primary', 'coletivo'),
                'btn-success' => esc_html__('Success', 'coletivo'),
                'btn-info' => esc_html__('Info', 'coletivo'),
                'btn-warning' => esc_html__('Warning', 'coletivo'),
                'btn-danger' => esc_html__('Danger', 'coletivo'),
            )
        )
    );
	/* Layout 2 ---- */
	// Layout 22 content text
	$wp_customize->add_setting( 'coletivo_hcl2_content',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'mod' 				=> 'html',
			'default'           =>  wp_kses_post( '<h1>Business Website'."\n".'Made Simple.</h1>'."\n".'We provide creative solutions to clients around the world,'."\n".'creating things that get attention and meaningful.'."\n\n".'<a class="btn btn-secondary-outline btn-lg" href="#">Get Started</a>' ),
		)
	);
	$wp_customize->add_control( new coletivo_Editor_Custom_Control(
		$wp_customize,
		'coletivo_hcl2_content',
		array(
			'label' 		=> esc_html__('Content Text', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1',
			'description'   => '',
		)
	));
	// Layout 2 image
	$wp_customize->add_setting( 'coletivo_hcl2_image',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'mod' 				=> 'html',
			'default'           =>  get_template_directory_uri().'/assets/images/coletivo_responsive.png',
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'coletivo_hcl2_image',
		array(
			'label' 		=> esc_html__('Image', 'coletivo'),
			'section' 		=> 'coletivo_hero_content_layout1',
			'description'   => '',
		)
	));
	/*------------------------------------------------------------------------*/
    /*  End of Section Hero
    /*------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------*/
    /*  Section: Features
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_features' ,
        array(
            'priority'        => coletivo_get_customizer_priority( 'coletivo_features' ),
            'title'           => esc_html__( 'Section: Features', 'coletivo' ),
            'description'     => '',
            'active_callback' => 'coletivo_showon_frontpage'
        )
    );
    $wp_customize->add_section( 'coletivo_features_settings' ,
        array(
            'priority'    => 3,
            'title'       => esc_html__( 'Section Settings', 'coletivo' ),
            'description' => '',
            'panel'       => 'coletivo_features',
        )
    );
    // Show Content
    $wp_customize->add_setting( 'coletivo_features_disable',
        array(
            'sanitize_callback' => 'coletivo_sanitize_checkbox',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'coletivo_features_disable',
        array(
            'type'        => 'checkbox',
            'label'       => esc_html__('Hide this section?', 'coletivo'),
            'section'     => 'coletivo_features_settings',
            'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
        )
    );
    // Section ID
    $wp_customize->add_setting( 'coletivo_features_id',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => esc_html__('features', 'coletivo'),
        )
    );
    $wp_customize->add_control( 'coletivo_features_id',
        array(
            'label' 		=> esc_html__('Section ID:', 'coletivo'),
            'section' 		=> 'coletivo_features_settings',
            'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
        )
    );
    // Title
    $wp_customize->add_setting( 'coletivo_features_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => esc_html__('Features', 'coletivo'),
        )
    );
    $wp_customize->add_control( 'coletivo_features_title',
        array(
            'label' 		=> esc_html__('Section Title', 'coletivo'),
            'section' 		=> 'coletivo_features_settings',
            'description'   => '',
        )
    );
    // Sub Title
    $wp_customize->add_setting( 'coletivo_features_subtitle',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => esc_html__('Section subtitle', 'coletivo'),
        )
    );
    $wp_customize->add_control( 'coletivo_features_subtitle',
        array(
            'label' 		=> esc_html__('Section Subtitle', 'coletivo'),
            'section' 		=> 'coletivo_features_settings',
            'description'   => '',
        )
    );
    // Description
    $wp_customize->add_setting( 'coletivo_features_desc',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new coletivo_Editor_Custom_Control(
        $wp_customize,
        'coletivo_features_desc',
        array(
            'label' 		=> esc_html__('Section Description', 'coletivo'),
            'section' 		=> 'coletivo_features_settings',
            'description'   => '',
        )
    ));
    // Features layout
    $wp_customize->add_setting( 'coletivo_features_layout',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '3',
        )
    );
    $wp_customize->add_control( 'coletivo_features_layout',
        array(
            'label' 		=> esc_html__('Features Layout Setting', 'coletivo'),
            'section' 		=> 'coletivo_features_settings',
            'description'   => '',
            'type'          => 'select',
            'choices'       => array(
                '3' => esc_html__( '4 Columns', 'coletivo' ),
                '4' => esc_html__( '3 Columns', 'coletivo' ),
                '6' => esc_html__( '2 Columns', 'coletivo' ),
            ),
        )
    );
    $wp_customize->add_section( 'coletivo_features_content' ,
        array(
            'priority'    => 6,
            'title'       => esc_html__( 'Section Content', 'coletivo' ),
            'description' => '',
            'panel'       => 'coletivo_features',
        )
    );
    // Order & Styling
    $wp_customize->add_setting(
        'coletivo_features_boxes',
        array(
            //'default' => '',
            'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
            'transport' => 'refresh', // refresh or postMessage
        ) );
    $wp_customize->add_control(
        new coletivo_Customize_Repeatable_Control(
            $wp_customize,
            'coletivo_features_boxes',
            array(
                'label' 		=> esc_html__('Features content', 'coletivo'),
                'description'   => '',
                'section'       => 'coletivo_features_content',
                'live_title_id' => 'title', // apply for unput text and textarea only
                'title_format'  => esc_html__('[live_title]', 'coletivo'), // [live_title]
                'max_item'      => 12, // Maximum item can add
                'limited_msg' 	=> esc_html__( 'Only 12 features allowed', 'coletivo' ),
                'fields'    => array(
                    'title'  => array(
                        'title' => esc_html__('Title', 'coletivo'),
                        'type'  =>'text',
                    ),
					'icon_type'  => array(
						'title' => esc_html__('Custom icon', 'coletivo'),
						'type'  =>'select',
						'options' => array(
							'icon' => esc_html__('Icon', 'coletivo'),
							'image' => esc_html__('image', 'coletivo'),
						),
					),
                    'icon'  => array(
                        'title' => esc_html__('Icon', 'coletivo'),
                        'type'  =>'icon',
						'required' => array( 'icon_type', '=', 'icon' ),
                    ),
					'image'  => array(
						'title' => esc_html__('Image', 'coletivo'),
						'type'  =>'media',
						'required' => array( 'icon_type', '=', 'image' ),
					),
                    'desc'  => array(
                        'title' => esc_html__('Description', 'coletivo'),
                        'type'  =>'editor',
                    ),
                    'link'  => array(
                        'title' => esc_html__('Custom Link', 'coletivo'),
                        'type'  =>'text',
                    ),
                ),
            )
        )
    );
	/*------------------------------------------------------------------------*/
    /*  End of Section Features
    /*------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------*/
	/*  Section: Your Slider
	/*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_yourslider' ,
        array(
            'priority'        => coletivo_get_customizer_priority( 'coletivo_yourslider' ),
            'title'           => esc_html__( 'Section: Your Slider', 'coletivo' ),
            'description'     => '',
            'active_callback' => 'coletivo_showon_frontpage'
        )
    );
    $wp_customize->add_section( 'coletivo_yourslider_settings' ,
        array(
            'priority'    => 3,
            'title'       => esc_html__( 'Section Settings', 'coletivo' ),
            'description' => '',
            'panel'       => 'coletivo_yourslider',
        )
    );
    // Show Content
    $wp_customize->add_setting( 'coletivo_yourslider_disable',
        array(
            'sanitize_callback' => 'coletivo_sanitize_checkbox',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'coletivo_yourslider_disable',
        array(
            'type'        => 'checkbox',
            'label'       => esc_html__('Hide this section?', 'coletivo'),
            'section'     => 'coletivo_yourslider_settings',
            'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
        )
    );
    // Section ID
    $wp_customize->add_setting( 'coletivo_yourslider_id',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => esc_html__('yourslider', 'coletivo'),
        )
    );
    $wp_customize->add_control( 'coletivo_yourslider_id',
        array(
            'label' 		=> esc_html__('Section ID:', 'coletivo'),
            'section' 		=> 'coletivo_yourslider_settings',
            'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
        )
    );
    $wp_customize->add_section( 'coletivo_yourslider_content' ,
        array(
            'priority'    => 6,
            'title'       => esc_html__( 'Section Content', 'coletivo' ),
            'description' => '',
            'panel'       => 'coletivo_yourslider',
        )
    );
    // Title
    $wp_customize->add_setting( 'coletivo_yourslider_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => esc_html__('Your Slider', 'coletivo'),
        )
    );
    $wp_customize->add_control( 'coletivo_yourslider_title',
        array(
            'label' 		=> esc_html__('Section Title', 'coletivo'),
            'section' 		=> 'coletivo_yourslider_content',
            'description'   => '',
        )
    );
    // Sub Title
    $wp_customize->add_setting( 'coletivo_yourslider_subtitle',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => esc_html__('See all we Do', 'coletivo'),
        )
    );
    $wp_customize->add_control( 'coletivo_yourslider_subtitle',
        array(
            'label' 		=> esc_html__('Section Subtitle', 'coletivo'),
            'section' 		=> 'coletivo_yourslider_content',
            'description'   => '',
        )
    );
    // Description
    $wp_customize->add_setting( 'coletivo_yourslider_shortcode',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
	$wp_customize->add_control( 'coletivo_yourslider_shortcode',
		array(
			'label'     	=> esc_html__('Slider Shortcode', 'coletivo'),
			'section' 		=> 'coletivo_yourslider_content',
			'description' => __( 'In order to display a Slider install the plugin of your preference and then copy the shortcode and paste it here, the shortcode will be like this <code>[metaslider id=XXX]</code> or this <code>[brasa_slider id="123"]</code>', 'coletivo' )
		)
	);

	/*------------------------------------------------------------------------*/
    /*  End of Section Your Slider
    /*------------------------------------------------------------------------*/
   	/*------------------------------------------------------------------------*/
    /*  Section: Featured Page
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_featuredpage' ,
		array(
			'priority'    => coletivo_get_customizer_priority( 'coletivo_featuredpage' ),
			'title'           => esc_html__( 'Section: Page Featured', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	$wp_customize->add_section( 'coletivo_featuredpage_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_featuredpage',
		)
	);
	// Show Content
	$wp_customize->add_setting( 'coletivo_featuredpage_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_featuredpage_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide this section?', 'coletivo'),
			'section'     => 'coletivo_featuredpage_settings',
			'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
		)
	);
	// Title
    $wp_customize->add_setting( 'coletivo_featuredpage_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'coletivo_featuredpage_title',
        array(
            'label' 		=> esc_html__('Title section in customizer', 'coletivo'),
            'section' 		=> 'coletivo_featuredpage_settings',
            'description'   => esc_html__( 'This title is only showed in customizer', 'coletivo'),
        )
    );

	// Section ID
	$wp_customize->add_setting( 'coletivo_featuredpage_id',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('featuredpage', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_featuredpage_id',
		array(
			'label' 		=> esc_html__('Section ID:', 'coletivo'),
			'section' 		=> 'coletivo_featuredpage_settings',
			'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
		)
	);
	$wp_customize->add_section( 'coletivo_featuredpage_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'coletivo' ),
			'panel'       => 'coletivo_featuredpage',
		)
	);
	// Select Page
	$wp_customize->add_setting('coletivo_featuredpage_content',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
	$wp_customize->add_control( 'coletivo_featuredpage_content',
			array(
				'label' 		=> esc_html__('Featured Page', 'coletivo'),
				'section'       => 'coletivo_featuredpage_content',
				'description' => esc_html__( 'You need to select a Featured Image for a background in full size.', 'coletivo' ),
				'type'     => 'select',
				'choices' => $option_pages,
				'fields'    => array(
					'options' => $option_pages
					)
		) );
    // Featured page content source
    $wp_customize->add_setting( 'coletivo_featuredpage_content_source',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => 'content',
        )
    );
    $wp_customize->add_control( 'coletivo_featuredpage_content_source',
        array(
            'label' 		=> esc_html__('Content source', 'coletivo'),
            'section' 		=> 'coletivo_featuredpage_content',
            'type'          => 'select',
            'choices'       => array(
                'content' => esc_html__( 'Full Page Content', 'coletivo' ),
                'excerpt' => esc_html__( 'Page Excerpt', 'coletivo' ),
            ),
        )
    );
    // More Button
	$wp_customize->add_setting( 'coletivo_featuredpage_more_text',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Discover', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_featuredpage_more_text',
		array(
			'label'     	=> esc_html__('Featured Page Button Text', 'coletivo'),
			'section'       => 'coletivo_featuredpage_content',
			'description'   => '',
		)
	);

	// Overlay color
	$wp_customize->add_setting( 'coletivo_featuredpage_overlay_color',
		array(
			'sanitize_callback' => 'coletivo_sanitize_color_alpha',
			'default'           => 'rgba(0,0,0,.3)',
			'transport' => 'refresh', // refresh or postMessage
		)
	);
	$wp_customize->add_control( new coletivo_Alpha_Color_Control(
			$wp_customize,
			'coletivo_featuredpage_overlay_color',
			array(
				'label' 		=> esc_html__('Background Overlay Color', 'coletivo'),
				'section' 		=> 'coletivo_featuredpage_content',
				'priority'      => 30,
			)
		)
	);
    /*------------------------------------------------------------------------*/
    /*  End of Section Featured Page
    /*------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------*/
    /*  Section: Services
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_services' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_services' ),
			'title'           => esc_html__( 'Section: Services', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	$wp_customize->add_section( 'coletivo_service_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_services',
		)
	);
	// Show Content
	$wp_customize->add_setting( 'coletivo_services_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_services_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide this section?', 'coletivo'),
			'section'     => 'coletivo_service_settings',
			'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
		)
	);
	// Section ID
	$wp_customize->add_setting( 'coletivo_services_id',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('services', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_services_id',
		array(
			'label'     => esc_html__('Section ID:', 'coletivo'),
			'section' 		=> 'coletivo_service_settings',
			'description'   => esc_html__( 'The section id, we will use this for link anchor.' , 'coletivo')
		)
	);
	// Title
	$wp_customize->add_setting( 'coletivo_services_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Our Services', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_services_title',
		array(
			'label'     => esc_html__('Section Title', 'coletivo'),
			'section' 		=> 'coletivo_service_settings',
			'description'   => '',
		)
	);
	// Sub Title
	$wp_customize->add_setting( 'coletivo_services_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Section subtitle', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_services_subtitle',
		array(
			'label'     => esc_html__('Section Subtitle', 'coletivo'),
			'section' 		=> 'coletivo_service_settings',
			'description'   => '',
		)
	);
    // Description
    $wp_customize->add_setting( 'coletivo_services_desc',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new coletivo_Editor_Custom_Control(
        $wp_customize,
        'coletivo_services_desc',
        array(
            'label' 		=> esc_html__('Section Description', 'coletivo'),
            'section' 		=> 'coletivo_service_settings',
            'description'   => '',
        )
    ));
    // Services layout
    $wp_customize->add_setting( 'coletivo_service_layout',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '6',
        )
    );
    $wp_customize->add_control( 'coletivo_service_layout',
        array(
            'label' 		=> esc_html__('Services Layout Setting', 'coletivo'),
            'section' 		=> 'coletivo_service_settings',
            'description'   => '',
            'type'          => 'select',
            'choices'       => array(
                '3' => esc_html__( '4 Columns', 'coletivo' ),
                '4' => esc_html__( '3 Columns', 'coletivo' ),
                '6' => esc_html__( '2 Columns', 'coletivo' ),
            ),
        )
    );
	$wp_customize->add_section( 'coletivo_service_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_services',
		)
	);
	// Section service content.
	$wp_customize->add_setting(
		'coletivo_services',
		array(
			'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
			'transport' => 'refresh', // refresh or postMessage
		) );
	$wp_customize->add_control(
		new coletivo_Customize_Repeatable_Control(
			$wp_customize,
			'coletivo_services',
			array(
				'label'     	=> esc_html__('Service content', 'coletivo'),
				'description'   => '',
				'section'       => 'coletivo_service_content',
				'live_title_id' => 'content_page', // apply for unput text and textarea only
				'title_format'  => esc_html__('[live_title]', 'coletivo'), // [live_title]
				'max_item'      => 12, // Maximum item can add
                'limited_msg' 	=> esc_html__( 'Only 12 Services highlights allowed ', 'coletivo' ),
				'fields'    => array(
					'icon_type'  => array(
						'title' => esc_html__('Custom icon', 'coletivo'),
						'type'  =>'select',
						'options' => array(
							'icon' => esc_html__('Icon', 'coletivo'),
							'image' => esc_html__('image', 'coletivo'),
						),
					),
					'icon'  => array(
						'title' => esc_html__('Icon', 'coletivo'),
						'type'  =>'icon',
						'required' => array( 'icon_type', '=', 'icon' ),
					),
					'image'  => array(
						'title' => esc_html__('Image', 'coletivo'),
						'type'  =>'media',
						'required' => array( 'icon_type', '=', 'image' ),
					),
					'content_page'  => array(
						'title' => esc_html__('Select a page', 'coletivo'),
						'type'  =>'select',
						'options' => $option_pages
					),
					'enable_link'  => array(
						'title' => esc_html__('Link to single page', 'coletivo'),
						'type'  =>'checkbox',
					),
				),
			)
		)
	);
	/*------------------------------------------------------------------------*/
    /*  End of Section Services
    /*------------------------------------------------------------------------*/
		/*------------------------------------------------------------------------*/
	    /*  Section: Portfolio
	    /*------------------------------------------------------------------------*/
	    $wp_customize->add_panel( 'coletivo_portfolio' ,
			array(
				'priority'        => coletivo_get_customizer_priority( 'coletivo_portfolio' ),
				'title'           => esc_html__( 'Section: Portfolio', 'coletivo' ),
				'description'     => '',
				'active_callback' => 'coletivo_is_jetpack_active'
			)
		);
		$wp_customize->add_section( 'coletivo_portfolio_settings' ,
			array(
				'priority'    => 3,
				'title'       => esc_html__( 'Section Settings', 'coletivo' ),
				'description' => '',
				'panel'       => 'coletivo_portfolio',
			)
		);
		// Show Content
		$wp_customize->add_setting( 'coletivo_portfolio_disable',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'coletivo_portfolio_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'coletivo'),
				'section'     => 'coletivo_portfolio_settings',
				'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
			)
		);
		// Section ID
		$wp_customize->add_setting( 'coletivo_portfolio_id',
			array(
				'sanitize_callback' => 'coletivo_sanitize_text',
				'default'           => esc_html__('portfolio', 'coletivo'),
			)
		);
		$wp_customize->add_control( 'coletivo_portfolio_id',
			array(
				'label'     => esc_html__('Section ID:', 'coletivo'),
				'section' 		=> 'coletivo_portfolio_settings',
				'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
			)
		);
		// Number of projects to show.
		$wp_customize->add_setting( 'coletivo_portfolio_number',
			array(
				'sanitize_callback' => 'coletivo_sanitize_number',
				'default'           => '3',
			)
		);
		$wp_customize->add_control( 'coletivo_portfolio_number',
			array(
				'label'     	=> esc_html__('Number of projects to show', 'coletivo'),
				'section' 		=> 'coletivo_portfolio_settings',
				'description'   => '',
			)
		);
		$wp_customize->add_section( 'coletivo_portfolio_content' ,
			array(
				'priority'    => 6,
				'title'       => esc_html__( 'Section Content', 'coletivo' ),
				'description' => '',
				'panel'       => 'coletivo_portfolio',
			)
		);
		// Title
		$wp_customize->add_setting( 'coletivo_portfolio_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Our Work', 'coletivo'),
			)
		);
		$wp_customize->add_control( 'coletivo_portfolio_title',
			array(
				'label'     => esc_html__('Section Title', 'coletivo'),
				'section' 		=> 'coletivo_portfolio_content',
				'description'   => '',
			)
		);
		// Sub Title
		$wp_customize->add_setting( 'coletivo_portfolio_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'coletivo'),
			)
		);
		$wp_customize->add_control( 'coletivo_portfolio_subtitle',
			array(
				'label'     => esc_html__('Section Subtitle', 'coletivo'),
				'section' 		=> 'coletivo_portfolio_content',
				'description'   => '',
			)
		);
        // Description
        $wp_customize->add_setting( 'coletivo_portfolio_desc',
            array(
                'sanitize_callback' => 'coletivo_sanitize_text',
                'default'           => '',
            )
        );
        $wp_customize->add_control( new coletivo_Editor_Custom_Control(
            $wp_customize,
            'coletivo_portfolio_desc',
            array(
                'label' 		=> esc_html__('Section Description', 'coletivo'),
                'section' 		=> 'coletivo_portfolio_content',
                'description'   => '',
            )
        ));
		// Portfolio Button
		$wp_customize->add_setting( 'coletivo_portfolio_more_link',
			array(
				'sanitize_callback' => 'esc_url',
				'default'           => '#',
			)
		);
		$wp_customize->add_control( 'coletivo_portfolio_more_link',
			array(
				'label'       => esc_html__('Portfolio Button Link', 'coletivo'),
				'section'     => 'coletivo_portfolio_content',
				'description' => esc_html__('It should be your portfolio page link.', 'coletivo' )
			)
		);
		$wp_customize->add_setting( 'coletivo_portfolio_more_text',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('See Our Portfolio', 'coletivo'),
			)
		);
		$wp_customize->add_control( 'coletivo_portfolio_more_text',
			array(
				'label'     	=> esc_html__('Portfolio Button Text', 'coletivo'),
				'section' 		=> 'coletivo_portfolio_content',
				'description'   => '',
			)
		);
		/*------------------------------------------------------------------------*/
		/*  End of Section Portfolio
		/*------------------------------------------------------------------------*/
	// jetpack section

	/*------------------------------------------------------------------------*/
	/*  Section: Video Lightbox
	/*------------------------------------------------------------------------*/
	$wp_customize->add_panel( 'coletivo_videolightbox' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_videolightbox' ),
			'title'           => esc_html__( 'Section: Video Lightbox', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
    $wp_customize->add_section( 'coletivo_videolightbox_settings' ,
        array(
            'priority'    => 3,
            'title'       => esc_html__( 'Section Settings', 'coletivo' ),
            'description' => '',
            'panel'       => 'coletivo_videolightbox',
        )
    );
    // Show Content
    $wp_customize->add_setting( 'coletivo_videolightbox_disable',
        array(
            'sanitize_callback' => 'coletivo_sanitize_checkbox',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'coletivo_videolightbox_disable',
        array(
            'type'        => 'checkbox',
            'label'       => esc_html__('Hide this section?', 'coletivo'),
            'section'     => 'coletivo_videolightbox_settings',
            'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
        )
    );
    // Title
    $wp_customize->add_setting( 'coletivo_videolightbox_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'coletivo_videolightbox_section_title',
        array(
            'label'         => esc_html__('Title section in customizer', 'coletivo'),
            'section'       => 'coletivo_videolightbox_settings',
            'description'   => esc_html__( 'This title is only showed in customizer', 'coletivo'),
        )
    );
    // Section ID
    $wp_customize->add_setting( 'coletivo_videolightbox_id',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => 'videolightbox',
        )
    );
    $wp_customize->add_control( 'coletivo_videolightbox_id',
        array(
            'label' 		=> esc_html__('Section ID:', 'coletivo'),
            'section' 		=> 'coletivo_videolightbox_settings',
            'description'   => esc_html__('The section id, we will use this for link anchor.', 'coletivo' )
        )
    );
    // Title
    $wp_customize->add_setting( 'coletivo_videolightbox_title',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new coletivo_Editor_Custom_Control(
        $wp_customize,
        'coletivo_videolightbox_title',
        array(
            'label'     	=>  esc_html__('Section heading', 'coletivo'),
            'section' 		=> 'coletivo_videolightbox_settings',
            'description'   => '',
        )
    ));
    // Video URL
    $wp_customize->add_setting( 'coletivo_videolightbox_url',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'coletivo_videolightbox_url',
        array(
            'label' 		=> esc_html__('Video url', 'coletivo'),
            'section' 		=> 'coletivo_videolightbox_settings',
            'description'   =>  esc_html__('Paste Youtube or Vimeo url here', 'coletivo'),
        )
    );
    // Parallax image
    $wp_customize->add_setting( 'coletivo_videolightbox_image',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'coletivo_videolightbox_image',
        array(
            'label' 		=> esc_html__('Background image', 'coletivo'),
            'section' 		=> 'coletivo_videolightbox_settings',
        )
    ));
		/*------------------------------------------------------------------------*/
		/*  Section: Gallery
	    /*------------------------------------------------------------------------*/
		$wp_customize->add_panel( 'coletivo_gallery' ,
			array(
				'priority'        => coletivo_get_customizer_priority( 'coletivo_gallery' ),
				'title'           => esc_html__( 'Section: Gallery', 'coletivo' ),
				'description'     => '',
				'active_callback' => 'coletivo_showon_frontpage'
			)
		);
		$wp_customize->add_section( 'coletivo_gallery_settings' ,
			array(
				'priority'    => 3,
				'title'       => esc_html__( 'Section Settings', 'coletivo' ),
				'description' => '',
				'panel'       => 'coletivo_gallery',
			)
		);
		// Show Content
		$wp_customize->add_setting( 'coletivo_gallery_disable',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => 1,
			)
		);
		$wp_customize->add_control( 'coletivo_gallery_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'coletivo'),
				'section'     => 'coletivo_gallery_settings',
				'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
			)
		);
		// Section ID
		$wp_customize->add_setting( 'coletivo_gallery_id',
			array(
				'sanitize_callback' => 'coletivo_sanitize_text',
				'default'           => esc_html__('gallery', 'coletivo'),
			)
		);
		$wp_customize->add_control( 'coletivo_gallery_id',
			array(
				'label'     => esc_html__('Section ID:', 'coletivo'),
				'section' 		=> 'coletivo_gallery_settings',
				'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
			)
		);
		// Title
		$wp_customize->add_setting( 'coletivo_gallery_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Gallery', 'coletivo'),
			)
		);
		$wp_customize->add_control( 'coletivo_gallery_title',
			array(
				'label'     => esc_html__('Section Title', 'coletivo'),
				'section' 		=> 'coletivo_gallery_settings',
				'description'   => '',
			)
		);
		// Sub Title
		$wp_customize->add_setting( 'coletivo_gallery_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'coletivo'),
			)
		);
		$wp_customize->add_control( 'coletivo_gallery_subtitle',
			array(
				'label'     => esc_html__('Section Subtitle', 'coletivo'),
				'section' 		=> 'coletivo_gallery_settings',
				'description'   => '',
			)
		);
		// Description
		$wp_customize->add_setting( 'coletivo_gallery_desc',
			array(
				'sanitize_callback' => 'coletivo_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( new coletivo_Editor_Custom_Control(
			$wp_customize,
			'coletivo_gallery_desc',
			array(
				'label' 		=> esc_html__('Section Description', 'coletivo'),
				'section' 		=> 'coletivo_gallery_settings',
				'description'   => '',
			)
		));
		$wp_customize->add_section( 'coletivo_gallery_content' ,
			array(
				'priority'    => 6,
				'title'       => esc_html__( 'Section Content', 'coletivo' ),
				'description' => '',
				'panel'       => 'coletivo_gallery',
			)
		);
		// Source page settings
		$wp_customize->add_setting( 'coletivo_gallery_source_page',
			array(
				'sanitize_callback' => 'coletivo_sanitize_number',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'coletivo_gallery_source_page',
			array(
				'label'     	=> esc_html__('Select Gallery Page', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'type'          => 'select',
				'priority'      => 10,
				'choices'       => $option_pages,
				'description'   => esc_html__('Select a page which have content contain [gallery] shortcode.', 'coletivo'),
			)
		);
		// Gallery Layout
		$wp_customize->add_setting( 'coletivo_gallery_layout',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'default',
			)
		);
		$wp_customize->add_control( 'coletivo_gallery_layout',
			array(
				'label'     	=> esc_html__('Layout', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'type'          => 'select',
				'priority'      => 40,
				'choices'       => array(
					'default'      => esc_html__('Default, inside container', 'coletivo'),
					'full-width'  => esc_html__('Full Width', 'coletivo'),
				)
			)
		);
		// Gallery Display
		$wp_customize->add_setting( 'coletivo_gallery_display',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'default',
			)
		);
		$wp_customize->add_control( 'coletivo_gallery_display',
			array(
				'label'     	=> esc_html__('Display', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'type'          => 'select',
				'priority'      => 50,
				'choices'       => array(
					'grid'      => esc_html__('Grid', 'coletivo'),
					'carousel'    => esc_html__('Carousel', 'coletivo'),
					'slider'      => esc_html__('Slider', 'coletivo'),
					'justified'   => esc_html__('Justified', 'coletivo'),
				)
			)
		);
		// Gallery grid spacing
		$wp_customize->add_setting( 'coletivo_g_spacing',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 20,
			)
		);
		$wp_customize->add_control( 'coletivo_g_spacing',
			array(
				'label'     	=> esc_html__('Item Spacing', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'priority'      => 55,
			)
		);
		// Gallery grid spacing
		$wp_customize->add_setting( 'coletivo_g_row_height',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 120,
			)
		);
		$wp_customize->add_control( 'coletivo_g_row_height',
			array(
				'label'     	=> esc_html__('Row Height', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'priority'      => 57,
			)
		);
		// Gallery grid gird col
		$wp_customize->add_setting( 'coletivo_g_col',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '4',
			)
		);
		$wp_customize->add_control( 'coletivo_g_col',
			array(
				'label'     	=> esc_html__('Layout columns', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'priority'      => 60,
				'type'          => 'select',
				'choices'       => array(
					'1'      => 1,
					'2'      => 2,
					'3'      => 3,
					'4'      => 4,
					'5'      => 5,
					'6'      => 6,
				)
			)
		);
		// Gallery max number
		$wp_customize->add_setting( 'coletivo_g_number',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 10,
			)
		);
		$wp_customize->add_control( 'coletivo_g_number',
			array(
				'label'     	=> esc_html__('Number items', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'priority'      => 65,
			)
		);
		// Gallery grid spacing
		$wp_customize->add_setting( 'coletivo_g_lightbox',
			array(
				'sanitize_callback' => 'coletivo_sanitize_checkbox',
				'default'           => 1,
			)
		);
		$wp_customize->add_control( 'coletivo_g_lightbox',
			array(
				'label'     	=> esc_html__('Enable Lightbox', 'coletivo'),
				'section' 		=> 'coletivo_gallery_content',
				'priority'      => 70,
				'type'          => 'checkbox',
			)
		);
	    // Gallery readmore link
	    $wp_customize->add_setting( 'coletivo_g_readmore_link',
	        array(
	            'sanitize_callback' => 'sanitize_text_field',
	            'default'           => '',
	        )
	    );
	    $wp_customize->add_control( 'coletivo_g_readmore_link',
	        array(
	            'label'     	=> esc_html__('Read More Link', 'coletivo'),
	            'section' 		=> 'coletivo_gallery_content',
	            'priority'      => 90,
	            'type'          => 'text',
	        )
	    );
	    $wp_customize->add_setting( 'coletivo_g_readmore_text',
	        array(
	            'sanitize_callback' => 'sanitize_text_field',
	            'default'           => esc_html__('View More', 'coletivo'),
	        )
	    );
	    $wp_customize->add_control( 'coletivo_g_readmore_text',
	        array(
	            'label'     	=> esc_html__('Read More Text', 'coletivo'),
	            'section' 		=> 'coletivo_gallery_content',
	            'priority'      => 100,
	            'type'          => 'text',
	        )
	    );
    // jetpack section
    /*------------------------------------------------------------------------*/
    /*  End of Section Gallery
    /*------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------*/
    /*  Section: Team
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_team' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_team' ),
			'title'           => esc_html__( 'Section: Team', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	$wp_customize->add_section( 'coletivo_team_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_team',
		)
	);
	// Show Content
	$wp_customize->add_setting( 'coletivo_team_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_team_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide this section?', 'coletivo'),
			'section'     => 'coletivo_team_settings',
			'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
		)
	);
	// Section ID
	$wp_customize->add_setting( 'coletivo_team_id',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('team', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_team_id',
		array(
			'label'     	=> esc_html__('Section ID:', 'coletivo'),
			'section' 		=> 'coletivo_team_settings',
			'description'   => esc_html__( 'The section id, we will use this for link anchor.' , 'coletivo')
		)
	);
	// Title
	$wp_customize->add_setting( 'coletivo_team_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Our Team', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_team_title',
		array(
			'label'    		=> esc_html__('Section Title', 'coletivo'),
			'section' 		=> 'coletivo_team_settings',
			'description'   => '',
		)
	);
	// Sub Title
	$wp_customize->add_setting( 'coletivo_team_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Section subtitle', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_team_subtitle',
		array(
			'label'     => esc_html__('Section Subtitle', 'coletivo'),
			'section' 		=> 'coletivo_team_settings',
			'description'   => '',
		)
	);
    // Description
    $wp_customize->add_setting( 'coletivo_team_desc',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new coletivo_Editor_Custom_Control(
        $wp_customize,
        'coletivo_team_desc',
        array(
            'label' 		=> esc_html__('Section Description', 'coletivo'),
            'section' 		=> 'coletivo_team_settings',
            'description'   => '',
        )
    ));
    // Team layout
    $wp_customize->add_setting( 'coletivo_team_layout',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '3',
        )
    );
    $wp_customize->add_control( 'coletivo_team_layout',
        array(
            'label' 		=> esc_html__('Team Layout Setting', 'coletivo'),
            'section' 		=> 'coletivo_team_settings',
            'description'   => '',
            'type'          => 'select',
            'choices'       => array(
				'3' => esc_html__( '4 Columns', 'coletivo' ),
				'4' => esc_html__( '3 Columns', 'coletivo' ),
				'6' => esc_html__( '2 Columns', 'coletivo' ),
            ),
        )
    );
	$wp_customize->add_section( 'coletivo_team_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_team',
		)
	);
	// Team member settings
	$wp_customize->add_setting(
		'coletivo_team_members',
		array(
			'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
			'transport' => 'refresh', // refresh or postMessage
		) );
	$wp_customize->add_control(
		new coletivo_Customize_Repeatable_Control(
			$wp_customize,
			'coletivo_team_members',
			array(
				'label'     => esc_html__('Team members', 'coletivo'),
				'description'   => '',
				'section'       => 'coletivo_team_content',
				//'live_title_id' => 'user_id', // apply for unput text and textarea only
				'title_format'  => esc_html__( '[live_title]', 'coletivo'), // [live_title]
				'max_item'      => 12, // Maximum item can add
                'limited_msg' 	=> esc_html__( 'Only 12 members allowed', 'coletivo' ),
                'fields'    => array(
					'user_id' => array(
						'title' => esc_html__('User media', 'coletivo'),
						'type'  =>'media',
						'desc'  => '',
					),
                    'link' => array(
                        'title' => esc_html__('Custom Link', 'coletivo'),
                        'type'  =>'text',
                        'desc'  => '',
                    ),
				),
			)
		)
	);
	/*------------------------------------------------------------------------*/
    /*  Section: News
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_news' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_news' ),
			'title'           => esc_html__( 'Section: News', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	$wp_customize->add_section( 'coletivo_news_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_news',
		)
	);
	// Show Content
	$wp_customize->add_setting( 'coletivo_news_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_news_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide this section?', 'coletivo'),
			'section'     => 'coletivo_news_settings',
			'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
		)
	);
	// Section ID
	$wp_customize->add_setting( 'coletivo_news_id',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('news', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_news_id',
		array(
			'label'     => esc_html__('Section ID:', 'coletivo'),
			'section' 		=> 'coletivo_news_settings',
			'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
		)
	);
	// Title
	$wp_customize->add_setting( 'coletivo_news_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Latest News', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_news_title',
		array(
			'label'     => esc_html__('Section Title', 'coletivo'),
			'section' 		=> 'coletivo_news_settings',
			'description'   => '',
		)
	);
	// Sub Title
	$wp_customize->add_setting( 'coletivo_news_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Section subtitle', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_news_subtitle',
		array(
			'label'     => esc_html__('Section Subtitle', 'coletivo'),
			'section' 		=> 'coletivo_news_settings',
			'description'   => '',
		)
	);
    // Description
    $wp_customize->add_setting( 'coletivo_news_desc',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new coletivo_Editor_Custom_Control(
        $wp_customize,
        'coletivo_news_desc',
        array(
            'label' 		=> esc_html__('Section Description', 'coletivo'),
            'section' 		=> 'coletivo_news_settings',
            'description'   => '',
        )
    ));
	// hr
	$wp_customize->add_setting( 'coletivo_news_settings_hr',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
		)
	);
	$wp_customize->add_control( new coletivo_Misc_Control( $wp_customize, 'coletivo_news_settings_hr',
		array(
			'section'     => 'coletivo_news_settings',
			'type'        => 'hr'
		)
	));
	// Number of post to show.
	$wp_customize->add_setting( 'coletivo_news_number',
		array(
			'sanitize_callback' => 'coletivo_sanitize_number',
			'default'           => '3',
		)
	);
	$wp_customize->add_control( 'coletivo_news_number',
		array(
			'label'     	=> esc_html__('Number of post to show', 'coletivo'),
			'section' 		=> 'coletivo_news_settings',
			'description'   => '',
		)
	);
	// Blog Button
	$wp_customize->add_setting( 'coletivo_news_more_link',
		array(
			'sanitize_callback' => 'esc_url',
			'default'           => '#',
		)
	);
	$wp_customize->add_control( 'coletivo_news_more_link',
		array(
			'label'       => esc_html__('More News button link', 'coletivo'),
			'section'     => 'coletivo_news_settings',
			'description' => esc_html__(  'It should be your blog page link.', 'coletivo' )
		)
	);
	$wp_customize->add_setting( 'coletivo_news_more_text',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Read Our Blog', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_news_more_text',
		array(
			'label'     	=> esc_html__('More News Button Text', 'coletivo'),
			'section' 		=> 'coletivo_news_settings',
			'description'   => '',
		)
	);
	/*------------------------------------------------------------------------*/
    /*  Section: Contact
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_contact' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_contact' ),
			'title'           => esc_html__( 'Section: Contact', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	$wp_customize->add_section( 'coletivo_contact_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_contact',
		)
	);
	// Show Content
	$wp_customize->add_setting( 'coletivo_contact_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide this section?', 'coletivo'),
			'section'     => 'coletivo_contact_settings',
			'description' => esc_html__('Check this box to hide this section.', 'coletivo'),
		)
	);
	// Show Form
	$wp_customize->add_setting( 'coletivo_contact_cf7_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_cf7_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide contact form completely.', 'coletivo'),
			'section'     => 'coletivo_contact_settings',
			'description' => esc_html__('Check this box to hide contact form.', 'coletivo'),
		)
	);
	// Section ID
	$wp_customize->add_setting( 'coletivo_contact_id',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__('contact', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_contact_id',
		array(
			'label'     => esc_html__('Section ID:', 'coletivo'),
			'section' 		=> 'coletivo_contact_settings',
			'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
		)
	);
	// Title
	$wp_customize->add_setting( 'coletivo_contact_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Get in touch', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_contact_title',
		array(
			'label'     => esc_html__('Section Title', 'coletivo'),
			'section' 		=> 'coletivo_contact_settings',
			'description'   => '',
		)
	);
	// Sub Title
	$wp_customize->add_setting( 'coletivo_contact_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__('Section subtitle', 'coletivo'),
		)
	);
	$wp_customize->add_control( 'coletivo_contact_subtitle',
		array(
			'label'     => esc_html__('Section Subtitle', 'coletivo'),
			'section' 		=> 'coletivo_contact_settings',
			'description'   => '',
		)
	);
    // Description
    $wp_customize->add_setting( 'coletivo_contact_desc',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new coletivo_Editor_Custom_Control(
        $wp_customize,
        'coletivo_contact_desc',
        array(
            'label' 		=> esc_html__('Section Description', 'coletivo'),
            'section' 		=> 'coletivo_contact_settings',
            'description'   => '',
        )
    ));
	$wp_customize->add_section( 'coletivo_contact_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_contact',
		)
	);
	// Contact form guide.
	$wp_customize->add_setting( 'coletivo_contact_cf7_guide',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text'
		)
	);
	$wp_customize->add_control( new coletivo_Misc_Control( $wp_customize, 'coletivo_contact_cf7_guide',
		array(
			'section'     => 'coletivo_contact_content',
			'type'        => 'custom_message',
			'description' => __( 'In order to display a contact form install a plugin and then copy the shortcode and paste it here, the shortcode will be like this <code>[contact-form][contact-field...][/contact-form]</code>', 'coletivo' )
		)
	));
	// Contact Form Shortcode
	$wp_customize->add_setting( 'coletivo_contact_cf7',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_cf7',
		array(
			'label'     	=> esc_html__('Contact Form Shortcode', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => '',
		)
	);

	// hr
	$wp_customize->add_setting( 'coletivo_contact_text_hr', array( 'sanitize_callback' => 'coletivo_sanitize_text' ) );
	$wp_customize->add_control( new coletivo_Misc_Control( $wp_customize, 'coletivo_contact_text_hr',
		array(
			'section'     => 'coletivo_contact_content',
			'type'        => 'hr'
		)
	));
	// Contact Text

	$wp_customize->add_setting( 'coletivo_contact_address_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_address_title',
		array(
			'label'     	=> esc_html__('Contact Box Title', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => '',
		)
	);
	$wp_customize->add_setting( 'coletivo_contact_text',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( new coletivo_Editor_Custom_Control(
		$wp_customize,
		'coletivo_contact_text',
		array(
			'label'     	=> esc_html__('Contact Text', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => '',
		)
	));
	// Address Box
	// Contact Address
	$wp_customize->add_setting( 'coletivo_contact_address',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_address',
		array(
			'label'     => esc_html__('Address', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => '',
		)
	);
	// Contact Phone
	$wp_customize->add_setting( 'coletivo_contact_phone',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_phone',
		array(
			'label'     	=> esc_html__('Phone', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => '',
		)
	);
	// Contact What's app
	$wp_customize->add_setting( 'coletivo_contact_whats',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_whats',
		array(
			'label'     	=> esc_html__('What´s App', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => '',
		)
	);
	// Contact Email
	$wp_customize->add_setting( 'coletivo_contact_email',
		array(
			'sanitize_callback' => 'sanitize_email',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_email',
		array(
			'label'     	=> esc_html__('Email', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => '',
		)
	);
	// Contact Social Networks
	$wp_customize->add_setting( 'coletivo_contact_fb',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_fb',
		array(
			'label'     	=> esc_html__('Facebook', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => esc_html__('Enter the name of the page url after the "/" (example of url https://www.facebook.com/facebook, just put facebook)', 'coletivo')
			)
	);
	$wp_customize->add_setting( 'coletivo_contact_instagram',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_instagram',
		array(
			'label'     	=> esc_html__('Instagram', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => esc_html__('Enter your Instagram username', 'coletivo')
		)
	);
	$wp_customize->add_setting( 'coletivo_contact_twitter',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_contact_twitter',
		array(
			'label'     	=> esc_html__('Twitter', 'coletivo'),
			'section' 		=> 'coletivo_contact_content',
			'description'   => esc_html__('Enter your Twitter username', 'coletivo')
		)
	);
	/*------------------------------------------------------------------------*/
    /*  End of Section Contact
    /*------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------*/
    /*  Section: Social
    /*------------------------------------------------------------------------*/
	$wp_customize->add_panel( 'coletivo_social_panel' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_social_panel' ),
			'title'           => esc_html__( 'Section: Social', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	// Social settings
	$wp_customize->add_section( 'coletivo_social_settings' ,
		array(
			'priority'    => 1,
			'title'       => esc_html__( 'Social Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_social_panel',
		)
	);
	// Disable Social
	$wp_customize->add_setting( 'coletivo_social_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '1',
		)
	);
	$wp_customize->add_control( 'coletivo_social_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__('Hide Footer Social?', 'coletivo'),
			'section'     => 'coletivo_social_settings',
			'description' => esc_html__('Check this box to hide footer social section.', 'coletivo')
		)
	);
	$wp_customize->add_setting( 'coletivo_social_footer_guide',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text'
		)
	);
	$wp_customize->add_setting( 'coletivo_social_footer_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Keep Updated', 'coletivo' ),
			'transport'			=> 'postMessage',
		)
	);
	// Social Title
	$wp_customize->add_control( 'coletivo_social_footer_title',
		array(
			'label'       => esc_html__('Social Footer Title', 'coletivo'),
			'section'     => 'coletivo_social_settings',
			'description' => ''
		)
	);
    // Social BG color
    $wp_customize->add_setting( 'coletivo_footer_bg', array(
        'sanitize_callback' => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
        'default' => '#939393',
        'transport' => 'postMessage'
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'coletivo_footer_bg',
        array(
            'label'       => esc_html__( 'Footer Background', 'coletivo' ),
            'section'     => 'coletivo_social_settings',
            'description' => '',
        )
    ));
	$wp_customize->add_section( 'coletivo_social' ,
		array(
			'priority'    => 2,
			'title'       => esc_html__( 'Social Profiles', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_social_panel',
		)
	);
	// Custom Message
	$wp_customize->add_control( new coletivo_Misc_Control( $wp_customize, 'coletivo_social_footer_guide',
		array(
			'section'     => 'coletivo_social',
			'type'        => 'custom_message',
			'description' => esc_html__( 'These social profiles setting below will display at the footer of your site.', 'coletivo' )
		)
	));
	// Social Profiles
    $wp_customize->add_setting(
        'coletivo_social_profiles',
        array(
            //'default' => '',
            'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
            'transport' => 'postMessage', // refresh or postMessage
    ) );
    $wp_customize->add_control(
        new coletivo_Customize_Repeatable_Control(
            $wp_customize,
            'coletivo_social_profiles',
            array(
                'label' 		=> esc_html__('Socials', 'coletivo'),
                'description'   => '',
                'section'       => 'coletivo_social',
                'live_title_id' => 'network', // apply for unput text and textarea only
                'title_format'  => esc_html__('[live_title]', 'coletivo'), // [live_title]
                'max_item'      => 9, // Maximum item can add
                'limited_msg' 	=> esc_html__( 'Only 9 social networks allowed', 'coletivo' ),
                'fields'    => array(
                    'network'  => array(
                        'title' => esc_html__('Social network', 'coletivo'),
                        'type'  =>'text',
                    ),
                    'icon'  => array(
                        'title' => esc_html__('Icon', 'coletivo'),
                        'type'  =>'icon',
                    ),
                    'link'  => array(
                        'title' => esc_html__('URL', 'coletivo'),
                        'type'  =>'text',
                    ),
                ),
            )
        )
    );

	/*------------------------------------------------------------------------*/
    /*  End of Section Social
    /*------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------*/
    /*  Section: Sections
    /*------------------------------------------------------------------------*/
    $wp_customize->add_section( 'coletivo_sections_options' ,
		array(
			'priority'    => 130,
			'title'       => esc_html__( 'Sections', 'coletivo' ),
			'description' => '',
		)
	);
	// Social Profiles
    $wp_customize->add_setting(
        'coletivo_section_order',
        array(
            //'default' => '',
            'sanitize_callback' => 'coletivo_sanitize_repeatable_data_field',
            'transport' => 'refresh', // refresh or postMessage
    ) );

    $wp_customize->add_control(
        new coletivo_Customize_Repeatable_Control(
            $wp_customize,
            'coletivo_section_order',
            array(
                'label' 		=> esc_html__('Sections', 'coletivo'),
                'is_order_field'=> true,
                'description' => esc_html__('Organize with drag and drop to define sections order, open it to customize each one', 'coletivo'),
                'section'       => 'coletivo_sections_options',
                'live_title_id' => 'section_order', // apply for unput text and textarea only
                'title_format'  => __('[live_title] <a>(Edit Section)</a>', 'coletivo'), // [live_title]
                'max_item'      => 200, // Maximum item can add
                'limited_msg' 	=> '',
                'fields'    => array(),

            )
        )
    );
	// Hidden field to reorder home sections
	$wp_customize->add_setting( 'coletivo_sections_order',
		array(
			'default' => apply_filters( 'coletivo_sections_order_default_value', 'hero,features,yourslider,featuredpage,services,portfolio,videolightbox,gallery,team,news,contact,social' )
		)
	);
	$wp_customize->add_control( 'coletivo_sections_order',
		array(
			'type'			=> 'hidden',
			'section'		=> 'coletivo_sections_options'
		)
	);

	/**
	 * Hook to add other customize
	 */
	do_action( 'coletivo_customize_after_register', $wp_customize );

}

add_action( 'customize_register', 'coletivo_customize_register' );

/**
* Selective refresh
*/
require get_template_directory() . '/inc/customizer-selective-refresh.php';

/*------------------------------------------------------------------------*/
/*  coletivo Sanitize Functions.
/*------------------------------------------------------------------------*/

function coletivo_sanitize_file_url( $file_url ) {
	$output = '';
	$filetype = wp_check_filetype( $file_url );
	if ( $filetype["ext"] ) {
		$output = esc_url( $file_url );
	}
	return $output;
}

/**
 * Conditional to show more hero settings
 *
 * @param $control
 * @return bool
 */
function coletivo_hero_fullscreen_callback ( $control ) {
	if ( $control->manager->get_setting('coletivo_hero_fullscreen')->value() == '' ) {
        return true;
    } else {
        return false;
    }
}


function coletivo_sanitize_number( $input ) {
    return balanceTags( $input );
}

function coletivo_sanitize_hex_color( $color ) {
	if ( $color === '' ) {
		return '';
	}
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}
	return null;
}

function coletivo_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
		return 1;
    } else {
		return 0;
    }
}

function coletivo_sanitize_text( $string ) {
	return wp_kses_post( balanceTags( $string ) );
}

function coletivo_sanitize_html_input( $string ) {
	return wp_kses_allowed_html( $string );
}

function coletivo_showon_frontpage() {
	return is_page_template( 'template-frontpage.php' );
}

function coletivo_is_jetpack_active() {
	return is_page_template( 'template-frontpage.php' ) && class_exists( 'Jetpack' );
}
/**
 * Remove deactivated sections
 * @param array $sections
 * @return array
 */
function coletivo_remove_deactivated_sections( $sections ) {
	if ( in_array( 'portfolio', $sections ) && ! coletivo_is_jetpack_active() ) {
		$key = array_search( 'portfolio', $sections );
		unset( $sections[ $key ] );
	}
	return $sections;
}
add_filter( 'coletivo_frontpage_sections_order', 'coletivo_remove_deactivated_sections', 9999 );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function coletivo_customize_preview_js() {
    wp_enqueue_script( 'coletivo_customizer_liveview', get_template_directory_uri() . '/assets/js/customizer-liveview.js', array( 'customize-preview', 'customize-selective-refresh' ), false, true );
}
add_action( 'customize_preview_init', 'coletivo_customize_preview_js', 65 );


add_action( 'customize_controls_enqueue_scripts', 'opneress_customize_js_settings' );
function opneress_customize_js_settings(){
    if ( ! function_exists( 'coletivo_get_actions_required' ) ) {
        return;
    }
    $actions = coletivo_get_actions_required();
    $n = array_count_values( $actions );
    $number_action =  0;
    if ( $n && isset( $n['active'] ) ) {
        $number_action = $n['active'];
    }

    wp_localize_script( 'customize-controls', 'coletivo_customizer_settings', array(
        'number_action' => $number_action,
        'is_plus_activated' => class_exists( 'coletivo_PLus' ) ? 'y' : 'n',
        'action_url' => admin_url( 'themes.php?page=ft_coletivo&tab=actions_required' )
    ) );
}

/**
 * Customizer Icon picker
 */
function coletivo_customize_controls_enqueue_scripts(){
    wp_localize_script( 'customize-controls', 'C_Icon_Picker',
        apply_filters( 'c_icon_picker_js_setup',
            array(
                'search'    => esc_html__( 'Search', 'coletivo' ),
                'fonts' => array(
                    'font-awesome' => array(
                        // Name of icon
                        'name' => esc_html__( 'Font Awesome', 'coletivo' ),
                        // prefix class example for font-awesome fa-fa-{name}
                        'prefix' => 'fa',
                        // font url
                        'url' => esc_url( add_query_arg( array( 'ver'=> '4.7.0' ), get_template_directory_uri() .'/assets/css/font-awesome.min.css' ) ),
                        // Icon class name, separated by |
                        'icons' => 'fa-glass|fa-music|fa-search|fa-envelope-o|fa-heart|fa-star|fa-star-o|fa-user|fa-film|fa-th-large|fa-th|fa-th-list|fa-check|fa-times|fa-search-plus|fa-search-minus|fa-power-off|fa-signal|fa-cog|fa-trash-o|fa-home|fa-file-o|fa-clock-o|fa-road|fa-download|fa-arrow-circle-o-down|fa-arrow-circle-o-up|fa-inbox|fa-play-circle-o|fa-repeat|fa-refresh|fa-list-alt|fa-lock|fa-flag|fa-headphones|fa-volume-off|fa-volume-down|fa-volume-up|fa-qrcode|fa-barcode|fa-tag|fa-tags|fa-book|fa-bookmark|fa-print|fa-camera|fa-font|fa-bold|fa-italic|fa-text-height|fa-text-width|fa-align-left|fa-align-center|fa-align-right|fa-align-justify|fa-list|fa-outdent|fa-indent|fa-video-camera|fa-picture-o|fa-pencil|fa-map-marker|fa-adjust|fa-tint|fa-pencil-square-o|fa-share-square-o|fa-check-square-o|fa-arrows|fa-step-backward|fa-fast-backward|fa-backward|fa-play|fa-pause|fa-stop|fa-forward|fa-fast-forward|fa-step-forward|fa-eject|fa-chevron-left|fa-chevron-right|fa-plus-circle|fa-minus-circle|fa-times-circle|fa-check-circle|fa-question-circle|fa-info-circle|fa-crosshairs|fa-times-circle-o|fa-check-circle-o|fa-ban|fa-arrow-left|fa-arrow-right|fa-arrow-up|fa-arrow-down|fa-share|fa-expand|fa-compress|fa-plus|fa-minus|fa-asterisk|fa-exclamation-circle|fa-gift|fa-leaf|fa-fire|fa-eye|fa-eye-slash|fa-exclamation-triangle|fa-plane|fa-calendar|fa-random|fa-comment|fa-magnet|fa-chevron-up|fa-chevron-down|fa-retweet|fa-shopping-cart|fa-folder|fa-folder-open|fa-arrows-v|fa-arrows-h|fa-bar-chart|fa-twitter-square|fa-facebook-square|fa-camera-retro|fa-key|fa-cogs|fa-comments|fa-thumbs-o-up|fa-thumbs-o-down|fa-star-half|fa-heart-o|fa-sign-out|fa-linkedin-square|fa-thumb-tack|fa-external-link|fa-sign-in|fa-trophy|fa-github-square|fa-upload|fa-lemon-o|fa-phone|fa-square-o|fa-bookmark-o|fa-phone-square|fa-twitter|fa-facebook|fa-github|fa-unlock|fa-credit-card|fa-rss|fa-hdd-o|fa-bullhorn|fa-bell|fa-certificate|fa-hand-o-right|fa-hand-o-left|fa-hand-o-up|fa-hand-o-down|fa-arrow-circle-left|fa-arrow-circle-right|fa-arrow-circle-up|fa-arrow-circle-down|fa-globe|fa-wrench|fa-tasks|fa-filter|fa-briefcase|fa-arrows-alt|fa-users|fa-link|fa-cloud|fa-flask|fa-scissors|fa-files-o|fa-paperclip|fa-floppy-o|fa-square|fa-bars|fa-list-ul|fa-list-ol|fa-strikethrough|fa-underline|fa-table|fa-magic|fa-truck|fa-pinterest|fa-pinterest-square|fa-google-plus-square|fa-google-plus|fa-money|fa-caret-down|fa-caret-up|fa-caret-left|fa-caret-right|fa-columns|fa-sort|fa-sort-desc|fa-sort-asc|fa-envelope|fa-linkedin|fa-undo|fa-gavel|fa-tachometer|fa-comment-o|fa-comments-o|fa-bolt|fa-sitemap|fa-umbrella|fa-clipboard|fa-lightbulb-o|fa-exchange|fa-cloud-download|fa-cloud-upload|fa-user-md|fa-stethoscope|fa-suitcase|fa-bell-o|fa-coffee|fa-cutlery|fa-file-text-o|fa-building-o|fa-hospital-o|fa-ambulance|fa-medkit|fa-fighter-jet|fa-beer|fa-h-square|fa-plus-square|fa-angle-double-left|fa-angle-double-right|fa-angle-double-up|fa-angle-double-down|fa-angle-left|fa-angle-right|fa-angle-up|fa-angle-down|fa-desktop|fa-laptop|fa-tablet|fa-mobile|fa-circle-o|fa-quote-left|fa-quote-right|fa-spinner|fa-circle|fa-reply|fa-github-alt|fa-folder-o|fa-folder-open-o|fa-smile-o|fa-frown-o|fa-meh-o|fa-gamepad|fa-keyboard-o|fa-flag-o|fa-flag-checkered|fa-terminal|fa-code|fa-reply-all|fa-star-half-o|fa-location-arrow|fa-crop|fa-code-fork|fa-chain-broken|fa-question|fa-info|fa-exclamation|fa-superscript|fa-subscript|fa-eraser|fa-puzzle-piece|fa-microphone|fa-microphone-slash|fa-shield|fa-calendar-o|fa-fire-extinguisher|fa-rocket|fa-maxcdn|fa-chevron-circle-left|fa-chevron-circle-right|fa-chevron-circle-up|fa-chevron-circle-down|fa-html5|fa-css3|fa-anchor|fa-unlock-alt|fa-bullseye|fa-ellipsis-h|fa-ellipsis-v|fa-rss-square|fa-play-circle|fa-ticket|fa-minus-square|fa-minus-square-o|fa-level-up|fa-level-down|fa-check-square|fa-pencil-square|fa-external-link-square|fa-share-square|fa-compass|fa-caret-square-o-down|fa-caret-square-o-up|fa-caret-square-o-right|fa-eur|fa-gbp|fa-usd|fa-inr|fa-jpy|fa-rub|fa-krw|fa-btc|fa-file|fa-file-text|fa-sort-alpha-asc|fa-sort-alpha-desc|fa-sort-amount-asc|fa-sort-amount-desc|fa-sort-numeric-asc|fa-sort-numeric-desc|fa-thumbs-up|fa-thumbs-down|fa-youtube-square|fa-youtube|fa-xing|fa-xing-square|fa-youtube-play|fa-dropbox|fa-stack-overflow|fa-instagram|fa-flickr|fa-adn|fa-bitbucket|fa-bitbucket-square|fa-tumblr|fa-tumblr-square|fa-long-arrow-down|fa-long-arrow-up|fa-long-arrow-left|fa-long-arrow-right|fa-apple|fa-windows|fa-android|fa-linux|fa-dribbble|fa-skype|fa-foursquare|fa-trello|fa-female|fa-male|fa-gratipay|fa-sun-o|fa-moon-o|fa-archive|fa-bug|fa-vk|fa-weibo|fa-renren|fa-pagelines|fa-stack-exchange|fa-arrow-circle-o-right|fa-arrow-circle-o-left|fa-caret-square-o-left|fa-dot-circle-o|fa-wheelchair|fa-vimeo-square|fa-try|fa-plus-square-o|fa-space-shuttle|fa-slack|fa-envelope-square|fa-wordpress|fa-openid|fa-university|fa-graduation-cap|fa-yahoo|fa-google|fa-reddit|fa-reddit-square|fa-stumbleupon-circle|fa-stumbleupon|fa-delicious|fa-digg|fa-pied-piper-pp|fa-pied-piper-alt|fa-drupal|fa-joomla|fa-language|fa-fax|fa-building|fa-child|fa-paw|fa-spoon|fa-cube|fa-cubes|fa-behance|fa-behance-square|fa-steam|fa-steam-square|fa-recycle|fa-car|fa-taxi|fa-tree|fa-spotify|fa-deviantart|fa-soundcloud|fa-database|fa-file-pdf-o|fa-file-word-o|fa-file-excel-o|fa-file-powerpoint-o|fa-file-image-o|fa-file-archive-o|fa-file-audio-o|fa-file-video-o|fa-file-code-o|fa-vine|fa-codepen|fa-jsfiddle|fa-life-ring|fa-circle-o-notch|fa-rebel|fa-empire|fa-git-square|fa-git|fa-hacker-news|fa-tencent-weibo|fa-qq|fa-weixin|fa-paper-plane|fa-paper-plane-o|fa-history|fa-circle-thin|fa-header|fa-paragraph|fa-sliders|fa-share-alt|fa-share-alt-square|fa-bomb|fa-futbol-o|fa-tty|fa-binoculars|fa-plug|fa-slideshare|fa-twitch|fa-yelp|fa-newspaper-o|fa-wifi|fa-calculator|fa-paypal|fa-google-wallet|fa-cc-visa|fa-cc-mastercard|fa-cc-discover|fa-cc-amex|fa-cc-paypal|fa-cc-stripe|fa-bell-slash|fa-bell-slash-o|fa-trash|fa-copyright|fa-at|fa-eyedropper|fa-paint-brush|fa-birthday-cake|fa-area-chart|fa-pie-chart|fa-line-chart|fa-lastfm|fa-lastfm-square|fa-toggle-off|fa-toggle-on|fa-bicycle|fa-bus|fa-ioxhost|fa-angellist|fa-cc|fa-ils|fa-meanpath|fa-buysellads|fa-connectdevelop|fa-dashcube|fa-forumbee|fa-leanpub|fa-sellsy|fa-shirtsinbulk|fa-simplybuilt|fa-skyatlas|fa-cart-plus|fa-cart-arrow-down|fa-diamond|fa-ship|fa-user-secret|fa-motorcycle|fa-street-view|fa-heartbeat|fa-venus|fa-mars|fa-mercury|fa-transgender|fa-transgender-alt|fa-venus-double|fa-mars-double|fa-venus-mars|fa-mars-stroke|fa-mars-stroke-v|fa-mars-stroke-h|fa-neuter|fa-genderless|fa-facebook-official|fa-pinterest-p|fa-whatsapp|fa-server|fa-user-plus|fa-user-times|fa-bed|fa-viacoin|fa-train|fa-subway|fa-medium|fa-y-combinator|fa-optin-monster|fa-opencart|fa-expeditedssl|fa-battery-full|fa-battery-three-quarters|fa-battery-half|fa-battery-quarter|fa-battery-empty|fa-mouse-pointer|fa-i-cursor|fa-object-group|fa-object-ungroup|fa-sticky-note|fa-sticky-note-o|fa-cc-jcb|fa-cc-diners-club|fa-clone|fa-balance-scale|fa-hourglass-o|fa-hourglass-start|fa-hourglass-half|fa-hourglass-end|fa-hourglass|fa-hand-rock-o|fa-hand-paper-o|fa-hand-scissors-o|fa-hand-lizard-o|fa-hand-spock-o|fa-hand-pointer-o|fa-hand-peace-o|fa-trademark|fa-registered|fa-creative-commons|fa-gg|fa-gg-circle|fa-tripadvisor|fa-odnoklassniki|fa-odnoklassniki-square|fa-get-pocket|fa-wikipedia-w|fa-safari|fa-chrome|fa-firefox|fa-opera|fa-internet-explorer|fa-television|fa-contao|fa-500px|fa-amazon|fa-calendar-plus-o|fa-calendar-minus-o|fa-calendar-times-o|fa-calendar-check-o|fa-industry|fa-map-pin|fa-map-signs|fa-map-o|fa-map|fa-commenting|fa-commenting-o|fa-houzz|fa-vimeo|fa-black-tie|fa-fonticons|fa-reddit-alien|fa-edge|fa-credit-card-alt|fa-codiepie|fa-modx|fa-fort-awesome|fa-usb|fa-product-hunt|fa-mixcloud|fa-scribd|fa-pause-circle|fa-pause-circle-o|fa-stop-circle|fa-stop-circle-o|fa-shopping-bag|fa-shopping-basket|fa-hashtag|fa-bluetooth|fa-bluetooth-b|fa-percent|fa-gitlab|fa-wpbeginner|fa-wpforms|fa-envira|fa-universal-access|fa-wheelchair-alt|fa-question-circle-o|fa-blind|fa-audio-description|fa-volume-control-phone|fa-braille|fa-assistive-listening-systems|fa-american-sign-language-interpreting|fa-deaf|fa-glide|fa-glide-g|fa-sign-language|fa-low-vision|fa-viadeo|fa-viadeo-square|fa-snapchat|fa-snapchat-ghost|fa-snapchat-square|fa-pied-piper|fa-first-order|fa-yoast|fa-themeisle|fa-google-plus-official|fa-font-awesome|fa-handshake-o|fa-envelope-open|fa-envelope-open-o|fa-linode|fa-address-book|fa-address-book-o|fa-address-card|fa-address-card-o|fa-user-circle|fa-user-circle-o|fa-user-o|fa-id-badge|fa-id-card|fa-id-card-o|fa-quora|fa-free-code-camp|fa-telegram|fa-thermometer-full|fa-thermometer-three-quarters|fa-thermometer-half|fa-thermometer-quarter|fa-thermometer-empty|fa-shower|fa-bath|fa-podcast|fa-window-maximize|fa-window-minimize|fa-window-restore|fa-window-close|fa-window-close-o|fa-bandcamp|fa-grav|fa-etsy|fa-imdb|fa-ravelry|fa-eercast|fa-microchip|fa-snowflake-o|fa-superpowers|fa-wpexplorer|fa-meetup'
                        ),
                )
            )
        )
    );
}
add_action( 'customize_controls_enqueue_scripts', 'coletivo_customize_controls_enqueue_scripts' );

/**
 * Get customizer panel priority
 * @param string $panel
 * @return int
 */
function coletivo_get_customizer_priority ( $panel ) {
	$panel = str_replace( array( 'coletivo_', '_panel' ), '', $panel );
	$order = get_theme_mod( 'coletivo_sections_order', 'hero,features,yourslider,featuredpage,services,portfolio,videolightbox,gallery,team,news,contact,social' );
	$index = 129;
	$order = explode( ',', $order );
	foreach ( $order as $key => $value ) {
		$index++;
		if ( $panel === $value ) {
			break;
		}
	}
	return $index;
}
