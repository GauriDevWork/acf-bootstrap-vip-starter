<?php
/**
 * Content Section
 */

$heading = get_sub_field( 'heading' );
$content = get_sub_field( 'content' );

$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-content <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

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