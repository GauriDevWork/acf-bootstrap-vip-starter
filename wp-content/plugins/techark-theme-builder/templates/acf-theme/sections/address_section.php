<?php

$section = $args['section'];

$heading = $section['heading'];
$address_list = $section['address_list'];

if (!empty($heading) || !empty($address_list)) {

?>
    <section class="{{THEME_PREFIX}}-find-us py-75">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <?php
            if (!empty($heading)) {
            ?>
                <h2 class="h2 wow fadeInUp"><?php echo $heading; ?></h2>
            <?php
            }
            if (!empty($address_list)) {

                $post_count = count($address_list);
            ?>
                <div class="{{THEME_PREFIX}}-find-us-slider owl-carousel owl-theme" post_count="<?php echo $post_count; ?>">
                    <?php
                    foreach ($address_list as $location) {

                        $address = $location['address'];
                        $google_map_url = $location['google_map_url'];

                        $btn_text_1 = !empty($location['phone_1']['title']) ? $location['phone_1']['title'] : '';
                        $btn_link_1 = !empty($location['phone_1']['url']) ? $location['phone_1']['url'] : '#';
                        $btn_link_target_1 = !empty($location['phone_1']['target']) ? $location['phone_1']['target'] : '_self';

                        $btn_text_2 = !empty($location['phone_2']['title']) ? $location['phone_2']['title'] : '';
                        $btn_link_2 = !empty($location['phone_2']['url']) ? $location['phone_2']['url'] : '#';
                        $btn_link_target_2 = !empty($location['phone_2']['target']) ? $location['phone_2']['target'] : '_self';

                    ?>
                        <div class="item">
                            <span class="location-icon"></span>
                            <?php
                            if (!empty($address)) {
                                if (!empty($google_map_url)) {
                            ?>
                                    <a class="h6" href="<?php echo $google_map_url; ?>" target="_blank">
                                    <?php
                                } else {
                                    ?>
                                        <p class="h6">
                                        <?php
                                    }
                                    echo $address;
                                    if (!empty($google_map_url)) {
                                        ?>
                                    </a>
                                <?php
                                    } else {
                                ?>
                                    </p>
                                <?php
                                    }
                                }
                                if (!empty($btn_text_1)) {
                                ?>
                                <a href="<?php echo $btn_link_1; ?>" target="<?php echo $btn_link_target_1; ?>" class="p"><?php echo $btn_text_1; ?></a>
                            <?php
                                }
                                if (!empty($btn_text_2)) {
                            ?>
                                <p>
                                    <span class="fax-number">
                                        <?php echo $btn_text_2; ?>
                                    </span>
                                </p>
                            <?php
                                }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
<?php
}
