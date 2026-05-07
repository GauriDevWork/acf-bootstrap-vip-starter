<?php

$options = get_option('{{THEME_PREFIX}}options');

$blog_page_id = get_option('page_for_posts');
$current_page_id = get_the_ID();

if (is_home() || is_archive() || is_category() || is_tag() || is_search()) {
    $page_id = $blog_page_id;
} else {
    $page_id = $current_page_id;
}

$banner_enable = get_post_meta($page_id, 'banner_enable', true);

$banner_title = get_post_meta($page_id, 'banner_title', true);
if (empty($banner_title)) {
    $banner_title = get_the_title($page_id);
}

/* BG type */
$banner_bg_type = get_post_meta($page_id, 'banner_bg_type', true);

/* BG color */
$banner_bg_color = get_post_meta($page_id, 'page_banner_color', true);
$banner_bg_color = !empty($banner_bg_color) ? $banner_bg_color : $options['default_banner_bg_color'];

// Image
$banner_bg_image_data = get_post_meta($page_id, 'page_banner_image', true);

$banner_bg_image_color = !empty($banner_bg_image_data['background-color']) ? $banner_bg_image_data['background-color'] : $options['default_banner_bg_color'];
$banner_bg_image = !empty($banner_bg_image_data['background-image']) ? $banner_bg_image_data['background-image'] : '';
$banner_bg_repeat = !empty($banner_bg_image_data['background-repeat']) ? $banner_bg_image_data['background-repeat'] : 'no-repeat';
$banner_bg_size = !empty($banner_bg_image_data['background-size']) ? $banner_bg_image_data['background-size'] : 'cover';
$banner_bg_position = !empty($banner_bg_image_data['background-position']) ? $banner_bg_image_data['background-position'] : 'center center';
$banner_bg_attach = !empty($banner_bg_image_data['background-attachment']) ? $banner_bg_image_data['background-attachment'] : 'scroll';

// Alignment
$banner_title_align = get_post_meta($page_id, 'banner_title_align', true);
$banner_title_align = !empty($banner_title_align) ? $banner_title_align : 'left';

// Padding
$banner_padding = get_post_meta($page_id, 'banner_padding', true);
$banner_padding_top = isset($banner_padding['width']) ? $banner_padding['width'] : 260;
$banner_padding_bottom = isset($banner_padding['height']) ? $banner_padding['height'] : 150;

// Build inline style
$banner_style = '';

if ($banner_bg_type) {
    // Image mode
    if (!empty($banner_bg_image)) {
        /*   $banner_style  = "background-image:url('{$banner_bg_image}');"; */
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
    <section class="{{THEME_PREFIX}}-banner my-75 custom-lazystyle" style="<?php echo esc_attr($banner_style); ?>" data-style="<?php echo $banner_bg_image; ?>">
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
        <section class="{{THEME_PREFIX}}-banner my-75" style="<?php echo esc_attr($banner_style); ?>">
            <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
                <h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
                    <?php echo get_the_title(); ?>
                </h1>
            </div>
        </section>
        <?php
    }
}
