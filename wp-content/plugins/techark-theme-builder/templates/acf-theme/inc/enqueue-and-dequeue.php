<?php

/**
 * {{THEME_NAME}} enqueue scripts
 *
 * @package {{THEME_PACKAGE}}
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Enqueue scripts and styles.
 */

function load_dynamic_css()
{
	$global_dynamic_css = get_template_directory() . '/inc/global-dynamic-css.php';
	if (file_exists($global_dynamic_css)) {
		require_once $global_dynamic_css;
	}
}
add_action('wp_head', 'load_dynamic_css');

function {{THEME_PREFIX_LONG}}scripts()
{

	$page_id = get_the_ID();

	$global_sections = function_exists('get_field') ? get_field('global_sections', $page_id) : array();

	$banner_enable = get_post_meta($page_id, 'banner_enable', true);

	/* Style */

	wp_enqueue_style('{{TEXT_DOMAIN}}-style', get_stylesheet_uri(), array(), {{THEME_UPPER_PREFIX}}_VERSION);
	wp_style_add_data('{{TEXT_DOMAIN}}-style', 'rtl', 'replace');

	wp_enqueue_style('{{THEME_PREFIX}}-bootstrap-style', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', array(), rand(99, 997));

	if (!empty($global_sections)) {
		foreach ($global_sections as $section) {

			if (!empty($section['acf_fc_layout'] && $section['acf_fc_layout'] === 'testimonials_section') || !empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'address_section') {

				wp_enqueue_style('{{THEME_PREFIX}}-owl-carousel-style', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css', array(), rand(99, 997));
				wp_enqueue_style('{{THEME_PREFIX}}-owl-theme-style', get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.css', array(), rand(99, 997));
			}
		}
	} elseif (is_singular('post')) {
		wp_enqueue_style('{{THEME_PREFIX}}-owl-carousel-style', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css', array(), rand(99, 997));
		wp_enqueue_style('{{THEME_PREFIX}}-owl-theme-style', get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.css', array(), rand(99, 997));
	}

	wp_enqueue_style('{{THEME_PREFIX}}-custom-icons-style', get_stylesheet_directory_uri() . '/assets/css/custom-icons.css', array(), rand(99, 997));

	wp_enqueue_style('{{THEME_PREFIX}}-animate-style', get_stylesheet_directory_uri() . '/assets/css/animate.min.css', array(), rand(99, 997));

	wp_enqueue_style('{{THEME_PREFIX}}-custom-global-style', get_stylesheet_directory_uri() . '/assets/css/custom-global.css', array(), rand(99, 997));

	wp_enqueue_style('{{THEME_PREFIX}}-custom-footer-style', get_stylesheet_directory_uri() . '/assets/css/custom-footer.css', array(), rand(99, 997));

	if ($banner_enable || is_404() || is_home()) {
		wp_enqueue_style('{{THEME_PREFIX}}-banner-style', get_stylesheet_directory_uri() . '/assets/css/{{THEME_PREFIX}}-banner.css', array(), rand(99, 997));
	}

	if (is_home() || is_category() || is_search() || is_tag() || is_single() || is_author() || is_archive()) {
		wp_enqueue_style('{{THEME_PREFIX}}-sidebar-style', get_stylesheet_directory_uri() . '/assets/css/sidebar.css', array(), rand(99, 997));
	}


	if (!empty($global_sections)) {
		foreach ($global_sections as $section) {

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'large_banner') {
				wp_enqueue_style('{{THEME_PREFIX}}-hero-banner-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/hero-banner.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'image_with_content') {
				wp_enqueue_style('{{THEME_PREFIX}}-img-text-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/img-text.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'only_content_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-only-content-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/only-content.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'counter_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-counter-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/counter.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'address_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-find-us-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/find-us.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'testimonials_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-client-testimonials-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/client-testimonials.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'address_with_map') {
				wp_enqueue_style('{{THEME_PREFIX}}-locations-list-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/locations-list.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'services_section' || !empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'card_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-service-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/service.css', array(), rand(99, 997));
			}

			if ((!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'form_section') || (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'form_with_content_section') || function_exists('wpcf7_contact_form')) {

				wp_enqueue_style('{{THEME_PREFIX}}-bootstrap-datepicker-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/bootstrap-datepicker.min.css', array(), rand(99, 997));
				wp_enqueue_style('{{THEME_PREFIX}}-appointment-style', get_stylesheet_directory_uri() . '//assets/sections-assets/css/appointment.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'physicians_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-physicians-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/physicians.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'faqs') {
				wp_enqueue_style('{{THEME_PREFIX}}-faq-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/faq.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'video_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-lightgallery-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/lightgallery-bundle.css', array(), rand(99, 997));
				wp_enqueue_style('{{THEME_PREFIX}}-videos-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/videos.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'team_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-team-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/team.css', array(), rand(99, 997));
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'cta_section') {
				wp_enqueue_style('{{THEME_PREFIX}}-cta-style', get_stylesheet_directory_uri() . '/assets/sections-assets/css/cta.css', array(), rand(99, 997));
			}

		}
	}

	if (is_singular('services')) {
		wp_enqueue_style('services-details-style', get_stylesheet_directory_uri() . '/assets/css/{{THEME_PREFIX}}-services-data.css', array(), time());
	}

	if (is_singular('physicians')) {
		wp_enqueue_style('physicians-details-style', get_stylesheet_directory_uri() . '/assets/css/{{THEME_PREFIX}}-physicians-data.css', array(), time());
	}

	if (is_singular('post')) {
		wp_enqueue_style('blog-details-style', get_stylesheet_directory_uri() . '/assets/css/blog-detail.css', array(), time());
	}

	if (is_home() || is_category() || is_search() || is_tag() || is_archive()) {
		wp_enqueue_style('blog-style', get_stylesheet_directory_uri() . '/assets/css/blog.css', array(), time());
	}

	/* jQuery */

	wp_enqueue_script('jquery');

	wp_enqueue_script('{{THEME_PREFIX}}-bootstrap-script', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), rand(99, 997), true);

	if (!empty($global_sections)) {
		foreach ($global_sections as $section) {

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'testimonials_section' || !empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'address_section') {

				wp_enqueue_script('{{THEME_PREFIX}}-owl.carousel-script', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.js', array(), rand(99, 997), true);
			}
		}
	} elseif (is_singular('post')) {
		wp_enqueue_script('{{THEME_PREFIX}}-owl.carousel-script', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.js', array(), rand(99, 997), true);
	}

	wp_enqueue_script('{{THEME_PREFIX}}-lazyimages-script', get_stylesheet_directory_uri() . '/assets/js/lazyimages.min.js', array(), rand(99, 997), true);

	wp_enqueue_script('{{THEME_PREFIX}}-wow-script', get_stylesheet_directory_uri() . '/assets/js/wow.min.js', array(), rand(99, 997), true);

	if (!empty($global_sections)) {
		foreach ($global_sections as $section) {

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'large_banner') {
				wp_enqueue_script('{{THEME_PREFIX}}-marquee-script', get_stylesheet_directory_uri() . '/assets/sections-assets/js/jquery.marquee.min.js', array(), rand(99, 997), true);
			}

			if ((!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'form_section') || (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'form_with_content_section') || function_exists('wpcf7_contact_form')) {

				wp_enqueue_script('{{THEME_PREFIX}}-datepicker-script', get_stylesheet_directory_uri() . '/assets/sections-assets/js/bootstrap-datepicker.min.js', array(), rand(99, 997), true);
				wp_enqueue_script('{{THEME_PREFIX}}-inputmask-script', get_stylesheet_directory_uri() . '/assets/sections-assets/js/jquery.inputmask.bundle.min.js', array(), rand(99, 997), true);
			}

			if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'video_section') {
				wp_enqueue_script('{{THEME_PREFIX}}-lightgallery-script', get_stylesheet_directory_uri() . '/assets/sections-assets/js/lightgallery.min.js', array(), rand(99, 997), true);
				wp_enqueue_script('{{THEME_PREFIX}}-lg-video-script', get_stylesheet_directory_uri() . '/assets/sections-assets/js/lg-video.min.js', array(), rand(99, 997), true);
			}

		}
	}

	wp_enqueue_script('{{THEME_PREFIX}}-custom-script', get_stylesheet_directory_uri() . '/assets/js/custom-script.js', array(), rand(99, 997), true);

	wp_enqueue_script('{{THEME_PREFIX}}-rocket-script', get_stylesheet_directory_uri() . '/assets/js/trigger-wp-rocket-delay.js', array(), rand(99, 997), true);

}
add_action('wp_enqueue_scripts', '{{THEME_PREFIX_LONG}}scripts');


function wpdocs_enqueue_custom_admin_style_and_scripts()
{
	/* Style */

	wp_enqueue_style('global_admin_style', get_stylesheet_directory_uri() . '/admin-assets/css/global-admin.css', array(), rand(99, 997));
}
add_action('admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style_and_scripts');

function my_redux_custom_css()
{
	/* Style */
	wp_enqueue_style('my-redux-admin-font', 'https://fonts.googleapis.com/css?family=Libre%20Franklin:300,500&display=swap', array(), null);
	wp_enqueue_style('my-redux-admin', get_stylesheet_directory_uri() . '/admin-assets/css/redux-admin.css', array(), rand(99, 997));

	/* script */

	wp_enqueue_script('{{THEME_PREFIX}}-redux-admin-script', get_stylesheet_directory_uri() . '/admin-assets/js/redux-admin.js', array(), rand(99, 997), true);
}

add_action('redux/page/{{THEME_PREFIX}}options/enqueue', 'my_redux_custom_css');

/*
# remove unused script
*/
function _unused_styles_scripts()
{
	wp_dequeue_style('wp-block-library');
	wp_deregister_script('wp-block-library');
	wp_dequeue_script('wp-embed');
	wp_deregister_script('wp-embed');
}
add_action('wp_enqueue_scripts', '_unused_styles_scripts');

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

# Remove dns-prefetch Link from WordPress Head (Frontend)
remove_action('wp_head', 'wp_resource_hints', 2);
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

add_filter('rocket_lrc_optimization', '__return_false', 999);
