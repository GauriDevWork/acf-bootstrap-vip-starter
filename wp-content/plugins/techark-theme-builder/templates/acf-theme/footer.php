<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package {{THEME_PACKAGE}}
 */

$options = get_option('{{THEME_PREFIX}}options');

$placeholder_image_id = !empty($options['placeholder_image']['id']) ? (int) $options['placeholder_image']['id'] : 254;

$footer_logo_url = !empty($options['footer_logo_url']) ? $options['footer_logo_url'] : site_url();
$footer_logo_target = !empty($options['footer_logo_target']) ? $options['footer_logo_target'] : '_self';

$footer_fullwidth = $options['footer_fullwidth'] == 1 ? 'container-fluid' : esc_attr({{THEME_PREFIX}}get_container_class());

$footer_bg = !empty($options['footer_bg_image_and_color']) ? $options['footer_bg_image_and_color'] : array();

$footer_style = "";


if (!empty($footer_bg['background-image'])) {
	$footer_style .= "background-image: url('" . esc_url($footer_bg['background-image']) . "');";
	$footer_style .= !empty($footer_bg['background-repeat']) ? "background-repeat: " . esc_attr($footer_bg['background-repeat']) . ";" : "no-repeat";
	$footer_style .= !empty($footer_bg['background-size']) ? "background-size: " . esc_attr($footer_bg['background-size']) . ";" : "cover";
	$footer_style .= !empty($footer_bg['background-position']) ? "background-position: " . esc_attr($footer_bg['background-position']) . ";" : "center center";
	$footer_style .= !empty($footer_bg['background-attachment']) ? "background-attachment: " . esc_attr($footer_bg['background-attachment']) . ";" : "scroll";

	$footer_color = !empty($footer_bg['background-color']) ? $footer_bg['background-color'] : $options['default_banner_bg_color'];
	$footer_style = 'background-color: ' . esc_attr($footer_color) . ';';
} else {

	$footer_color = !empty($footer_bg['background-color']) ? $footer_bg['background-color'] : $options['default_banner_bg_color'];
	$footer_style = 'background-color: ' . esc_attr($footer_color) . ';';
}

?>
<footer class="{{THEME_PREFIX}}-footer mt-75" style="<?php echo esc_attr($footer_style); ?>">
	<div class="<?php echo $footer_fullwidth; ?>">
		<a href="<?php echo $footer_logo_url; ?>" target="<?php echo $footer_logo_target; ?>">
			<?php

			$footer_logo_id = !empty($options['footer_logo']['id']) ? (int) $options['footer_logo']['id'] : $placeholder_image_id;


			$alt = get_post_meta($footer_logo_id, '_wp_attachment_image_alt', true);
			$title = get_the_title($footer_logo_id);

			$image_data = array(
				'url' => $options['footer_logo']['url'],
				'alt' => $alt,
				'title' => $title,
			);

			echo getlazyload_img($image_data, '100', '100', 'logo');
			?>
		</a>
		<?php

		if (!empty($options['footer_widget'])) {

			$columns = !empty($options['footer_columns']) ? intval($options['footer_columns']) : 4;

			$default_layouts = array(
				1 => '',
				2 => '50-50',
				3 => '33-33-33',
				4 => '25-25-25-25',
			);

			$layout_option_key = "footer_columns_layout_{$columns}";
			$layout = !empty($options[$layout_option_key]) ? $options[$layout_option_key] : $default_layouts[$columns];

			$row_class = 'col' . $columns;
			if ($layout && $layout !== $default_layouts[$columns]) {
				$row_class .= '-' . $layout;
			}
			?>

			<div class="ft-top-row <?php echo esc_attr($row_class); ?>">
				<?php
				for ($i = 1; $i <= $columns; $i++):
					?>
					<div class="footer-col">
						<?php
						if (is_active_sidebar("footer-{$i}")):
							dynamic_sidebar("footer-{$i}");
						endif;
						?>
					</div>
					<?php
				endfor;
				?>
			</div>
			<?php
		}
		?>
		<div class="ft-bottom-row">
			<?php
			if ($options['footer_social']) {

				$social_buttons = !empty($options['social_buttons']) ? $options['social_buttons'] : array();

				if (!empty($social_buttons['social_icon'])) {

					$social_icon_options = array(
						'fb-link' => __('Facebook', '{{TEXT_DOMAIN}}'),
						'instagram-link' => __('Instagram', '{{TEXT_DOMAIN}}'),
						'yt-link' => __('YouTube', '{{TEXT_DOMAIN}}'),
						'linkedin-icon' => __('Linkedin', '{{TEXT_DOMAIN}}'),
						'whatsapp-icon' => __('Whatsapp', '{{TEXT_DOMAIN}}'),
						'twitter-icon' => __('Twitter', '{{TEXT_DOMAIN}}'),
						'tiktok-icon' => __('Tiktok', '{{TEXT_DOMAIN}}'),
					);

					?>
					<div class="follow-us">
						<p>Follow Us</p>
						<ul class="social-link">
							<?php

							foreach ($social_buttons['social_icon'] as $i => $icon_key) {
								$icon_title = isset($social_icon_options[$icon_key]) ? $social_icon_options[$icon_key] : $icon_key;
								$icon_url = !empty($social_buttons['social_url'][$i]) ? $social_buttons['social_url'][$i] : '';
								if ($icon_url) {
									?>
									<li>
										<a title="<?php echo $icon_title; ?>" href="<?php echo $icon_url; ?>" target="_blank" class="<?php echo esc_attr($icon_key); ?>"></a>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
					<?php

				}
			}

			if (!empty($options['copyright'])):
				?>
				<div class="copyright-text p">
					<?php
					echo do_shortcode($options['copyright']);
					?>
				</div>
				<?php
			endif;
			if (!empty($options['credit_line'])):
				?>
				<div class="design-txt p">
					<?php
					echo do_shortcode($options['credit_line']);
					?>
				</div>
				<?php
			endif;
			?>
		</div>
	</div>
	<?php
	if (!empty($options['back_to_top'])):
		?>
		<a href="javascript:void(0);" class="back-top" aria-label="back-to-top"><span class="icon-arrow"></span></a>
		<?php
	endif;
	?>
</footer>
</div>
<?php
wp_footer();

if ($options['custom_css_footer']) {
	?>
	<style type="text/css" id="dynamic-footer-css">
		<?php
		echo $options['custom_css_footer'];
		?>
	</style>
	<?php
}

if ($options['custom_js_footer']) {
	?>
	<script type="text/javascript" id="dynamic-footer-script">
		<?php
		echo $options['custom_js_footer'];
		?>
	</script>
	<?php
}
?>
</body>

</html>