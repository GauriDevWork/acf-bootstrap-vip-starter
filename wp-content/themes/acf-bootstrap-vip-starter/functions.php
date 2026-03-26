<?php

function theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');

function theme_assets() {
    wp_enqueue_style(
        'bootstrap',
        get_template_directory_uri() . '/assets/css/bootstrap.min.css',
        [],
        '5.0'
    );

    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri(),
        ['bootstrap'],
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'theme_assets');