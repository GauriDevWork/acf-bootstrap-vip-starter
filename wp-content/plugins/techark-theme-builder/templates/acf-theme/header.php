<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package {{THEME_PACKAGE}}
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php
	wp_head();


	$options = get_option('{{THEME_PREFIX}}options');

	$blog_page_id = get_option('page_for_posts');
	$current_page_id = get_the_ID();

	if (is_home() || is_archive() || is_category() || is_tag() || is_search()) {
		$page_id = $blog_page_id;
	} else {
		$page_id = $current_page_id;
	}

	$banner_enable = get_post_meta($page_id, 'banner_enable', true);

	$banner_bg_image_data = get_post_meta($page_id, 'page_banner_image', true);
	$banner_bg_image = !empty($banner_bg_image_data['background-image']) ? $banner_bg_image_data['background-image'] : '';

	if ($banner_enable) {
		if ($banner_bg_image) {
			?>
			<link rel="preload" as="image" href="<?php echo $banner_bg_image; ?>" fetchpriority="high">
			<?php
		}
	}

	$global_sections = get_field('global_sections', $page_id);

	if (!empty($global_sections)) {

		foreach ($global_sections as $section) {
			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'large_banner') {

				$background_image_url = !empty($section['background_image']) ? $section['background_image']['url'] : '';
				if ($background_image_url) {
					?>
					<link rel="preload" as="image" href="<?php echo $background_image_url; ?>" fetchpriority="high">
					<?php
				}
			}
		}
	}

	if ($options['custom_css_header']) {
		?>
		<style type="text/css" id="dynamic-header-css">
			<?php
			echo $options['custom_css_header'];
			?>
		</style>
		<?php
	}

	if ($options['google_analytics']) {
		?>
		<script type="text/javascript" id="ga-script">
			<?php
			echo $options['google_analytics'];
			?>
		</script>
		<?php
	}

	if ($options['custom_js_header']) {
		?>
		<script type="text/javascript" id="dynamic-header-script">
			<?php
			echo $options['custom_js_header'];
			?>
		</script>
		<?php
	}

	?>

</head>

