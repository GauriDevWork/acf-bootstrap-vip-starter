<?php
$show_topbar = get_field( 'show_topbar', 'option' );
$email       = get_field( 'email', 'option' );
$phone       = get_field( 'phone', 'option' );
?>

<?php if ( $show_topbar ) : ?>
<div class="topbar">
	<div class="container d-flex justify-content-between">

		<div>
			<?php if ( $email ) : ?> 
				<?php echo esc_html( $email ); ?> 
			<?php endif; ?>
			<?php if ( $phone ) : ?> 
				| <?php echo esc_html( $phone ); ?> 
			<?php endif; ?>
		</div>

		<div class="social">
			<?php if ( have_rows( 'social_links', 'option' ) ) : ?>
				<?php
				while ( have_rows( 'social_links', 'option' ) ) :
					the_row();
					?>
					<a href="<?php the_sub_field( 'link' ); ?>">
						<?php the_sub_field( 'icon' ); ?>
					</a>
					<?php
					endwhile;
				?>
			<?php endif; ?>
		</div>

	</div>
</div>
<?php endif; ?>

<?php get_template_part( 'template-parts/header/header', 'layout1' ); ?>