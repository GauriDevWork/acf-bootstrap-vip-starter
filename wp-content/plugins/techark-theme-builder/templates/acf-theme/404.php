<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package {{THEME_PACKAGE}}
 */

get_header();

$options = get_option('{{THEME_PREFIX}}options');

$banner_enable = !empty($options['banner_enable']) ? $options['banner_enable'] : false;

$banner_bg_type =  $options['banner_bg_type'];

$banner_bg_color = !empty($options['page_banner_color']) ? $options['page_banner_color'] : '#E6F5FF';

$banner_bg_image_data = !empty($options['page_banner_image']) ? $options['page_banner_image'] : array();

$banner_bg_image_color    = !empty($banner_bg_image_data['background-color']) ? $banner_bg_image_data['background-color'] : '#E6F5FF';
$banner_bg_image    = !empty($banner_bg_image_data['background-image']) ? $banner_bg_image_data['background-image'] : '';
$banner_bg_repeat   = !empty($banner_bg_image_data['background-repeat']) ? $banner_bg_image_data['background-repeat'] : 'no-repeat';
$banner_bg_size     = !empty($banner_bg_image_data['background-size']) ? $banner_bg_image_data['background-size'] : 'cover';
$banner_bg_position = !empty($banner_bg_image_data['background-position']) ? $banner_bg_image_data['background-position'] : 'center center';
$banner_bg_attach   = !empty($banner_bg_image_data['background-attachment']) ? $banner_bg_image_data['background-attachment'] : 'scroll';

$banner_title_align = !empty($options['banner_title_align']) ? $options['banner_title_align'] : 'left';

$banner_padding_top    = !empty($options['banner_padding']['width']) ? (int) $options['banner_padding']['width'] : 260;
$banner_padding_bottom = !empty($options['banner_padding']['height']) ? (int) $options['banner_padding']['height'] : 150;

$banner_style = '';

if ($banner_bg_type) {
	if (!empty($banner_bg_image)) {
		$banner_style  = "background-image:url('{$banner_bg_image}');";
		$banner_style .= "background-repeat:{$banner_bg_repeat};";
		$banner_style .= "background-size:{$banner_bg_size};";
		$banner_style .= "background-position:{$banner_bg_position};";
		$banner_style .= "background-attachment:{$banner_bg_attach};";
		$banner_style .= "background-color:{$banner_bg_image_color};";
	} else {
		$banner_style .= "background-color:{$banner_bg_image_color};";
	}
} else {
	$banner_style .= "background-color:{$banner_bg_color};";
}

$banner_style .= "padding-top:{$banner_padding_top}px;";
$banner_style .= "padding-bottom:{$banner_padding_bottom}px;";

$heading      = !empty($options['heading']) ? $options['heading'] : '404';
$sub_heading  = !empty($options['sub_heading']) ? $options['sub_heading'] : 'Page not found';
$page_content = !empty($options['page_content']) ? $options['page_content'] : '';
$btn_text     = !empty($options['btn_text']) ? $options['btn_text'] : 'Go Home';
$btn_url      = !empty($options['btn_url']) ? $options['btn_url'] : home_url('/');
$btn_target   = !empty($options['btn_target']) ? $options['btn_target'] : '_self';

?>
<main id="main-content" class="site-main">
	<?php
	if ($banner_enable) :
	?>
		<section class="{{THEME_PREFIX}}-banner my-75" style="<?php echo esc_attr($banner_style); ?>">
			<div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
				<?php if (!empty($heading)) : ?>
					<h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
						<?php
						echo esc_html($heading);
						?>
					</h1>
				<?php endif; ?>
			</div>
		</section>
	<?php
	endif;
	?>
	<section class="error-404 not-found py-75">
		<div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
			<?php
			if (!$banner_enable && !empty($heading)) :
			?>
				<h1 class="h1" style="text-align:<?php echo esc_attr($banner_title_align); ?>;">
					<?php
					echo esc_html($heading);
					?>
				</h1>
			<?php
			endif;

			if (!empty($sub_heading)) :
			?>
				<h3 class="h2 wow fadeInUp">
					<?php
					echo esc_html($sub_heading);
					?>
				</h3>
			<?php
			endif;
			if (!empty($page_content)) :
			?>
				<p>
					<?php
					echo wp_kses_post($page_content);
					?>
				</p>
			<?php
			endif;
			if (!empty($btn_text)) :
			?>
				<a href="<?php echo esc_url($btn_url); ?>" target="<?php echo esc_attr($btn_target); ?>" class="{{THEME_PREFIX}}-btn wow fadeInUp">
					<?php echo esc_html($btn_text); ?>
				</a>
			<?php
			endif;
			?>
		</div>
	</section>
</main>
<?php
get_footer();
