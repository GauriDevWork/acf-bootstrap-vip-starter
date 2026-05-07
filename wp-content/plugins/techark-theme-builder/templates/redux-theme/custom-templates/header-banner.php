<?php

$options = get_option('{{THEME_PREFIX}}options');

$banner_enable = !empty($options['banner_enable']) ? $options['banner_enable'] : false;

$banner_title = get_the_title();

/* BG type */
$banner_bg_type = isset($options['banner_bg_type']) ? $options['banner_bg_type'] : false;

/* BG color */
$banner_bg_color = !empty($options['page_banner_color']) ? $options['page_banner_color'] : '#E6F5FF';

// Image
$banner_bg_image_data = !empty($options['page_banner_image']) ? $options['page_banner_image'] : array();

$banner_bg_image_color = !empty($banner_bg_image_data['background-color']) ? $banner_bg_image_data['background-color'] : '#E6F5FF';
$banner_bg_image = !empty($banner_bg_image_data['background-image']) ? $banner_bg_image_data['background-image'] : '';
$banner_bg_repeat = !empty($banner_bg_image_data['background-repeat']) ? $banner_bg_image_data['background-repeat'] : 'no-repeat';
$banner_bg_size = !empty($banner_bg_image_data['background-size']) ? $banner_bg_image_data['background-size'] : 'cover';
$banner_bg_position = !empty($banner_bg_image_data['background-position']) ? $banner_bg_image_data['background-position'] : 'center center';
$banner_bg_attach = !empty($banner_bg_image_data['background-attachment']) ? $banner_bg_image_data['background-attachment'] : 'scroll';

// Alignment
$banner_title_align = !empty($options['banner_title_align']) ? $options['banner_title_align'] : 'left';

// Padding
$banner_padding = !empty($options['banner_padding']) ? $options['banner_padding'] : array();
$banner_padding_top = isset($banner_padding['width']) ? $banner_padding['width'] : 260;
$banner_padding_bottom = isset($banner_padding['height']) ? $banner_padding['height'] : 150;

// Build inline style
$banner_style = '';

if ($banner_bg_type) {
    // Image mode
    if (!empty($banner_bg_image)) {
        $banner_style .= "background-repeat:{$banner_bg_repeat};";
        $banner_style .= "background-size:{$banner_bg_size};";
        $banner_style .= "background-position:{$banner_bg_position};";
        $banner_style .= "background-attachment:{$banner_bg_attach};";
        $banner_style .= "background-color:{$banner_bg_image_color};";
    } else {
        // Fallback to color
        $banner_style .= "background-color:{$banner_bg_image_color};";
    }
} else {
    // Color mode
    $banner_style .= "background-color:{$banner_bg_color};";
}

// Add paddings
$banner_style .= "padding-top:{$banner_padding_top}px;";
$banner_style .= "padding-bottom:{$banner_padding_bottom}px;";

if ($banner_enable) {

    ?>
    <section class="{{TEXT_DOMAIN}}-banner my-75 custom-lazystyle" style="<?php echo esc_attr($banner_style); ?>" data-style="<?php echo $banner_bg_image; ?>">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <?php
            if (is_category()) {
                $cat = get_queried_object();
                $cat_name = $cat->name;
                ?>
                <h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
                    Category: <?php echo $cat_name; ?>
                </h1>
                <?php
            } else if (is_tag()) {
                $tag = get_queried_object();
                $tag_name = $tag->name;
                ?>
                    <h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
                        Tag: <?php echo $tag_name; ?>
                    </h1>
                <?php
            } else if (is_search()) {
                ?>
                        <h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
                            Search Results for: <?php echo get_search_query(); ?>
                        </h1>
                <?php
            } else {
                ?>
                        <h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
                    <?php echo $banner_title; ?>
                        </h1>
                <?php
            }
            ?>
        </div>
    </section>
    <?php
} else {
    if (is_singular('post')) {
        ?>
        <section class="{{TEXT_DOMAIN}}-banner my-75" style="<?php echo esc_attr($banner_style); ?>">
            <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
                <h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
                    <?php echo get_the_title(); ?>
                </h1>
            </div>
        </section>
        <?php
    }
}
