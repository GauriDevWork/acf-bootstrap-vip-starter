<?php
/**
 * Custom Layout — CodeMirror enqueue + frontend asset loader
 *
 * AJAX handlers are in the TechArk Theme Builder plugin (inc/asset-manager.php)
 * so they load on every request including admin-ajax.php.
 *
 * @since Phase 2 — Day 7
 */

// Enqueue CodeMirror + admin JS/CSS on page edit screens
add_action( 'admin_enqueue_scripts', 'acf_vip_enqueue_codemirror' );

function acf_vip_enqueue_codemirror( $hook ) {

	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
	wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
	wp_enqueue_code_editor( array( 'type' => 'text/javascript' ) );

	wp_enqueue_script(
		'acf-vip-custom-layout-admin',
		get_template_directory_uri() . '/assets/js/admin/custom-layout-admin.js',
		array( 'jquery', 'wp-codemirror' ),
		'1.0.0',
		true
	);

	wp_localize_script(
		'acf-vip-custom-layout-admin',
		'acfVipCodeEditor',
		array(
			'nonce'   => wp_create_nonce( 'techark_asset_manager' ),
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		)
	);

	wp_enqueue_style(
		'acf-vip-custom-layout-admin',
		get_template_directory_uri() . '/assets/css/admin/custom-layout-admin.css',
		array( 'wp-codemirror' ),
		'1.0.0'
	);
}

// Frontend — enqueue selected CSS/JS files on pages using Custom Layout
add_action( 'wp_enqueue_scripts', 'acf_vip_enqueue_custom_layout_assets' );

function acf_vip_enqueue_custom_layout_assets() {

	if ( ! is_singular() ) {
		return;
	}

	$layouts = get_field( 'page_builder' );
	if ( empty( $layouts ) ) {
		return;
	}

	foreach ( $layouts as $index => $layout ) {

		if ( $layout['acf_fc_layout'] !== 'custom_layout' ) {
			continue;
		}

		$css_files = ! empty( $layout['custom_layout_css_files'] ) ? (array) $layout['custom_layout_css_files'] : array();
		$js_files  = ! empty( $layout['custom_layout_js_files'] )  ? (array) $layout['custom_layout_js_files']  : array();

		foreach ( $css_files as $i => $css_file ) {
			if ( empty( $css_file ) ) continue;
			$path = get_template_directory() . '/assets/css/' . $css_file;
			if ( file_exists( $path ) ) {
				wp_enqueue_style(
					'custom-layout-css-' . $index . '-' . $i,
					get_template_directory_uri() . '/assets/css/' . $css_file,
					array(),
					filemtime( $path )
				);
			}
		}

		foreach ( $js_files as $i => $js_file ) {
			if ( empty( $js_file ) ) continue;
			$path = get_template_directory() . '/assets/js/' . $js_file;
			if ( file_exists( $path ) ) {
				wp_enqueue_script(
					'custom-layout-js-' . $index . '-' . $i,
					get_template_directory_uri() . '/assets/js/' . $js_file,
					array(),
					filemtime( $path ),
					true
				);
			}
		}
	}
}
