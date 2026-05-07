<?php

/**
 * {{THEME_NAME}} functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package {{THEME_PACKAGE}}
 */

if (!defined('{{THEME_UPPER_PREFIX}}_VERSION')) {
	// Replace the version number of the theme on each release.
	define('{{THEME_UPPER_PREFIX}}_VERSION', '1.0.0');
}



/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function {{THEME_PREFIX_LONG}}setup()
{

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', '{{TEXT_DOMAIN}}'),
			'gtranslate-menu' => esc_html__('Gtranslate Menu', '{{TEXT_DOMAIN}}'),
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', '{{THEME_PREFIX_LONG}}setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function {{THEME_PREFIX_LONG}}content_width()
{
	$GLOBALS['content_width'] = apply_filters('{{THEME_PREFIX_LONG}}content_width', 640);
}
add_action('after_setup_theme', '{{THEME_PREFIX_LONG}}content_width', 0);



/**
 * Prevent theme activation if required plugins are missing.
 */
function {{THEME_PREFIX_LONG}}check_dependencies_on_switch($old_theme_name, $old_theme = false)
{
	if (!class_exists('acf') || !function_exists('flpi_acf_init')) {
		// Switch back to the previous theme
		switch_theme($old_theme ? $old_theme->get_stylesheet() : '');

		// Set a transient to show the error message
		set_transient('{{THEME_PREFIX}}_activation_error', true, 30);
	}
}
add_action('after_switch_theme', '{{THEME_PREFIX_LONG}}check_dependencies_on_switch', 10, 2);

/**
 * Display error message if activation failed due to missing dependencies.
 */
function {{THEME_PREFIX_LONG}}activation_error_notice()
{
	if (get_transient('{{THEME_PREFIX}}_activation_error')) {
		delete_transient('{{THEME_PREFIX}}_activation_error');
?>
		<div class="notice notice-error is-dismissible">
			<p><?php
				printf(
					/* translators: 1: theme name */
					esc_html__('Activation failed! %s requires both "Advanced Custom Fields Pro" and "Flexible Layout Preview Image for ACF" plugins to be installed and activated.', '{{TEXT_DOMAIN}}'),
					'<strong>{{THEME_NAME}}</strong>'
				);
				?></p>
		</div>
<?php
	}
}
add_action('admin_notices', '{{THEME_PREFIX_LONG}}activation_error_notice');

/**
 * Check if ACF is active and show notice if not.
 */
function {{THEME_PREFIX_LONG}}check_acf_dependency()
{
	if (!class_exists('acf') || !function_exists('flpi_acf_init')) {
		add_action('admin_notices', function () {
?>
			<div class="notice notice-warning is-dismissible">
				<p><?php
					printf(
						/* translators: 1: theme name */
						esc_html__('%s requires "Advanced Custom Fields Pro" and "Flexible Layout Preview Image for ACF" to be installed and activated for full functionality.', '{{TEXT_DOMAIN}}'),
						'<strong>{{THEME_NAME}}</strong>'
					);
					?></p>
			</div>
<?php
		});
	}
}
add_action('admin_init', '{{THEME_PREFIX_LONG}}check_acf_dependency');

${{THEME_PREFIX}}inc_dir = 'inc';

// Array of files to include.
${{THEME_PREFIX}}includes = array(
	'/custom-header.php',
	'/template-tags.php',
	'/template-functions.php',
	'/customizer.php',
	'/jetpack.php',
	'/enqueue-and-dequeue.php',
	'/custom-image.php',
	'/custom-post-type-and-taxonomy.php'
);

// Include files.
foreach (${{THEME_PREFIX}}includes as $file) {
	require_once get_theme_file_path(${{THEME_PREFIX}}inc_dir . $file);
}

if (!class_exists('Redux')) {
	$redux_framework = get_template_directory() . '/inc/redux-core/framework.php';
	if (file_exists($redux_framework)) {
		require_once $redux_framework;
	}
}

$redux_options_file = get_template_directory() . '/inc/redux-options.php';
if (file_exists($redux_options_file)) {
	require_once $redux_options_file;
}
