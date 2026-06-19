<?php
/**
 * Plugin Name: TechArk Theme Builder
 * Plugin URI:  https://github.com/GauriDevWork/acf-bootstrap-vip-starter
 * Description: Generate branded ACF Bootstrap starter themes from WP Admin. No Redux dependency — ACF PRO only.
 * Version:     1.0.0
 * Author:      Gauri Kaushik
 * Author URI:  https://github.com/GauriDevWork
 * Text Domain: techark-theme-builder
 * Requires WP: 6.0
 * Requires PHP: 8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TECHARK_BUILDER_VERSION', '1.0.0' );
define( 'TECHARK_BUILDER_PATH', plugin_dir_path( __FILE__ ) );
define( 'TECHARK_BUILDER_URL', plugin_dir_url( __FILE__ ) );

require_once TECHARK_BUILDER_PATH . 'inc/admin-menu.php';
require_once TECHARK_BUILDER_PATH . 'inc/theme-generator.php';
require_once TECHARK_BUILDER_PATH . 'inc/template-creator.php';
