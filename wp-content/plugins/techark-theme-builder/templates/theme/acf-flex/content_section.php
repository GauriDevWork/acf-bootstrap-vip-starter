<?php
/**
 * Content Section
 */
// Get unique section ID for this layout instance
$section_id = acf_vip_layout_section_id();

// Output scoped custom CSS/JS BEFORE the section HTML
acf_vip_output_layout_custom_code( $section_id );

$heading = get_sub_field( 'heading' );
$content = get_sub_field( 'content' );

$settings = acf_vip_section_settings();
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="section-content <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

	<div class="<?php echo $settings['container']; ?>">

		<div class="row justify-content-center">
			<div class="col-lg-8">

				<?php if ( $heading ): ?>
					<h2 class="mb-4 text-center">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $content ): ?>
					<div class="content-editor">
						<?php echo wp_kses_post( $content ); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>

	</div>

</section>