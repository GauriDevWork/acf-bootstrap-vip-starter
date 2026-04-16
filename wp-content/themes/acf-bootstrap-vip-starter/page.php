<?php
/**
 * Default page template
 */
get_header();
?>
<main id="primary" class="site-main">

<?php if ( have_rows( 'page_builder' ) ) : ?>

	<?php
	while ( have_rows( 'page_builder' ) ) :
		the_row();
		?>

		<?php
		get_template_part(
			'acf-flex/' . get_row_layout()
		);
		?>

	<?php endwhile; ?>

<?php endif; ?>

</main>
<?php
get_footer();
?>