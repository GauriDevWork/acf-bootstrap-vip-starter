<?php
/**
 * Spacer Section
 */
// Get unique section ID for this layout instance
$section_id = acf_vip_layout_section_id();

// Output scoped custom CSS/JS BEFORE the section HTML
acf_vip_output_layout_custom_code( $section_id );

$height = get_sub_field( 'height' ) ?: 50;
$show_line = get_sub_field( 'show_line' );

$settings = acf_vip_section_settings();
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="section-spacer <?php echo $settings['class']; ?>">

    <div style="height: <?php echo esc_attr( $height ); ?>px;"></div>

    <?php if ($show_line): ?>
        <hr class="spacer-line">
    <?php endif; ?>

</section>