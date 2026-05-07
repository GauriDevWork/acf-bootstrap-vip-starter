<?php
/**
 * Plugin Name: TechArk Theme Builder
 * Plugin URI: https://gotechark.com/
 * Description: Generate custom WordPress starter themes with Redux Framework integration, global design settings, and template creator functionality.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: TechArk Solutions
 * Author URI: https://gotechark.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: techark-theme-builder
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TATB_VERSION', '1.0.0');
define('TATB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TATB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TATB_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
class TechArk_Theme_Builder
{
    /**
     * Single instance of the class
     */
    private static $instance = null;

    /**
     * Get singleton instance
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Load required files
     */
    private function load_dependencies()
    {
        require_once TATB_PLUGIN_DIR . 'includes/class-admin-page.php';
        require_once TATB_PLUGIN_DIR . 'includes/class-theme-generator.php';
    }

    /**
     * Initialize hooks
     */
    private function init_hooks()
    {
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // Initialize admin page
        if (is_admin()) {
            new TATB_Admin_Page();
            add_filter('plugin_action_links_' . TATB_PLUGIN_BASENAME, array($this, 'add_action_links'));
        }
    }

    /**
     * Add action links to plugin page
     */
    public function add_action_links($links)
    {
        $settings_link = array(
            '<a href="' . admin_url('admin.php?page=techark-theme-builder') . '">' . __('Build Theme', 'techark-theme-builder') . '</a>',
            '<a href="' . admin_url('admin.php?page=tatb-template-creator') . '">' . __('Create Template', 'techark-theme-builder') . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain()
    {
        load_plugin_textdomain(
            'techark-theme-builder',
            false,
            dirname(TATB_PLUGIN_BASENAME) . '/languages/'
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook)
    {
        // Only load on our plugin page
        if ('toplevel_page_techark-theme-builder' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'tatb-admin-style',
            TATB_PLUGIN_URL . 'assets/css/admin-style.css',
            array(),
            TATB_VERSION
        );

        wp_enqueue_script(
            'tatb-admin-script',
            TATB_PLUGIN_URL . 'assets/js/admin-script.js',
            array('jquery'),
            TATB_VERSION,
            true
        );
    }
}

/**
 * Initialize the plugin
 */
function techark_theme_builder()
{
    return TechArk_Theme_Builder::get_instance();
}

// Start the plugin
techark_theme_builder();
