<?php
/**
 * Spacer Section
 */

$height = get_sub_field( 'height' ) ?: 50;
$show_line = get_sub_field( 'show_line' );

$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-spacer <?php echo $settings['class']; ?>">

    <div style="height: <?php echo esc_attr( $height ); ?>px;"></div>

    <?php if ($show_line): ?>
        <hr class="spacer-line">
    <?php endif; ?>

</section>