<?php
$email = get_field( 'email', 'option' );
$phone = get_field( 'phone', 'option' );
?>

<div class="topbar">
	<div class="container d-flex justify-content-between align-items-center">

		<div class="topbar-left">
			<?php if ( $email ) : ?>
				<span><?php echo esc_html( $email ); ?></span>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<span class="ms-2">| <?php echo esc_html( $phone ); ?></span>
			<?php endif; ?>
		</div>

		<div class="topbar-right">
			<?php if ( have_rows( 'social_links', 'option' ) ) : ?>
				<?php
				while ( have_rows( 'social_links', 'option' ) ) :
					the_row();
					$social_link = get_sub_field( 'link' );
					$icon        = get_sub_field( 'icon' );
					?>
					<a href="<?php echo esc_url( $social_link ); ?>" target="_blank">
						<i class="<?php echo esc_attr( $icon ); ?>"></i>
					</a>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>

	</div>
</div>