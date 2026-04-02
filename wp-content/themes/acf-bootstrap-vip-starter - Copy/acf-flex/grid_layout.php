<?php
$heading = get_sub_field('heading');
$columns = get_sub_field('columns') ?: 3;

$settings = acf_vip_section_settings();

// Safe column calculation
$col_map = [
    2 => 'col-lg-6',
    3 => 'col-lg-4',
    4 => 'col-lg-3'
];

$col_class = $col_map[$columns] ?? 'col-lg-4';
?>

<section <?php echo $settings['id']; ?> class="section-grid <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <?php if ($heading): ?>
            <h2 class="text-center mb-5">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if (have_rows('items')): ?>
            <div class="row">

                <?php while (have_rows('items')): the_row(); 
                    $icon  = get_sub_field('icon');
                    $title = get_sub_field('title');
                    $text  = get_sub_field('content');
                    $link  = get_sub_field('button');
                ?>

                    <div class="<?php echo esc_attr($col_class); ?> col-md-6 mb-4">

                        <div class="grid-card h-100 text-center">

                            <?php if ($icon): ?>
                                <div class="grid-icon">
                                    <?php acf_vip_image($icon, 'img-fluid'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($title): ?>
                                <h3 class="grid-title">
                                    <?php echo esc_html($title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($text): ?>
                                <p class="grid-text">
                                    <?php echo $text; ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($link): ?>
                                <?php acf_vip_button($link, 'btn btn-outline-primary mt-2'); ?>
                            <?php endif; ?>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>
        <?php endif; ?>

    </div>

</section>