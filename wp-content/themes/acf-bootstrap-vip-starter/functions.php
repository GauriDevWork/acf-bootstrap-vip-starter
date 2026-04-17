<?php
/**
 * Sets up theme defaults and registers support for various WordPress
 * features such as title tag, post thumbnails, and HTML5 markup.
 *
 * @since 1.0.0
 */

function acf_vip_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'acf_vip_theme_setup' );


/**
 * Registers the theme's navigation menus.
 *
 * Registers the Primary Menu and Footer Menu for use in the theme.
 *
 * @since 1.0.0
 */
function acf_vip_register_menus() {

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'acf-bootstrap-vip-starter' ),
			'footer'  => __( 'Footer Menu', 'acf-bootstrap-vip-starter' ),
		)
	);
}
add_action( 'after_setup_theme', 'acf_vip_register_menus' );

/**
 * Enqueue assets for the theme.
 *
 * Enqueue Bootstrap CSS and JS, as well as the theme's stylesheet.
 *
 * @since 1.0.0
 */

function acf_vip_enqueue_assets() {

	$theme_version = wp_get_theme()->get( 'Version' );

	// Styles
	wp_enqueue_style(
		'bootstrap',
		get_template_directory_uri() . '/assets/css/bootstrap.min.css',
		array(),
		'5.0',
		'all'
	);

	wp_enqueue_style(
		'theme-style',
		get_stylesheet_uri(),
		array( 'bootstrap' ),
		$theme_version
	);

	wp_enqueue_style(
		'swiper',
		get_template_directory_uri() . '/assets/css/swiper.min.css',
		array(),
		'9.0'
	);

	wp_enqueue_style(
		'custom-style',
		get_template_directory_uri() . '/assets/css/custom.css',
		array( 'bootstrap' ),
		$theme_version
	);

	// Scripts
	wp_enqueue_script(
		'bootstrap',
		get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js',
		array(),
		'5.0',
		true
	);

	wp_enqueue_script(
		'swiper',
		get_template_directory_uri() . '/assets/js/swiper-bundle.min.js',
		array(),
		'9.0',
		true
	);

	wp_enqueue_script(
		'main-js',
		get_template_directory_uri() . '/assets/js/custom.js',
		array( 'swiper' ),
		$theme_version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'acf_vip_enqueue_assets' );

/**
 * Defer scripts that are not needed immediately.
 *
 * If the script is in the list of defer scripts, this function
 * will return the script tag with the src attribute replaced with
 * defer src.
 *
 * @param string $tag The script tag.
 * @param string $handle The script handle.
 * @return string The modified script tag.
 */
require_once get_template_directory() . '/inc/helpers.php';
function acf_vip_defer_scripts( $tag, $handle ) {

	$defer_scripts = array( 'bootstrap' );

	if ( in_array( $handle, $defer_scripts, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'acf_vip_defer_scripts', 10, 2 );


// Remove emoji scripts
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Remove wp-embed
function acf_vip_remove_wp_embed() {
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'acf_vip_remove_wp_embed' );

// Remove block library CSS (if not using Gutenberg)
function acf_vip_remove_block_css() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'acf_vip_remove_block_css', 100 );



// ACF JSON save path
add_filter(
	'acf/settings/save_json',
	function () {
		return get_stylesheet_directory() . '/acf-json';
	}
);

// ACF JSON load path
add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = get_stylesheet_directory() . '/acf-json';
		return $paths;
	}
);

function acf_vip_get_used_layouts() {

	if ( ! is_singular() ) {
		return array();
	}

	$layouts = get_field( 'page_builder' );

	if ( empty( $layouts ) ) {
		return array();
	}

	return array_column( $layouts, 'acf_fc_layout' );
}


