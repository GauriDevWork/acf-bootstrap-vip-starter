<?php

$section = $args['section'];


$physicians = $section['physicians'];

if (!empty($physicians)) {

?>
    <section class="py-75">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <div class="physicians-row row">
                <?php
                foreach ($physicians as $physician) {

                    $post_id = $physician->ID;
                    $designation = get_field('designation', $post_id);

                    $post_excerpt = $physician->post_excerpt;

                    $post_content = '';
                    if (!empty($post_excerpt)) {
                        $post_content = $post_excerpt;
                    } else {
                        $post_content = $physician->post_content;
                    }

                    $image_url = !empty(get_the_post_thumbnail_url($post_id, 'full')) ? get_the_post_thumbnail_url($post_id, 'full') : $section['default_placeholder_image']['url'];

                    $thumb_id   = get_post_thumbnail_id($testimonial);
                    $image_alt  = !empty($thumb_id) ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) :   get_the_title($post_id) . '-alt';

                    $image_arr = array(
                        'url' => $image_url,
                        'alt' => $image_alt,
                        'title' =>  get_the_title($post_id),
                    );

                ?>
                    <div class="col-xl-6">
                        <a href="<?php echo get_the_permalink($post_id);  ?>" class="physicians-card wow zoomIn <?php echo $post_id; ?>">
                            <div class="img-block">
                                <?php echo getlazyload_img($image_arr, '100', '100'); ?>
                                <span class="icon"></span>
                            </div>
                            <div class="content-block">
                                <h2 class="h3"><?php echo get_the_title($post_id); ?></h2>
                                <?php
                                if (!empty($designation)) {
                                ?>
                                    <h3 class="h6"><?php echo $designation; ?></h3>
                                <?php
                                }
                                if (!empty($post_content)) {
                                ?>
                                    <p><?php echo $post_content; ?></p>
                                <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
}
?>