<?php
/**
 * Custom Layout
 *
 * Developer/designer use only. Outputs raw HTML, CSS, and JS
 * directly — with CSS scoped to the section ID and JS wrapped
 * in an IIFE to prevent variable leakage.
 *
 * Security:
 * - HTML output via wp_kses_post (allows safe tags, strips scripts)
 * - CSS sanitized via wp_strip_all_tags
 * - JS sanitized via wp_strip_all_tags
 * - Layout only visible to manage_options users in WP Admin
 *   (enforced via ACF conditional logic on the field group)
 *
 * @since Phase 2 — Sprint 2 Day 2
 */

// Get unique section ID for this layout instance
$section_id = acf_vip_layout_section_id();

// Output scoped CSS and JS from the shared helper
acf_vip_output_layout_custom_code( $section_id );

// Get the raw HTML field
$custom_html = get_sub_field( 'custom_html' );

// Allowed HTML tags — wp_kses_post covers all safe post content tags
// strips <script>, <iframe>, <style> but allows structural and semantic HTML
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
