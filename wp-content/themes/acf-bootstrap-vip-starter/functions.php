<?php
/**
 * Sets up theme defaults and registers support for various WordPress
 * features such as title tag, post thumbnails, and HTML5 markup.
 *
 * @since 1.0.0
 */

function acf_vip_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption']);
}
add_action('after_setup_theme', 'acf_vip_theme_setup');

/**
 * Enqueue assets for the theme.
 *
 * Enqueue Bootstrap CSS and JS, as well as the theme's stylesheet.
 *
 * @since 1.0.0
 */

function acf_vip_enqueue_assets() {

    $theme_version = wp_get_theme()->get('Version');

    // Styles
    wp_enqueue_style(
        'bootstrap',
        get_template_directory_uri() . '/assets/css/bootstrap.min.css',
        [],
        '5.0',
        'all'
    );

    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri(),
        ['bootstrap'],
        $theme_version
    );

    // Scripts
    wp_enqueue_script(
        'bootstrap',
        get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js',
        [],
        '5.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'acf_vip_enqueue_assets');

/**
 * Defer scripts that are not needed immediately.
 *
 * If the script is in the list of defer scripts, this function
 * will return the script tag with the src attribute replaced with
 * defer src.
 *
 * @param string $tag The script tag.
 * @param string $handle The script handle.
 * @return string The modified script tag.
 */
function acf_vip_defer_scripts($tag, $handle) {

    $defer_scripts = ['bootstrap'];

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'acf_vip_defer_scripts', 10, 2);


// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove wp-embed
function acf_vip_remove_wp_embed() {
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'acf_vip_remove_wp_embed');

// Remove block library CSS (if not using Gutenberg)
function acf_vip_remove_block_css() {
    wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'acf_vip_remove_block_css', 100);



// ACF JSON save path
add_filter('acf/settings/save_json', function() {
    return get_stylesheet_directory() . '/acf-json';
});

// ACF JSON load path
add_filter('acf/settings/load_json', function($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});