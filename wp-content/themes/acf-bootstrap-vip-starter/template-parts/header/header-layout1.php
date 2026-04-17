<?php
$logo      = get_field( 'header_logo', 'option' );
$cta       = get_field( 'header_cta_button', 'option' );
$container = get_field( 'container_type', 'option' ) ? get_field( 'container_type', 'option' ) : 'container';
?>

<div class="<?php echo esc_attr( $container ); ?>">

	<div class="header-inner d-flex justify-content-between align-items-center">

		<!-- LOGO -->
		<div class="header-logo">
			<a href="<?php echo esc_url( home_url() ); ?>">
				<?php echo $logo ? wp_get_attachment_image( $logo['ID'], 'full' ) : bloginfo( 'name' ); ?>
			</a>
		</div>

		<!-- MENU -->
		<nav class="header-menu d-none d-lg-block">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'd-flex gap-3 list-unstyled mb-0',
				)
			);
			?>
		</nav>

		<!-- CTA -->
		<?php
		if ( $cta ) :
			?>
			<a href="<?php echo esc_url( $cta['url'] ); ?>" class="btn btn-primary d-none d-lg-inline-block">
				<?php echo esc_html( $cta['title'] ); ?>
			</a>
			<?php
			endif;
		?>

		<!-- MOBILE TOGGLE -->
		<div class="mobile-toggle d-lg-none">
			<span></span>
			<span></span>
			<span></span>
		</div>

	</div>

</div>

<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>