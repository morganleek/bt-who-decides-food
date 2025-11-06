<?php

	/**
	 * Bones Theme
	 */

	if ( ! defined( 'ABSPATH' ) )
		exit;

	require get_template_directory() . '/inc/vite-assets.php'; // vite-related functions
	require get_template_directory() . '/inc/tools.php';
	require get_template_directory() . '/inc/block-patterns.php';

	// Declutter
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

	// Actions
	add_action( 'init', 'bones_name_register_block_styles', 100 );
	add_action( 'wp_head', 'bones_theme_js_data_object', 5 );
	add_action( 'wp_head', 'bones_theme_load_favicons', 20 );
	add_action( 'current_screen', 'bones_theme_add_editor_styles', 20 );
	add_action( 'init', 'bones_theme_init', 0 );
	// add_action( 'wp_head', 'theme_fonts', 20 );

	// Frontend Actions
	if ( ! is_admin() ) {
		add_action( 'render_block', 'bones_theme_render_block', 5, 2 );
	}

	function bones_theme_init() {
		// Hide default WP patters
		remove_theme_support('core-block-patterns');
	}

	// Entry Points
	function bones_theme_entry_points(): array {
		return [ 
			'src/index.js',
			'src/style.scss',
		];
	}

	// Inline Data
	function bones_theme_js_data_object() {
		$data = [ 
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		];

		print "<script type=\"text/javascript\">const phpData = " . wp_json_encode( $data ) . ";</script>";
	}

	// Favicons
	function bones_theme_load_favicons() {
		print '<link rel="icon" href="' . get_theme_file_uri( 'assets/favicon/favicon.svg' ) . '" type="image/svg+xml">';
	}

	// Block greps
	function bones_theme_render_block( $block_content, $block ) {
		// Copyright Year
		if( $block['blockName'] === "core/paragraph" ) {
			$year_regex = "/({YEAR})/i";
			$block_content = preg_replace( $year_regex, date('Y'), $block_content );
		}

		// Change Hamburger
		// if( $block['blockName'] === "core/navigation" ) {
		// 	$svg_regex = "/<svg.*?\/svg>/i";
		// 	$svg = '<svg class="open" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12H21M3 6H21M9 18H21" stroke="#38332F" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/></svg><svg class="close" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 2L2 22M2 2L22 22" stroke="#38332F" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/></svg>';
		// 	$block_content = preg_replace( $svg_regex, $svg, $block_content );
		// }

		return $block_content;
	}

	// Fonts
	// function theme_fonts() {
	// 	print '<link rel="preconnect" href="https://fonts.googleapis.com">';
	// 	print '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	// 	print '<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">';
	// }

	// Load Editor Styles
	function bones_theme_add_editor_styles( WP_Screen $screen ) {
		if ( $screen->base !== 'post' && $screen->base !== 'site-editor' ) {
			return;
		}
		
		$main_entry = 'src/index.js';

		try {
			$frontend_config = bones_theme_get_frontend_config(); // shared variables between js and php
			$manifest = theme_get_vite_manifest_data( $frontend_config['distFolder'] );// vite manifest
			$css_files = bones_theme_get_styles_for_entry( $main_entry, $manifest );
			if ( pathinfo( $manifest[ $main_entry ]['file'], PATHINFO_EXTENSION ) === 'css' ) {
				$css_files[] = $manifest[ $main_entry ]['file']; // add if your entry is css-only
			}

			foreach ( $css_files as $css_file ) {
				add_editor_style( "{$frontend_config['distFolder']}/$css_file" ); // path relative to the theme!
			}
		} catch (Exception $e) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions -- intentional trigger_error for admin area
			trigger_error( $e->getMessage(), E_USER_WARNING );// don't break the entire admin page
		}
	}

	// Custom Block Types
	function bones_name_register_block_styles() {
		register_block_style( 'core/image', [
			'name' => 'special-appearance',
			'label' => __( 'Special', 'bones_name' ),
		] );
	}