<?php

/**
 * Redux Options for the theme
 */
if (!class_exists('Redux')) {
    return;
}

/**
 * Option name – used as the DB key. Also becomes the global variable (if enabled).
 */

$opt_name = '{{THEME_PREFIX}}options'; // change if you like

$theme = wp_get_theme();

$args = array(
    'opt_name' => $opt_name,
    'display_name' => $theme->get('Name'),
    'display_version' => $theme->get('Version'),
    'menu_type' => 'menu',
    'allow_sub_menu' => true,
    'menu_title' => __('Theme Options', '{{TEXT_DOMAIN}}'),
    'page_title' => __('Theme Options', '{{TEXT_DOMAIN}}'),
    'page_priority' => 81,
    'menu_icon' => 'dashicons-admin-generic',
    'admin_bar' => true,
    'dev_mode' => false,
    'update_notice' => false,
    'customizer' => false,
    'global_variable' => '{{THEME_PREFIX}}options',
    'save_defaults' => true,
    'show_import_export' => true,
    'async_typography' => true,
    'display_inline' => false,
    'output_tag' => false,
    'database' => 'options',
    'default_mark' => '*',
    'hints' => array(
        'icon' => 'el el-cog',
        'icon_position' => 'right',
        'tip_style' => array('color' => 'light'),
        'tip_position' => array('my' => 'top left', 'at' => 'bottom right'),
        'tip_effect' => array(
            'show' => array('duration' => '500', 'event' => 'mouseover'),
            'hide' => array('duration' => '500', 'event' => 'mouseleave')
        ),
    ),
    'permissions' => array('capability' => 'edit_theme_options'),
);


Redux::setArgs($opt_name, $args);

Redux_Metaboxes::set_box($opt_name, array(
    'id' => 'page_banner_box',
    'title' => esc_html__('Banner', '{{TEXT_DOMAIN}}'),
    'post_types' => array('page', 'physicians', 'post', 'services'),
    'position' => 'normal',
    'priority' => 'high',
    'database' => 'meta',
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'sections' => array(
        array(
            'id' => 'page_banner_section',
            'title' => esc_html__('', '{{TEXT_DOMAIN}}'),
            'fields' => array(
                array(
                    'id' => 'banner_enable',
                    'type' => 'switch',
                    'title' => esc_html__('Enable Banner', '{{TEXT_DOMAIN}}'),
                    'default' => true,
                ),
                array(
                    'id' => 'banner_title',
                    'type' => 'text',
                    'title' => esc_html__('Heading', '{{TEXT_DOMAIN}}'),
                    'subtitle' => esc_html__('Leave empty to use page Heading.', '{{TEXT_DOMAIN}}'),
                    'required' => array('banner_enable', '=', true),
                ),
                array(
                    'id' => 'banner_bg_type',
                    'type' => 'switch',
                    'title' => esc_html__('Background Type', '{{TEXT_DOMAIN}}'),
                    'on' => esc_html__('Image', '{{TEXT_DOMAIN}}'),
                    'off' => esc_html__('Color', '{{TEXT_DOMAIN}}'),
                    'default' => true,
                    'required' => array('banner_enable', '=', true),
                ),
                array(
                    'id' => 'page_banner_color',
                    'type' => 'color',
                    'title' => __('Background Color', '{{TEXT_DOMAIN}}'),
                    'default' => '#E6F5FF',
                    'transparent' => false,
                    'required' => array('banner_bg_type', '=', false),
                ),
                array(
                    'id' => 'page_banner_image',
                    'type' => 'background',
                    'title' => __('Background Image', '{{TEXT_DOMAIN}}'),
                    'subtitle' => esc_html__('Size: 1920 X 486 | If an image is not added, a color will be displayed instead. ', '{{TEXT_DOMAIN}}'),
                    'url' => true,
                    'transparent' => false,
                    'default' => array(
                        'background-color' => '#E6F5FF',
                        'background-repeat' => 'no-repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-image' => get_stylesheet_directory_uri() . '/assets/options-assets/images/default-banner.jpg'
                    ),
                    'required' => array('banner_bg_type', '=', true),
                ),
                array(
                    'id' => 'banner_title_align',
                    'type' => 'button_set',
                    'title' => __('Heading Alignment', '{{TEXT_DOMAIN}}'),
                    'options' => array(
                        'left' => __('Left', '{{TEXT_DOMAIN}}'),
                        'center' => __('Center', '{{TEXT_DOMAIN}}'),
                        'right' => __('Right', '{{TEXT_DOMAIN}}'),
                    ),
                    'default' => 'left',
                    'required' => array('banner_enable', '=', true),
                ),
                array(
                    'id' => 'banner_padding',
                    'type' => 'dimensions',
                    'title' => __('Paddings Top/Bottom', '{{TEXT_DOMAIN}}'),
                    'subtitle' => __('Set top and bottom padding in px.', '{{TEXT_DOMAIN}}'),
                    'units' => false,
                    'height' => true,
                    'width' => true,
                    'default' => array(
                        'width' => '260',
                        'height' => '150',
                    ),
                    'required' => array('banner_enable', '=', true),
                )
            ),
        ),
    ),
));

/**
 * General SECTION
 */

