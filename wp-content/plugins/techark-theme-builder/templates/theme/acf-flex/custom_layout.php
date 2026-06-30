<?php
/**
 * Custom Layout
 *
 * Developer/designer use only.
 * - HTML via wp_kses_post
 * - CSS scoped to section ID
 * - JS wrapped in IIFE
 * - Optional CSS/JS files from assets/ folder, enqueued on frontend
 *
 * @since Phase 2 — Day 2 (file manager added Day 7)
 */

$section_id = acf_vip_layout_section_id();
acf_vip_output_layout_custom_code( $section_id );

$custom_html = get_sub_field( 'custom_html' );
$allowed_html = wp_kses_allowed_html( 'post' );
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="section-custom-layout py-5">

	<div class="container">

		<?php if ( ! empty( $custom_html ) ) : ?>

			<?php echo wp_kses( $custom_html, $allowed_html ); ?>

		<?php else : ?>

			<?php if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) : ?>
				<div class="alert alert-warning" role="alert">
					<strong>Custom Layout:</strong> No HTML content added yet. Edit this page and add HTML in the Custom Layout block.
				</div>
			<?php endif; ?>

		<?php endif; ?>

	</div>

</section>
