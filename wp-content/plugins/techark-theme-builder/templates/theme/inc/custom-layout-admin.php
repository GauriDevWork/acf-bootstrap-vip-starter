<?php
/**
 * Custom Layout — CodeMirror editor + Asset file manager
 *
 * Uses 'techark_' prefix for AJAX actions so they are NOT
 * replaced by the Theme Generator's placeholder system.
 *
 * @since Phase 2 — Day 7
 */

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

// AJAX — list files (techark_ prefix so generator doesn't replace it)
add_action( 'wp_ajax_techark_get_asset_files', 'acf_vip_ajax_get_asset_files' );

function acf_vip_ajax_get_asset_files() {

	check_ajax_referer( 'techark_asset_manager', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'Unauthorized' );
	}

	$type = sanitize_text_field( $_POST['type'] ?? 'css' );
	$ext  = $type === 'js' ? '*.js' : '*.css';
	$path = get_template_directory() . '/assets/' . $type . '/';

	$files = array();
	if ( is_dir( $path ) ) {
		$matched = glob( $path . $ext ) ?: array();
		foreach ( $matched as $file ) {
			$files[] = basename( $file );
		}
		sort( $files );
	}

	wp_send_json_success( array( 'files' => $files ) );
}

// AJAX — upload file
add_action( 'wp_ajax_techark_upload_asset_file', 'acf_vip_ajax_upload_asset_file' );

function acf_vip_ajax_upload_asset_file() {

	check_ajax_referer( 'techark_asset_manager', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'Unauthorized' );
	}

	if ( empty( $_FILES['file'] ) ) {
		wp_send_json_error( 'No file received' );
	}

	$type    = sanitize_text_field( $_POST['type'] ?? 'css' );
	$allowed = $type === 'js' ? array( 'js' ) : array( 'css' );
	$file    = $_FILES['file'];
	$ext     = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

	if ( ! in_array( $ext, $allowed, true ) ) {
		wp_send_json_error( 'Invalid file type. Only .' . $ext . ' files allowed here.' );
	}

	$dest_dir = get_template_directory() . '/assets/' . $type . '/';
	$filename = sanitize_file_name( $file['name'] );
	$dest     = $dest_dir . $filename;

	if ( ! is_dir( $dest_dir ) ) {
		wp_send_json_error( 'Directory not found: assets/' . $type . '/' );
	}

	if ( ! move_uploaded_file( $file['tmp_name'], $dest ) ) {
		wp_send_json_error( 'Upload failed. Check server permissions.' );
	}

	wp_send_json_success( array(
		'filename' => $filename,
		'message'  => 'Uploaded: ' . $filename,
	) );
}

// Frontend enqueue of selected files
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

		$css_files = $layout['custom_layout_css_files'] ?? array();
		$js_files  = $layout['custom_layout_js_files'] ?? array();

		foreach ( (array) $css_files as $i => $css_file ) {
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

		foreach ( (array) $js_files as $i => $js_file ) {
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
