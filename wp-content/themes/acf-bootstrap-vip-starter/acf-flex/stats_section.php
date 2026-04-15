<?php
/**
 * Stats Section
 */

$heading = get_sub_field('heading');
$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-stats text-center <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <?php if ($heading): ?>
            <h2 class="mb-5"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if (have_rows('stats')): ?>

            <div class="row">

                <?php while (have_rows('stats')): the_row(); 
                    $number = get_sub_field('number');
                    $suffix = get_sub_field('suffix');
                    $label  = get_sub_field('label');
                ?>

                    <div class="col-lg-3 col-md-6 mb-4">

                        <div class="stat-item">

                            <?php if ($number): ?>
                                <h3 class="stat-number" data-target="<?php echo esc_attr($number); ?>">
                                    
                                    <span class="count">0</span>

                                    <?php if ($suffix): ?>
                                        <span class="suffix"><?php echo esc_html($suffix); ?></span>
                                    <?php endif; ?>

                                </h3>
                            <?php endif; ?>

                            <?php if ($label): ?>
                                <p class="stat-label"><?php echo esc_html($label); ?></p>
                            <?php endif; ?>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php endif; ?>

    </div>

</section>