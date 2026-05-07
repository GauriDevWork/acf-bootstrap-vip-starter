<?php

$section = $args['section'];

$heading = $section['heading'];
$card_list = $section['card_list'];

$section_background = !empty($section['section_background']) ? 'my-75 py-150 no-bg' : 'py-75';

if (!empty($card_list) || !empty($heading)) {

    ?>
    <section class="py-150 my-75 {{THEME_PREFIX}}-services <?php echo $section_background; ?>">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <?php
            if (!empty($heading)) {
                ?>
                <h2 class="h2"><?php echo $heading ?></h2>
                <?php
            }
            ?>
            <div class="{{THEME_PREFIX}}-services-row row">
                <?php

                foreach ($card_list as $card) {

                    $card_heading = $card['card_heading'];
                    $card_content = $card['card_content'];
                    ?>
                    <div class="col-xxl-4 col-md-6">
                        <div class="service-card wow zoomIn">
                            <?php
                            if (!empty($card_heading)) {
                                ?>
                                <h2 class="h3"><?php echo $card_heading; ?></h2>
                                <?php
                            }

                            if (!empty($card_content)) {
                                echo $card_content;
                            }
                            ?>
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