<body <?php body_class(); ?>>
	<?php
	wp_body_open();


	$placeholder_image_id = !empty($options['placeholder_image']['id']) ? $options['placeholder_image']['id'] : 254;

	$header_logo_url = !empty($options['header_logo_url']) ? $options['header_logo_url'] : site_url();
	$header_logo_target = !empty($options['header_logo_target']) ? $options['header_logo_target'] : '_self';

	$header_layout = !empty($options['header_layout']) ? $options['header_layout'] : 'left-logo';

	$nav_dropdown_animation = $options['nav_dropdown_animation'];

	$header_fullwidth = $options['header_fullwidth'] == 1 ? 'container-fluid' : esc_attr({{THEME_PREFIX}}get_container_class());

	?>
	<div class="wrapper">
		<a class="skip-to-content" href="#skip-main-content">Skip to main content</a>
		<header class="header <?php echo $header_layout . ' ' . $nav_dropdown_animation; ?> ">
			<div class="back-overlay"></div>
			<?php
			if (!empty($options['topbar_enable'])) {
				?>
				<div class="top-bar">
					<div class="<?php echo $header_fullwidth;
					echo (!empty($options['topbar_text'])) ? " show-in-mobile " : " hide-in-mobile"; ?>">
						<?php
						if ($options['social_media']) {

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
								<ul class="social-link">
									<?php
									foreach ($social_buttons['social_icon'] as $i => $icon_key) {
										$icon_title = isset($social_icon_options[$icon_key]) ? $social_icon_options[$icon_key] : $icon_key;
										$icon_url = !empty($social_buttons['social_url'][$i]) ? $social_buttons['social_url'][$i] : '#';
										if ($icon_url) {
											?>
											<li>
												<a href="<?php echo $icon_url; ?>" target="_blank" class="<?php echo esc_attr($icon_key); ?>"><span class="d-none"><?php echo $icon_title; ?></span></a>
											</li>
											<?php
										}
									}
									?>
								</ul>
								<?php

							}
						}

						if (!empty($options['topbar_text'])) {
							echo "<p>" . do_shortcode($options['topbar_text']) . '</p>';
						}

						if (!empty($options['topbar_contact_info'])) {
							?>
							<div class="contact-info">
								<?php
								echo do_shortcode($options['topbar_contact_info']);
								?>
							</div>
							<?php
						}

						if ($options['google_translate']) {
							?>
							<div class="gTranslate-menu">
								<?php
								wp_nav_menu(
									array(
										'menu' => 'Gtranslate Menu',
										'theme_location' => 'gtranslate-menu',
										'menu_class' => 'gtranslate-menu',
										'menu_id' => 'menu-gtranslate-menu',
									)
								);
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
			?>
			<div class="header-main">
				<div class="<?php echo $header_fullwidth; ?>">
					<div class="logo-block">
						<?php
						if ($options['header_logo']) {
							?>
							<a href="<?php echo $header_logo_url; ?>" target="<?php echo $header_logo_target; ?>">
								<?php

								$logo_id = !empty($options['header_logo']['id']) ? $options['header_logo']['id'] : $placeholder_image_id;

								$alt = get_post_meta($logo_id, '_wp_attachment_image_alt', true);
								$title = get_the_title($logo_id);
								$retina_logo_url = !empty($options['retina_logo']['url']) ? $options['retina_logo']['url'] : $options['header_logo']['url'];
								?>
								<img src="<?php echo $options['header_logo']['url']; ?>" srcset="<?php echo $retina_logo_url; ?> 2x" width="100" height="100" alt="<?php echo $alt; ?>-alt" title="<?php echo $title; ?>">
							</a>
							<?php
						}
						?>
					</div>
					<?php
					if ($options['google_translate']) {
						?>
						<div class="responsive-lang" tabindex="-1">
							<?php
							wp_nav_menu(
								array(
									'menu' => 'Gtranslate Menu',
									'theme_location' => 'gtranslate-menu',
									'menu_class' => 'gtranslate-menu',
									'menu_id' => 'menu-gtranslate-menu-responsive',
								)
							);
							?>
						</div>
						<?php
					}
					?>
					<nav class="navbar ta-navigation-menu">
						<button class="navbar-toggler" type="button" data-bs-target="#collapsibleNavbar">
							<span class="navbar-toggler-icon"></span>
							<b class="fs-0 d-none ">Menu</b>
						</button>
						<div class="collapse navbar-collapse" id="collapsibleNavbar">
							<div class="mobile-header">
								<?php
								if ($options['header_logo']) {
									?>
									<a href="<?php echo site_url(); ?>">
										<?php

										$logo_id = !empty($options['header_logo']['id']) ? $options['header_logo']['id'] : $placeholder_image_id;

										$alt = get_post_meta($logo_id, '_wp_attachment_image_alt', true);
										$title = get_the_title($logo_id);
										$retina_logo_url = !empty($options['retina_logo']['url']) ? $options['retina_logo']['url'] : $options['header_logo']['url'];
										?>
										<img src="<?php echo $options['header_logo']['url']; ?>" srcset="<?php echo $retina_logo_url; ?> 2x" width="100" height="100" alt="<?php echo $alt; ?> Mobile" title="<?php echo $title; ?>" class="logo">
									</a>
									<?php
								}
								?>
								<a href="javascript:void(0);" class="ta-close-icon" aria-label="Close">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</a>
							</div>
							<?php

							$menu_locations = get_nav_menu_locations();
							$primary_menu_id = $menu_locations['menu-1'];
							$header_menu = !empty($options['header_menu']) ? $options['header_menu'] : $primary_menu_id;

							$args = array(
								'menu' => $header_menu,
								'menu_class' => 'main-menu',
								'container' => ''
							);

							wp_nav_menu($args);
							if (!empty($options['{{THEME_PREFIX}}buttons']['text']) && is_array($options['{{THEME_PREFIX}}buttons']['text'])):
								?>
								<div class="btn-block">
									<?php

									foreach ($options['{{THEME_PREFIX}}buttons']['text'] as $i => $text) {
										$url = !empty($options['{{THEME_PREFIX}}buttons']['url'][$i]) ? $options['{{THEME_PREFIX}}buttons']['url'][$i] : '#';
										$target = !empty($options['{{THEME_PREFIX}}buttons']['target'][$i]) ? $options['{{THEME_PREFIX}}buttons']['target'][$i] : '_self';

										echo '<a href="' . esc_url($url) . '" target="' . esc_attr($target) . '" class="{{THEME_PREFIX}}-btn">';
										echo esc_html($text);
										echo '</a>';
									}
									?>
								</div>
								<?php
							endif;

							if ($options['social_media']) {

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
									<ul class="social-link">
										<?php
										foreach ($social_buttons['social_icon'] as $i => $icon_key) {
											$icon_title = isset($social_icon_options[$icon_key]) ? $social_icon_options[$icon_key] : $icon_key;
											$icon_url = !empty($social_buttons['social_url'][$i]) ? $social_buttons['social_url'][$i] : '#';
											if ($icon_url) {
												?>
												<li>
													<a tabindex="-1" href="<?php echo $icon_url; ?>" target="_blank" class="<?php echo esc_attr($icon_key); ?>"></a>
												</li>
												<?php
											}
										}
										?>
									</ul>
									<?php

								}
							}

							if (!empty($options['topbar_contact_info'])) {
								?>
								<div class="contact-info responsive-contact">
									<?php
									echo do_shortcode($options['topbar_contact_info']);
									?>
								</div>
								<?php
							}

							?>
						</div>
					</nav>
				</div>
			</div>
		</header>