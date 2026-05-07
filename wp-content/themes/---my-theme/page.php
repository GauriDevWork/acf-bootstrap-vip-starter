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
 * @package My_theme
 */

get_header();


$options = get_option('my_theme_options');

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
	while (have_posts()) :
		the_post();

		get_template_part('custom-templates/header-banner', null);
		?>

		<section class="page-content py-75">
			<div class="<?php echo esc_attr(my_theme_get_container_class()); ?>">
				<?php
				the_content();
				?>
			</div>
		</section>

	<?php
	endwhile;
	?>
	?>
</main>
<?php

get_footer();
