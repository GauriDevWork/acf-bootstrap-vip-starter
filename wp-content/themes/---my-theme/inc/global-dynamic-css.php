<?php

/**
 * Global dynamic css
 */

// Collect inline CSS from Redux options
$options = get_option('my_theme_options');
if (empty($options) || ! is_array($options)) {
    return;
}

$page_id = get_the_ID();

$global_sections = '';

/* Colors */

$color_1     = isset($options['color_1']) ? $options['color_1'] : '#C31F27';
$color_2     = isset($options['color_2']) ? $options['color_2'] : '#08184D';

$content_font_color = (!empty($options['content_font_color']) && !empty($options['content_font_color_code'])) ? $options['content_font_color_code'] : $color_2;

$headings_font_color = (!empty($options['headings_font_color']) && !empty($options['heading_font_color_code'])) ? $options['heading_font_color_code'] : $color_2;

$menu_and_arrow_color = (!empty($options['menu_and_arrow_color_code']) && !empty($options['menu_and_arrow_color'])) ? $options['menu_and_arrow_color'] : $color_2;


$dark_section_background     = isset($options['dark_section_colors']['regular']) ? $options['dark_section_colors']['regular'] : '#040b22';
$dark_section_content_color     = isset($options['dark_section_colors']['hover']) ? $options['dark_section_colors']['hover'] : '#ffffff';

$link_color_regular     = isset($options['link_color']['regular']) ? $options['link_color']['regular'] : '#08184d';
$link_color_hover     = isset($options['link_color']['hover']) ? $options['link_color']['hover'] : '#dd3333';

/* Typography */

/* body */

$content_font     = isset($options['content_font']['font-family']) ? $options['content_font']['font-family'] : 'Libre Franklin';
$content_font_weight     = isset($options['content_font']['font-weight']) ? $options['content_font']['font-weight'] : 300;

/* h1 to h6 */

$headings_font = !empty($options['headings_font']['font-family']) ? $options['headings_font']['font-family'] : 'Libre Franklin';
$headings_font_weight      = !empty($options['headings_font']['font-weight']) ? $options['headings_font']['font-weight'] : 300;

/* Buttons */

$button_font_family = !empty($options['button_typography']['font-family']) ? $options['button_typography']['font-family'] : 'Libre Franklin';
$button_color       = !empty($options['button_typography']['color']) ? $options['button_typography']['color'] : '#ffffff';
$button_font_weight       = !empty($options['button_typography']['font-weight']) ? $options['button_typography']['font-weight'] : 300;

$button_bg_color = !empty($options['button_bg_color']) ? $options['button_bg_color'] : '#C31F27';

$button_border_style = !empty($options['button_border']['border-style']) ? $options['button_border']['border-style'] : 'Solid';
$button_border_color = !empty($options['button_border']['border-color']) ? $options['button_border']['border-color'] : '#c31f27';
$button_border_top   = !empty($options['button_border']['border-top']) ? $options['button_border']['border-top'] : '1px';
$button_border_right = !empty($options['button_border']['border-right']) ? $options['button_border']['border-right'] : '1px';
$button_border_bottom = !empty($options['button_border']['border-bottom']) ? $options['button_border']['border-bottom'] : '1px';
$button_border_left = !empty($options['button_border']['border-left']) ? $options['button_border']['border-left'] : '1px';

$button_radius = !empty($options['button_radius']) ? $options['button_radius'] . 'px' : 0;

$button_hover_bg = isset($options['on_button_hover']['regular']) ? $options['on_button_hover']['regular'] : '#ffffff';
$button_hover_color = isset($options['on_button_hover']['hover']) ? $options['on_button_hover']['hover'] : '#C31F27';
$button_border_hover_color = isset($options['on_button_hover']['active']) ? $options['on_button_hover']['active'] : '#C31F27';

$arrow_color     = isset($options['arrow_color']['regular']) ? $options['arrow_color']['regular'] : '#ffffff';
$arrow_hover_color     = isset($options['arrow_color']['hover']) ? $options['arrow_color']['hover'] : '#C31F27';

$transparent_header = !empty($options['transparent_header']) ? $options['transparent_header'] : false;
$header_background_color = !empty($options['header_background_color']) ? $options['header_background_color'] : '#ffffff';

$header_opacity = isset($options['transparent_header_opacity']) ? $options['transparent_header_opacity'] : 0.9;

$header_social_bg_regular     = isset($options['header_social_bg']['regular']) ? $options['header_social_bg']['regular'] : '#21409A';
$header_social_bg_hover     = isset($options['header_social_bg']['hover']) ? $options['header_social_bg']['hover'] : '#c31f27';

