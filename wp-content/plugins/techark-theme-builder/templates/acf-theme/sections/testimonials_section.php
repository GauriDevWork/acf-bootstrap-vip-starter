<?php

$section = $args['section'];

$heading = $section['heading'];
$testimonial_list = $section['testimonial_list'];


if (!empty($heading) || !empty($testimonial_list)) {

    ?>
    <section class="{{THEME_PREFIX}}-client py-75">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <?php
            if (!empty($heading)) {
                ?>
                <h2 class="h2 wow fadeInUp"><?php echo $heading; ?></h2>
                <?php
            }

            if (!empty($testimonial_list)) {

                $post_count = count($testimonial_list);

                ?>
                <div class="{{THEME_PREFIX}}-client-slider-wrapper">
                    <div class="{{THEME_PREFIX}}-client-slider owl-carousel owl-theme" post_count="<?php echo $post_count; ?>">
                        <?php
                        foreach ($testimonial_list as $testimonial) {

                            $client_name = get_field('author_name', $testimonial->ID);

                            $client_content = $testimonial->post_content;
                            $star_rating = get_field('rating', $testimonial->ID);

                            ?>
                            <div class="item">
                                <?php
                                if (!empty(get_the_post_thumbnail_url($testimonial, 'full')) || !empty($client_name)) {
                                    ?>
                                    <div class="profile">
                                        <?php
                                        if (!empty(get_the_post_thumbnail_url($testimonial, 'full'))) {

                                            $image_url = get_the_post_thumbnail_url($testimonial, 'full');

                                            $thumb_id = get_post_thumbnail_id($testimonial);
                                            $image_alt = !empty($thumb_id) ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) : $client_name . '-alt';

                                            $image_arr = array(
                                                'url' => $image_url,
                                                'alt' => $image_alt,
                                                'title' => $client_name,
                                            );

                                            echo getlazyload_img($image_arr, '100', '100');
                                        }

                                        if (!empty($client_name)) {
                                            ?>
                                            <h3 class="h5"><?php echo $client_name ?></h3>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                if (!empty($client_content)) {
                                    ?>
                                    <p><?php echo $client_content; ?></p>
                                    <?php
                                }
                                if (!empty($star_rating) && $star_rating > 0) {
                                    $total_stars = 5;
                                    ?>

                                    <div class="ratings">
                                        <?php for ($i = 1; $i <= $total_stars; $i++): ?>
                                            <?php if ($i <= $star_rating): ?>
                                                <span class="rating-star yellow-star"></span>
                                            <?php else: ?>
                                                <span class="rating-star grey-star"></span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
    <?php
}
?>