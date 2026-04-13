<?php
/**
 * Icon List Section (Final)
 */

$heading = get_sub_field('heading');
$style   = get_sub_field('layout_style') ?: 'vertical';
$icon_style = get_sub_field('icon_style') ?: 'plain';

$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-icon-list <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <?php if ($heading): ?>
            <h2 class="mb-5 text-center"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if (have_rows('items')): ?>

            <!-- ========================= -->
            <!-- HORIZONTAL (GRID STYLE) -->
            <!-- ========================= -->
            <?php if ($style === 'horizontal'): ?>

                <div class="row">

                    <?php while (have_rows('items')): the_row(); 
                        $icon = get_sub_field('icon');
                        $title = get_sub_field('title');
                        $content = get_sub_field('content');
                    ?>

                        <div class="col-lg-6 mb-4">

                            <div class="icon-list-item d-flex <?php echo esc_attr($icon_style); ?>">

                                <?php if ($icon): ?>
                                    <div class="icon">
                                        <?php acf_vip_image($icon, 'img-fluid'); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="icon-content">

                                    <?php if ($title): ?>
                                        <h5><?php echo esc_html($title); ?></h5>
                                    <?php endif; ?>

                                    <?php if ($content): ?>
                                        <p><?php echo $content; ?></p>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

            <!-- ========================= -->
            <!-- VERTICAL (LIST STYLE) -->
            <!-- ========================= -->
            <?php else: ?>

                <div class="icon-list-vertical">

                    <?php while (have_rows('items')): the_row(); 
                        $icon = get_sub_field('icon');
                        $title = get_sub_field('title');
                        $content = get_sub_field('content');
                    ?>

                        <div class="icon-list-item d-flex <?php echo esc_attr($icon_style); ?>">

                            <?php if ($icon): ?>
                                <div class="icon">
                                    <?php acf_vip_image($icon, 'img-fluid'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="icon-content">

                                <?php if ($title): ?>
                                    <h5><?php echo esc_html($title); ?></h5>
                                <?php endif; ?>

                                <?php if ($content): ?>
                                    <p><?php echo $content; ?></p>
                                <?php endif; ?>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</section>