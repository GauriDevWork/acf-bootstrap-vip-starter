<?php
$copy = get_field( 'copyright_text', 'option' );
$container = get_field( 'container_type', 'option' ) ?: 'container';
?>

<div class="<?php echo esc_attr( $container ); ?>">

	<div class="row">

		<div class="col-lg-3">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>

		<div class="col-lg-3">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>

		<div class="col-lg-3">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>

		<div class="col-lg-3">
			<h5>Quick Links</h5>
			<?php
			wp_nav_menu([
				'theme_location' => 'footer',
				'container'      => false,
			]);
			?>
		</div>

	</div>

	<div class="footer-bottom d-flex justify-content-between align-items-center mt-4">

		<div>
			<?php echo esc_html( $copy ); ?>
		</div>

		<div class="footer-social">
			<?php if ( have_rows( 'footer_social_links', 'option' ) ) : ?>
				<?php while ( have_rows( 'footer_social_links', 'option' ) ) : the_row(); ?>
					<a href="<?php echo esc_url( get_sub_field( 'link' ) ); ?>">
						<i class="<?php echo esc_attr( get_sub_field( 'icon' ) ); ?>"></i>
					</a>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>

	</div>

</div>