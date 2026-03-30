<?php
/**
 * Hero Section Layout
 */

// Core Fields
$hero_type = get_sub_field('hero_type') ?: 'single';

$heading = get_sub_field('heading');
$content = get_sub_field('content');
$button  = get_sub_field('button');
$image   = get_sub_field('image');

$image_position = get_sub_field('image_position') ?: 'right';
$text_align     = get_sub_field('text_alignment') ?: 'left';
$bg             = get_sub_field('background_color') ?: 'light';
$spacing        = get_sub_field('section_padding');

// Classes
$section_class = 'section-hero';
$section_class .= ($bg === 'dark') ? ' bg-dark text-white' : ' bg-light';
$section_class .= ($spacing) ? ' py-5' : '';
?>

<section class="<?php echo esc_attr($section_class); ?>">

    <?php if ($hero_type === 'slider' && have_rows('slider')): ?>

        <!-- ===================== -->
        <!-- HERO SWIPER SLIDER -->
        <!-- ===================== -->

        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">

                <?php while (have_rows('slider')): the_row(); 
                    $slide_image = get_sub_field('image');
                ?>

                    <div class="swiper-slide">

                        <div class="hero-slide position-relative">

                            <?php if ($slide_image): ?>
                                <img 
                                    src="<?php echo esc_url($slide_image['url']); ?>" 
                                    alt="<?php echo esc_attr($slide_image['alt']); ?>"
                                    class="w-100"
                                    loading="lazy"
                                >
                            <?php endif; ?>

                            <div class="hero-content d-flex align-items-center h-100">

                                <div class="container text-<?php echo esc_attr($text_align); ?>">

                                    <?php if ($heading): ?>
                                        <h1><?php echo esc_html($heading); ?></h1>
                                    <?php endif; ?>

                                    <?php if ($content): ?>
                                        <p><?php echo esc_html($content); ?></p>
                                    <?php endif; ?>

                                    <?php if ($button): ?>
                                        <a 
                                            href="<?php echo esc_url($button['url']); ?>" 
                                            class="btn btn-primary"
                                            aria-label="<?php echo esc_attr($button['title']); ?>"
                                        >
                                            <?php echo esc_html($button['title']); ?>
                                        </a>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Navigation -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

    <?php else: ?>

        <!-- ===================== -->
        <!-- SINGLE HERO -->
        <!-- ===================== -->

        <?php if ($image_position === 'background' && $image): ?>

            <!-- Background Hero -->
            <div 
                class="hero-bg d-flex align-items-center <?php echo ($text_align === 'center') ? 'justify-content-center text-center' : 'justify-content-start text-start'; ?>"
                style="min-height: 60vh; background-image: url('<?php echo esc_url($image['url']); ?>'); background-size: cover; background-position: center;"
            >

                <div class="container">
                    <div class="col-lg-8">

                        <?php if ($heading): ?>
                            <h1><?php echo esc_html($heading); ?></h1>
                        <?php endif; ?>

                        <?php if ($content): ?>
                            <p><?php echo esc_html($content); ?></p>
                        <?php endif; ?>

                        <?php if ($button): ?>
                            <a 
                                href="<?php echo esc_url($button['url']); ?>" 
                                class="btn btn-primary"
                                aria-label="<?php echo esc_attr($button['title']); ?>"
                            >
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        <?php else: ?>

            <!-- Left / Right Layout -->
            <div class="container">
                <div class="row align-items-center">

                    <?php if ($image_position === 'left' && $image): ?>
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <img 
                                src="<?php echo esc_url($image['url']); ?>" 
                                alt="<?php echo esc_attr($image['alt']); ?>"
                                class="img-fluid"
                                loading="lazy"
                            >
                        </div>
                    <?php endif; ?>

                    <div class="col-lg-6 text-<?php echo esc_attr($text_align); ?>">

                        <?php if ($heading): ?>
                            <h1><?php echo esc_html($heading); ?></h1>
                        <?php endif; ?>

                        <?php if ($content): ?>
                            <p><?php echo esc_html($content); ?></p>
                        <?php endif; ?>

                        <?php if ($button): ?>
                            <a 
                                href="<?php echo esc_url($button['url']); ?>" 
                                class="btn btn-primary"
                                aria-label="<?php echo esc_attr($button['title']); ?>"
                            >
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        <?php endif; ?>

                    </div>

                    <?php if ($image_position === 'right' && $image): ?>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <img 
                                src="<?php echo esc_url($image['url']); ?>" 
                                alt="<?php echo esc_attr($image['alt']); ?>"
                                class="img-fluid"
                                loading="lazy"
                            >
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php endif; ?>

    <?php endif; ?>

</section>