<?php
/**
 * Pricing Section
 */

$heading = get_sub_field('heading');
$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-pricing <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <?php if ($heading): ?>
            <h2 class="text-center mb-5"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if (have_rows('plans')): ?>
            <div class="row">

                <?php while (have_rows('plans')): the_row();

                    $title = get_sub_field('title');
                    $price = get_sub_field('price');
                    $duration = get_sub_field('duration');
                    $features = get_sub_field('features');
                    $button = get_sub_field('button');
                    $highlighted = get_sub_field('highlighted');
                ?>

                    <div class="col-lg-4 mb-4">

                        <div class="pricing-card <?php echo $highlighted ? 'highlighted' : ''; ?>">

                            <h5><?php echo esc_html($title); ?></h5>

                            <h3 class="price">
                                <?php echo esc_html($price); ?>
                                <?php if ($duration): ?>
                                    <span><?php echo esc_html($duration); ?></span>
                                <?php endif; ?>
                            </h3>

                            <?php if ($features): ?>
                                <div class="features">
                                    <?php echo nl2br($features); ?>
                                </div>
                            <?php endif; ?>

                            <?php acf_vip_button($button); ?>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>
        <?php endif; ?>

    </div>

</section>