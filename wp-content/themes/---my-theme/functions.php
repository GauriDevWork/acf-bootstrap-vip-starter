<?php

/**
 * My theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package My_theme
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}



/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function my_theme_setup()
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
			'menu-1' => esc_html__('Primary', 'my-theme'),
			'gtranslate-menu' => esc_html__('Gtranslate Menu', 'my-theme'),
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
add_action('after_setup_theme', 'my_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function my_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('my_theme_content_width', 640);
}

/**
 * Prevent theme activation if Redux Framework is missing.
 */
function my_theme_check_dependencies_on_switch($old_theme_name, $old_theme = false)
{
	if (!class_exists('Redux')) {
		// Switch back to the previous theme
		switch_theme($old_theme ? $old_theme->get_stylesheet() : '');

		// Set a transient to show the error message
		set_transient('my_theme_activation_error', true, 30);
	}
}
add_action('after_switch_theme', 'my_theme_check_dependencies_on_switch', 10, 2);

/**
 * Display error message if activation failed due to missing Redux Framework.
 */
function my_theme_activation_error_notice()
{
	if (get_transient('my_theme_activation_error')) {
		delete_transient('my_theme_activation_error');
?>
		<div class="notice notice-error is-dismissible">
			<p><?php
				printf(
					/* translators: 1: theme name */
					esc_html__('Activation failed! %s requires the "Redux Framework" plugin to be installed and activated.', 'my-theme'),
					'<strong>My theme</strong>'
				);
				?></p>
		</div>
<?php
	}
}
add_action('admin_notices', 'my_theme_activation_error_notice');

/**
 * Check if Redux is active and show notice if not.
 */
function my_theme_check_redux_dependency()
{
	if (!class_exists('Redux')) {
		add_action('admin_notices', function () {
?>
			<div class="notice notice-warning is-dismissible">
				<p><?php
					printf(
						/* translators: 1: theme name */
						esc_html__('%s requires the "Redux Framework" plugin to be installed and activated for full functionality.', 'my-theme'),
						'<strong>My theme</strong>'
					);
					?></p>
			</div>
<?php
		});
	}
}
add_action('admin_init', 'my_theme_check_redux_dependency');




$my_theme_inc_dir = 'inc';

// Array of files to include.
$my_theme_includes = array(
	'/custom-header.php',
	'/template-tags.php',
	'/template-functions.php',
	'/customizer.php',
	'/jetpack.php',
	'/enqueue-and-dequeue.php',
	'/custom-image.php'
);

// Include files.
foreach ($my_theme_includes as $file) {
	require_once get_theme_file_path($my_theme_inc_dir . $file);
}


$redux_options_file = get_template_directory() . '/inc/redux-options.php';
if (file_exists($redux_options_file)) {
	require_once $redux_options_file;
}
