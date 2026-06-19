<?php
$logo      = get_field( 'footer_logo', 'option' );
$text      = get_field( 'footer_description', 'option' );
$copy      = get_field( 'copyright_text', 'option' );
$container = get_field( 'container_type', 'option' ) ? get_field( 'container_type', 'option' ) : 'container';
?>

<div class="<?php echo esc_attr( $container ); ?>">
	<div class="row">

		<div class="col-lg-4">
			<?php if ( $logo ) : ?>
				<?php echo wp_get_attachment_image( $logo['ID'], 'full' ); ?>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<p><?php echo wp_kses_post( $text ); ?></p>
			<?php endif; ?>
		</div>

		<div class="col-lg-4">
			<?php
			if ( is_active_sidebar( 'footer-1' ) ) {
				dynamic_sidebar( 'footer-1' );
			}
			?>
		</div>

		<div class="col-lg-4">
			<?php
			if ( is_active_sidebar( 'footer-2' ) ) {
				dynamic_sidebar( 'footer-2' );
			}
			?>
		</div>

	</div>

	<div class="footer-social mt-4">
		<?php if ( have_rows( 'footer_social_links', 'option' ) ) : ?>
			<?php
			while ( have_rows( 'footer_social_links', 'option' ) ) :
				the_row();
				?>
				<a href="<?php echo esc_url( get_sub_field( 'link' ) ); ?>">
					<i class="<?php echo esc_attr( get_sub_field( 'icon' ) ); ?>"></i>
				</a>
				<?php
			endwhile;
			?>
		<?php endif; ?>
	</div>

	<div class="footer-bottom text-center mt-4">
		<?php echo esc_html( $copy ); ?>
	</div>
</div>