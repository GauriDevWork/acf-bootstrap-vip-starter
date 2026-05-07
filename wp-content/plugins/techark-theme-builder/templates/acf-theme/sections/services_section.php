<?php

$section = $args['section'];

$heading = $section['heading'];
$service_list = $section['service_list'];

if (!empty($service_list) || !empty($heading)) {

    ?>
    <section class="py-150 my-75 {{THEME_PREFIX}}-services">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <?php
            if (!empty($heading)) {
                ?>
                <h2 class="h2 wow fadeInUp"><?php echo $heading; ?></h2>
                <?php
            }
            ?>
            <div class="{{THEME_PREFIX}}-services-row row">
                <?php
                foreach ($service_list as $service) {

                    $post_id = $service->ID;

                    $post_excerpt = $service->post_excerpt;

                    $post_content = '';
                    if (!empty($post_excerpt)) {
                        $post_content = $post_excerpt;
                    } else {
                        $post_content = $service->post_content;
                    }

                    ?>
                    <div class="col-xxl-4 col-md-6">
                        <div class="service-card wow zoomIn">
                            <span class="heart-beat-icon icon"></span>
                            <h3 class="h3"><?php echo get_the_title($post_id); ?></h3>
                            <?php

                            if (!empty($post_content)) {
                                echo "<p>" . $post_content . "</p>";
                            }
                            ?>
                            <a href="<?php echo get_the_permalink($post_id); ?>" class="p">Learn More</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}