Redux::setSection($opt_name, array(
    'title' => __('General', '{{TEXT_DOMAIN}}'),
    'id' => 'general',
    'icon' => 'el el-cog',
    'fields' => array(
        array(
            'id' => 'container_width',
            'type' => 'button_set',
            'title' => esc_html__('Container Width', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'default_container' => esc_html__('Default', '{{TEXT_DOMAIN}}'),
                'boxed_container' => esc_html__('Boxed', '{{TEXT_DOMAIN}}'),
                'fullwidth_container' => esc_html__('Full Width', '{{TEXT_DOMAIN}}'),
            ),
            'default' => 'default_container',
        ),
        array(
            'id' => 'boxed_container_width',
            'type' => 'slider',
            'title' => esc_html__('Boxed Container Width', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('Set the width for boxed layout.', '{{TEXT_DOMAIN}}'),
            'default' => 1810,
            'min' => 1500,
            'step' => 10,
            'max' => 1900,
            'display_value' => 'text',
            'required' => array('container_width', '=', 'boxed_container'),
        ),
        array(
            'id' => 'back_to_top',
            'type' => 'switch',
            'title' => esc_html__('Scroll to Top Button', '{{TEXT_DOMAIN}}'),
            'on' => esc_html__('Enable', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('Disable', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
    )
));

/**
 * LOGO SECTION
 */

Redux::setSection($opt_name, array(
    'title' => __('Logos', '{{TEXT_DOMAIN}}'),
    'id' => 'general_logos',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'favicon_logo',
            'type' => 'media',
            'title' => __('Favicon', '{{TEXT_DOMAIN}}'),
            'url' => true,
            'preview' => true,
            'preview_size' => 'full',
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/options-assets/images/favicon.png',
            ),
        ),
        array(
            'id' => 'retina_logo',
            'type' => 'media',
            'title' => __('Retina Logo', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('MacBooks, iPhones, modern smartphones', '{{TEXT_DOMAIN}}'),
            'url' => true,
            'preview' => true,
            'preview_size' => 'full',
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/options-assets/images/header-logo.svg',
            ),
        ),
        array(
            'id' => 'header_logo',
            'type' => 'media',
            'title' => __('Header Logo', '{{TEXT_DOMAIN}}'),
            'url' => true,
            'preview' => true,
            'preview_size' => 'full',
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/options-assets/images/header-logo.svg',
            ),
        ),
        array(
            'id' => 'header_logo_url',
            'type' => 'text',
            'title' => __('Logo Link', '{{TEXT_DOMAIN}}'),
            'default' => site_url(),
        ),
        array(
            'id' => 'header_logo_target',
            'type' => 'select',
            'title' => __('Link Target', '{{TEXT_DOMAIN}}'),
            'options' => array(
                '_self' => __('Same Tab', '{{TEXT_DOMAIN}}'),
                '_blank' => __('New Tab', '{{TEXT_DOMAIN}}'),
            ),
            'default' => '_self',
        ),
        array(
            'id' => 'footer_logo',
            'type' => 'media',
            'title' => __('Footer Logo', '{{TEXT_DOMAIN}}'),
            'preview' => true,
            'preview_size' => 'full',
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/options-assets/images/footer-logo.svg',
            ),
        ),
        array(
            'id' => 'footer_logo_url',
            'type' => 'text',
            'title' => __('Logo Link', '{{TEXT_DOMAIN}}'),
            'default' => site_url(),
        ),
        array(
            'id' => 'footer_logo_target',
            'type' => 'select',
            'title' => __('Link Target', '{{TEXT_DOMAIN}}'),
            'options' => array(
                '_self' => __('Same Tab', '{{TEXT_DOMAIN}}'),
                '_blank' => __('New Tab', '{{TEXT_DOMAIN}}'),
            ),
            'default' => '_self',
        ),
        array(
            'id' => 'admin_logo',
            'type' => 'media',
            'title' => __('Admin Login Logo', '{{TEXT_DOMAIN}}'),
            'preview' => true,
            'preview_size' => 'full',
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/options-assets/images/header-logo.svg',
            ),
        ),
        array(
            'id' => 'email_logo',
            'type' => 'media',
            'title' => __('Email Template Logo', '{{TEXT_DOMAIN}}'),
            'preview' => true,
            'preview_size' => 'full',
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/options-assets/images/email-logo.png',
            ),
        ),
        array(
            'id' => 'placeholder_image',
            'type' => 'media',
            'title' => __('Default Placeholder Image', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('This image is required. It will be used if users have not added an image in the required sections.', '{{TEXT_DOMAIN}}'),
            'preview' => true,
            'preview_size' => 'full',
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/options-assets/images/placeholder.jpg',
            ),
        )
    )
));

/**
 * HEADER SECTION
 */

