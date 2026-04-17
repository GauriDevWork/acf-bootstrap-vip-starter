<?php
$layout    = get_field( 'header_layout', 'option' ) ? get_field( 'header_layout', 'option' ) : 'layout1';
$sticky    = get_field( 'sticky_header', 'option' );
$container = get_field( 'container_type', 'option' ) ? get_field( 'container_type', 'option' ) : 'container';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<a class="skip-link screen-reader-text" href="#primary">
		Skip to content
	</a>     
	<header class="site-header <?php echo $sticky ? 'is-sticky' : ''; ?>">

		<?php get_template_part( 'template-parts/header/header', $layout ); ?>

	</header>