function acf_vip_enqueue_layout_css() {

	$layouts = acf_vip_get_used_layouts();

	// HERO CSS
	if ( in_array( 'hero_section', $layouts, true ) ) {
		wp_enqueue_style(
			'hero-css',
			get_template_directory_uri() . '/assets/css/hero.css',
			array(),
			'1.0'
		);
	}

	// CTA CSS (future)
	if ( in_array( 'cta_section', $layouts, true ) ) {
		wp_enqueue_style(
			'cta-css',
			get_template_directory_uri() . '/assets/css/cta.css',
			array(),
			'1.0'
		);
	}

	// GRID CSS
	if ( in_array( 'grid_section', $layouts, true ) ) {

		wp_enqueue_style(
			'grid-css',
			get_template_directory_uri() . '/assets/css/grid.css',
			array(),
			'1.0'
		);
	}

	// TESTIMONIALS CSS AND JS
	if ( in_array( 'testimonials_section', $layouts, true ) ) {

		wp_enqueue_style(
			'testimonials-css',
			get_template_directory_uri() . '/assets/css/testimonials.css',
			array(),
			'1.0'
		);

		wp_enqueue_script(
			'testimonials-swiper',
			get_template_directory_uri() . '/assets/js/testimonials-swiper.js',
			array( 'swiper' ),
			'1.0',
			true
		);
	}

	// FAQ CSS AND JS
	if ( in_array( 'faq_section', $layouts, true ) ) {

		wp_enqueue_style(
			'faq-css',
			get_template_directory_uri() . '/assets/css/faq.css',
			array(),
			'1.0'
		);

		wp_enqueue_script(
			'faq-js',
			get_template_directory_uri() . '/assets/js/faq.js',
			array(),
			'1.0',
			true
		);
	}

	// CONTENT CSS for content_section and two_column_section
	if (
		in_array( 'content_section', $layouts, true ) ||
		in_array( 'two_column_section', $layouts, true )
	) {

		wp_enqueue_style(
			'content-css',
			get_template_directory_uri() . '/assets/css/content.css',
			array(),
			'1.0'
		);
	}

	// CSS for icon_list_section
	if ( in_array( 'icon_list_section', $layouts, true ) ) {

		wp_enqueue_style(
			'icon-list-css',
			get_template_directory_uri() . '/assets/css/icon-list.css',
			array(),
			'1.0'
		);
	}

	// CSS for steps_section
	if (
		in_array( 'steps_section', $layouts, true )
	) {
		wp_enqueue_style(
			'steps-css',
			get_template_directory_uri() . '/assets/css/steps.css',
			array(),
			'1.0'
		);
	}

	// CSS for spacer_section
	if (
		in_array( 'spacer_section', $layouts, true )
	) {
		wp_enqueue_style(
			'spacer-css',
			get_template_directory_uri() . '/assets/css/spacer.css',
			array(),
			'1.0'
		);
	}

	// CSS for pricing_section
	if (
		in_array( 'pricing_section', $layouts, true )
	) {
		wp_enqueue_style(
			'pricing-css',
			get_template_directory_uri() . '/assets/css/pricing.css',
			array(),
			'1.0'
		);
	}

	// CSS for form_section
	if (
		in_array( 'form_section', $layouts, true )
	) {
		wp_enqueue_style(
			'form-css',
			get_template_directory_uri() . '/assets/css/form.css',
			array(),
			'1.0'
		);
	}
}

add_action( 'wp_enqueue_scripts', 'acf_vip_enqueue_layout_css' );

function acf_vip_bg_class( $bg ) {

	$map = array(
		'light'     => 'bg-light',
		'dark'      => 'bg-dark text-white',
		'primary'   => 'bg-primary text-white',
		'secondary' => 'bg-secondary text-white',
	);

	return $map[ $bg ] ?? 'bg-light';
}

/**
 * Hide admin bar on front-end.
 *
 * @since 1.0.0
 */
function acf_vip_hide_admin_bar() {
	show_admin_bar( false );
}
add_action( 'after_setup_theme', 'acf_vip_hide_admin_bar' );
