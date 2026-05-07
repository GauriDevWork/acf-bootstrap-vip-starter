<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package {{THEME_PACKAGE}}
 */

get_header();


$options = get_option('{{THEME_PREFIX}}options');

$placeholder_image_id = !empty($options['placeholder_image']['id']) ? (int) $options['placeholder_image']['id'] : 254;

$alt = get_post_meta($placeholder_image_id, '_wp_attachment_image_alt', true);
$title = get_the_title($placeholder_image_id);

$image_data = array(
	'url' => $options['placeholder_image']['url'],
	'alt' => $alt,
	'title' => $title,
);

?>
<main id="main-content" class="site-main">
	<?php

	$cnt = 1;

	$page_id = get_the_ID();

	get_template_part('custom-templates/header-banner', null);

	$global_sections = get_field('global_sections', $page_id);

	if (!empty($global_sections)) {

		if (!empty(get_the_content())) {
			?>
			<section class="page-content">
				<div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		}

		foreach ($global_sections as $section) {

			$section['default_placeholder_image'] = $image_data;

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'large_banner') {
				get_template_part('sections/large_banner', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'image_with_content') {
				get_template_part('sections/image_with_content', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'only_content_section') {
				get_template_part('sections/only_content_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'counter_section') {
				get_template_part('sections/counter_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'address_section') {
				get_template_part('sections/address_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'testimonials_section') {
				get_template_part('sections/testimonials_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'address_with_map') {
				get_template_part('sections/address_with_map', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'services_section') {
				get_template_part('sections/services_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'form_section') {
				get_template_part('sections/form_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'physicians_section') {
				get_template_part('sections/physicians_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'faqs') {
				get_template_part('sections/faq_section', null, ['section' => $section, 'id' => $cnt]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'card_section') {
				get_template_part('sections/card_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'video_section') {
				get_template_part('sections/video_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'team_section') {
				get_template_part('sections/team_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'cta_section') {
				get_template_part('sections/cta_section', null, ['section' => $section]);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'form_with_content_section') {
				get_template_part('sections/form_with_content_section', null, ['section' => $section]);
			}

			$cnt++;

		}
	} else {
		if (!empty(get_the_content())) {
			?>
			<section class="page-content">
				<div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		} else {
			?>
			<section class="blank-content">
				<div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		}
	}
	?>
</main>
<?php

get_footer();
