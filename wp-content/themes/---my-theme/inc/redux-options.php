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

$opt_name = 'my_theme_options'; // change if you like

$theme = wp_get_theme();

$args = array(
'opt_name' => $opt_name,
'display_name' => $theme->get('Name'),
'display_version' => $theme->get('Version'),
'menu_type' => 'menu',
'allow_sub_menu' => true,
'menu_title' => __('Theme Options', 'my-theme'),
'page_title' => __('Theme Options', 'my-theme'),
'page_priority' => 81,
'menu_icon' => 'dashicons-admin-generic',
'admin_bar' => true,
'dev_mode' => false,
'update_notice' => false,
'customizer' => false,
'global_variable' => 'my_theme_options',
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
'title' => esc_html__('Banner', 'my-theme'),
'post_types' => array('page', 'physicians', 'post', 'services'),
'position' => 'normal',
'priority' => 'high',
'database' => 'meta',
'transient_time' => 60 * MINUTE_IN_SECONDS,
'sections' => array(
array(
'id' => 'page_banner_section',
'title' => esc_html__('', 'my-theme'),
'fields' => array(
array(
'id' => 'banner_enable',
'type' => 'switch',
'title' => esc_html__('Enable Banner', 'my-theme'),
'default' => true,
),
array(
'id' => 'banner_title',
'type' => 'text',
'title' => esc_html__('Heading', 'my-theme'),
'subtitle' => esc_html__('Leave empty to use page Heading.', 'my-theme'),
'required' => array('banner_enable', '=', true),
),
array(
'id' => 'banner_bg_type',
'type' => 'switch',
'title' => esc_html__('Background Type', 'my-theme'),
'on' => esc_html__('Image', 'my-theme'),
'off' => esc_html__('Color', 'my-theme'),
'default' => true,
'required' => array('banner_enable', '=', true),
),
array(
'id' => 'page_banner_color',
'type' => 'color',
'title' => __('Background Color', 'my-theme'),
'default' => '#E6F5FF',
'transparent' => false,
'required' => array('banner_bg_type', '=', false),
),
array(
'id' => 'page_banner_image',
'type' => 'background',
'title' => __('Background Image', 'my-theme'),
'subtitle' => esc_html__('Size: 1920 X 486 | If an image is not added, a color will be displayed instead. ', 'my-theme'),
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
'title' => __('Heading Alignment', 'my-theme'),
'options' => array(
'left' => __('Left', 'my-theme'),
'center' => __('Center', 'my-theme'),
'right' => __('Right', 'my-theme'),
),
'default' => 'left',
'required' => array('banner_enable', '=', true),
),
array(
'id' => 'banner_padding',
'type' => 'dimensions',
'title' => __('Paddings Top/Bottom', 'my-theme'),
'subtitle' => __('Set top and bottom padding in px.', 'my-theme'),
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
'title' => __('General', 'my-theme'),
'id' => 'general',
'icon' => 'el el-cog',
'fields' => array(
array(
'id' => 'container_width',
'type' => 'button_set',
'title' => esc_html__('Container Width', 'my-theme'),
'options' => array(
'default_container' => esc_html__('Default', 'my-theme'),
'boxed_container' => esc_html__('Boxed', 'my-theme'),
'fullwidth_container' => esc_html__('Full Width', 'my-theme'),
),
'default' => 'default_container',
),
array(
'id' => 'boxed_container_width',
'type' => 'slider',
'title' => esc_html__('Boxed Container Width', 'my-theme'),
'subtitle' => esc_html__('Set the width for boxed layout.', 'my-theme'),
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
'title' => esc_html__('Scroll to Top Button', 'my-theme'),
'on' => esc_html__('Enable', 'my-theme'),
'off' => esc_html__('Disable', 'my-theme'),
'default' => true,
),
)
));

/**
* LOGO SECTION
*/

Redux::setSection($opt_name, array(
'title' => __('Logos', 'my-theme'),
'id' => 'general_logos',
'subsection' => true,
'fields' => array(
array(
'id' => 'favicon_logo',
'type' => 'media',
'title' => __('Favicon', 'my-theme'),
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
'title' => __('Retina Logo', 'my-theme'),
'subtitle' => __('MacBooks, iPhones, modern smartphones', 'my-theme'),
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
'title' => __('Header Logo', 'my-theme'),
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
'title' => __('Logo Link', 'my-theme'),
'default' => site_url(),
),
array(
'id' => 'header_logo_target',
'type' => 'select',
'title' => __('Link Target', 'my-theme'),
'options' => array(
'_self' => __('Same Tab', 'my-theme'),
'_blank' => __('New Tab', 'my-theme'),
),
'default' => '_self',
),
array(
'id' => 'footer_logo',
'type' => 'media',
'title' => __('Footer Logo', 'my-theme'),
'preview' => true,
'preview_size' => 'full',
'default' => array(
'url' => get_template_directory_uri() . '/assets/options-assets/images/footer-logo.svg',
),
),
array(
'id' => 'footer_logo_url',
'type' => 'text',
'title' => __('Logo Link', 'my-theme'),
'default' => site_url(),
),
array(
'id' => 'footer_logo_target',
'type' => 'select',
'title' => __('Link Target', 'my-theme'),
'options' => array(
'_self' => __('Same Tab', 'my-theme'),
'_blank' => __('New Tab', 'my-theme'),
),
'default' => '_self',
),
array(
'id' => 'admin_logo',
'type' => 'media',
'title' => __('Admin Login Logo', 'my-theme'),
'preview' => true,
'preview_size' => 'full',
'default' => array(
'url' => get_template_directory_uri() . '/assets/options-assets/images/header-logo.svg',
),
),
array(
'id' => 'email_logo',
'type' => 'media',
'title' => __('Email Template Logo', 'my-theme'),
'preview' => true,
'preview_size' => 'full',
'default' => array(
'url' => get_template_directory_uri() . '/assets/options-assets/images/email-logo.png',
),
),
array(
'id' => 'placeholder_image',
'type' => 'media',
'title' => __('Default Placeholder Image', 'my-theme'),
'subtitle' => esc_html__('This image is required. It will be used if users have not added an image in the required sections.', 'my-theme'),
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
'title' => __('Header', 'my-theme'),
'id' => 'header',
'icon' => 'el el-arrow-up',
'fields' => array(
array(
'id' => 'header_menu',
'type' => 'select',
'title' => __('Header Menu', 'my-theme'),
'subtitle' => __('Default primary menu will set.', 'my-theme'),
'options' => my_theme_get_wp_menus(),
'default' => my_theme_get_primary_menu_id(),
),
array(
'id' => 'my_theme_buttons',
'type' => 'repeater',
'title' => __('Buttons', 'my-theme'),
'group_values' => true,
'max' => 2,
'fields' => array(
array(
'id' => 'text',
'type' => 'text',
'title' => __('Text', 'my-theme'),
'default' => __('Contact Us', 'my-theme'),
),
array(
'id' => 'url',
'type' => 'text',
'title' => __('Link', 'my-theme'),
'default' => '#',
),
array(
'id' => 'target',
'type' => 'select',
'title' => __('Link Target', 'my-theme'),
'options' => array(
'_self' => __('Same Tab', 'my-theme'),
'_blank' => __('New Tab', 'my-theme'),
),
'default' => '_self',
),
),
),
array(
'id' => 'topbar_enable',
'type' => 'switch',
'title' => __('Enable Top Bar', 'my-theme'),
'default' => false,
),
array(
'id' => 'social_media',
'type' => 'switch',
'title' => __('Social Media', 'my-theme'),
'default' => true,
'on' => __('Enable', 'my-theme'),
'off' => __('Disable', 'my-theme'),
'required' => array('topbar_enable', '=', true),
),
array(
'id' => 'header_social_bg',
'type' => 'link_color',
'title' => __('Social Background Color', 'my-theme'),
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
'title' => __('Social Icons Color', 'my-theme'),
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
'title' => __('Top Bar Text', 'my-theme'),
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
'title' => __('Contact Info', 'my-theme'),
'subtitle' => __('Add shortcode, phone, email, or address for the Top Bar. Leave empty if you don’t want to show', 'my-theme'),
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
'title' => esc_html__('Enable Google Translate?', 'my-theme'),
//'subtitle' => esc_html__('To add the Google Translate we need to required this plugin:<a href="https://wordpress.org/plugins/gtranslate/" target="_blank">Translate WordPress with GTranslate</a>', 'my-theme'),
'subtitle' => wp_kses(
sprintf(
__('To add Google Translate we need this plugin: <a href="%1$s" target="_blank">Translate WordPress with GTranslate</a>', 'my-theme'),
'https://wordpress.org/plugins/gtranslate/'
),
array(
'a' => array(
'href' => array(),
'target' => array()
)
)
),
'on' => esc_html__('Yes', 'my-theme'),
'off' => esc_html__('No', 'my-theme'),
'default' => true,
'required' => array('topbar_enable', '=', true),
),
)
));


Redux::setSection(
$opt_name,
array(
'title' => __('Header Builder', 'my-theme'),
'id' => 'header_builder',
'subsection' => true,
'fields' => array(
array(
'id' => 'header_fullwidth',
'type' => 'switch',
'title' => __('Full Width ?', 'my-theme'),
'on' => __('On', 'my-theme'),
'off' => __('Off', 'my-theme'),
'default' => false,
),
array(
'id' => 'header_layout',
'type' => 'image_select',
'title' => esc_html__('Header Layout', 'my-theme'),
'subtitle' => esc_html__('Choose the header layout style.', 'my-theme'),
'options' => array(
'left-logo' => array(
'alt' => esc_html__('Left Logo', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/header-left-logo.png'
),
'logo-above-centered' => array(
'alt' => esc_html__('Logo Above Menu', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/header-logo-above.png'
)
),
'default' => 'left-logo',
'mode' => 'list'
),
array(
'id' => 'sticky_header',
'type' => 'switch',
'title' => esc_html__('Sticky Header', 'my-theme'),
'subtitle' => esc_html__('Enable or disable sticky header.', 'my-theme'),
'on' => esc_html__('On', 'my-theme'),
'off' => esc_html__('Off', 'my-theme'),
'default' => true,
),
array(
'id' => 'transparent_header',
'type' => 'switch',
'title' => esc_html__('Transparent Header', 'my-theme'),
'subtitle' => esc_html__('Enable or disable transparent header.', 'my-theme'),
'on' => esc_html__('On', 'my-theme'),
'off' => esc_html__('Off', 'my-theme'),
'default' => false,
),
array(
'id' => 'transparent_header_opacity',
'type' => 'slider',
'title' => esc_html__('Header Opacity', 'my-theme'),
'subtitle' => esc_html__('Adjust the transparency level of the header.', 'my-theme'),
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
'title' => esc_html__('Header Background Color', 'my-theme'),
'subtitle' => esc_html__('Pick a background color for the header.', 'my-theme'),
'default' => '#ffffff',
'transparent' => false,
'validate' => 'color',
),
array(
'id' => 'menu_and_arrow_color_code',
'type' => 'switch',
'title' => esc_html__('Do you want to set the Menu and Arrow Color?', 'my-theme'),
'subtitle' => esc_html__('Default Secondary color will be used.', 'my-theme'),
'on' => esc_html__('Yes', 'my-theme'),
'off' => esc_html__('No', 'my-theme'),
'default' => false,
),
array(
'id' => 'menu_and_arrow_color',
'type' => 'color',
'title' => esc_html__('Menu and Arrow Color', 'my-theme'),
'default' => '#08184D',
'transparent' => false,
'validate' => 'color',
'required' => array('menu_and_arrow_color_code', '=', true),
),
array(
'id' => 'nav_dropdown_animation',
'type' => 'button_set',
'title' => __('Dropdown Animation', 'my-theme'),
'subtitle' => __('Select the animation style for dropdown menus.', 'my-theme'),
'options' => array(
'submenu-fadeinup' => __('Fade In Up', 'my-theme'),
'submenu-fadeindown' => __('Fade In Down', 'my-theme'),
'submenu-fadeinleft' => __('Fade In Left', 'my-theme'),
'submenu-fadeinright' => __('Fade In Right', 'my-theme'),
),
'default' => 'submenu-fadeinup',
),
array(
'id' => 'enable_off_canvas',
'type' => 'switch',
'title' => esc_html__('Mobile Off-Canvas Menu?', 'my-theme'),
'on' => esc_html__('Enable', 'my-theme'),
'off' => esc_html__('Disable', 'my-theme'),
'default' => false,
),
array(
'id' => 'mobile_menu_type',
'type' => 'button_set',
'title' => esc_html__('Mobile Off-Canvas Menu Position.', 'my-theme'),
'options' => array(
'left' => esc_html__('Left', 'my-theme'),
'right' => esc_html__('Right', 'my-theme'),
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
'title' => __('Typography', 'my-theme'),
'id' => 'typography',
'icon' => 'el el-font',
'fields' => array(
array(
'id' => 'content_font',
'type' => 'typography',
'title' => __('Content Font', 'my-theme'),
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
'title' => esc_html__('Do you want to set the Content color?', 'my-theme'),
'subtitle' => esc_html__('Default Secondary color will be used.', 'my-theme'),
'on' => esc_html__('Yes', 'my-theme'),
'off' => esc_html__('No', 'my-theme'),
'default' => false,
),
array(
'id' => 'content_font_color_code',
'type' => 'color',
'title' => esc_html__('Content Font Color', 'my-theme'),
'default' => '#08184d',
'transparent' => false,
'validate' => 'color',
'required' => array('content_font_color', '=', true),
),
array(
'id' => 'headings_font',
'type' => 'typography',
'title' => __('Headings Font', 'my-theme'),
'subtitle' => esc_html__('This will apply on the H1 to H6', 'my-theme'),
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
'title' => esc_html__('Do you want to set the Heading color?', 'my-theme'),
'subtitle' => esc_html__('Default Secondary color will be used.', 'my-theme'),
'on' => esc_html__('Yes', 'my-theme'),
'off' => esc_html__('No', 'my-theme'),
'default' => false,
),
array(
'id' => 'heading_font_color_code',
'type' => 'color',
'title' => esc_html__('Heading Font Color', 'my-theme'),
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
'title' => __('Colors', 'my-theme'),
'id' => 'colors',
'icon' => 'el el-brush',
'fields' => array(
array(
'id' => 'color_1',
'type' => 'color',
'title' => __('Primary Color', 'my-theme'),
'subtitle' => esc_html__('The main accent color used for highlights and key interactive elements.', 'my-theme'),
'validate' => 'color',
'default' => '#C31F27',
'transparent' => false,
),
array(
'id' => 'color_2',
'type' => 'color',
'title' => __('Secondary Color', 'my-theme'),
'subtitle' => esc_html__('A supporting color used for headings, descriptions, and icons to complement the primary color.', 'my-theme'),
'validate' => 'color',
'default' => '#08184D',
'transparent' => false,
),
array(
'id' => 'color_section',
'type' => 'section',
'title' => __('Other color palette', 'my-theme'),
'indent' => true,
'transparent' => false,
),
array(
'id' => 'dark_section_colors',
'type' => 'link_color', // or 'color' (multi) depending on your config
'title' => __('Dark Section Colors', 'my-theme'),
'subtitle' => __('Set the background and text colors for dark sections.', 'my-theme'),
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
'title' => __('Global Background', 'my-theme'),
'subtitle' => __('Use this color for sections and banner backgrounds.', 'my-theme'),
'transparent' => false,
),
array(
'id' => 'link_color',
'type' => 'link_color',
'title' => __('Link Colors', 'my-theme'),
'subtitle' => __('Use this color for all links.', 'my-theme'),
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
'title' => __('Buttons', 'my-theme'),
'id' => 'buttons',
'icon' => 'el el-icon-plus-sign',
'fields' => array(
array(
'id' => 'button_typography',
'type' => 'typography',
'title' => __('Typography', 'my-theme'),
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
'title' => __('Background Color', 'my-theme'),
'validate' => 'color',
'transparent' => false,
'default' => '#C31F27',
),
array(
'id' => 'button_border',
'type' => 'border',
'title' => esc_html__('Button Border', 'my-theme'),
'subtitle' => esc_html__('Set border size, style and color.', 'my-theme'),
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
'title' => __('Border Radius', 'my-theme'),
'subtitle' => __('Set the border radius for buttons.', 'my-theme'),
'default' => 240,
'min' => 0,
'step' => 1,
'max' => 500,
'display_value' => 'text'
),
array(
'id' => 'on_button_hover',
'type' => 'link_color',
'title' => __('On Button Hover', 'my-theme'),
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
'title' => esc_html__('Enable Arrow?', 'my-theme'),
'on' => esc_html__('Enable', 'my-theme'),
'off' => esc_html__('Disable', 'my-theme'),
'default' => true,
),
array(
'id' => 'arrow_color',
'type' => 'link_color',
'title' => __('Arrow Color', 'my-theme'),
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
'title' => __('404 Page', 'my-theme'),
'id' => '404_page',
'icon' => 'el el-refresh',
'fields' => array(
array(
'id' => 'banner_enable',
'type' => 'switch',
'title' => esc_html__('Enable Banner', 'my-theme'),
'default' => true,
),
array(
'id' => 'banner_bg_type',
'type' => 'switch',
'title' => esc_html__('Background Type', 'my-theme'),
'on' => esc_html__('Image', 'my-theme'),
'off' => esc_html__('Color', 'my-theme'),
'default' => true,
'required' => array('banner_enable', '=', true),
),
array(
'id' => 'page_banner_color',
'type' => 'color',
'title' => __('Background Color', 'my-theme'),
'default' => '#e6f5ff',
'transparent' => false,
'required' => array('banner_bg_type', '=', false),
),
array(
'id' => 'page_banner_image',
'type' => 'background',
'title' => __('Background Image', 'my-theme'),
'subtitle' => esc_html__('Size: 1920 X 486 ', 'my-theme'),
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
'title' => __('Heading Alignment', 'my-theme'),
'options' => array(
'left' => __('Left', 'my-theme'),
'center' => __('Center', 'my-theme'),
'right' => __('Right', 'my-theme'),
),
'default' => 'left',
'required' => array('banner_enable', '=', true),
),
array(
'id' => 'banner_padding',
'type' => 'dimensions',
'title' => __('Paddings Top/Bottom', 'my-theme'),
'subtitle' => __('Set top and bottom padding in px.', 'my-theme'),
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
'title' => __('Heading', 'my-theme'),
'default' => '404',
),
array(
'id' => 'sub_heading',
'type' => 'text',
'title' => __('Sub Heading', 'my-theme'),
'default' => 'Oops! That page can’t be found.',
),
array(
'id' => 'page_content',
'type' => 'editor',
'default' => '<strong>Not all who wander are lost.</strong><br />You are not one of them.',
'title' => __('Content', 'my-theme'),
'args' => array(
'media_buttons' => false,
'teeny' => true,
'quicktags' => true,
),
),
array(
'id' => 'btn_text',
'type' => 'text',
'title' => __('Button', 'my-theme'),
'default' => __('Back to Home', 'my-theme'),
),
array(
'id' => 'btn_url',
'type' => 'text',
'title' => __('Link', 'my-theme'),
'default' => site_url(),
),
array(
'id' => 'btn_target',
'type' => 'select',
'title' => __('Link Target', 'my-theme'),
'options' => array(
'_self' => __('Same Tab', 'my-theme'),
'_blank' => __('New Tab', 'my-theme'),
),
'default' => '_self',
),
)
));

/**
* FOOTER SECTION
*/
Redux::setSection($opt_name, array(
'title' => __('Footer', 'my-theme'),
'id' => 'footer',
'icon' => 'el el-arrow-down',
'fields' => array(
array(
'id' => 'footer_social',
'type' => 'switch',
'title' => esc_html__('Social Media', 'my-theme'),
'on' => esc_html__('Enable', 'my-theme'),
'off' => esc_html__('Disable', 'my-theme'),
'default' => true,
),
array(
'id' => 'footer_social_bg',
'type' => 'link_color',
'title' => __('Social Background Color', 'my-theme'),
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
'title' => __('Social Icons Color', 'my-theme'),
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
'title' => __('Copyright Text', 'my-theme'),
'subtitle' => __('Leave empty if you don’t want to show', 'my-theme'),
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
'title' => __('Credit Line Text', 'my-theme'),
'subtitle' => __('Leave empty if you don’t want to show', 'my-theme'),
'default' => '<p><a href="" target="_blank">My theme Website Design</a> by <a href="" target="_blank">TechArk</a></p>',
'args' => array(
'media_buttons' => false,
'teeny' => true,
'quicktags' => true,
),
)
)
));


Redux::setSection($opt_name, array(
'title' => __('Footer Builder', 'my-theme'),
'id' => 'footer_builder',
'subsection' => true,
'fields' => array(
array(
'id' => 'footer_settings',
'type' => 'section',
'title' => __('Footer Settings', 'my-theme'),
'indent' => true,
'transparent' => false,
),
array(
'id' => 'footer_widget',
'type' => 'switch',
'title' => esc_html__('Footer Widgets ', 'my-theme'),
'on' => esc_html__('Enable', 'my-theme'),
'off' => esc_html__('Disable', 'my-theme'),
'default' => true,
),
array(
'id' => 'footer_columns',
'type' => 'button_set',
'title' => __('Columns', 'my-theme'),
'options' => array(
'1' => __('1', 'my-theme'),
'2' => __('2', 'my-theme'),
'3' => __('3', 'my-theme'),
'4' => __('4', 'my-theme'),
),
'default' => '3',
'required' => array('footer_widget', '=', true),
),
array(
'id' => 'footer_columns_layout_2',
'type' => 'image_select',
'title' => __('Columns Layout', 'my-theme'),
'subtitle' => __('Choose how the 2 columns are arranged.', 'my-theme'),
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
'title' => __('Columns Layout', 'my-theme'),
'subtitle' => __('Choose how the 3 columns are arranged.', 'my-theme'),
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
'title' => __('Paddings', 'my-theme'),
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
'title' => __('Footer Styling', 'my-theme'),
'indent' => true,
'transparent' => false,
),
array(
'id' => 'footer_fullwidth',
'type' => 'switch',
'title' => __('Full Width?', 'my-theme'),
'on' => __('On', 'my-theme'),
'off' => __('Off', 'my-theme'),
'default' => false,
),
array(
'id' => 'footer_bg_image_and_color',
'type' => 'background',
'title' => __('Background Image OR Color', 'my-theme'),
'subtitle' => esc_html__('If an image is not added, a color will be displayed instead.', 'my-theme'),
'url' => true,
'transparent' => false,
'default' => array(
'background-color' => '#040b22'
),
),
array(
'id' => 'content_align',
'type' => 'button_set',
'title' => __('Content Align', 'my-theme'),
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
'title' => __('Headings Color', 'my-theme'),
'default' => '#ffffff',
'transparent' => false
),
array(
'id' => 'footer_content_color',
'type' => 'color',
'title' => __('Content Color', 'my-theme'),
'default' => '#ffffff',
'transparent' => false
),
array(
'id' => 'add_border_top',
'type' => 'switch',
'title' => __('Add Border Top', 'my-theme'),
'default' => false,
'on' => 'On',
'off' => 'Off'
),
array(
'id' => 'footer_top_border',
'type' => 'border',
'title' => esc_html__('Footer Top Border', 'my-theme'),
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
'title' => __('Border Radius', 'my-theme'),
'subtitle' => __('Set the border radius for Footer.', 'my-theme'),
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
'title' => __('Blog (Archive page)', 'my-theme'),
'id' => 'blog_options',
'icon' => 'el el-edit',
'fields' => array(
array(
'id' => 'blog_post_layout',
'type' => 'image_select',
'title' => __('Blog posts Layout', 'my-theme'),
'subtitle' => __('Choose how blog posts are displayed.', 'my-theme'),
'options' => array(
'grid' => array(
'alt' => __('Grid', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
),
'list' => array(
'alt' => __('List', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
)
),
'default' => 'grid',
),
array(
'id' => 'sidebar_position',
'type' => 'image_select',
'title' => __('Sidebar Position', 'my-theme'),
'subtitle' => __('Select layout for Blog page.', 'my-theme'),
'options' => array(
'right-sidebar' => array(
'alt' => __('Right Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
),
'left-sidebar' => array(
'alt' => __('Left Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
),
'no-sidebar' => array(
'alt' => __('No Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
),
),
'default' => 'right-sidebar',
),
array(
'id' => 'post_meta_display',
'type' => 'button_set',
'title' => __('Meta Data Display', 'my-theme'),
'subtitle' => __('Choose which post meta data to show.', 'my-theme'),
'options' => array(
'date' => __('Date', 'my-theme'),
'category' => __('Category', 'my-theme'),
),
'multi' => true,
'default' => array('date', 'category'),
)
)
));


Redux::setSection($opt_name, array(
'title' => __('Single Post', 'my-theme'),
'id' => 'single_post',
'subsection' => true,
'fields' => array(
array(
'id' => 'single_sidebar_position',
'type' => 'image_select',
'title' => __('Sidebar Position', 'my-theme'),
'subtitle' => __('Select layout for Blog page.', 'my-theme'),
'options' => array(
'right-sidebar' => array(
'alt' => __('Right Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
),
'left-sidebar' => array(
'alt' => __('Left Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
),
'no-sidebar' => array(
'alt' => __('No Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
),
),
'default' => 'right-sidebar',
),
array(
'id' => 'single_post_meta_display',
'type' => 'button_set',
'title' => __('Meta Data Display', 'my-theme'),
'subtitle' => __('Choose which post meta data to show.', 'my-theme'),
'options' => array(
'author' => __('Author', 'my-theme'),
'date' => __('Date', 'my-theme'),
'category' => __('Category', 'my-theme'),
'tags' => __('Tags', 'my-theme'),
),
'multi' => true,
'default' => array('date', 'category', 'author', 'tags'),
),
array(
'id' => 'single_social_media',
'type' => 'switch',
'title' => __('Social Share It?', 'my-theme'),
'default' => true,
'on' => __('Yes', 'my-theme'),
'off' => __('No', 'my-theme'),
'required' => array('topbar_enable', '=', true),
),
array(
'id' => 'share_buttons',
'type' => 'sortable',
'title' => __('Share Buttons', 'my-theme'),
'subtitle' => __('Enable/disable and reorder the share buttons.', 'my-theme'),
'mode' => 'toggle',
'options' => array(
'fb-link' => __('Facebook', 'my-theme'),
'linkedin-icon' => __('LinkedIn', 'my-theme'),
'whatsapp-icon' => __('Whatsapp', 'my-theme'),
'twitter-icon' => __('Twitter', 'my-theme'),
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
'title' => __('Social Background Color', 'my-theme'),
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
'title' => __('Social Icons Color', 'my-theme'),
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
'title' => __('Related Posts Settings', 'my-theme'),
'indent' => true,
'transparent' => false,
),
array(
'id' => 'related_posts',
'type' => 'switch',
'title' => __('Show Related Posts', 'my-theme'),
'default' => true,
),
array(
'id' => 'related_title',
'type' => 'text',
'title' => esc_html__('Heading', 'my-theme'),
'required' => array('related_posts', '=', true),
'default' => 'Related Posts',
),
array(
'id' => 'related_post_meta_display',
'type' => 'button_set',
'title' => __('Meta Data Display', 'my-theme'),
'subtitle' => __('Choose which post meta data to show.', 'my-theme'),
'options' => array(
'date' => __('Date', 'my-theme'),
'category' => __('Category', 'my-theme'),
),
'multi' => true,
'default' => array('date', 'category'),
'required' => array('related_posts', '=', true),
),
array(
'id' => 'related_posts_count',
'type' => 'slider',
'title' => __('Number of Related Posts', 'my-theme'),
'min' => 3,
'max' => 12,
'step' => 1,
'default' => 3,
'required' => array('related_posts', '=', true),
),
array(
'id' => 'related_posts_by',
'type' => 'button_set',
'title' => __('Related Posts By', 'my-theme'),
'options' => array(
'category' => __('Category', 'my-theme'),
'tag' => __('Tag', 'my-theme'),
),
'default' => 'category',
'required' => array('related_posts', '=', true),
),
)
));


Redux::setSection($opt_name, array(
'title' => __('Category', 'my-theme'),
'id' => 'category_options',
'subsection' => true,
'fields' => array(
array(
'id' => 'category_post_layout',
'type' => 'image_select',
'title' => __('Category posts Layout', 'my-theme'),
'subtitle' => __('Choose how blog posts are displayed.', 'my-theme'),
'options' => array(
'grid' => array(
'alt' => __('Grid', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
),
'list' => array(
'alt' => __('List', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
)
),
'default' => 'grid',
),
array(
'id' => 'category_sidebar_position',
'type' => 'image_select',
'title' => __('Sidebar Position', 'my-theme'),
'subtitle' => __('Select layout for category page.', 'my-theme'),
'options' => array(
'right-sidebar' => array(
'alt' => __('Right Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
),
'left-sidebar' => array(
'alt' => __('Left Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
),
'no-sidebar' => array(
'alt' => __('No Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
),
),
'default' => 'right-sidebar',
),
array(
'id' => 'enable_date_category',
'type' => 'switch',
'title' => esc_html__('Enable Date?', 'my-theme'),
'default' => true,
),
)
));


Redux::setSection($opt_name, array(
'title' => __('Tag', 'my-theme'),
'id' => 'tags_options',
'subsection' => true,
'fields' => array(
array(
'id' => 'tag_post_layout',
'type' => 'image_select',
'title' => __('Tags posts Layout', 'my-theme'),
'subtitle' => __('Choose how blog posts are displayed.', 'my-theme'),
'options' => array(
'grid' => array(
'alt' => __('Grid', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
),
'list' => array(
'alt' => __('List', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
)
),
'default' => 'grid',
),
array(
'id' => 'tag_sidebar_position',
'type' => 'image_select',
'title' => __('Sidebar Position', 'my-theme'),
'subtitle' => __('Select layout for Blog page.', 'my-theme'),
'options' => array(
'right-sidebar' => array(
'alt' => __('Right Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
),
'left-sidebar' => array(
'alt' => __('Left Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
),
'no-sidebar' => array(
'alt' => __('No Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
),
),
'default' => 'right-sidebar',
),
array(
'id' => 'enable_date_tag',
'type' => 'switch',
'title' => esc_html__('Enable Date?', 'my-theme'),
'default' => true,
),
)
));


Redux::setSection($opt_name, array(
'title' => __('Search', 'my-theme'),
'id' => 'search_options',
'subsection' => true,
'fields' => array(
array(
'id' => 'search_post_layout',
'type' => 'image_select',
'title' => __('Search posts Layout', 'my-theme'),
'subtitle' => __('Choose how blog posts are displayed.', 'my-theme'),
'options' => array(
'grid' => array(
'alt' => __('Grid', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-grid.png'
),
'list' => array(
'alt' => __('List', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/blog-list.png'
)
),
'default' => 'grid',
),
array(
'id' => 'search_sidebar_position',
'type' => 'image_select',
'title' => __('Sidebar Position', 'my-theme'),
'subtitle' => __('Select layout for Search page.', 'my-theme'),
'options' => array(
'right-sidebar' => array(
'alt' => __('Right Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/right-sidebar.png'
),
'left-sidebar' => array(
'alt' => __('Left Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/left-sidebar.png'
),
'no-sidebar' => array(
'alt' => __('No Sidebar', 'my-theme'),
'img' => get_template_directory_uri() . '/assets/options-assets/images/no-sidebar.png'
),
),
'default' => 'right-sidebar',
),
array(
'id' => 'search_page_metadata',
'type' => 'button_set',
'title' => __('Search Page Metadata', 'my-theme'),
'options' => array(
'category' => __('Category', 'my-theme'),
'date' => __('Date', 'my-theme'),
),
'multi' => true,
'default' => array('date', 'category'),
'required' => array('related_posts', '=', true),
),
array(
'id' => 'enable_search_form',
'type' => 'switch',
'title' => esc_html__('Enable Search form?', 'my-theme'),
'default' => false,
'required' => array('search_sidebar_position', '=', 'no-sidebar'),
),
)
));

/**
* INTEGRATIONS SECTION
*/

Redux::setSection($opt_name, array(
'title' => __('Integrations', 'my-theme'),
'id' => 'integrations',
'icon' => 'el el-globe-alt',
'fields' => array(
array(
'id' => 'social_buttons',
'type' => 'repeater',
'title' => __('Social Links', 'my-theme'),
'group_values' => true,
'fields' => array(
array(
'id' => 'social_icon',
'type' => 'select',
'title' => __('Social Media', 'my-theme'),
'options' => array(
'fb-link' => __('Facebook', 'my-theme'),
'instagram-link' => __('Instagram', 'my-theme'),
'yt-link' => __('YouTube', 'my-theme'),
'linkedin-icon' => __('Linkedin', 'my-theme'),
'whatsapp-icon' => __('Whatsapp', 'my-theme'),
'twitter-icon' => __('Twitter', 'my-theme'),
'tiktok-icon' => __('Tiktok', 'my-theme'),
),
),
array(
'id' => 'social_url',
'type' => 'text',
'title' => __('Link', 'my-theme'),
'default' => '#',
)
),
),
array(
'id' => 'google_analytics',
'type' => 'ace_editor',
'title' => __('Google Analytics / Tag Manager', 'my-theme'),
'subtitle' => __('Paste your GA or GTM script here. Will be added in the site head tag.', 'my-theme'),
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
'title' => __('Custom Code', 'my-theme'),
'id' => 'custom_code',
'icon' => 'el el-css',
'fields' => array(

array(
'id' => 'custom_css_header',
'type' => 'ace_editor',
'title' => __('Additional CSS (Header)', 'my-theme'),
'subtitle' => __('Add custom CSS to be included in the sites head tag, inside the style tag.', 'my-theme'),
'mode' => 'css',
'theme' => 'monokai',
'default' => '',
),
array(
'id' => 'custom_css_footer',
'type' => 'ace_editor',
'title' => __('Additional CSS (Footer)', 'my-theme'),
'subtitle' => __('Add custom CSS to be included after the footer tag, inside the style tag.', 'my-theme'),
'mode' => 'css',
'theme' => 'monokai',
'default' => '',
),
array(
'id' => 'custom_js_header',
'type' => 'ace_editor',
'title' => __('Additional JS (Header)', 'my-theme'),
'subtitle' => __('Add custom JavaScript to be included in the sites head tag, inside the script tag.', 'my-theme'),
'mode' => 'javascript',
'theme' => 'monokai',
'default' => '',
),
array(
'id' => 'custom_js_footer',
'type' => 'ace_editor',
'title' => __('Additional JS (Footer)', 'my-theme'),
'subtitle' => __('Add custom JavaScript be included after the footer tag, inside the script tag.', 'my-theme'),
'mode' => 'javascript',
'theme' => 'monokai',
'default' => '',
),
)
));