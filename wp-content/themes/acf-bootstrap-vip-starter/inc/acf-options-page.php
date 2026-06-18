<?php
/**
 * Register ACF Theme Options page
 *
 * Adds "Theme Options" to the WP Admin sidebar.
 * All theme settings (colors, typography, buttons, header,
 * footer, social, custom code) live here.
 *
 * No plugin required — ACF PRO 6.x handles options pages natively.
 *
 * @since Phase 2 — Sprint 3
 */

add_action( 'acf/init', 'acf_vip_register_options_page' );

function acf_vip_register_options_page() {

	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page( array(
		'page_title' => 'Theme Options',
		'menu_title' => 'Theme Options',
		'menu_slug'  => 'theme-options',
		'capability' => 'manage_options',
		'position'   => 60,
		'icon_url'   => 'dashicons-admin-customizer',
		'redirect'   => false,
	) );
}
