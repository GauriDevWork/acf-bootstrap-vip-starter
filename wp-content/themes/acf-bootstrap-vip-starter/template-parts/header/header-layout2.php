<?php
$logo      = get_field( 'header_logo', 'option' );
$container = get_field( 'container_type', 'option' ) ?: 'container';
?>

<div class="<?php echo esc_attr( $container ); ?>">
	<div class="header-layout-2 text-center">

		<!-- LOGO -->
		<div class="header-logo mb-2">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php
				if ( $logo ) {
					echo wp_get_attachment_image( is_array( $logo ) ? $logo['ID'] : $logo, 'full' );
				} else {
					bloginfo( 'name' );
				}
				?>
			</a>
		</div>

		<!-- MENU -->
		<nav class="header-menu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu justify-content-center',
				)
			);
			?>
		</nav>

		<!-- MOBILE TOGGLE -->
		<div class="mobile-toggle d-lg-none">
			<span></span>
			<span></span>
			<span></span>
		</div>

	</div>
</div>

<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>