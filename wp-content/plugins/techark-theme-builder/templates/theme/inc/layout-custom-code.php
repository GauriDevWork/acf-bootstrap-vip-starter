<?php
/**
 * Per-layout custom CSS/JS output — scoped to #section-{index}
 *
 * Call this at the TOP of every acf-flex layout file, BEFORE the section HTML.
 * It reads the custom_css and custom_js sub-fields from the current row
 * and outputs them scoped to the section's unique ID.
 *
 * Usage inside any layout file:
 *   $section_id = acf_vip_layout_section_id();
 *   acf_vip_output_layout_custom_code( $section_id );
 *
 * @since Phase 2 — Sprint 2
 */

/**
 * Returns the unique section ID for the current layout row.
 * Uses the global section index set in page.php.
 *
 * @return string  e.g. "section-0", "section-1"
 */
function acf_vip_layout_section_id() {
	$index = isset( $GLOBALS['acf_vip_section_index'] )
		? (int) $GLOBALS['acf_vip_section_index']
		: 0;

	return 'section-' . $index;
}

/**
 * Outputs scoped <style> and <script> blocks for a layout section.
 * CSS is automatically prefixed with #section-{index} so styles
 * cannot leak into other sections.
 *
 * @param string $section_id  The section ID, e.g. "section-0"
 */
function acf_vip_output_layout_custom_code( $section_id ) {

	// Only admins can save these fields — but output is safe for all visitors.
	$custom_css = get_sub_field( 'layout_custom_css' );
	$custom_js  = get_sub_field( 'layout_custom_js' );

	// Output scoped CSS
	if ( ! empty( $custom_css ) ) {
		$css = wp_strip_all_tags( $custom_css );

		// Scope every rule to this section's ID.
		// Wraps the raw CSS in a #section-N { } block so rules
		// cannot affect other sections — mirrors Gutenberg's block style scoping.
		echo '<style id="' . esc_attr( $section_id ) . '-css">';
		echo '#' . esc_attr( $section_id ) . ' {';
		echo $css; // already stripped of tags; CSS values are safe here
		echo '}';
		echo '</style>';
	}

	// Output inline JS
	if ( ! empty( $custom_js ) ) {
		$js = wp_strip_all_tags( $custom_js );

		echo '<script id="' . esc_attr( $section_id ) . '-js">';
		echo '(function(){'; // IIFE — prevents variable collisions between sections
		echo $js;
		echo '})();';
		echo '</script>';
	}
}
