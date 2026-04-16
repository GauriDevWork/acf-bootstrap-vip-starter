<?php
/**
 * Content + Image Section
 */

$heading = get_sub_field( 'heading' );
$content = get_sub_field( 'content' );
$button  = get_sub_field( 'button' );
$image   = get_sub_field( 'image' );

$image_position = get_sub_field( 'image_position' ) ?: 'right';

$bg      = get_sub_field( 'background_color' ) ?: 'light';
$align   = get_sub_field( 'text_alignment' ) ?: 'left';
$spacing = get_sub_field( 'section_padding' );

// Helpers
$section_class = acf_vip_section_classes( $bg, $spacing );
$text_class    = acf_vip_text_align( $align );
?>

<section class="section-content-image <?php echo esc_attr( $section_class ); ?>">

	<div class="container">

		<div class="row align-items-center">

			<?php if ( $image && $image_position === 'left' ): ?>
				<div class="col-lg-6 mb-4 mb-lg-0">
					<?php acf_vip_image( $image ); ?>
				</div>
			<?php endif; ?>

			<div class="col-lg-6 <?php echo esc_attr( $text_class ); ?>">

				<?php if ( $heading ): ?>
					<h2 class="section-title">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $content ): ?>
						<?php echo $content; ?>
				<?php endif; ?>

				<?php acf_vip_button( $button ); ?>

			</div>

			<?php if ($image && $image_position === 'right'): ?>
				<div class="col-lg-6 mt-4 mt-lg-0">
					<?php acf_vip_image( $image ); ?>
				</div>
			<?php endif; ?>

		</div>

	</div>

</section>