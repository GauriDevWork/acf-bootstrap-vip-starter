<?php
/**
 * Redux Framework Configuration
 */

if (!defined('ABSPATH')) {
    exit;
}

// Bail if Redux is not installed
if (!class_exists('Redux')) {
    return;
}

$opt_name = {{UPPER_PREFIX}}_REDUX_OPT_NAME;

// Arguments
$args = array(
    'opt_name'             => $opt_name,
    'display_name'         => '{{TEXT_DOMAIN}} Options',
    'display_version'      => '1.0.0',
    'menu_type'            => 'menu',
    'allow_sub_menu'       => true,
    'menu_title'           => __('Theme Options', '{{TEXT_DOMAIN}}'),
    'page_title'           => __('Theme Options', '{{TEXT_DOMAIN}}'),
    'page_priority'        => 81,
    'dev_mode'             => false,
    'customizer'           => true,
    'page_permissions'     => 'edit_theme_options',
    'save_defaults'        => true,
    'show_import_export'   => true,
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    'output_tag'           => true,
);

Redux::setArgs($opt_name, $args);

// General Section
Redux::setSection($opt_name, array(
    'title'  => __('General', '{{TEXT_DOMAIN}}'),
    'id'     => 'general',
    'icon'   => 'el el-cog',
    'fields' => array(
        array(
            'id'       => 'container_width',
            'type'     => 'slider',
            'title'    => __('Container Width', '{{TEXT_DOMAIN}}'),
            'default'  => 1200,
            'min'      => 960,
            'step'     => 10,
            'max'      => 1920,
        ),
    )
));

// Typography Section
Redux::setSection($opt_name, array(
    'title'  => __('Typography', '{{TEXT_DOMAIN}}'),
    'id'     => 'typography',
    'icon'   => 'el el-font',
    'fields' => array(
        array(
            'id'       => 'content_font',
            'type'     => 'typography',
            'title'    => __('Content Font', '{{TEXT_DOMAIN}}'),
            'google'   => true,
            'default'  => array(
                'font-family' => 'Open Sans',
                'font-weight' => '400',
            ),
        ),
        array(
            'id'       => 'headings_font',
            'type'     => 'typography',
            'title'    => __('Headings Font', '{{TEXT_DOMAIN}}'),
            'google'   => true,
            'default'  => array(
                'font-family' => 'Montserrat',
                'font-weight' => '600',
            ),
        ),
    )
));

// Colors Section
Redux::setSection($opt_name, array(
    'title'  => __('Colors', '{{TEXT_DOMAIN}}'),
    'id'     => 'colors',
    'icon'   => 'el el-brush',
    'fields' => array(
        array(
            'id'       => 'color_primary',
            'type'     => 'color',
            'title'    => __('Primary Color', '{{TEXT_DOMAIN}}'),
            'default'  => '#0073aa',
        ),
        array(
            'id'       => 'color_secondary',
            'type'     => 'color',
            'title'    => __('Secondary Color', '{{TEXT_DOMAIN}}'),
            'default'  => '#23282d',
        ),
    ),
));
