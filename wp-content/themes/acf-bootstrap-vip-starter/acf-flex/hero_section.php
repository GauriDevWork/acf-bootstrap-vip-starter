<?php
$hero_type = get_sub_field('hero_type') ?: 'single';

$heading = get_sub_field('heading');
$content = get_sub_field('content');
$button  = get_sub_field('button');
$image   = get_sub_field('image');

$image_position = get_sub_field('image_position') ?: 'background';
$text_align     = get_sub_field('text_alignment') ?: 'left';
$bg             = get_sub_field('background_color') ?: 'light';
$spacing        = get_sub_field('section_padding');

$section_class = acf_vip_section_classes($bg, $spacing);
?>

<section class="<?php echo esc_attr($section_class); ?>">

    <?php if ($hero_type === 'slider' && have_rows('slider')): ?>

        <!-- ===================== -->
        <!-- SLIDER -->
        <!-- ===================== -->
        <div class="hero-wrapper is-slider">

            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">

                    <?php
                    $i = 0; 
                    while (have_rows('slider')): the_row(); 
                        $slide_image = get_sub_field('image');
                        $slide_heading = get_sub_field('heading');
                        $slide_content = get_sub_field('caption');
                        $slide_button  = get_sub_field('button');
                        $tag = ($i === 0) ? 'h1' : 'h2';
                    ?>

                        <div class="swiper-slide">

                            <!-- IMAGE -->
                            <?php acf_vip_image($slide_image, 'w-100'); ?>

                            <!-- CONTENT (INSIDE SLIDE) -->
                            <div class="hero-content d-flex align-items-center">
                                <div class="container <?php echo esc_attr(acf_vip_text_align($text_align)); ?>">

                                    <?php if ($slide_heading): ?>
                                        <<?php echo $tag; ?>><?php echo esc_html($slide_heading); ?></<?php echo $tag; ?>>
                                    <?php endif; ?>

                                    <?php if ($slide_content): ?>
                                        <p><?php echo esc_html($slide_content); ?></p>
                                    <?php endif; ?>

                                    <?php acf_vip_button($slide_button); ?>

                                </div>
                            </div>

                        </div>

                    <?php
                    $i++; 
                    endwhile; 
                    ?>

                </div>

                <!-- Controls -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>

        </div>

    <?php else: ?>

        <!-- ===================== -->
        <!-- SINGLE HERO -->
        <!-- ===================== -->

        <?php if ($image_position === 'background' && $image): ?>

            <!-- Background -->
            <div class="hero-wrapper is-static">

                <?php acf_vip_image($image, 'w-100'); ?>

                <div class="hero-content d-flex align-items-center">
                    <div class="container <?php echo esc_attr(acf_vip_text_align($text_align)); ?>">

                        <?php if ($heading): ?>
                            <h1><?php echo esc_html($heading); ?></h1>
                        <?php endif; ?>

                        <?php if ($content): ?>
                            <p><?php echo esc_html($content); ?></p>
                        <?php endif; ?>

                        <?php acf_vip_button($button); ?>

                    </div>
                </div>

            </div>

        <?php else: ?>

            <!-- LEFT / RIGHT -->
            <div class="container">
                <div class="row align-items-center">

                    <?php if ($image_position === 'left' && $image): ?>
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <?php acf_vip_image($image); ?>
                        </div>
                    <?php endif; ?>

                    <div class="col-lg-6 <?php echo esc_attr(acf_vip_text_align($text_align)); ?>">

                        <?php if ($heading): ?>
                            <h1><?php echo esc_html($heading); ?></h1>
                        <?php endif; ?>

                        <?php if ($content): ?>
                            <p><?php echo esc_html($content); ?></p>
                        <?php endif; ?>

                        <?php acf_vip_button($button); ?>

                    </div>

                    <?php if ($image_position === 'right' && $image): ?>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <?php acf_vip_image($image); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php endif; ?>

    <?php endif; ?>

</section>