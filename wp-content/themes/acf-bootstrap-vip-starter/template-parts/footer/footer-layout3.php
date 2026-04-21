<?php
$logo = get_field( 'footer_logo', 'option' );
$text = get_field( 'footer_description', 'option' );
$copy = get_field( 'copyright_text', 'option' );
$container = get_field( 'container_type', 'option' ) ?: 'container';
?>

<div class="<?php echo esc_attr( $container ); ?> text-center">

	<div class="footer-logo mb-3">
		<?php if ( $logo ) : ?>
			<?php echo wp_get_attachment_image( $logo['ID'], 'full' ); ?>
		<?php endif; ?>
	</div>

	<?php if ( $text ) : ?>
		<p class="mb-3"><?php echo wp_kses_post( $text ); ?></p>
	<?php endif; ?>

	<!-- MENU -->
	<div class="footer-menu mb-3">
		<?php
		wp_nav_menu([
			'theme_location' => 'footer',
			'container'      => false,
		]);
		?>
	</div>

	<!-- SOCIAL -->
	<div class="footer-social mb-3">
		<?php if ( have_rows( 'footer_social_links', 'option' ) ) : ?>
			<?php while ( have_rows( 'footer_social_links', 'option' ) ) : the_row(); ?>
				<a href="<?php echo esc_url( get_sub_field( 'link' ) ); ?>">
					<i class="<?php echo esc_attr( get_sub_field( 'icon' ) ); ?>"></i>
				</a>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>

	<div class="footer-bottom">
		<?php echo esc_html( $copy ); ?>
	</div>

</div>