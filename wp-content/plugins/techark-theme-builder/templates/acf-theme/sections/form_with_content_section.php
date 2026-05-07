<?php

$section = $args['section'];

$swap_module = !empty($section['swap_module']) ? 'row-reverse' : '';

$image = !empty($section['image']) ? $section['image'] : $section['default_placeholder_image'];

$heading = $section['heading'];

$form = $section['form'];
$content_section = $section['content_section'];

if (!empty($title) || !empty($form) || !empty($content_section)) {

    ?>
    <section class="py-75 {{THEME_PREFIX}}-appointment with-content">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <div class="{{THEME_PREFIX}}-appointment-row <?php echo $swap_module; ?>">
                <div class="{{THEME_PREFIX}}-appointment-form">
                    <?php
                    if (!empty($heading)) {
                        ?>
                        <h2 class="h2 wow fadeInUp"><?php echo $heading; ?></h2>
                        <?php
                    }

                    if (!empty($form)) {
                        echo do_shortcode('[contact-form-7 id="' . $form[0] . '"]');
                    }

                    ?>
                </div>
                <div class="{{THEME_PREFIX}}-appointment-img contact-content">
                    <?php
                    if (!empty($content_section)) {
                        $title = $content_section['title'];
                        $description = $content_section['description'];
                        $address = $content_section['address'];
                        $phone = $content_section['phone'];
                        $fax_number = $content_section['fax_number'];
                        $cta_list = $content_section['cta_list'];
                        if (!empty($title)) {
                            ?>
                            <h2 class="h2 wow fadeInUp"><?php echo $title; ?></h2>
                            <?php
                        }

                        if (!empty($description)) {
                            echo $description;
                        }

                        if (!empty($address)) {
                            echo $address;
                        }

                        if (!empty($phone) || !empty($fax_number)) {
                            ?>
                            <div class="number-wrap">
                                <?php
                                if (!empty($phone)) {
                                    ?>
                                    <a href="tel:<?php echo esc_attr($phone); ?>" class="p">
                                        <?php echo esc_html($phone); ?>
                                    </a>
                                    <?php
                                }

                                // Add pipe ONLY if both exist
                                if (!empty($phone) && !empty($fax_number)) {
                                    echo "|";
                                }

                                if (!empty($fax_number)) {
                                    ?>
                                    <span class="fax-number">
                                        <?php echo esc_html($fax_number); ?>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }



                        if (!empty($cta_list)) {
                            ?>
                            <div class="btn-wrap">
                                <?php
                                foreach ($cta_list as $cta) {
                                    if (!empty($cta['link']['title'])) {
                                        ?>
                                        <a href="<?php echo $cta['link']['url'] ?>" target="<?php echo $cta['link']['target'] ?>" class="{{THEME_PREFIX}}-btn"><?php echo $cta['link']['title']; ?></a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }


                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>