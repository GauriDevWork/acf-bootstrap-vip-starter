<?php
/**
 * Two Column Section
 */

$left_heading  = get_sub_field('left_heading');
$left_content  = get_sub_field('left_content');

$right_heading = get_sub_field('right_heading');
$right_content = get_sub_field('right_content');

$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-two-column <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <div class="row">

            <!-- LEFT -->
            <div class="col-lg-6 mb-4 mb-lg-0">

                <?php if ($left_heading): ?>
                    <h3><?php echo esc_html($left_heading); ?></h3>
                <?php endif; ?>

                <?php if ($left_content): ?>
                    <div class="content-editor">
                        <?php echo wp_kses_post($left_content); ?>
                    </div>
                <?php endif; ?>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-6">

                <?php if ($right_heading): ?>
                    <h3><?php echo esc_html($right_heading); ?></h3>
                <?php endif; ?>

                <?php if ($right_content): ?>
                    <div class="content-editor">
                        <?php echo wp_kses_post($right_content); ?>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>

</section>