$header_social_icon_color_regular     = isset($options['header_social_icon_color']['regular']) ? $options['header_social_icon_color']['regular'] : '#FFFFFF';
$header_social_icon_color_hover     = isset($options['header_social_icon_color']['hover']) ? $options['header_social_icon_color']['hover'] : '#FFFFFF';

$footer_social_bg_regular     = isset($options['footer_social_bg']['regular']) ? $options['footer_social_bg']['regular'] : '#21409A';
$footer_social_bg_hover     = isset($options['footer_social_bg']['hover']) ? $options['footer_social_bg']['hover'] : '#c31f27';

$footer_social_icon_color_regular     = isset($options['footer_social_icon_color']['regular']) ? $options['footer_social_icon_color']['regular'] : '#FFFFFF';
$footer_social_icon_color_hover     = isset($options['footer_social_icon_color']['hover']) ? $options['footer_social_icon_color']['hover'] : '#FFFFFF';

$single_social_bg_regular     = isset($options['single_social_bg']['regular']) ? $options['single_social_bg']['regular'] : '#21409A';
$single_social_bg_hover     = isset($options['single_social_bg']['hover']) ? $options['single_social_bg']['hover'] : '#c31f27';

$single_social_icon_color_regular     = isset($options['single_social_icon_color']['regular']) ? $options['single_social_icon_color']['regular'] : '#FFFFFF';
$single_social_icon_color_hover     = isset($options['single_social_icon_color']['hover']) ? $options['single_social_icon_color']['hover'] : '#FFFFFF';


/**
 * Convert HEX to RGBA
 */
function my_theme_hex2rgba($color, $opacity = 1)
{
    $color = str_replace('#', '', $color);

    if (strlen($color) == 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    }

    return "rgba($r, $g, $b, $opacity)";
}

// Final RGBA
$header_rgba = my_theme_hex2rgba($header_background_color, $header_opacity);

$footer_padding = !empty($options['footer_padding']) ? $options['footer_padding'] : [];

$pt = !empty($footer_padding['padding-top']) ? $footer_padding['padding-top'] : 0;
$pr = !empty($footer_padding['padding-right']) ? $footer_padding['padding-right'] : 0;
$pb = !empty($footer_padding['padding-bottom']) ? $footer_padding['padding-bottom'] : 0;
$pl = !empty($footer_padding['padding-left']) ? $footer_padding['padding-left'] : 0;

$unit = !empty($footer_padding['units']) ? $footer_padding['units'] : 'px';

/* Footer */

$footer_bg = !empty($options['footer_bg_image_and_color']) ? $options['footer_bg_image_and_color'] : array();

$footer_overlay_bg = my_theme_hex2rgba($footer_bg['background-color'], 0.8);

$footer_content_align = isset($options['content_align']) ? $options['content_align'] : 'left';

$footer_headings_color = !empty($options['footer_headings_color']) ? $options['footer_headings_color'] : '#ffffff';
$footer_content_color  = !empty($options['footer_content_color']) ? $options['footer_content_color'] : '#ffffff';

$default_banner_bg_color  = !empty($options['default_banner_bg_color']) ? $options['default_banner_bg_color'] : '#E6F5FF';

