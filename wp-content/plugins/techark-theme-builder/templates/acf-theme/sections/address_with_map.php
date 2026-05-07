<?php

$section = $args['section'];

$address_list = $section['address_list'];

$swap_module = !empty($section['swap_module']) ? 'row-reverse' : '';

if (!empty($address_list)) {

    ?>
    <section class="py-75">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <div class="{{THEME_PREFIX}}-locations-row <?php echo $swap_module; ?>">
                <div class="locations-list-shadow">
                    <div class="locations-list-wrapper">
                        <ul class="locations-list">
                            <?php
                            $cnt = 1;
                            foreach ($address_list as $address) {

                                $address_name = $address['address_name'];
                                $location_text = $address['address'];
                                $google_map_iframe_url = $address['google_map_iframe_url'];
                                $content = $address['content'];
                                ?>
                                <li class="<?php echo ($cnt == 1) ? 'active' : ''; ?>">
                                    <a href="<?php echo $google_map_iframe_url; ?>">
                                        <span class="location-icon"></span>
                                        <div class="text-block">
                                            <?php
                                            if (!empty($address_name)) {
                                                ?>
                                                <span class="h5"><?php echo $address_name; ?></span>
                                                <?php
                                            }
                                            if (!empty($location_text)) {
                                                ?>
                                                <h2 class="h6"><?php echo $location_text; ?></h2>
                                                <?php
                                            }
                                            if (!empty($content)) {
                                                echo $content;
                                            }
                                            ?>
                                        </div>
                                    </a>
                                </li>
                                <?php
                                $cnt++;
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="map-block wow zoomIn">
                    <iframe data-src="<?php echo $address_list[0]['google_map_iframe_url']; ?>" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="600" height="450" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade" class="custom-lazyload-iframe"></iframe>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>