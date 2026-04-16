<?php
/**
 * Form Section
 */

$heading = get_sub_field('heading');
$shortcode = get_sub_field('shortcode');

$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-form <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <div class="row justify-content-center">
            <div class="col-lg-6">

                <?php if ($heading): ?>
                    <h2 class="text-center mb-4"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>

                <?php if ($shortcode): ?>
                    <div class="form-wrapper">
                        <?php echo do_shortcode($shortcode); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

</section>