Redux::setSection($opt_name, array(
    'title' => __('Header', '{{TEXT_DOMAIN}}'),
    'id' => 'header',
    'icon' => 'el el-arrow-up',
    'fields' => array(
        array(
            'id' => 'header_menu',
            'type' => 'select',
            'title' => __('Header Menu', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Default primary menu will set.', '{{TEXT_DOMAIN}}'),
            'options' => {{THEME_PREFIX}}get_wp_menus(),
            'default' => {{THEME_PREFIX}}get_primary_menu_id(),
        ),
        array(
            'id' => '{{THEME_PREFIX}}buttons',
            'type' => 'repeater',
            'title' => __('Buttons', '{{TEXT_DOMAIN}}'),
            'group_values' => true,
            'max' => 2,
            'fields' => array(
                array(
                    'id' => 'text',
                    'type' => 'text',
                    'title' => __('Text', '{{TEXT_DOMAIN}}'),
                    'default' => __('Contact Us', '{{TEXT_DOMAIN}}'),
                ),
                array(
                    'id' => 'url',
                    'type' => 'text',
                    'title' => __('Link', '{{TEXT_DOMAIN}}'),
                    'default' => '#',
                ),
                array(
                    'id' => 'target',
                    'type' => 'select',
                    'title' => __('Link Target', '{{TEXT_DOMAIN}}'),
                    'options' => array(
                        '_self' => __('Same Tab', '{{TEXT_DOMAIN}}'),
                        '_blank' => __('New Tab', '{{TEXT_DOMAIN}}'),
                    ),
                    'default' => '_self',
                ),
            ),
        ),
        array(
            'id' => 'topbar_enable',
            'type' => 'switch',
            'title' => __('Enable Top Bar', '{{TEXT_DOMAIN}}'),
            'default' => false,
        ),
        array(
            'id' => 'social_media',
            'type' => 'switch',
            'title' => __('Social Media', '{{TEXT_DOMAIN}}'),
            'default' => true,
            'on' => __('Enable', '{{TEXT_DOMAIN}}'),
            'off' => __('Disable', '{{TEXT_DOMAIN}}'),
            'required' => array('topbar_enable', '=', true),
        ),
        array(
            'id' => 'header_social_bg',
            'type' => 'link_color',
            'title' => __('Social Background Color', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'required' => array('social_media', '=', true),
            'active' => false,
            'default' => array(
                'regular' => '#21409A',
                'hover' => '#c31f27',
            )
        ),
        array(
            'id' => 'header_social_icon_color',
            'type' => 'link_color',
            'title' => __('Social Icons Color', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'required' => array('social_media', '=', true),
            'active' => false,
            'default' => array(
                'regular' => '#FFFFFF',
                'hover' => '#FFFFFF',
            )
        ),
        array(
            'id' => 'topbar_text',
            'type' => 'editor',
            'title' => __('Top Bar Text', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Leave empty if you don’t want to show'),
            'default' => 'Lorem, ipsum dolor sit amet <strong>amet</strong> consectetur <a href="#">testing</a> adipisicing elit. Laborum, enim.',
            'args' => array(
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => true,
            ),
            'required' => array('topbar_enable', '=', true),
        ),
        array(
            'id' => 'topbar_contact_info',
            'type' => 'editor',
            'title' => __('Contact Info', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Add shortcode, phone, email, or address for the Top Bar. Leave empty if you don’t want to show', '{{TEXT_DOMAIN}}'),
            'default' => '<a href="tel:7578687600">(757) 868-7600</a> | <a href="mailto:test@test.com">test@test.com</a> | ',
            'args' => array(
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => true,
            ),
            'required' => array('topbar_enable', '=', true),
        ),
        array(
            'id' => 'google_translate',
            'type' => 'switch',
            'title' => esc_html__('Enable Google Translate?', '{{TEXT_DOMAIN}}'),
            //'subtitle'   => esc_html__('To add the Google Translate we need to required this plugin:<a href="https://wordpress.org/plugins/gtranslate/" target="_blank">Translate WordPress with GTranslate</a>', '{{TEXT_DOMAIN}}'),
            'subtitle' => wp_kses(
                sprintf(
                    __('To add Google Translate we need this plugin: <a href="%1$s" target="_blank">Translate WordPress with GTranslate</a>', '{{TEXT_DOMAIN}}'),
                    'https://wordpress.org/plugins/gtranslate/'
                ),
                array(
                    'a' => array(
                        'href' => array(),
                        'target' => array()
                    )
                )
            ),
            'on' => esc_html__('Yes', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('No', '{{TEXT_DOMAIN}}'),
            'default' => true,
            'required' => array('topbar_enable', '=', true),
        ),
    )
));


Redux::setSection(
    $opt_name,
    array(
        'title' => __('Header Builder', '{{TEXT_DOMAIN}}'),
        'id' => 'header_builder',
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'header_fullwidth',
                'type' => 'switch',
                'title' => __('Full Width ?', '{{TEXT_DOMAIN}}'),
                'on' => __('On', '{{TEXT_DOMAIN}}'),
                'off' => __('Off', '{{TEXT_DOMAIN}}'),
                'default' => false,
            ),
            array(
                'id' => 'header_layout',
                'type' => 'image_select',
                'title' => esc_html__('Header Layout', '{{TEXT_DOMAIN}}'),
                'subtitle' => esc_html__('Choose the header layout style.', '{{TEXT_DOMAIN}}'),
                'options' => array(
                    'left-logo' => array(
                        'alt' => esc_html__('Left Logo', '{{TEXT_DOMAIN}}'),
                        'img' => get_template_directory_uri() . '/assets/options-assets/images/header-left-logo.png'
                    ),
                    'logo-above-centered' => array(
                        'alt' => esc_html__('Logo Above Menu', '{{TEXT_DOMAIN}}'),
                        'img' => get_template_directory_uri() . '/assets/options-assets/images/header-logo-above.png'
                    )
                ),
                'default' => 'left-logo',
                'mode' => 'list'
            ),
            array(
                'id' => 'sticky_header',
                'type' => 'switch',
                'title' => esc_html__('Sticky Header', '{{TEXT_DOMAIN}}'),
                'subtitle' => esc_html__('Enable or disable sticky header.', '{{TEXT_DOMAIN}}'),
                'on' => esc_html__('On', '{{TEXT_DOMAIN}}'),
                'off' => esc_html__('Off', '{{TEXT_DOMAIN}}'),
                'default' => true,
            ),
            array(
                'id' => 'transparent_header',
                'type' => 'switch',
                'title' => esc_html__('Transparent Header', '{{TEXT_DOMAIN}}'),
                'subtitle' => esc_html__('Enable or disable transparent header.', '{{TEXT_DOMAIN}}'),
                'on' => esc_html__('On', '{{TEXT_DOMAIN}}'),
                'off' => esc_html__('Off', '{{TEXT_DOMAIN}}'),
                'default' => false,
            ),
            array(
                'id' => 'transparent_header_opacity',
                'type' => 'slider',
                'title' => esc_html__('Header Opacity', '{{TEXT_DOMAIN}}'),
                'subtitle' => esc_html__('Adjust the transparency level of the header.', '{{TEXT_DOMAIN}}'),
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => 0.9,
                'resolution' => 0.1,
                'display_value' => 'label',
                'required' => array('transparent_header', '=', true),
            ),
            array(
                'id' => 'header_background_color',
                'type' => 'color',
                'title' => esc_html__('Header Background Color', '{{TEXT_DOMAIN}}'),
                'subtitle' => esc_html__('Pick a background color for the header.', '{{TEXT_DOMAIN}}'),
                'default' => '#ffffff',
                'transparent' => false,
                'validate' => 'color',
            ),
            array(
                'id' => 'menu_and_arrow_color_code',
                'type' => 'switch',
                'title' => esc_html__('Do you want to set the Menu and Arrow Color?', '{{TEXT_DOMAIN}}'),
                'subtitle' => esc_html__('Default Secondary color will be used.', '{{TEXT_DOMAIN}}'),
                'on' => esc_html__('Yes', '{{TEXT_DOMAIN}}'),
                'off' => esc_html__('No', '{{TEXT_DOMAIN}}'),
                'default' => false,
            ),
            array(
                'id' => 'menu_and_arrow_color',
                'type' => 'color',
                'title' => esc_html__('Menu and Arrow Color', '{{TEXT_DOMAIN}}'),
                'default' => '#08184D',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('menu_and_arrow_color_code', '=', true),
            ),
            array(
                'id' => 'nav_dropdown_animation',
                'type' => 'button_set',
                'title' => __('Dropdown Animation', '{{TEXT_DOMAIN}}'),
                'subtitle' => __('Select the animation style for dropdown menus.', '{{TEXT_DOMAIN}}'),
                'options' => array(
                    'submenu-fadeinup' => __('Fade In Up', '{{TEXT_DOMAIN}}'),
                    'submenu-fadeindown' => __('Fade In Down', '{{TEXT_DOMAIN}}'),
                    'submenu-fadeinleft' => __('Fade In Left', '{{TEXT_DOMAIN}}'),
                    'submenu-fadeinright' => __('Fade In Right', '{{TEXT_DOMAIN}}'),
                ),
                'default' => 'submenu-fadeinup',
            ),
            array(
                'id' => 'enable_off_canvas',
                'type' => 'switch',
                'title' => esc_html__('Mobile Off-Canvas Menu?', '{{TEXT_DOMAIN}}'),
                'on' => esc_html__('Enable', '{{TEXT_DOMAIN}}'),
                'off' => esc_html__('Disable', '{{TEXT_DOMAIN}}'),
                'default' => false,
            ),
            array(
                'id' => 'mobile_menu_type',
                'type' => 'button_set',
                'title' => esc_html__('Mobile Off-Canvas Menu Position.', '{{TEXT_DOMAIN}}'),
                'options' => array(
                    'left' => esc_html__('Left', '{{TEXT_DOMAIN}}'),
                    'right' => esc_html__('Right', '{{TEXT_DOMAIN}}'),
                ),
                'default' => 'left',
                'required' => array('enable_off_canvas', '=', true),
            )
        )
    )
);


/* ----------------------------------------
 * Section: Typography
 * -------------------------------------- */

Redux::setSection($opt_name, array(
    'title' => __('Typography', '{{TEXT_DOMAIN}}'),
    'id' => 'typography',
    'icon' => 'el el-font',
    'fields' => array(
        array(
            'id' => 'content_font',
            'type' => 'typography',
            'title' => __('Content Font', '{{TEXT_DOMAIN}}'),
            'google' => true,
            'font-backup' => false,
            'font-family' => true,
            'font-weight' => true,
            'font-style' => false,
            'color' => false,
            'text-align' => false,
            'line-height' => false,
            'letter-spacing' => false,
            'font-size' => false,
            'all_styles' => false,
            'subsets' => false,
            'units' => 'px',
            'default' => array(
                'font-family' => 'Libre Franklin',
                'font-weight' => '300'
            )
        ),
        array(
            'id' => 'content_font_color',
            'type' => 'switch',
            'title' => esc_html__('Do you want to set the Content color?', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('Default Secondary color will be used.', '{{TEXT_DOMAIN}}'),
            'on' => esc_html__('Yes', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('No', '{{TEXT_DOMAIN}}'),
            'default' => false,
        ),
        array(
            'id' => 'content_font_color_code',
            'type' => 'color',
            'title' => esc_html__('Content Font Color', '{{TEXT_DOMAIN}}'),
            'default' => '#08184d',
            'transparent' => false,
            'validate' => 'color',
            'required' => array('content_font_color', '=', true),
        ),
        array(
            'id' => 'headings_font',
            'type' => 'typography',
            'title' => __('Headings Font', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('This will apply on the H1 to H6', '{{TEXT_DOMAIN}}'),
            'google' => true,
            'font-backup' => false,
            'font-family' => true,
            'font-weight' => true,
            'font-style' => false,
            'color' => false,
            'text-align' => false,
            'line-height' => false,
            'letter-spacing' => false,
            'font-size' => false,
            'all_styles' => false,
            'subsets' => false,
            'units' => 'px',
            'default' => array(
                'font-family' => 'Libre Franklin',
                'font-weight' => '500'
            ),
        ),
        array(
            'id' => 'headings_font_color',
            'type' => 'switch',
            'title' => esc_html__('Do you want to set the Heading color?', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('Default Secondary color will be used.', '{{TEXT_DOMAIN}}'),
            'on' => esc_html__('Yes', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('No', '{{TEXT_DOMAIN}}'),
            'default' => false,
        ),
        array(
            'id' => 'heading_font_color_code',
            'type' => 'color',
            'title' => esc_html__('Heading Font Color', '{{TEXT_DOMAIN}}'),
            'default' => '#08184d',
            'transparent' => false,
            'validate' => 'color',
            'required' => array('headings_font_color', '=', true),
        ),
    )
));


/* ----------------------------------------
 * Section: Colors
 * -------------------------------------- */

Redux::setSection($opt_name, array(
    'title' => __('Colors', '{{TEXT_DOMAIN}}'),
    'id' => 'colors',
    'icon' => 'el el-brush',
    'fields' => array(
        array(
            'id' => 'color_1',
            'type' => 'color',
            'title' => __('Primary Color', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('The main accent color used for highlights and key interactive elements.', '{{TEXT_DOMAIN}}'),
            'validate' => 'color',
            'default' => '#C31F27',
            'transparent' => false,
        ),
        array(
            'id' => 'color_2',
            'type' => 'color',
            'title' => __('Secondary Color', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('A supporting color used for headings, descriptions, and icons to complement the primary color.', '{{TEXT_DOMAIN}}'),
            'validate' => 'color',
            'default' => '#08184D',
            'transparent' => false,
        ),
        array(
            'id' => 'color_section',
            'type' => 'section',
            'title' => __('Other color palette', '{{TEXT_DOMAIN}}'),
            'indent' => true,
            'transparent' => false,
        ),
        array(
            'id' => 'dark_section_colors',
            'type' => 'link_color', // or 'color' (multi) depending on your config
            'title' => __('Dark Section Colors', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Set the background and text colors for dark sections.', '{{TEXT_DOMAIN}}'),
            'active' => false,
            'default' => array(
                'regular' => '#040b22',
                'hover' => '#ffffff',
            )
        ),
        array(
            'id' => 'default_banner_bg_color',
            'type' => 'color',
            'default' => '#E6F5FF',
            'title' => __('Global Background', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Use this color for sections and banner backgrounds.', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
        ),
        array(
            'id' => 'link_color',
            'type' => 'link_color',
            'title' => __('Link Colors', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Use this color for all links.', '{{TEXT_DOMAIN}}'),
            'validate' => 'color',
            'active' => false,
            'transparent' => false,
            'default' => array(
                'regular' => '#08184D',
                'hover' => '#DD3333',
            ),
        )
    ),
));


/* ----------------------------------------
 * Section: Buttons
 * -------------------------------------- */

Redux::setSection($opt_name, array(
    'title' => __('Buttons', '{{TEXT_DOMAIN}}'),
    'id' => 'buttons',
    'icon' => 'el el-icon-plus-sign',
    'fields' => array(
        array(
            'id' => 'button_typography',
            'type' => 'typography',
            'title' => __('Typography', '{{TEXT_DOMAIN}}'),
            'google' => true,
            'font-backup' => false,
            'font-family' => true,
            'font-weight' => true,
            'font-style' => false,
            'color' => true,
            'text-align' => false,
            'line-height' => false,
            'letter-spacing' => false,
            'font-size' => false,
            'all_styles' => false,
            'subsets' => false,
            'units' => 'px',
            'default' => array(
                'font-family' => 'Libre Franklin',
                'font-weight' => '300',
                'color' => '#ffffff',
            ),
        ),
        array(
            'id' => 'button_bg_color',
            'type' => 'color',
            'title' => __('Background Color', '{{TEXT_DOMAIN}}'),
            'validate' => 'color',
            'transparent' => false,
            'default' => '#C31F27',
        ),
        array(
            'id' => 'button_border',
            'type' => 'border',
            'title' => esc_html__('Button Border', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('Set border size, style and color.', '{{TEXT_DOMAIN}}'),
            'all' => true,
            'default' => array(
                'border-color' => '#c31f27',
                'border-style' => 'solid',
                'border-top' => '1px',
                'border-right' => '1px',
                'border-bottom' => '1px',
                'border-left' => '1px',
            ),
        ),
        array(
            'id' => 'button_radius',
            'type' => 'slider',
            'title' => __('Border Radius', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Set the border radius for buttons.', '{{TEXT_DOMAIN}}'),
            'default' => 240,
            'min' => 0,
            'step' => 1,
            'max' => 500,
            'display_value' => 'text'
        ),
        array(
            'id' => 'on_button_hover',
            'type' => 'link_color',
            'title' => __('On Button Hover', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'active' => true,
            'output' => false,
            'compiler' => false,
            'default' => array(
                'regular' => '#FFFFFF',
                'hover' => '#C31F27',
                'active' => '#C31F27',
            ),
            'validate' => 'not_empty',
        ),
        array(
            'id' => 'arrow_enable',
            'type' => 'switch',
            'title' => esc_html__('Enable Arrow?', '{{TEXT_DOMAIN}}'),
            'on' => esc_html__('Enable', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('Disable', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
        array(
            'id' => 'arrow_color',
            'type' => 'link_color',
            'title' => __('Arrow Color', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'required' => array('arrow_enable', '=', true),
            'active' => false,
            'default' => array(
                'regular' => '#FFFFFF',
                'hover' => '#C31F27',
            )
        )
    ),
));

/**
 * 404 PAGE SECTION
 */

Redux::setSection($opt_name, array(
    'title' => __('404 Page', '{{TEXT_DOMAIN}}'),
    'id' => '404_page',
    'icon' => 'el el-refresh',
    'fields' => array(
        array(
            'id' => 'banner_enable',
            'type' => 'switch',
            'title' => esc_html__('Enable Banner', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
        array(
            'id' => 'banner_bg_type',
            'type' => 'switch',
            'title' => esc_html__('Background Type', '{{TEXT_DOMAIN}}'),
            'on' => esc_html__('Image', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('Color', '{{TEXT_DOMAIN}}'),
            'default' => true,
            'required' => array('banner_enable', '=', true),
        ),
        array(
            'id' => 'page_banner_color',
            'type' => 'color',
            'title' => __('Background Color', '{{TEXT_DOMAIN}}'),
            'default' => '#e6f5ff',
            'transparent' => false,
            'required' => array('banner_bg_type', '=', false),
        ),
        array(
            'id' => 'page_banner_image',
            'type' => 'background',
            'title' => __('Background Image', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('Size: 1920 X 486 ', '{{TEXT_DOMAIN}}'),
            'url' => true,
            'transparent' => false,
            'default' => array(
                'background-color' => '#E6F5FF',
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-attachment' => 'scroll',
                'background-position' => 'center center',
                'background-image' => get_stylesheet_directory_uri() . '/assets/options-assets/images/default-banner.jpg'
            ),
            'required' => array('banner_bg_type', '=', true),
        ),
        array(
            'id' => 'banner_title_align',
            'type' => 'button_set',
            'title' => __('Heading Alignment', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'left' => __('Left', '{{TEXT_DOMAIN}}'),
                'center' => __('Center', '{{TEXT_DOMAIN}}'),
                'right' => __('Right', '{{TEXT_DOMAIN}}'),
            ),
            'default' => 'left',
            'required' => array('banner_enable', '=', true),
        ),
        array(
            'id' => 'banner_padding',
            'type' => 'dimensions',
            'title' => __('Paddings Top/Bottom', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Set top and bottom padding in px.', '{{TEXT_DOMAIN}}'),
            'units' => false,
            'height' => true,
            'width' => true,
            'default' => array(
                'width' => '260',
                'height' => '150',
            ),
            'required' => array('banner_enable', '=', true),
        ),
        array(
            'id' => 'heading',
            'type' => 'text',
            'title' => __('Heading', '{{TEXT_DOMAIN}}'),
            'default' => '404',
        ),
        array(
            'id' => 'sub_heading',
            'type' => 'text',
            'title' => __('Sub Heading', '{{TEXT_DOMAIN}}'),
            'default' => 'Oops! That page can’t be found.',
        ),
        array(
            'id' => 'page_content',
            'type' => 'editor',
            'default' => '<strong>Not all who wander are lost.</strong><br/>You are not one of them.',
            'title' => __('Content', '{{TEXT_DOMAIN}}'),
            'args' => array(
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => true,
            ),
        ),
        array(
            'id' => 'btn_text',
            'type' => 'text',
            'title' => __('Button', '{{TEXT_DOMAIN}}'),
            'default' => __('Back to Home', '{{TEXT_DOMAIN}}'),
        ),
        array(
            'id' => 'btn_url',
            'type' => 'text',
            'title' => __('Link', '{{TEXT_DOMAIN}}'),
            'default' => site_url(),
        ),
        array(
            'id' => 'btn_target',
            'type' => 'select',
            'title' => __('Link Target', '{{TEXT_DOMAIN}}'),
            'options' => array(
                '_self' => __('Same Tab', '{{TEXT_DOMAIN}}'),
                '_blank' => __('New Tab', '{{TEXT_DOMAIN}}'),
            ),
            'default' => '_self',
        ),
    )
));

/**
 * FOOTER SECTION
 */
Redux::setSection($opt_name, array(
    'title' => __('Footer', '{{TEXT_DOMAIN}}'),
    'id' => 'footer',
    'icon' => 'el el-arrow-down',
    'fields' => array(
        array(
            'id' => 'footer_social',
            'type' => 'switch',
            'title' => esc_html__('Social Media', '{{TEXT_DOMAIN}}'),
            'on' => esc_html__('Enable', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('Disable', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
        array(
            'id' => 'footer_social_bg',
            'type' => 'link_color',
            'title' => __('Social Background Color', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'required' => array('footer_social', '=', true),
            'active' => false,
            'default' => array(
                'regular' => '#21409A',
                'hover' => '#c31f27',
            )
        ),
        array(
            'id' => 'footer_social_icon_color',
            'type' => 'link_color',
            'title' => __('Social Icons Color', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'required' => array('footer_social', '=', true),
            'active' => false,
            'default' => array(
                'regular' => '#FFFFFF',
                'hover' => '#FFFFFF',
            )
        ),
        array(
            'id' => 'copyright',
            'type' => 'editor',
            'title' => __('Copyright Text', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Leave empty if you don’t want to show', '{{TEXT_DOMAIN}}'),
            'default' => '<p>Copyright © [current_year] loremipsumdummy.</p>',
            'args' => array(
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => true,
            ),
        ),
        array(
            'id' => 'credit_line',
            'type' => 'editor',
            'title' => __('Credit Line Text', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Leave empty if you don’t want to show', '{{TEXT_DOMAIN}}'),
            'default' => '<p><a href="{{AUTHOR_URI}}" target="_blank">{{THEME_NAME}} Website Design</a> by <a href="{{AUTHOR_URI}}" target="_blank">{{AUTHOR}}</a></p>',
            'args' => array(
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => true,
            ),
        )
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Footer Builder', '{{TEXT_DOMAIN}}'),
    'id' => 'footer_builder',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'footer_settings',
            'type' => 'section',
            'title' => __('Footer Settings', '{{TEXT_DOMAIN}}'),
            'indent' => true,
            'transparent' => false,
        ),
        array(
            'id' => 'footer_widget',
            'type' => 'switch',
            'title' => esc_html__('Footer Widgets ', '{{TEXT_DOMAIN}}'),
            'on' => esc_html__('Enable', '{{TEXT_DOMAIN}}'),
            'off' => esc_html__('Disable', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
        array(
            'id' => 'footer_columns',
            'type' => 'button_set',
            'title' => __('Columns', '{{TEXT_DOMAIN}}'),
            'options' => array(
                '1' => __('1', '{{TEXT_DOMAIN}}'),
                '2' => __('2', '{{TEXT_DOMAIN}}'),
                '3' => __('3', '{{TEXT_DOMAIN}}'),
                '4' => __('4', '{{TEXT_DOMAIN}}'),
            ),
            'default' => '3',
            'required' => array('footer_widget', '=', true),
        ),
        array(
            'id' => 'footer_columns_layout_2',
            'type' => 'image_select',
            'title' => __('Columns Layout', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose how the 2 columns are arranged.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                '50-50' => array('alt' => '50-50', 'img' => get_template_directory_uri() . '/assets/options-assets/images/50-50.png'),
                '25-75' => array('alt' => '25-75', 'img' => get_template_directory_uri() . '/assets/options-assets/images/25-75.png'),
                '75-25' => array('alt' => '75-25', 'img' => get_template_directory_uri() . '/assets/options-assets/images/75-25.png'),
                '33-66' => array('alt' => '33-66', 'img' => get_template_directory_uri() . '/assets/options-assets/images/33-66.png'),
                '66-33' => array('alt' => '66-33', 'img' => get_template_directory_uri() . '/assets/options-assets/images/66-33.png'),
            ),
            'default' => '50-50',
            'required' => array('footer_columns', '=', '2'),
        ),
        array(
            'id' => 'footer_columns_layout_3',
            'type' => 'image_select',
            'title' => __('Columns Layout', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose how the 3 columns are arranged.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                '33-33-33' => array('alt' => '33-33-33', 'img' => get_template_directory_uri() . '/assets/options-assets/images/33-33-33.png'),
                '25-25-50' => array('alt' => '25-25-50', 'img' => get_template_directory_uri() . '/assets/options-assets/images/25-25-50.png'),
                '25-50-25' => array('alt' => '25-50-25', 'img' => get_template_directory_uri() . '/assets/options-assets/images/25-50-25.png'),
                '50-25-25' => array('alt' => '1/4 + 1/2 + 1/2', 'img' => get_template_directory_uri() . '/assets/options-assets/images/50-25-25.png'),
            ),
            'default' => '33-33-33',
            'required' => array('footer_columns', '=', '3'),
        ),
        array(
            'id' => 'footer_padding',
            'type' => 'spacing',
            'mode' => 'padding',
            'units' => false,
            'title' => __('Paddings', '{{TEXT_DOMAIN}}'),
            'default' => array(
                'padding-top' => '35px',
                'padding-right' => '0px',
                'padding-bottom' => '35px',
                'padding-left' => '0px',
            ),
            'required' => array('footer_widget', '=', true),
        ),
        array(
            'id' => 'footer_styling',
            'type' => 'section',
            'title' => __('Footer Styling', '{{TEXT_DOMAIN}}'),
            'indent' => true,
            'transparent' => false,
        ),
        array(
            'id' => 'footer_fullwidth',
            'type' => 'switch',
            'title' => __('Full Width?', '{{TEXT_DOMAIN}}'),
            'on' => __('On', '{{TEXT_DOMAIN}}'),
            'off' => __('Off', '{{TEXT_DOMAIN}}'),
            'default' => false,
        ),
        array(
            'id' => 'footer_bg_image_and_color',
            'type' => 'background',
            'title' => __('Background Image OR Color', '{{TEXT_DOMAIN}}'),
            'subtitle' => esc_html__('If an image is not added, a color will be displayed instead.', '{{TEXT_DOMAIN}}'),
            'url' => true,
            'transparent' => false,
            'default' => array(
                'background-color' => '#040b22'
            ),
        ),
        array(
            'id' => 'content_align',
            'type' => 'button_set',
            'title' => __('Content Align', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right'
            ),
            'default' => 'left'
        ),
        array(
            'id' => 'footer_headings_color',
            'type' => 'color',
            'title' => __('Headings Color', '{{TEXT_DOMAIN}}'),
            'default' => '#ffffff',
            'transparent' => false
        ),
        array(
            'id' => 'footer_content_color',
            'type' => 'color',
            'title' => __('Content Color', '{{TEXT_DOMAIN}}'),
            'default' => '#ffffff',
            'transparent' => false
        ),
        array(
            'id' => 'add_border_top',
            'type' => 'switch',
            'title' => __('Add Border Top', '{{TEXT_DOMAIN}}'),
            'default' => false,
            'on' => 'On',
            'off' => 'Off'
        ),
        array(
            'id' => 'footer_top_border',
            'type' => 'border',
            'title' => esc_html__('Footer Top Border', '{{TEXT_DOMAIN}}'),
            'top' => true,
            'right' => false,
            'bottom' => false,
            'left' => false,
            'all' => false,
            'default' => array(
                'border-top' => '1px',
                'style' => 'solid',
                'color' => '#000000',
            ),
            'required' => array('add_border_top', '=', true),
        ),
        array(
            'id' => 'footer_border_radius',
            'type' => 'slider',
            'title' => __('Border Radius', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Set the border radius for Footer.', '{{TEXT_DOMAIN}}'),
            'default' => 30,
            'min' => 0,
            'step' => 1,
            'max' => 500,
            'display_value' => 'text',
            'required' => array('add_border_top', '=', true),

        ),
    )
));

/**
 * BLOG OPTIONS SECTION
 */

Redux::setSection($opt_name, array(
    'title' => __('Blog (Archive page)', '{{TEXT_DOMAIN}}'),
    'id' => 'blog_options',
    'icon' => 'el el-edit',
    'fields' => array(
        array(
            'id' => 'blog_post_layout',
            'type' => 'image_select',
            'title' => __('Blog posts Layout', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose how blog posts are displayed.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'grid' => array(
                    'alt' => __('Grid', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
                ),
                'list' => array(
                    'alt' => __('List', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
                )
            ),
            'default' => 'grid',
        ),
        array(
            'id' => 'sidebar_position',
            'type' => 'image_select',
            'title' => __('Sidebar Position', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Select layout for Blog page.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'right-sidebar' => array(
                    'alt' => __('Right Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
                ),
                'left-sidebar' => array(
                    'alt' => __('Left Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
                ),
                'no-sidebar' => array(
                    'alt' => __('No Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
                ),
            ),
            'default' => 'right-sidebar',
        ),
        array(
            'id' => 'post_meta_display',
            'type' => 'button_set',
            'title' => __('Meta Data Display', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose which post meta data to show.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'date' => __('Date', '{{TEXT_DOMAIN}}'),
                'category' => __('Category', '{{TEXT_DOMAIN}}'),
            ),
            'multi' => true,
            'default' => array('date', 'category'),
        )
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Single Post', '{{TEXT_DOMAIN}}'),
    'id' => 'single_post',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'single_sidebar_position',
            'type' => 'image_select',
            'title' => __('Sidebar Position', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Select layout for Blog page.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'right-sidebar' => array(
                    'alt' => __('Right Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
                ),
                'left-sidebar' => array(
                    'alt' => __('Left Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
                ),
                'no-sidebar' => array(
                    'alt' => __('No Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
                ),
            ),
            'default' => 'right-sidebar',
        ),
        array(
            'id' => 'single_post_meta_display',
            'type' => 'button_set',
            'title' => __('Meta Data Display', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose which post meta data to show.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'author' => __('Author', '{{TEXT_DOMAIN}}'),
                'date' => __('Date', '{{TEXT_DOMAIN}}'),
                'category' => __('Category', '{{TEXT_DOMAIN}}'),
                'tags' => __('Tags', '{{TEXT_DOMAIN}}'),
            ),
            'multi' => true,
            'default' => array('date', 'category', 'author', 'tags'),
        ),
        array(
            'id' => 'single_social_media',
            'type' => 'switch',
            'title' => __('Social Share It?', '{{TEXT_DOMAIN}}'),
            'default' => true,
            'on' => __('Yes', '{{TEXT_DOMAIN}}'),
            'off' => __('No', '{{TEXT_DOMAIN}}'),
            'required' => array('topbar_enable', '=', true),
        ),
        array(
            'id' => 'share_buttons',
            'type' => 'sortable',
            'title' => __('Share Buttons', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Enable/disable and reorder the share buttons.', '{{TEXT_DOMAIN}}'),
            'mode' => 'toggle',
            'options' => array(
                'fb-link' => __('Facebook', '{{TEXT_DOMAIN}}'),
                'linkedin-icon' => __('LinkedIn', '{{TEXT_DOMAIN}}'),
                'whatsapp-icon' => __('Whatsapp', '{{TEXT_DOMAIN}}'),
                'twitter-icon' => __('Twitter', '{{TEXT_DOMAIN}}'),
            ),
            'default' => array(
                'fb-link' => 1,
                'linkedin-icon' => 1,
                'whatsapp-icon' => 1,
                'twitter-icon' => 1
            ),
            'required' => array('single_social_media', '=', true),
        ),
        array(
            'id' => 'single_social_bg',
            'type' => 'link_color',
            'title' => __('Social Background Color', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'required' => array('single_social_media', '=', true),
            'active' => false,
            'default' => array(
                'regular' => '#21409A',
                'hover' => '#c31f27',
            )
        ),
        array(
            'id' => 'single_social_icon_color',
            'type' => 'link_color',
            'title' => __('Social Icons Color', '{{TEXT_DOMAIN}}'),
            'transparent' => false,
            'required' => array('single_social_media', '=', true),
            'active' => false,
            'default' => array(
                'regular' => '#FFFFFF',
                'hover' => '#FFFFFF',
            )
        ),
        array(
            'id' => 'related_posts_settings',
            'type' => 'section',
            'title' => __('Related Posts Settings', '{{TEXT_DOMAIN}}'),
            'indent' => true,
            'transparent' => false,
        ),
        array(
            'id' => 'related_posts',
            'type' => 'switch',
            'title' => __('Show Related Posts', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
        array(
            'id' => 'related_title',
            'type' => 'text',
            'title' => esc_html__('Heading', '{{TEXT_DOMAIN}}'),
            'required' => array('related_posts', '=', true),
            'default' => 'Related Posts',
        ),
        array(
            'id' => 'related_post_meta_display',
            'type' => 'button_set',
            'title' => __('Meta Data Display', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose which post meta data to show.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'date' => __('Date', '{{TEXT_DOMAIN}}'),
                'category' => __('Category', '{{TEXT_DOMAIN}}'),
            ),
            'multi' => true,
            'default' => array('date', 'category'),
            'required' => array('related_posts', '=', true),
        ),
        array(
            'id' => 'related_posts_count',
            'type' => 'slider',
            'title' => __('Number of Related Posts', '{{TEXT_DOMAIN}}'),
            'min' => 3,
            'max' => 12,
            'step' => 1,
            'default' => 3,
            'required' => array('related_posts', '=', true),
        ),
        array(
            'id' => 'related_posts_by',
            'type' => 'button_set',
            'title' => __('Related Posts By', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'category' => __('Category', '{{TEXT_DOMAIN}}'),
                'tag' => __('Tag', '{{TEXT_DOMAIN}}'),
            ),
            'default' => 'category',
            'required' => array('related_posts', '=', true),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Category', '{{TEXT_DOMAIN}}'),
    'id' => 'category_options',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'category_post_layout',
            'type' => 'image_select',
            'title' => __('Category posts Layout', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose how blog posts are displayed.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'grid' => array(
                    'alt' => __('Grid', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
                ),
                'list' => array(
                    'alt' => __('List', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
                )
            ),
            'default' => 'grid',
        ),
        array(
            'id' => 'category_sidebar_position',
            'type' => 'image_select',
            'title' => __('Sidebar Position', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Select layout for category page.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'right-sidebar' => array(
                    'alt' => __('Right Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
                ),
                'left-sidebar' => array(
                    'alt' => __('Left Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
                ),
                'no-sidebar' => array(
                    'alt' => __('No Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
                ),
            ),
            'default' => 'right-sidebar',
        ),
        array(
            'id' => 'enable_date_category',
            'type' => 'switch',
            'title' => esc_html__('Enable Date?', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Tag', '{{TEXT_DOMAIN}}'),
    'id' => 'tags_options',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'tag_post_layout',
            'type' => 'image_select',
            'title' => __('Tags posts Layout', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose how blog posts are displayed.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'grid' => array(
                    'alt' => __('Grid', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
                ),
                'list' => array(
                    'alt' => __('List', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
                )
            ),
            'default' => 'grid',
        ),
        array(
            'id' => 'tag_sidebar_position',
            'type' => 'image_select',
            'title' => __('Sidebar Position', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Select layout for Blog page.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'right-sidebar' => array(
                    'alt' => __('Right Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
                ),
                'left-sidebar' => array(
                    'alt' => __('Left Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
                ),
                'no-sidebar' => array(
                    'alt' => __('No Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
                ),
            ),
            'default' => 'right-sidebar',
        ),
        array(
            'id' => 'enable_date_tag',
            'type' => 'switch',
            'title' => esc_html__('Enable Date?', '{{TEXT_DOMAIN}}'),
            'default' => true,
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Search', '{{TEXT_DOMAIN}}'),
    'id' => 'search_options',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'search_post_layout',
            'type' => 'image_select',
            'title' => __('Search posts Layout', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Choose how blog posts are displayed.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'grid' => array(
                    'alt' => __('Grid', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
                ),
                'list' => array(
                    'alt' => __('List', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
                )
            ),
            'default' => 'grid',
        ),
        array(
            'id' => 'search_sidebar_position',
            'type' => 'image_select',
            'title' => __('Sidebar Position', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Select layout for Search page.', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'right-sidebar' => array(
                    'alt' => __('Right Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
                ),
                'left-sidebar' => array(
                    'alt' => __('Left Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
                ),
                'no-sidebar' => array(
                    'alt' => __('No Sidebar', '{{TEXT_DOMAIN}}'),
                    'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
                ),
            ),
            'default' => 'right-sidebar',
        ),
        array(
            'id' => 'search_page_metadata',
            'type' => 'button_set',
            'title' => __('Search Page Metadata', '{{TEXT_DOMAIN}}'),
            'options' => array(
                'category' => __('Category', '{{TEXT_DOMAIN}}'),
                'date' => __('Date', '{{TEXT_DOMAIN}}'),
            ),
            'multi' => true,
            'default' => array('date', 'category'),
            'required' => array('related_posts', '=', true),
        ),
        array(
            'id' => 'enable_search_form',
            'type' => 'switch',
            'title' => esc_html__('Enable Search form?', '{{TEXT_DOMAIN}}'),
            'default' => false,
            'required' => array('search_sidebar_position', '=', 'no-sidebar'),
        ),
    )
));

/**
 * INTEGRATIONS SECTION
 */

Redux::setSection($opt_name, array(
    'title' => __('Integrations', '{{TEXT_DOMAIN}}'),
    'id' => 'integrations',
    'icon' => 'el el-globe-alt',
    'fields' => array(
        array(
            'id' => 'social_buttons',
            'type' => 'repeater',
            'title' => __('Social Links', '{{TEXT_DOMAIN}}'),
            'group_values' => true,
            'fields' => array(
                array(
                    'id' => 'social_icon',
                    'type' => 'select',
                    'title' => __('Social Media', '{{TEXT_DOMAIN}}'),
                    'options' => array(
                        'fb-link' => __('Facebook', '{{TEXT_DOMAIN}}'),
                        'instagram-link' => __('Instagram', '{{TEXT_DOMAIN}}'),
                        'yt-link' => __('YouTube', '{{TEXT_DOMAIN}}'),
                        'linkedin-icon' => __('Linkedin', '{{TEXT_DOMAIN}}'),
                        'whatsapp-icon' => __('Whatsapp', '{{TEXT_DOMAIN}}'),
                        'twitter-icon' => __('Twitter', '{{TEXT_DOMAIN}}'),
                        'tiktok-icon' => __('Tiktok', '{{TEXT_DOMAIN}}'),
                    ),
                ),
                array(
                    'id' => 'social_url',
                    'type' => 'text',
                    'title' => __('Link', '{{TEXT_DOMAIN}}'),
                    'default' => '#',
                )
            ),
        ),
        array(
            'id' => 'google_analytics',
            'type' => 'ace_editor',
            'title' => __('Google Analytics / Tag Manager', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Paste your GA or GTM script here. Will be added in the site head tag.', '{{TEXT_DOMAIN}}'),
            'mode' => 'html',
            'theme' => 'monokai',
            'default' => '',
        ),
    )
));


/**
 * CUSTOM CODE SECTION
 */
Redux::setSection($opt_name, array(
    'title' => __('Custom Code', '{{TEXT_DOMAIN}}'),
    'id' => 'custom_code',
    'icon' => 'el el-css',
    'fields' => array(

        array(
            'id' => 'custom_css_header',
            'type' => 'ace_editor',
            'title' => __('Additional CSS (Header)', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Add custom CSS to be included in the sites head tag, inside the style tag.', '{{TEXT_DOMAIN}}'),
            'mode' => 'css',
            'theme' => 'monokai',
            'default' => '',
        ),
        array(
            'id' => 'custom_css_footer',
            'type' => 'ace_editor',
            'title' => __('Additional CSS (Footer)', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Add custom CSS to be included after the footer tag, inside the style tag.', '{{TEXT_DOMAIN}}'),
            'mode' => 'css',
            'theme' => 'monokai',
            'default' => '',
        ),
        array(
            'id' => 'custom_js_header',
            'type' => 'ace_editor',
            'title' => __('Additional JS (Header)', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Add custom JavaScript to be included in the sites head tag, inside the script tag.', '{{TEXT_DOMAIN}}'),
            'mode' => 'javascript',
            'theme' => 'monokai',
            'default' => '',
        ),
        array(
            'id' => 'custom_js_footer',
            'type' => 'ace_editor',
            'title' => __('Additional JS (Footer)', '{{TEXT_DOMAIN}}'),
            'subtitle' => __('Add custom JavaScript be included after the footer tag, inside the script tag.', '{{TEXT_DOMAIN}}'),
            'mode' => 'javascript',
            'theme' => 'monokai',
            'default' => '',
        ),
    )
));
