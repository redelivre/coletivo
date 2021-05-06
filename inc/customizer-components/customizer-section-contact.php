<?php
/**
 * Customizer Section Contact
 *
 * @package Coletivo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Section: Contact
 */
$wp_customize->add_panel(
	'coletivo_contact',
	array(
		'priority'        => coletivo_get_customizer_priority( 'coletivo_contact' ),
		'title'           => esc_html__( 'Section: Contact', 'coletivo' ),
		'description'     => '',
		'active_callback' => 'coletivo_showon_frontpage',
	)
);

$wp_customize->add_section(
	'coletivo_contact_settings',
	array(
		'priority'    => 3,
		'title'       => esc_html__( 'Section Settings', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_contact',
	)
);

// Show Content.
$wp_customize->add_setting(
	'coletivo_contact_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
		'section'     => 'coletivo_contact_settings',
		'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
	)
);

// Show Form.
$wp_customize->add_setting(
	'coletivo_contact_cf7_disable',
	array(
		'sanitize_callback' => 'coletivo_sanitize_checkbox',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_cf7_disable',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Hide contact form completely.', 'coletivo' ),
		'section'     => 'coletivo_contact_settings',
		'description' => esc_html__( 'Check this box to hide contact form.', 'coletivo' ),
	)
);

// Section ID.
$wp_customize->add_setting(
	'coletivo_contact_id',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => esc_html__( 'contact', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_contact_id',
	array(
		'label'       => esc_html__( 'Section ID:', 'coletivo' ),
		'section'     => 'coletivo_contact_settings',
		'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' ),
	)
);

// Title.
$wp_customize->add_setting(
	'coletivo_contact_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Get in touch', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_contact_title',
	array(
		'label'       => esc_html__( 'Section Title', 'coletivo' ),
		'section'     => 'coletivo_contact_settings',
		'description' => '',
	)
);

// Sub Title.
$wp_customize->add_setting(
	'coletivo_contact_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Section subtitle', 'coletivo' ),
	)
);

$wp_customize->add_control(
	'coletivo_contact_subtitle',
	array(
		'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
		'section'     => 'coletivo_contact_settings',
		'description' => '',
	)
);

// Description.
$wp_customize->add_setting(
	'coletivo_contact_desc',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new coletivo_Editor_Custom_Control(
		$wp_customize,
		'coletivo_contact_desc',
		array(
			'label'       => esc_html__( 'Section Description', 'coletivo' ),
			'section'     => 'coletivo_contact_settings',
			'description' => '',
		)
	)
);

$wp_customize->add_section(
	'coletivo_contact_content',
	array(
		'priority'    => 6,
		'title'       => esc_html__( 'Section Content', 'coletivo' ),
		'description' => '',
		'panel'       => 'coletivo_contact',
	)
);

// Contact form guide.
$wp_customize->add_setting(
	'coletivo_contact_cf7_guide',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
	)
);

$wp_customize->add_control(
	new coletivo_Misc_Control(
		$wp_customize,
		'coletivo_contact_cf7_guide',
		array(
			'section'     => 'coletivo_contact_content',
			'type'        => 'custom_message',
			'description' => __( 'In order to display a contact form install a plugin and then copy the shortcode and paste it here, the shortcode will be like this <code>[contact-form][contact-field...][/contact-form]</code>', 'coletivo' ),
		)
	)
);

// Contact Form Shortcode.
$wp_customize->add_setting(
	'coletivo_contact_cf7',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_cf7',
	array(
		'label'       => esc_html__( 'Contact Form Shortcode', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => '',
	)
);

// hr.
$wp_customize->add_setting(
	'coletivo_contact_text_hr',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
	)
);

$wp_customize->add_control(
	new coletivo_Misc_Control(
		$wp_customize,
		'coletivo_contact_text_hr',
		array(
			'section' => 'coletivo_contact_content',
			'type'    => 'hr',
		)
	)
);

// Contact Text.
$wp_customize->add_setting(
	'coletivo_contact_address_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_address_title',
	array(
		'label'       => esc_html__( 'Contact Box Title', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => '',
	)
);

$wp_customize->add_setting(
	'coletivo_contact_text',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	new coletivo_Editor_Custom_Control(
		$wp_customize,
		'coletivo_contact_text',
		array(
			'label'       => esc_html__( 'Contact Text', 'coletivo' ),
			'section'     => 'coletivo_contact_content',
			'description' => '',
		)
	)
);

// Address Box.
// Contact Address.
$wp_customize->add_setting(
	'coletivo_contact_address',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_address',
	array(
		'label'       => esc_html__( 'Address', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => '',
	)
);

// Contact Phone.
$wp_customize->add_setting(
	'coletivo_contact_phone',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_phone',
	array(
		'label'       => esc_html__( 'Phone', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => '',
	)
);

// Contact WhatsApp.
$wp_customize->add_setting(
	'coletivo_contact_whats',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_whats',
	array(
		'label'       => esc_html__( 'What´s App', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => '',
	)
);

// Contact Email.
$wp_customize->add_setting(
	'coletivo_contact_email',
	array(
		'sanitize_callback' => 'sanitize_email',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_email',
	array(
		'label'       => esc_html__( 'Email', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => '',
	)
);

// Contact Social Networks.
$wp_customize->add_setting(
	'coletivo_contact_fb',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_fb',
	array(
		'label'       => esc_html__( 'Facebook', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => esc_html__( 'Enter the name of the page url after the "/" (example of url https://www.facebook.com/facebook, just put facebook)', 'coletivo' ),
	)
);

$wp_customize->add_setting(
	'coletivo_contact_instagram',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_instagram',
	array(
		'label'       => esc_html__( 'Instagram', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => esc_html__( 'Enter your Instagram username', 'coletivo' ),
	)
);

$wp_customize->add_setting(
	'coletivo_contact_twitter',
	array(
		'sanitize_callback' => 'coletivo_sanitize_text',
		'default'           => '',
	)
);

$wp_customize->add_control(
	'coletivo_contact_twitter',
	array(
		'label'       => esc_html__( 'Twitter', 'coletivo' ),
		'section'     => 'coletivo_contact_content',
		'description' => esc_html__( 'Enter your Twitter username', 'coletivo' ),
	)
);
