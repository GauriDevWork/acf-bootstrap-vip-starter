<?php
/**
 * Asset File Manager — AJAX handlers
 *
 * Lives in TechArk Theme Builder PLUGIN so it loads
 * on every request including admin-ajax.php.
 * Uses techark_ prefix — never replaced by Theme Generator.
 *
 * @since Phase 2 — Day 7 fix
 */

add_action( 'wp_ajax_techark_get_asset_files', 'techark_ajax_get_asset_files' );

function techark_ajax_get_asset_files() {

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

add_action( 'wp_ajax_techark_upload_asset_file', 'techark_ajax_upload_asset_file' );

function techark_ajax_upload_asset_file() {

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
		wp_send_json_error( 'Invalid file type. Only .' . $ext . ' files allowed.' );
	}

	$dest_dir = get_template_directory() . '/assets/' . $type . '/';
	$filename = sanitize_file_name( $file['name'] );
	$dest     = $dest_dir . $filename;

	if ( ! is_dir( $dest_dir ) ) {
		wp_send_json_error( 'Directory not found: ' . $dest_dir );
	}

	if ( ! move_uploaded_file( $file['tmp_name'], $dest ) ) {
		wp_send_json_error( 'Upload failed. Check permissions.' );
	}

	wp_send_json_success( array(
		'filename' => $filename,
		'message'  => 'Uploaded: ' . $filename,
	) );
}