if ($options['add_border_top']) {

    $footer_border_top = '';
    if (!empty($options['add_border_top']) && !empty($options['footer_top_border']['border-top'])) {
        $border_size  = $options['footer_top_border']['border-top'];
        $border_style = !empty($options['footer_top_border']['border-style']) ? $options['footer_top_border']['border-style'] : 'solid';
        $border_color = !empty($options['footer_top_border']['border-color']) ? $options['footer_top_border']['border-color'] : '#000';
        $footer_border_top = "border-top: {$border_size} {$border_style} {$border_color};";
    }

    $footer_radius = !empty($options['footer_border_radius']) ? intval($options['footer_border_radius']) : 0;
}
?>
<style type="text/css" id="global-dynamic-css">
    :root {
        --Libre-Franklin: '<?php echo $content_font; ?>';

        --header_background_color: <?php echo $header_background_color; ?>;
        --menu_and_arrow_color: <?php echo $menu_and_arrow_color; ?>;

        --content_font_color: <?php echo $content_font_color; ?>;
        --headings_font_color: <?php echo $headings_font_color; ?>;

        --button_color: <?php echo $button_color; ?>;
        --button_bg_color: <?php echo $button_bg_color; ?>;
        --button_border_color: <?php echo $button_border_color; ?>;
        --button_hover_bg: <?php echo $button_hover_bg; ?>;
        --button_hover_color: <?php echo $button_hover_color; ?>;
        --button_border_hover_color: <?php echo $button_border_hover_color; ?>;

        --arrow_color: <?php echo $arrow_color; ?>;
        --arrow_hover_color: <?php echo $arrow_hover_color; ?>;

        --primary: <?php echo $color_1; ?>;
        --secondary: <?php echo $color_2; ?>;

        --dark_section_background: <?php echo $dark_section_background; ?>;
        --dark_section_content_color: <?php echo $dark_section_content_color; ?>;

        --link_color_regular: <?php echo $link_color_regular; ?>;
        --link_color_hover: <?php echo $link_color_hover; ?>;

        --footer_headings_color: <?php echo $footer_headings_color; ?>;
        --footer_content_color: <?php echo $footer_content_color; ?>;

        --default_banner_bg_color: <?php echo $default_banner_bg_color; ?>;

        --header_social_bg_regular: <?php echo $header_social_bg_regular; ?>;
        --header_social_bg_hover: <?php echo $header_social_bg_hover; ?>;

        --header_social_icon_color_regular: <?php echo $header_social_icon_color_regular; ?>;
        --header_social_icon_color_hover: <?php echo $header_social_icon_color_hover; ?>;

        --footer_social_bg_regular: <?php echo $footer_social_bg_regular; ?>;
        --footer_social_bg_hover: <?php echo $footer_social_bg_hover; ?>;

        --footer_social_icon_color_regular: <?php echo $footer_social_icon_color_regular; ?>;
        --footer_social_icon_color_hover: <?php echo $footer_social_icon_color_hover; ?>;

        --single_social_bg_regular: <?php echo $single_social_bg_regular; ?>;
        --single_social_bg_hover: <?php echo $single_social_bg_hover; ?>;

        --single_social_icon_color_regular: <?php echo $single_social_icon_color_regular; ?>;
        --single_social_icon_color_hover: <?php echo $single_social_icon_color_hover; ?>;

        /* static */
        --white: #FFFFFF;
        --black: #0C0C14;
        --grey: #F6F4F4;
        --light-pink: #C31F27;

    }

    <?php
    if ($options['add_border_top']) {
    ?>.my-theme-footer {
        border-top-left-radius: <?php echo $footer_radius; ?>px;
        border-top-right-radius: <?php echo $footer_radius; ?>px;
        color: var(--footer_content_color);
        <?php echo $footer_border_top; ?>
    }

    <?php
    }
    ?>.my-theme-footer .footer-col {
        text-align: <?php echo $footer_content_align; ?>;
    }

    <?php
    if (!empty($footer_bg['background-image'])) {
    ?>.my-theme-footer::before {
        position: absolute;
        content: '';
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: <?php echo $footer_overlay_bg; ?>;
    }

    <?php
    }

    if ($options['container_width'] == 'boxed_container') {
        $boxed_container_width     = $options['boxed_container_width'];

    ?>.custom-container .container {
        max-width: <?php echo $boxed_container_width ?>px !important;
    }

    <?php

        if (!empty($global_sections)) {
            foreach ($global_sections as $section) {
                if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'address_section') {

    ?>@media(min-width:1400px) {
        .custom-container .my-theme-find-us-slider {
            margin-left: calc((100% - calc(<?php echo $boxed_container_width; ?>px - 100px)) / 2);
        }
    }

    <?php
                }
            }
        }
    }

    ?>body,
    p,
    .p {
        font-family: '<?php echo $content_font; ?>';
        color: var(--content_font_color);
        font-weight: <?php echo $content_font_weight; ?>;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6 {
        font-family: '<?php echo $headings_font; ?>';
        color: var(--headings_font_color);
        font-weight: <?php echo $headings_font_weight; ?>;
    }

    <?php
    if ($transparent_header) : ?>.header {
        background: <?php echo esc_attr($header_rgba); ?>;
    }

    <?php else: ?>.header {
        background: var(--header_background_color);
    }

    <?php endif; ?>.my-theme-footer .ft-top-row {
        padding-top: <?php echo esc_attr($pt . $unit); ?>;
        padding-right: <?php echo esc_attr($pr . $unit); ?>;
        padding-bottom: <?php echo esc_attr($pb . $unit); ?>;
        padding-left: <?php echo esc_attr($pl . $unit); ?>;
    }

    .my-theme-btn,
    button,
    input[type=submit],
    input[type=reset],
    input[type=button],
    .my-theme-footer .footer-col .wp-block-button .wp-element-button {
        border-radius: <?php echo $button_radius; ?>;
        border-style: <?php echo  $button_border_style; ?>;
        border-bottom-width: <?php echo  $button_border_bottom; ?>;
        border-top-width: <?php echo $button_border_top; ?>;
        border-left-width: <?php echo $button_border_left; ?>;
        border-right-width: <?php echo  $button_border_right; ?>;
        font-weight: <?php echo $button_font_weight; ?>;
    }
</style>
<?php
