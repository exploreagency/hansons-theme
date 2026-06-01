<?php
/**
 * Enqueue theme styles and scripts.
 *
 * @return void
 * @hooked wp_enqueue_scripts
 */

function vt_enqueue_assets() {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	wp_enqueue_style(
		'venture-css',
		$theme_uri . '/dist/css/style.min.css',
		[],
		filemtime( $theme_dir . '/dist/css/style.min.css' )
	);

	wp_enqueue_script(
		'venture-output-js',
		$theme_uri . '/dist/js/output.min.js',
		[],
		filemtime( $theme_dir . '/dist/js/output.min.js' ),
		true
	);

	// JS vendor (shared)
	wp_register_script(
		'venture-vendor',
		$theme_uri . '/dist/js/vendor.min.js',
		[],
		filemtime( $theme_dir . '/dist/js/vendor.min.js' ),
		true
	);

	// Optional: CSS vendor (shared)
	if ( file_exists( $theme_dir . '/dist/css/vendor.css' ) ) {
		wp_register_style(
			'venture-vendor',
			$theme_uri . '/dist/css/vendor.css',
			[],
			filemtime( $theme_dir . '/dist/css/vendor.css' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'vt_enqueue_assets' );
