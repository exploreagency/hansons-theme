<?php

/**
 * Save ACF JSON
 *
 * @param string $path : Path where ACF JSON will be saved.
 *
 * @return string : Modified path for saving ACF JSON files.
 * @hooked acf/settings/save_json
 */
function vt_acf_json_save_point( string $path ): string {
	return THEME_INC_PATH . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'vt_acf_json_save_point' );

/**
 * Load ACF JSON
 *
 * @param array $paths : Array of paths to load ACF JSON from.
 *
 * @return array : Modified array with custom path for loading ACF JSON.
 * @hooked acf/settings/load_json
 */
function vt_acf_json_load_point( array $paths ): array {
	unset( $paths[0] ); // Remove default path

	$paths[] = THEME_INC_PATH . '/acf-json';

	return $paths;
}
add_filter( 'acf/settings/load_json', 'vt_acf_json_load_point' );

/**
 * Replace "@year" with the current year in ACF fields
 *
 * @param string $value : ACF field value.
 *
 * @return string : Modified ACF field value with current year.
 * @hooked acf/load_value/name=copyright
 */
function vt_replace_year_in_acf( string $value ): string {
	return str_replace( '@year', date( 'Y' ), $value );
}

if ( ! is_admin() ) {
	add_filter( 'acf/load_value/name=copyright', 'vt_replace_year_in_acf' );
}
