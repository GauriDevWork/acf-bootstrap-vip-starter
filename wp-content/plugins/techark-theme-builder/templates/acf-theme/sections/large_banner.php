<?php

$section = $args['section'];

$background_image_url = !empty($section['background_image']) ? $section['background_image']['url'] : $section['default_placeholder_image']['url'];

$heading = $section['heading'];
$content = $section['content'];

$btn_text = !empty($section['button']['title']) ? $section['button']['title'] : '';
$btn_link = !empty($section['button']['url']) ? $section['button']['url'] : '#';
$btn_link_target = !empty($section['button']['target']) ? $section['button']['target'] : '_self';

$highlight_text = $section['highlight_text'];

if (!empty($heading) || !empty($content) | !empty($btn_text) || !empty($highlight_text)) {
    ?>
    <section class="{{THEME_PREFIX}}-hero-banner my-75" style="background-image: url('<?php echo $background_image_url; ?>');">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <div class="{{THEME_PREFIX}}-content">
                <?php
                if (!empty($heading)) {
                    ?>
                    <h1 class="h1"><?php echo $heading; ?></h1>
                    <?php
                }
                if (!empty($content)) {
                    echo $content;
                }
                if (!empty($btn_text)) {
                    ?>
                    <a href="<?php echo $btn_link; ?>" target="<?php echo $btn_link_target; ?>" class="{{THEME_PREFIX}}-btn"><?php echo $btn_text; ?></a>
                    <?php
                }
                ?>
            </div>
            <?php
            if (!empty($highlight_text)) {
                ?>
                <div class="default-ticker">
                    <h2 class="trust-large-text marquee">
                        <span><?php echo $highlight_text; ?></span>
                        <span><?php echo $highlight_text; ?></span>
                        <span><?php echo $highlight_text; ?></span>
                        <span><?php echo $highlight_text; ?></span>
                    </h2>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
    <?php
}
