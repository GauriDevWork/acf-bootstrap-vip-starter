<?php
/**
 * Global styles — reads Theme Options and outputs CSS variables to <head>
 * Also outputs global custom CSS and JS from the Custom Code tab.
 *
 * All values read from the 'theme-options' options page.
 * Uses get_field( 'field_name', 'option' ) — the 'option' parameter
 * is required for options page fields.
 *
 * @since Phase 2 — Sprint 3
 */

add_action( 'wp_head', 'acf_vip_global_styles' );

function acf_vip_global_styles() {

	// Colors
	$primary_color    = get_field( 'primary_color', 'option' ) ?: '#0d6efd';
	$secondary_color  = get_field( 'secondary_color', 'option' ) ?: '#6c757d';
	$text_color       = get_field( 'text_color', 'option' ) ?: '#212529';
	$bg_color         = get_field( 'background_color', 'option' ) ?: '#ffffff';

	// Typography
	$heading_font   = get_field( 'heading_font', 'option' );
	$body_font      = get_field( 'body_font', 'option' );
	$base_font_size = get_field( 'base_font_size', 'option' ) ?: 16;
	$heading_weight = get_field( 'heading_weight', 'option' ) ?: '700';
	$h1             = get_field( 'h1_font_size', 'option' ) ?: 48;
	$h2             = get_field( 'h2_font_size', 'option' ) ?: 36;
	$h3             = get_field( 'h3_font_size', 'option' ) ?: 28;
	$h4             = get_field( 'h4_font_size', 'option' ) ?: 22;
	$h5             = get_field( 'h5_font_size', 'option' ) ?: 18;
	$h6             = get_field( 'h6_font_size', 'option' ) ?: 16;

	// Buttons
	$btn_bg         = get_field( 'button_bg', 'option' ) ?: '#0d6efd';
	$btn_text_color = get_field( 'button_text_color', 'option' ) ?: '#ffffff';
	$btn_radius     = get_field( 'button_radius', 'option' ) ?: 6;
	$btn_padding    = get_field( 'button_padding', 'option' ) ?: '10px 24px';

	// Header
	$header_bg     = get_field( 'header_bg', 'option' ) ?: '#ffffff';
	$sticky_header = get_field( 'sticky_header', 'option' );

	// Footer
	$footer_bg         = get_field( 'footer_bg', 'option' ) ?: '#1a1a1a';
	$footer_text_color = get_field( 'footer_text_color', 'option' ) ?: '#ffffff';

	// Google Fonts — enqueue if set
	if ( $heading_font || $body_font ) {
		$fonts   = array_filter( array( $heading_font, $body_font ) );
		$fonts   = array_unique( $fonts );
		$font_q  = implode( '&family=', array_map( function( $f ) {
			return urlencode( $f ) . ':wght@400;500;600;700';
		}, $fonts ) );
		$font_url = 'https://fonts.googleapis.com/css2?family=' . $font_q . '&display=swap';
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
		echo '<link rel="stylesheet" href="' . esc_url( $font_url ) . '">';
	}
	?>
	<style id="acf-vip-global-styles">
		:root {
			--primary:          <?php echo esc_attr( $primary_color ); ?>;
			--secondary:        <?php echo esc_attr( $secondary_color ); ?>;
			--text-color:       <?php echo esc_attr( $text_color ); ?>;
			--bg-color:         <?php echo esc_attr( $bg_color ); ?>;

			--btn-bg:           <?php echo esc_attr( $btn_bg ); ?>;
			--btn-text:         <?php echo esc_attr( $btn_text_color ); ?>;
			--btn-radius:       <?php echo esc_attr( $btn_radius ); ?>px;
			--btn-padding:      <?php echo esc_attr( $btn_padding ); ?>;

			--base-font-size:   <?php echo esc_attr( $base_font_size ); ?>px;
			--heading-weight:   <?php echo esc_attr( $heading_weight ); ?>;
			<?php if ( $heading_font ) : ?>
			--heading-font:     '<?php echo esc_attr( $heading_font ); ?>', sans-serif;
			<?php endif; ?>
			<?php if ( $body_font ) : ?>
			--body-font:        '<?php echo esc_attr( $body_font ); ?>', sans-serif;
			<?php endif; ?>

			--header-bg:        <?php echo esc_attr( $header_bg ); ?>;
			--footer-bg:        <?php echo esc_attr( $footer_bg ); ?>;
			--footer-text:      <?php echo esc_attr( $footer_text_color ); ?>;
		}

		body {
			color: var(--text-color);
			background-color: var(--bg-color);
			font-size: var(--base-font-size);
			<?php if ( $body_font ) : ?>font-family: var(--body-font);<?php endif; ?>
		}

		h1, h2, h3, h4, h5, h6 {
			font-weight: var(--heading-weight);
			<?php if ( $heading_font ) : ?>font-family: var(--heading-font);<?php endif; ?>
		}

		h1 { font-size: <?php echo esc_attr( $h1 ); ?>px; }
		h2 { font-size: <?php echo esc_attr( $h2 ); ?>px; }
		h3 { font-size: <?php echo esc_attr( $h3 ); ?>px; }
		h4 { font-size: <?php echo esc_attr( $h4 ); ?>px; }
		h5 { font-size: <?php echo esc_attr( $h5 ); ?>px; }
		h6 { font-size: <?php echo esc_attr( $h6 ); ?>px; }

		a { color: var(--primary); }

		.btn {
			background: var(--btn-bg);
			color: var(--btn-text);
			border-radius: var(--btn-radius);
			padding: var(--btn-padding);
		}
		.btn:hover { background: var(--secondary); color: var(--btn-text); }

		<?php if ( $sticky_header ) : ?>
		.site-header { position: sticky; top: 0; z-index: 1030; }
		<?php endif; ?>
	</style>
	<?php

	// Global Custom CSS from Custom Code tab
	$global_css = get_field( 'global_custom_css', 'option' );
	if ( ! empty( $global_css ) ) {
		echo '<style id="acf-vip-custom-css">';
		echo wp_strip_all_tags( $global_css );
		echo '</style>';
	}
}

// Global Custom JS — output before </body>
add_action( 'wp_footer', 'acf_vip_global_custom_js' );

function acf_vip_global_custom_js() {
	$global_js = get_field( 'global_custom_js', 'option' );
	if ( ! empty( $global_js ) ) {
		echo '<script id="acf-vip-custom-js">';
		echo '(function(){';
		echo wp_strip_all_tags( $global_js );
		echo '})();';
		echo '</script>';
	}
}
