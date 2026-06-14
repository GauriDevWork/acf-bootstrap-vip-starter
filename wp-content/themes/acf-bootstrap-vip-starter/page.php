<?php
/**
 * Default page template
 */
get_header();
?>
<main id="primary" class="site-main">

<?php if ( have_rows( 'page_builder' ) ) : ?>

	<?php
	$section_index = 0;

	while ( have_rows( 'page_builder' ) ) :
		the_row();

		// Pass section index to each layout via global
		$GLOBALS['acf_vip_section_index'] = $section_index;

		get_template_part(
			'acf-flex/' . get_row_layout()
		);

		$section_index++;
	endwhile;
	?>

<?php endif; ?>

</main>
<?php
get_footer();
?>