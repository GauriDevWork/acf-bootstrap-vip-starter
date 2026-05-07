<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

	$post_id = get_the_ID();

	get_template_part('custom-templates/header-banner', null);

	$image_url = !empty(get_the_post_thumbnail_url($post_id, 'full')) ? get_the_post_thumbnail_url($post_id, 'full') : $options['placeholder_image']['url'];

	$thumb_id_main = get_post_thumbnail_id($post_id);
	$image_alt_main = !empty($thumb_id_main) ? get_post_meta($thumb_id_main, '_wp_attachment_image_alt', true) : get_the_title($post_id) . '-alt';

	$image_arr = array(
		'url' => $image_url,
		'alt' => $image_alt_main,
		'title' => get_the_title($post_id),
	);

	$designation = get_field('designation', $post_id);

	?>
	<section class="pt-75">
		<div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
			<div class="{{THEME_PREFIX}}-physicians-data-block">
				<div class="img-block">
					<?php echo getlazyload_img($image_arr, '100', '100'); ?>
				</div>
				<div class="content-block">
					<h2 class="h3"><?php echo get_the_title($post_id); ?></h2>
					<?php
					if (!empty($designation)) {
						?>
						<h3 class="h6"><?php echo $designation; ?></h3>
						<?php
					}
					if (!empty(get_the_content())) {
						the_content();
					}

					?>
					<a href="<?php echo site_url('/physicians'); ?>" class="{{THEME_PREFIX}}-btn">Go Back</a>
				</div>
			</div>
		</div>
	</section>
	<?php


	/* if (!empty($designation)) {

		$number_of_related_items = get_field('number_of_related_items', $post_id);

		$args = array(
			'post_type'      => 'physicians',
			'posts_per_page' => $number_of_related_items,
			'post__not_in'   => array($post_id),
			'meta_query'     => array(
				array(
					'key'     => 'designation',
					'value'   => $designation,
					'compare' => '='
				)
			)
		);

		$query = new WP_Query($args);

		$post_count = $query->found_posts;

		if ($query->have_posts()) {
	?>
			<section class="pb-75">
				<div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
					<div class="{{THEME_PREFIX}}-physicians-slider owl-carousel owl-theme" post_count="<?php echo $post_count; ?>">
						<?php
						while ($query->have_posts()) : $query->the_post();


							$postid =  get_the_ID();
							$designation = get_field('designation', $postid);

							$post_excerpt = $query->post_excerpt;

							$post_content = '';

							if (has_excerpt()) {
								$post_content = get_the_excerpt();
							} else {
								$post_content = wp_trim_words(get_the_content(), 15, '...');
							}

							$image_url = !empty(get_the_post_thumbnail_url($postid, 'full')) ? get_the_post_thumbnail_url($postid, 'full') : $options['placeholder_image']['url'];

							$thumb_id   = get_post_thumbnail_id($postid);
							$image_alt  = !empty($thumb_id) ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) :   get_the_title($postid) . '-alt';

							$image_arr = array(
								'url' => $image_url,
								'alt' => $image_alt,
								'title' =>  get_the_title($postid),
							);

						?>
							<div class="item">
								<a href="<?php echo get_the_permalink($postid);  ?>" class="physicians-card <?php echo $postid; ?> ">
									<div class="img-block">
										<?php echo getlazyload_img($image_arr, '100', '100'); ?>
										<span class="icon"></span>
									</div>
									<div class="content-block">
										<h2 class="h3"><?php echo get_the_title($postid); ?></h2>
										<?php
										if (!empty($designation)) {
										?>
											<h3 class="h6"><?php echo $designation; ?></h3>
										<?php
										}
										if (!empty($post_content)) {
										?>
											<p><?php echo $post_content; ?></p>
										<?php
										}
										?>
									</div>
								</a>
							</div>
						<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</section>
	<?php
		}
	} */


	$global_sections = get_field('global_sections', $page_id);
	$cnt = 1;

	if (!empty($global_sections)) {
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
	}

	?>
</main>
<?php

get_footer();
