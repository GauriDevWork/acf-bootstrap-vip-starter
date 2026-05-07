<?php

/**
 * My theme enqueue scripts
 *
 * @package My_theme
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

function my_theme_scripts()
{
	/* Style */

	wp_enqueue_style('my-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('my-theme-style', 'rtl', 'replace');

	wp_enqueue_style('my-theme-bootstrap-style', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', array(), rand(99, 997));

	if (is_singular('post')) {
		wp_enqueue_style('my-theme-owl-carousel-style', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css', array(), rand(99, 997));
		wp_enqueue_style('my-theme-owl-theme-style', get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.css', array(), rand(99, 997));
	}

	wp_enqueue_style('my-theme-custom-icons-style', get_stylesheet_directory_uri() . '/assets/css/custom-icons.css', array(), rand(99, 997));

	wp_enqueue_style('my-theme-animate-style', get_stylesheet_directory_uri() . '/assets/css/animate.min.css', array(), rand(99, 997));

	wp_enqueue_style('my-theme-custom-global-style', get_stylesheet_directory_uri() . '/assets/css/custom-global.css', array(), rand(99, 997));

	wp_enqueue_style('my-theme-custom-footer-style', get_stylesheet_directory_uri() . '/assets/css/custom-footer.css', array(), rand(99, 997));

	$banner_enable = get_post_meta(get_the_ID(), 'banner_enable', true);
	if ($banner_enable || is_404() || is_home()) {
		wp_enqueue_style('my-theme-banner-style', get_stylesheet_directory_uri() . '/assets/css/custom-banner.css', array(), rand(99, 997));
	}

	if (is_home() || is_category() || is_search() || is_tag() || is_single() || is_author() || is_archive()) {
		wp_enqueue_style('my-theme-sidebar-style', get_stylesheet_directory_uri() . '/assets/css/sidebar.css', array(), rand(99, 997));
	}

	if (is_singular('post')) {
		wp_enqueue_style('blog-details-style', get_stylesheet_directory_uri() . '/assets/css/blog-detail.css', array(), time());
	}

	if (is_home() || is_category() || is_search() || is_tag() || is_archive()) {
		wp_enqueue_style('blog-style', get_stylesheet_directory_uri() . '/assets/css/blog.css', array(), time());
	}

	/* jQuery */

	wp_enqueue_script('jquery');

	wp_enqueue_script('my-theme-bootstrap-script', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), rand(99, 997), true);

	if (is_singular('post')) {
		wp_enqueue_script('my-theme-owl.carousel-script', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.js', array(), rand(99, 997), true);
	}

	wp_enqueue_script('my-theme-lazyimages-script', get_stylesheet_directory_uri() . '/assets/js/lazyimages.min.js', array(), rand(99, 997), true);

	wp_enqueue_script('my-theme-wow-script', get_stylesheet_directory_uri() . '/assets/js/wow.min.js', array(), rand(99, 997), true);

	wp_enqueue_script('my-theme-custom-script', get_stylesheet_directory_uri() . '/assets/js/custom-script.js', array(), rand(99, 997), true);

	wp_enqueue_script('my-theme-rocket-script', get_stylesheet_directory_uri() . '/assets/js/trigger-wp-rocket-delay.js', array(), rand(99, 997), true);

}
add_action('wp_enqueue_scripts', 'my_theme_scripts');


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

	wp_enqueue_script('my-theme-redux-admin-script', get_stylesheet_directory_uri() . '/admin-assets/js/redux-admin.js', array(), rand(99, 997), true);
}

add_action('redux/page/my_theme_options/enqueue', 'my_redux_custom_css');

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
