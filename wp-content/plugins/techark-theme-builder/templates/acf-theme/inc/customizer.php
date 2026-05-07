<?php

/**
 * {{THEME_NAME}} Theme Customizer
 *
 * @package {{THEME_PACKAGE}}
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function {{THEME_PREFIX_LONG}}customize_register($wp_customize)
{
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => '{{THEME_PREFIX_LONG}}customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => '{{THEME_PREFIX_LONG}}customize_partial_blogdescription',
			)
		);
	}
}
add_action('customize_register', '{{THEME_PREFIX_LONG}}customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function {{THEME_PREFIX_LONG}}customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function {{THEME_PREFIX_LONG}}customize_partial_blogdescription()
{
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function {{THEME_PREFIX_LONG}}customize_preview_js()
{
	wp_enqueue_script('{{TEXT_DOMAIN}}-customizer', get_stylesheet_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), {{THEME_UPPER_PREFIX}}_VERSION, true);
}
add_action('customize_preview_init', '{{THEME_PREFIX_LONG}}customize_preview_js');


/* Allow SVG images */

function my_custom_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'my_custom_mime_types');


/**
 * Admin login page logo set.
 */
function my_login_logo()
{
	$options = get_option('{{THEME_PREFIX}}options');

	$admin_logo_url = !empty($options['admin_logo']['url']) ?  $options['admin_logo']['url'] : $options['placeholder_image']['url'];

?>
	<style>
		#login h1 a,
		.login h1 a {
			background-image: url('<?php echo $admin_logo_url; ?>');
			width: 215px;
			background-size: contain;
			background-repeat: no-repeat;
			padding-bottom: 5px;
			height: 58px;
		}
	</style>
<?php
}
add_action('login_enqueue_scripts', 'my_login_logo');

/**
 * Admin login page logo URL set.
 */
function custom_loginlogo_url($url)
{
	$options = get_option('{{THEME_PREFIX}}options');

	$header_logo_url = !empty($options['header_logo_url']) ? $options['header_logo_url'] : site_url();

	return $header_logo_url;
}

add_filter('login_headerurl', 'custom_loginlogo_url');

function get_site_logo()
{
	$options = get_option('{{THEME_PREFIX}}options');

	$admin_logo_url = !empty($options['email_logo']['url']) ?  $options['email_logo']['url'] : $options['placeholder_image']['url'];

	return $admin_logo_url;
}

add_shortcode('site_logo', 'get_site_logo');

function get_email_logo_site_url()
{
	$options = get_option('{{THEME_PREFIX}}options');

	$header_logo_url = !empty($options['header_logo_url']) ? $options['header_logo_url'] : site_url();

	return $header_logo_url;
}

add_shortcode('email_logo_site_url', 'get_email_logo_site_url');

function get_current_year()
{
	return date("Y");
}

add_shortcode('current_year', 'get_current_year');

add_filter('wp_mail', function ($args) {
	if (! empty($args['message'])) {
		$args['message'] = do_shortcode($args['message']);
	}
	return $args;
});

/* add span tag for sub menu*/

function add_arrow($output, $item, $depth, $args)
{
	$options = get_option('{{THEME_PREFIX}}options');
	$menu_locations = get_nav_menu_locations();
	$primary_menu_id = $menu_locations['menu-1'];
	$header_menu = !empty($options['header_menu']) ? $options['header_menu'] : $primary_menu_id;

	//Only add class to 'top level' items on the 'primary' menu.
	if ($header_menu == $args->menu && $depth === 0) {

		if (in_array("menu-item-has-children", $item->classes)) {
			$output .= '<span class="ta-arrow-down ta-arrow-down1"></span>';
		}
	}
	return $output;
}

add_filter('walker_nav_menu_start_el', 'add_arrow', 10, 4);


