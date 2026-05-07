<?php

$section = $args['section'];

$section_background = !empty($section['section_background']) ? 'my-75 py-150 bg-dark-blue' : 'py-75';

$heading = $section['heading'];
$content = $section['content'];

$btn_text = !empty($section['button']['title']) ? $section['button']['title'] : '';
$btn_link = !empty($section['button']['url']) ? $section['button']['url'] : '#';
$btn_link_target = !empty($section['button']['target']) ? $section['button']['target'] : '_self';


if (!empty($heading) || !empty($content) || !empty($btn_text)) {

    ?>
    <section class="content-sec <?php echo $section_background; ?>">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <div class="text-block wow fadeInUp">
                <?php
                if (!empty($heading)) {
                    ?>
                    <h2><?php echo $heading; ?></h2>
                    <?php
                }

                if (!empty($content)) {
                    echo $content;
                }

                if (!empty($btn_text)) {
                    ?>
                    <a href="<?php echo $btn_link ?>" target="<?php echo $btn_link_target ?>" class="{{THEME_PREFIX}}-btn"><?php echo $btn_text; ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}
?>