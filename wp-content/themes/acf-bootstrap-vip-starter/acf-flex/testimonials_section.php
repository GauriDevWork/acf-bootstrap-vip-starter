<?php
/**
 * Testimonials Section (Flexible)
 */

$heading = get_sub_field('heading');
$layout  = get_sub_field('layout_type') ?: 'slider';

$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-testimonials <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <?php if ($heading): ?>
            <h2 class="text-center mb-5">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if (have_rows('testimonials')): ?>

            <!-- ===================== -->
            <!-- SLIDER -->
            <!-- ===================== -->
            <?php if ($layout === 'slider'): ?>

                <div class="swiper testimonials-swiper">
                    <div class="swiper-wrapper">

                        <?php while (have_rows('testimonials')): the_row(); ?>
                            <div class="swiper-slide">
                                <?php get_template_part('acf-flex/partials/testimonial-card'); ?>
                            </div>
                        <?php endwhile; ?>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            <!-- ===================== -->
            <!-- CENTERED SLIDER -->
            <!-- ===================== -->
            <?php elseif ($layout === 'centered'): ?>

                <div class="swiper testimonials-centered-swiper">
                    <div class="swiper-wrapper">

                        <?php while (have_rows('testimonials')): the_row(); ?>
                            <div class="swiper-slide">
                                <?php get_template_part('acf-flex/partials/testimonial-card'); ?>
                            </div>
                        <?php endwhile; ?>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            <!-- ===================== -->
            <!-- GRID -->
            <!-- ===================== -->
            <?php else: ?>

                <div class="row">

                    <?php while (have_rows('testimonials')): the_row(); ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <?php get_template_part('acf-flex/partials/testimonial-card'); ?>
                        </div>
                    <?php endwhile; ?>

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</section>