add_action('wp_head', '{{THEME_PREFIX}}add_custom_favicon');
function {{THEME_PREFIX}}add_custom_favicon()
{
	$options = get_option('{{THEME_PREFIX}}options'); // Replace with your option key
	if (!empty($options['favicon_logo']['url'])) {
		$favicon = esc_url($options['favicon_logo']['url']);
		echo '
        <link rel="icon" href="' . $favicon . '" sizes="32x32" />
        <link rel="icon" href="' . $favicon . '" sizes="192x192" />
        <link rel="apple-touch-icon" href="' . $favicon . '" />
        <meta name="msapplication-TileImage" content="' . $favicon . '">';
	}
}

/* Remove from Text tab of editor */
function my_remove_quicktags_buttons($qt_init)
{
	// Buttons you want to remove (separate by comma)
	$remove = array('img', 'more', 'close');

	$qt_init['buttons'] = str_replace($remove, '', $qt_init['buttons']);

	return $qt_init;
}
add_filter('quicktags_settings', 'my_remove_quicktags_buttons');

/* Remove from visual tab of editor */
function my_remove_tinymce_buttons($buttons)
{
	// Buttons you want to remove
	$remove = array('wp_more', 'image', 'closetags');

	return array_diff($buttons, $remove);
}
add_filter('mce_buttons', 'my_remove_tinymce_buttons');

/*  END : Remove WYSIWYG editor buttons */


function {{THEME_PREFIX}}set_custom_logo_and_favicon()
{
	$options = get_option('{{THEME_PREFIX}}options');

	if (!empty($options['header_logo']['id'])) {
		$logo_id = $options['header_logo']['id'];
		set_theme_mod('custom_logo', $logo_id);
	}

	if (!empty($options['favicon_logo']['id'])) {
		$favicon_id = $options['favicon_logo']['id'];
		update_option('site_icon', $favicon_id);
	}
}
add_action('after_setup_theme', '{{THEME_PREFIX}}set_custom_logo_and_favicon');

function {{THEME_PREFIX}}remove_editor_for_global_template()
{
	$post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;

	if ($post_id && get_post_type($post_id) === 'page') {

		$template = get_post_meta($post_id, '_wp_page_template', true);

		remove_post_type_support('page', 'thumbnail');

		if ($template === 'custom-templates/global-template.php') {
			remove_post_type_support('page', 'editor');
		}
	}
}
add_action('load-post.php', '{{THEME_PREFIX}}remove_editor_for_global_template');
add_action('load-post-new.php', '{{THEME_PREFIX}}remove_editor_for_global_template');

