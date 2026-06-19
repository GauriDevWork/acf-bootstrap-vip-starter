<?php
/**
 * Theme Generator
 *
 * Generates a branded ACF Bootstrap starter theme ZIP from WP Admin.
 * The generated theme uses ACF PRO for options — no Redux dependency.
 *
 * How it works:
 * 1. User fills form (theme name, slug, prefix, author etc.)
 * 2. Plugin reads the template files from /templates/theme/
 * 3. Replaces all placeholders with user input
 * 4. Packages everything into a ZIP
 * 5. Triggers browser download
 *
 * Placeholders:
 * - {{THEME_NAME}}         → "My Client Theme"
 * - {{THEME_SLUG}}         → "my-client-theme"
 * - {{THEME_PREFIX}}       → "mct"
 * - {{THEME_PREFIX_UPPER}} → "MCT"
 * - {{THEME_DESCRIPTION}}  → "Custom theme..."
 * - {{THEME_AUTHOR}}       → "TechArk Solutions"
 * - {{THEME_AUTHOR_URI}}   → "https://techark.com"
 * - {{THEME_VERSION}}      → "1.0.0"
 */

add_action( 'admin_init', 'techark_handle_theme_generator' );

function techark_handle_theme_generator() {

	if ( ! isset( $_POST['techark_generate_theme'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}

	check_admin_referer( 'techark_theme_generator' );

	// Sanitize inputs
	$theme_name        = sanitize_text_field( $_POST['theme_name'] ?? '' );
	$theme_slug        = sanitize_title( $_POST['theme_slug'] ?? $theme_name );
	$theme_prefix      = preg_replace( '/[^a-z0-9_]/', '_', strtolower( sanitize_text_field( $_POST['theme_prefix'] ?? '' ) ) );
	$theme_description = sanitize_textarea_field( $_POST['theme_description'] ?? '' );
	$theme_author      = sanitize_text_field( $_POST['theme_author'] ?? '' );
	$theme_author_uri  = esc_url_raw( $_POST['theme_author_uri'] ?? '' );
	$theme_version     = sanitize_text_field( $_POST['theme_version'] ?? '1.0.0' );

	if ( empty( $theme_name ) || empty( $theme_slug ) || empty( $theme_prefix ) ) {
		wp_redirect( admin_url( 'admin.php?page=techark-theme-builder&error=missing_fields' ) );
		exit;
	}

	// Placeholders — order matters: longer strings first to prevent partial replacement
	$placeholders = array(
		'{{THEME_NAME}}'         => $theme_name,
		'{{THEME_SLUG}}'         => $theme_slug,
		'{{THEME_PREFIX_UPPER}}' => strtoupper( $theme_prefix ),
		'{{THEME_PREFIX}}'       => $theme_prefix,
		'{{THEME_DESCRIPTION}}'  => $theme_description,
		'{{THEME_AUTHOR_URI}}'   => $theme_author_uri,
		'{{THEME_AUTHOR}}'       => $theme_author,
		'{{THEME_VERSION}}'      => $theme_version,
		// Replace function prefix — all theme functions use acf_vip_ prefix
		'acf_vip_'               => $theme_prefix . '_',
		'ACF_VIP_'               => strtoupper( $theme_prefix ) . '_',
		// Replace text domain
		'acf-bootstrap-vip-starter' => $theme_slug,
		'acf_bootstrap_vip_starter' => str_replace( '-', '_', $theme_slug ),
	);

	// Template directory inside plugin
	$template_dir = TECHARK_BUILDER_PATH . 'templates/theme';

	if ( ! is_dir( $template_dir ) ) {
		wp_redirect( admin_url( 'admin.php?page=techark-theme-builder&error=no_template' ) );
		exit;
	}

	// Create ZIP
	$zip_filename = $theme_slug . '.zip';
	$zip_path     = sys_get_temp_dir() . '/' . $zip_filename;

	$zip = new ZipArchive();
	if ( $zip->open( $zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE ) !== true ) {
		wp_redirect( admin_url( 'admin.php?page=techark-theme-builder&error=zip_failed' ) );
		exit;
	}

	// Add all template files to ZIP with placeholder replacement
	techark_add_to_zip( $zip, $template_dir, $template_dir, $theme_slug, $placeholders );

	$zip->close();

	// Download
	header( 'Content-Type: application/zip' );
	header( 'Content-Disposition: attachment; filename="' . $zip_filename . '"' );
	header( 'Content-Length: ' . filesize( $zip_path ) );
	header( 'Pragma: no-cache' );
	readfile( $zip_path );
	unlink( $zip_path );
	exit;
}

/**
 * Recursively add template files to ZIP with placeholder replacement
 */
function techark_add_to_zip( $zip, $template_dir, $current_dir, $theme_slug, $placeholders ) {

	$files = scandir( $current_dir );

	foreach ( $files as $file ) {

		if ( $file === '.' || $file === '..' ) {
			continue;
		}

		$full_path = $current_dir . '/' . $file;
		$relative  = substr( $full_path, strlen( $template_dir ) + 1 );
		$zip_path  = $theme_slug . '/' . $relative;

		// Replace placeholders in file path too
		$zip_path = str_replace(
			array_keys( $placeholders ),
			array_values( $placeholders ),
			$zip_path
		);

		if ( is_dir( $full_path ) ) {
			$zip->addEmptyDir( $zip_path );
			techark_add_to_zip( $zip, $template_dir, $full_path, $theme_slug, $placeholders );
		} else {
			$content = file_get_contents( $full_path );
			$content = str_replace(
				array_keys( $placeholders ),
				array_values( $placeholders ),
				$content
			);
			$zip->addFromString( $zip_path, $content );
		}
	}
}

/**
 * Theme Generator page HTML
 */
function techark_theme_generator_page() {

	$error = $_GET['error'] ?? '';
	?>
	<div class="wrap">
		<h1>🎨 TechArk Theme Generator</h1>
		<p class="description">Generate a branded ACF Bootstrap starter theme. Fill in the details and click Generate — a ready-to-install ZIP downloads instantly.</p>

		<?php if ( $error === 'missing_fields' ) : ?>
			<div class="notice notice-error"><p><strong>Error:</strong> Theme Name, Slug, and Prefix are required.</p></div>
		<?php elseif ( $error === 'zip_failed' ) : ?>
			<div class="notice notice-error"><p><strong>Error:</strong> Could not create ZIP. Check server temp directory permissions.</p></div>
		<?php elseif ( $error === 'no_template' ) : ?>
			<div class="notice notice-error"><p><strong>Error:</strong> Theme template files not found in <code>templates/theme/</code>. Please re-install the plugin.</p></div>
		<?php endif; ?>

		<div style="max-width:700px;margin-top:20px;">
			<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=techark-theme-builder' ) ); ?>">
				<?php wp_nonce_field( 'techark_theme_generator' ); ?>
				<input type="hidden" name="techark_generate_theme" value="1">

				<table class="form-table">
					<tr>
						<th><label for="theme_name">Theme Name <span style="color:red">*</span></label></th>
						<td>
							<input type="text" id="theme_name" name="theme_name" class="regular-text" placeholder="My Client Theme" required>
							<p class="description">Full display name shown in WP Admin. e.g. "My Client Theme"</p>
						</td>
					</tr>
					<tr>
						<th><label for="theme_slug">Theme Slug <span style="color:red">*</span></label></th>
						<td>
							<input type="text" id="theme_slug" name="theme_slug" class="regular-text" placeholder="my-client-theme" required>
							<p class="description">Lowercase, hyphens only. Used as folder name and text domain.</p>
						</td>
					</tr>
					<tr>
						<th><label for="theme_prefix">Function Prefix <span style="color:red">*</span></label></th>
						<td>
							<input type="text" id="theme_prefix" name="theme_prefix" class="regular-text" placeholder="mct" required>
							<p class="description">Short lowercase prefix for all PHP functions. e.g. "mct" for My Client Theme. No hyphens or spaces.</p>
						</td>
					</tr>
					<tr>
						<th><label for="theme_description">Description</label></th>
						<td>
							<textarea id="theme_description" name="theme_description" class="large-text" rows="3" placeholder="Custom WordPress theme for My Client built with ACF PRO and Bootstrap 5."></textarea>
						</td>
					</tr>
					<tr>
						<th><label for="theme_author">Author</label></th>
						<td>
							<input type="text" id="theme_author" name="theme_author" class="regular-text" placeholder="TechArk Solutions">
						</td>
					</tr>
					<tr>
						<th><label for="theme_author_uri">Author URI</label></th>
						<td>
							<input type="url" id="theme_author_uri" name="theme_author_uri" class="regular-text" placeholder="https://techark.com">
						</td>
					</tr>
					<tr>
						<th><label for="theme_version">Version</label></th>
						<td>
							<input type="text" id="theme_version" name="theme_version" class="regular-text" value="1.0.0">
						</td>
					</tr>
				</table>

				<div style="background:#f0f6fc;border:1px solid #c3d9f5;border-radius:6px;padding:14px 18px;margin:20px 0;">
					<strong>📦 Generated theme includes:</strong>
					<ul style="margin:8px 0 0 16px;list-style:disc">
						<li>All 14 flex layouts pre-built (hero, CTA, testimonials, pricing, FAQ, grid, and more)</li>
						<li>ACF Theme Options — 7 tabs, 25 fields — no Redux dependency</li>
						<li>Bootstrap 5 + Vite build setup</li>
						<li>Per-layout scoped CSS/JS fields</li>
						<li>Custom Layout for developers</li>
						<li>All PHP functions prefixed with your chosen prefix</li>
						<li>Ready to install via Appearance → Themes → Add New</li>
					</ul>
				</div>

				<?php submit_button( '⬇ Generate Theme ZIP', 'primary large' ); ?>
			</form>
		</div>
	</div>

	<script>
	document.getElementById('theme_name').addEventListener('input', function() {
		const name   = this.value;
		const slug   = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
		const prefix = name.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_|_$/g, '').substring(0, 8);
		document.getElementById('theme_slug').value   = slug;
		document.getElementById('theme_prefix').value = prefix;
	});
	</script>
	<?php
}
