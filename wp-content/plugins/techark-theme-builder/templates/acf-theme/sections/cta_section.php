<?php

$section = $args['section'];

$heading = $section['heading'];
$content = $section['content'];
$cta_list = $section['cta_list'];

if (!empty($heading) || !empty($content) || !empty($cta_list)) {

    ?>
    <section class="py-75 cta-section">
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

                foreach ($cta_list as $cta) {

                    if (!empty($cta['link']['title'])) {
                        ?>
                        <a href="<?php echo $cta['link']['url'] ?>" target="<?php echo $cta['link']['target'] ?>" class="{{THEME_PREFIX}}-btn"><?php echo $cta['link']['title']; ?></a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}
?>