// Register Footer Widget Areas
function {{THEME_PREFIX}}footer_widgets_init()
{

	// Footer Column 1
	register_sidebar(array(
		'name'          => esc_html__('Footer Column 1', '{{TEXT_DOMAIN}}'),
		'id'            => 'footer-1',
		'description'   => esc_html__('Widgets in this area will be shown in the first column of the footer.', '{{TEXT_DOMAIN}}'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));

	// Footer Column 2
	register_sidebar(array(
		'name'          => esc_html__('Footer Column 2', '{{TEXT_DOMAIN}}'),
		'id'            => 'footer-2',
		'description'   => esc_html__('Widgets in this area will be shown in the second column of the footer.', '{{TEXT_DOMAIN}}'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));

	// Footer Column 3
	register_sidebar(array(
		'name'          => esc_html__('Footer Column 3', '{{TEXT_DOMAIN}}'),
		'id'            => 'footer-3',
		'description'   => esc_html__('Widgets in this area will be shown in the third column of the footer.', '{{TEXT_DOMAIN}}'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));

	// Footer Column 4
	register_sidebar(array(
		'name'          => esc_html__('Footer Column 4', '{{TEXT_DOMAIN}}'),
		'id'            => 'footer-4',
		'description'   => esc_html__('Widgets in this area will be shown in the third column of the footer.', '{{TEXT_DOMAIN}}'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));


	// Blog sidebar	
	register_sidebar(array(
		'name'          => esc_html__('Blog Sidebar', '{{TEXT_DOMAIN}}'),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__('Widgets in this area will be shown in the blog sidebar.', '{{TEXT_DOMAIN}}'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
}
add_action('widgets_init', '{{THEME_PREFIX}}footer_widgets_init');

add_filter('body_class', '{{THEME_PREFIX}}add_container_class');
function {{THEME_PREFIX}}add_container_class($classes)
{
	$options = get_option('{{THEME_PREFIX}}options');

	if (isset($options['container_width']) && $options['container_width'] == 'boxed_container') {
		$classes[] = 'custom-container';
	}

	if (isset($options['sticky_header']) && $options['sticky_header']) {
		$classes[] = '';
	} else {
		$classes[] = 'no-sticky-header';
	}

	if (isset($options['enable_off_canvas']) && $options['enable_off_canvas']) {
		if (isset($options['mobile_menu_type']) && $options['mobile_menu_type'] == 'left') {
			$classes[] = 'off-canvas-left';
		} else if (isset($options['mobile_menu_type']) && $options['mobile_menu_type'] == 'right') {
			$classes[] = 'off-canvas-right';
		}
	}

	if (isset($options['arrow_enable']) && $options['arrow_enable']) {
		$classes[] = '';
	} else {
		$classes[] = 'btn-no-arrow';
	}

	return $classes;
}

function {{THEME_PREFIX}}get_container_class()
{
	$options = get_option('{{THEME_PREFIX}}options');
	if ($options['container_width'] == 'default_container') {
		return 'container';
	} else if ($options['container_width'] == 'fullwidth_container') {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

function {{THEME_PREFIX}}get_excerpt_or_content($length = 50, $post_id = null)
{
	$post_id = $post_id ? $post_id : get_the_ID();

	// Get excerpt if available, else fallback to content
	$text = has_excerpt($post_id) ? get_the_excerpt($post_id) : get_post_field('post_content', $post_id);

	// Remove shortcodes & tags
	$text = wp_strip_all_tags(strip_shortcodes($text));

	// Trim to defined word length
	$text = wp_trim_words($text, $length, '...');

	return $text;
}

if (!is_admin()) {
	function wpb_search_filter($query)
	{
		if ($query->is_search) {
			$query->set('post_type', 'post');
		}
		return $query;
	}
	add_filter('pre_get_posts', 'wpb_search_filter');
}

/* add 'news' in slug */
function wp1482371_custom_post_type_args($args, $post_type)
{
	if ($post_type == "post") {
		$args['rewrite'] = array(
			'slug' => 'blog'
		);
	}
	return $args;
}
add_filter('register_post_type_args', 'wp1482371_custom_post_type_args', 20, 2);
add_filter('pre_post_link', 'my_change_post_link', 10, 3);
function my_change_post_link($permalink, $post, $leavename)
{
	if (get_post_type($post) == 'post') {
		return "/blog" . $permalink;
	}
	return $permalink;
}

if (!function_exists('{{THEME_PREFIX}}get_wp_menus')) {
	function {{THEME_PREFIX}}get_wp_menus()
	{
		$menus = wp_get_nav_menus();
		$menu_options = array('none' => __('No Menu', '{{TEXT_DOMAIN}}'));

		if (!empty($menus)) {
			foreach ($menus as $menu) {
				$menu_options[$menu->term_id] = $menu->name;
			}
		}

		return $menu_options;
	}
}

if (!function_exists('{{THEME_PREFIX}}get_primary_menu_id')) {
	function {{THEME_PREFIX}}get_primary_menu_id()
	{
		$locations = get_nav_menu_locations();
		if (!empty($locations['menu-1'])) {
			return $locations['menu-1']; // returns term_id of the menu assigned to 'primary'
		}
		return 'none'; // fallback if no primary menu is set
	}
}

add_action('admin_menu', function () {
	remove_meta_box('commentsdiv', 'post', 'normal');
});

add_action('admin_init', function () {
	remove_post_type_support('post', 'comments');
	remove_post_type_support('page', 'comments');
});

add_filter('render_block', function ($block_content, $block) {
	if ($block['blockName'] === 'core/search') {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none">
                  <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                  <line x1="16.65" y1="16.65" x2="22" y2="22" stroke="currentColor" stroke-width="2"/>
                </svg>';

		$block_content = preg_replace(
			'/(<button[^>]*>)(.*?)(<\/button>)/is',
			'$1' . $svg . '$3',
			$block_content
		);
	}
	return $block_content;
}, 10, 2);
