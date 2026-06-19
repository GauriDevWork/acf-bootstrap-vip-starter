<?php
/**
 * Register Theme Options ACF field group
 *
 * 7 tabs, 25 fields — registered via PHP so they are
 * version-controlled and require no manual ACF UI setup.
 *
 * Tabs: Colors, Typography, Buttons, Header, Footer, Social, Custom Code
 *
 * @since Phase 2 — Sprint 3
 */

add_action( 'acf/init', 'acf_vip_register_options_fields' );

function acf_vip_register_options_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Avoid duplicate registration
	if ( acf_get_field_group( 'group_theme_options' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'      => 'group_theme_options',
		'title'    => 'Theme Options',
		'fields'   => array(

			// =====================
			// TAB: Colors
			// =====================
			array(
				'key'   => 'field_tab_colors',
				'label' => 'Colors',
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'           => 'field_primary_color',
				'label'         => 'Primary Color',
				'name'          => 'primary_color',
				'type'          => 'color_picker',
				'instructions'  => 'Main brand color — buttons, links, accents.',
				'default_value' => '#0d6efd',
				'parent'        => 'field_tab_colors_group',
			),
			array(
				'key'           => 'field_secondary_color',
				'label'         => 'Secondary Color',
				'name'          => 'secondary_color',
				'type'          => 'color_picker',
				'instructions'  => 'Used for hover states and accents.',
				'default_value' => '#6c757d',
			),
			array(
				'key'           => 'field_text_color',
				'label'         => 'Text Color',
				'name'          => 'text_color',
				'type'          => 'color_picker',
				'instructions'  => 'Body text color.',
				'default_value' => '#212529',
			),
			array(
				'key'           => 'field_bg_color',
				'label'         => 'Background Color',
				'name'          => 'background_color',
				'type'          => 'color_picker',
				'instructions'  => 'Site background color.',
				'default_value' => '#ffffff',
			),

			// =====================
			// TAB: Typography
			// =====================
			array(
				'key'   => 'field_tab_typography',
				'label' => 'Typography',
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'          => 'field_heading_font',
				'label'        => 'Heading Font',
				'name'         => 'heading_font',
				'type'         => 'text',
				'instructions' => 'Google Font name for headings. e.g. Inter, Playfair Display',
				'placeholder'  => 'Inter',
			),
			array(
				'key'          => 'field_body_font',
				'label'        => 'Body Font',
				'name'         => 'body_font',
				'type'         => 'text',
				'instructions' => 'Google Font name for body text. e.g. Inter, Roboto',
				'placeholder'  => 'Inter',
			),
			array(
				'key'           => 'field_base_font_size',
				'label'         => 'Base Font Size (px)',
				'name'          => 'base_font_size',
				'type'          => 'number',
				'default_value' => 16,
				'min'           => 12,
				'max'           => 24,
			),
			array(
				'key'           => 'field_heading_weight',
				'label'         => 'Heading Weight',
				'name'          => 'heading_weight',
				'type'          => 'select',
				'choices'       => array(
					'400' => '400 — Regular',
					'500' => '500 — Medium',
					'600' => '600 — Semi Bold',
					'700' => '700 — Bold',
					'800' => '800 — Extra Bold',
				),
				'default_value' => '700',
			),
			array(
				'key'           => 'field_h1_size',
				'label'         => 'H1 Font Size (px)',
				'name'          => 'h1_font_size',
				'type'          => 'number',
				'default_value' => 48,
				'wrapper'       => array( 'width' => '33' ),
			),
			array(
				'key'           => 'field_h2_size',
				'label'         => 'H2 Font Size (px)',
				'name'          => 'h2_font_size',
				'type'          => 'number',
				'default_value' => 36,
				'wrapper'       => array( 'width' => '33' ),
			),
			array(
				'key'           => 'field_h3_size',
				'label'         => 'H3 Font Size (px)',
				'name'          => 'h3_font_size',
				'type'          => 'number',
				'default_value' => 28,
				'wrapper'       => array( 'width' => '33' ),
			),
			array(
				'key'           => 'field_h4_size',
				'label'         => 'H4 Font Size (px)',
				'name'          => 'h4_font_size',
				'type'          => 'number',
				'default_value' => 22,
				'wrapper'       => array( 'width' => '33' ),
			),
			array(
				'key'           => 'field_h5_size',
				'label'         => 'H5 Font Size (px)',
				'name'          => 'h5_font_size',
				'type'          => 'number',
				'default_value' => 18,
				'wrapper'       => array( 'width' => '33' ),
			),
			array(
				'key'           => 'field_h6_size',
				'label'         => 'H6 Font Size (px)',
				'name'          => 'h6_font_size',
				'type'          => 'number',
				'default_value' => 16,
				'wrapper'       => array( 'width' => '33' ),
			),

			// =====================
			// TAB: Buttons
			// =====================
			array(
				'key'   => 'field_tab_buttons',
				'label' => 'Buttons',
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'           => 'field_btn_bg',
				'label'         => 'Button Background',
				'name'          => 'button_bg',
				'type'          => 'color_picker',
				'default_value' => '#0d6efd',
				'wrapper'       => array( 'width' => '50' ),
			),
			array(
				'key'           => 'field_btn_text_color',
				'label'         => 'Button Text Color',
				'name'          => 'button_text_color',
				'type'          => 'color_picker',
				'default_value' => '#ffffff',
				'wrapper'       => array( 'width' => '50' ),
			),
			array(
				'key'           => 'field_btn_radius',
				'label'         => 'Border Radius (px)',
				'name'          => 'button_radius',
				'type'          => 'number',
				'default_value' => 6,
				'min'           => 0,
				'max'           => 50,
				'wrapper'       => array( 'width' => '50' ),
			),
			array(
				'key'           => 'field_btn_padding',
				'label'         => 'Button Padding',
				'name'          => 'button_padding',
				'type'          => 'text',
				'default_value' => '10px 24px',
				'placeholder'   => '10px 24px',
				'instructions'  => 'CSS shorthand e.g. 10px 24px',
				'wrapper'       => array( 'width' => '50' ),
			),

			// =====================
			// TAB: Header
			// =====================
			array(
				'key'   => 'field_tab_header',
				'label' => 'Header',
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'           => 'field_header_bg',
				'label'         => 'Header Background',
				'name'          => 'header_bg',
				'type'          => 'color_picker',
				'default_value' => '#ffffff',
				'wrapper'       => array( 'width' => '50' ),
			),
			array(
				'key'           => 'field_sticky_header',
				'label'         => 'Sticky Header',
				'name'          => 'sticky_header',
				'type'          => 'true_false',
				'ui'            => 1,
				'default_value' => 0,
				'instructions'  => 'Enable sticky header on scroll.',
				'wrapper'       => array( 'width' => '50' ),
			),
			array(
				'key'          => 'field_logo',
				'label'        => 'Logo',
				'name'         => 'logo',
				'type'         => 'image',
				'instructions' => 'Upload site logo. Replaces text site title in header.',
				'return_format' => 'array',
				'preview_size' => 'medium',
			),

			// =====================
			// TAB: Footer
			// =====================
			array(
				'key'   => 'field_tab_footer',
				'label' => 'Footer',
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'           => 'field_footer_bg',
				'label'         => 'Footer Background',
				'name'          => 'footer_bg',
				'type'          => 'color_picker',
				'default_value' => '#1a1a1a',
				'wrapper'       => array( 'width' => '50' ),
			),
			array(
				'key'           => 'field_footer_text_color',
				'label'         => 'Footer Text Color',
				'name'          => 'footer_text_color',
				'type'          => 'color_picker',
				'default_value' => '#ffffff',
				'wrapper'       => array( 'width' => '50' ),
			),
			array(
				'key'          => 'field_copyright_text',
				'label'        => 'Copyright Text',
				'name'         => 'copyright_text',
				'type'         => 'text',
				'placeholder'  => '© 2026 TechArk. All rights reserved.',
				'instructions' => 'Shown in footer bottom bar.',
			),

			// =====================
			// TAB: Social
			// =====================
			array(
				'key'   => 'field_tab_social',
				'label' => 'Social',
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'         => 'field_facebook_url',
				'label'       => 'Facebook URL',
				'name'        => 'facebook_url',
				'type'        => 'url',
				'placeholder' => 'https://facebook.com/yourpage',
				'wrapper'     => array( 'width' => '50' ),
			),
			array(
				'key'         => 'field_instagram_url',
				'label'       => 'Instagram URL',
				'name'        => 'instagram_url',
				'type'        => 'url',
				'placeholder' => 'https://instagram.com/yourhandle',
				'wrapper'     => array( 'width' => '50' ),
			),
			array(
				'key'         => 'field_linkedin_url',
				'label'       => 'LinkedIn URL',
				'name'        => 'linkedin_url',
				'type'        => 'url',
				'placeholder' => 'https://linkedin.com/company/yourcompany',
				'wrapper'     => array( 'width' => '50' ),
			),
			array(
				'key'         => 'field_twitter_url',
				'label'       => 'Twitter / X URL',
				'name'        => 'twitter_url',
				'type'        => 'url',
				'placeholder' => 'https://x.com/yourhandle',
				'wrapper'     => array( 'width' => '50' ),
			),
			array(
				'key'         => 'field_youtube_url',
				'label'       => 'YouTube URL',
				'name'        => 'youtube_url',
				'type'        => 'url',
				'placeholder' => 'https://youtube.com/@yourchannel',
				'wrapper'     => array( 'width' => '50' ),
			),

			// =====================
			// TAB: Custom Code
			// =====================
			array(
				'key'   => 'field_tab_custom_code',
				'label' => 'Custom Code',
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'          => 'field_global_css',
				'label'        => 'Global Custom CSS',
				'name'         => 'global_custom_css',
				'type'         => 'textarea',
				'instructions' => 'Site-wide CSS injected into <head>. No selectors needed for basic overrides.',
				'rows'         => 8,
				'placeholder'  => "/* Custom CSS */\nbody { font-family: 'Inter', sans-serif; }",
				'wrapper'      => array( 'width' => '50' ),
			),
			array(
				'key'          => 'field_global_js',
				'label'        => 'Global Custom JS',
				'name'         => 'global_custom_js',
				'type'         => 'textarea',
				'instructions' => 'Site-wide JS injected before </body>. Runs in an IIFE automatically.',
				'rows'         => 8,
				'placeholder'  => "// Custom JS\nconsole.log('site loaded');",
				'wrapper'      => array( 'width' => '50' ),
			),

		),
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'theme-options',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
	) );
}
