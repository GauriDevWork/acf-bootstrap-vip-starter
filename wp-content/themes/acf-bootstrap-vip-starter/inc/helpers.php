<?php

function acf_vip_button( $button, $classname = 'btn btn-primary' ) {

	if ( empty( $button ) || empty( $button['url'] ) ) {
		return;
	}

	$url    = esc_url( $button['url'] );
	$title  = esc_html( $button['title'] );
	$target = ! empty( $button['target'] ) ? esc_attr( $button['target'] ) : '_self';

	echo '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '" class="' . esc_attr( $classname ) . '" aria-label="' . esc_attr( $title ) . '">' . esc_html( $title ) . '</a>';
}

function acf_vip_image( $image, $classname = 'img-fluid', $size = 'full' ) {

	if ( empty( $image ) ) {
		return;
	}

	echo wp_get_attachment_image(
		$image['ID'],
		$size,
		false,
		array(
			'class'   => $classname,
			'loading' => 'lazy',
		)
	);
}

function acf_vip_text_align( $align = 'left' ) {
	$map = array(
		'left'   => 'text-start',
		'center' => 'text-center',
		'right'  => 'text-end',
	);

	return $map[ $align ] ?? 'text-start';
}

function acf_vip_section_classes( $bg = 'light', $spacing = true ) {

	$classes = '';

	$bg_map = array(
		'light'     => 'bg-light',
		'dark'      => 'bg-dark text-white',
		'primary'   => 'bg-primary text-white',
		'secondary' => 'bg-secondary text-white',
	);

	$classes .= $bg_map[ $bg ] ?? 'bg-light';
	$classes .= ( $spacing ) ? ' py-5' : '';

	return $classes;
}


function acf_vip_section_settings() {

	$settings = get_sub_field( 'section_settings' );

	// Safe fallback
	$id        = $settings['section_id'] ?? '';
	$classname = $settings['custom_class'] ?? '';
	$container = $settings['container_type'] ?? 'container';
	$spacing   = $settings['spacing'] ?? 'medium';

	$spacing_map = array(
		'none'   => '',
		'small'  => 'py-3',
		'medium' => 'py-5',
		'large'  => 'py-7',
	);

	return array(
		'id'        => $id ? 'id="' . esc_attr( $id ) . '"' : '',
		'class'     => esc_attr( $classname ),
		'container' => esc_attr( $container ),
		'spacing'   => $spacing_map[ $spacing ] ?? 'py-5',
	);
}
