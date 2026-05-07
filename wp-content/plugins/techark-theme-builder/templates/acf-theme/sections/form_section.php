<?php

$section = $args['section'];

$swap_module = !empty($section['swap_module']) ? 'row-reverse' : '';

$image = !empty($section['image']) ? $section['image'] : $section['default_placeholder_image'];

$heading = $section['heading'];

$form = $section['form'];

if (!empty($title) || !empty($form)) {

?>
    <section class="py-75 {{THEME_PREFIX}}-appointment">
        <div class="<?php echo esc_attr( {{THEME_PREFIX}}get_container_class() ); ?>">
            <div class="{{THEME_PREFIX}}-appointment-row <?php echo $swap_module; ?>">
                <div class="{{THEME_PREFIX}}-appointment-form">
                    <?php
                    if (!empty($heading)) {
                    ?>
                        <h2 class="h2 wow fadeInUp"><?php echo $heading; ?></h2>
                    <?php
                    }

                    if (!empty($form)) {
                        echo do_shortcode('[contact-form-7 id="'.$form[0].'"]');
                    }

                    ?>
                </div>
                <div class="{{THEME_PREFIX}}-appointment-img">
                    <?php echo getlazyload_img($image, '100', '100', 'wow zoomIn');  ?>
                </div>
            </div>
        </div>
    </section>
<?php
}
?>