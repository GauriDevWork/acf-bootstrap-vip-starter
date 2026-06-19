<?php
/**
 * CTA Section Layout
 */
// Get unique section ID for this layout instance
$section_id = acf_vip_layout_section_id();

// Output scoped custom CSS/JS BEFORE the section HTML
acf_vip_output_layout_custom_code( $section_id );

$heading = get_sub_field('heading');
$content = get_sub_field('content');
$button  = get_sub_field('button');

$bg      = get_sub_field('background_color') ?: 'light';
$align   = get_sub_field('alignment') ?: 'center';
$spacing = get_sub_field('section_padding');

$bg_image = get_sub_field('background_image');

// Helpers
$section_class = acf_vip_section_classes($bg, $spacing);
$text_class    = acf_vip_text_align($align);

// Inline style only if image exists
$style = '';
if (!empty($bg_image)) {
    $style = "background-image: url('" . esc_url($bg_image['url']) . "'); background-size: cover; background-position: center;";
}
?>

<section id="<?php echo esc_attr( $section_id ); ?>"
    class="section-cta <?php echo esc_attr($section_class); ?>"
    <?php if ($style): ?>
        style="<?php echo esc_attr($style); ?>"
    <?php endif; ?>
>

    <?php if ($bg_image): ?>
        <div class="cta-overlay"></div>
    <?php endif; ?>

    <div class="container <?php echo esc_attr($text_class); ?> position-relative">

        <?php if ($heading): ?>
            <h2 class="cta-title">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if ($content): ?>
            <p class="cta-text">
                <?php echo esc_html($content); ?>
            </p>
        <?php endif; ?>

        <?php acf_vip_button($button); ?>

    </div>

</section>