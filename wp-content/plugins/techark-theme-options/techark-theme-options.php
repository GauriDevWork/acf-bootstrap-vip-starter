<?php
/**
 * Plugin Name: TechArk Theme Options
 * Plugin URI:  https://github.com/GauriDevWork/techark-theme-options
 * Description: Global theme options, custom CSS/JS, and ACF field group management for TechArk Bootstrap Theme.
 * Version:     1.0.0
 * Author:      Gauri Kaushik
 * License:     GPL-2.0+
 * Text Domain: techark-theme-options
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TECHARK_OPTIONS_VERSION', '1.0.0' );
define( 'TECHARK_OPTIONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'TECHARK_OPTIONS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register field group for Theme options.
 */
add_action( 'acf/init', 'techark_register_custom_code_fields' );

function techark_register_custom_code_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'      => 'group_techark_custom_code',
        'title'    => 'Custom Code',
        'fields'   => array(
            array(
                'key'          => 'field_techark_global_css',
                'label'        => 'Global CSS',
                'name'         => 'techark_global_css',
                'type'         => 'textarea',
                'instructions' => 'Custom CSS injected into every page. Do not include <style> tags.',
                'rows'         => 10,
            ),
            array(
                'key'          => 'field_techark_global_js',
                'label'        => 'Global JavaScript',
                'name'         => 'techark_global_js',
                'type'         => 'textarea',
                'instructions' => 'Custom JS injected before </body>. Do not include <script> tags.',
                'rows'         => 10,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'acf-options', // match your ACF options page slug exactly
                ),
            ),
        ),
    ) );
}

/**
 * Add CSS.
 */
add_action( 'wp_head', 'techark_output_global_css', 99 );

function techark_output_global_css() {
    $css = get_field( 'techark_global_css', 'option' );
    if ( ! $css ) return;
    $css = wp_strip_all_tags( $css ); // NOT wp_kses — that breaks CSS syntax
    echo '<style id="techark-global-css">' . $css . '</style>';
}

/**
 * Add JS.
 */
add_action( 'wp_footer', 'techark_output_global_js', 99 );

function techark_output_global_js() {
    $js = get_field( 'techark_global_js', 'option' );
    if ( ! $js ) return;
    $js = wp_strip_all_tags( $js );
    echo '<script id="techark-global-js">' . $js . '</script>';
}