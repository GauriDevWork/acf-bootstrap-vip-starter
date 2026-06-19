<?php
/**
 * Admin menu registration for TechArk Theme Builder
 *
 * Adds a top-level "Theme Builder" menu with two submenus:
 * - Theme Generator
 * - Template Creator
 */

add_action( 'admin_menu', 'techark_builder_menu' );

function techark_builder_menu() {

	// Top-level menu
	add_menu_page(
		'TechArk Theme Builder',
		'Theme Builder',
		'manage_options',
		'techark-theme-builder',
		'techark_theme_generator_page',
		'dashicons-editor-code',
		61
	);

	// Submenu 1 — Theme Generator (same as parent)
	add_submenu_page(
		'techark-theme-builder',
		'Theme Generator',
		'Theme Generator',
		'manage_options',
		'techark-theme-builder',
		'techark_theme_generator_page'
	);

	// Submenu 2 — Template Creator
	add_submenu_page(
		'techark-theme-builder',
		'Template Creator',
		'Template Creator',
		'manage_options',
		'techark-template-creator',
		'techark_template_creator_page'
	);
}
