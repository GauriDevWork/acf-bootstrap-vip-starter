<?php
/**
 * Steps Section
 */
// Get unique section ID for this layout instance
$section_id = acf_vip_layout_section_id();

// Output scoped custom CSS/JS BEFORE the section HTML
acf_vip_output_layout_custom_code( $section_id );

$heading = get_sub_field('heading');
$settings = acf_vip_section_settings();
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="section-steps <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <?php if ($heading): ?>
            <h2 class="text-center mb-5">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if (have_rows('steps')): ?>

            <div class="row text-center">

                <?php $i = 1; while (have_rows('steps')): the_row(); 
                    $title = get_sub_field('title');
                    $content = get_sub_field('content');
                ?>

                    <div class="col-lg-4 mb-4">

                        <div class="step-item">

                            <div class="step-number mb-3">
                                <?php echo $i; ?>
                            </div>

                            <?php if ($title): ?>
                                <h5><?php echo esc_html($title); ?></h5>
                            <?php endif; ?>

                            <?php if ($content): ?>
                                <p><?php echo $content; ?></p>
                            <?php endif; ?>

                        </div>

                    </div>

                <?php $i++; endwhile; ?>

            </div>

        <?php endif; ?>

    </div>

</section>