<?php

/**
 * Get all block directories.
 *
 * @return array Array of block directories.
 */
function vt_get_block_dirs() {
	return glob( THEME_PATH . '/blocks/*', GLOB_ONLYDIR );
}

/**
 * Get block data from block.json.
 *
 * @param string $block_dir : Path to the block directory.
 *
 * @return array|null : Block data including styles, scripts, and localization or null if block.json is missing.
 */
function vt_get_block_assets_data( $block_dir ) {
	$block_path = $block_dir . '/block.json';

	if ( file_exists( $block_path ) ) {
		$block_data     = json_decode( file_get_contents( $block_path ), true );
		$block_assets   = [];
		$block_basename = basename( $block_dir );
		$block_name     = $block_data['name'];

		// Process styles
		$block_assets['styles'] = [];

		if ( isset( $block_data['block_styles'] ) && is_array( $block_data['block_styles'] ) ) {
			foreach ( $block_data['block_styles'] as $key => $style ) {
				$block_assets['styles'][] = [
					'handle'         => 'vt-block-' . $block_basename . '_' . md5( $key ),
					'src'            => THEME_DIST_URI . $style,
					'ver'            => get_last_modified( THEME_DIST_PATH . $style ),
					'block_name'     => $block_name,
					'block_basename' => $block_basename,
				];
			}
		}

		// Process scripts
		$block_assets['scripts'] = [];
		
		if ( isset( $block_data['block_scripts'] ) && is_array( $block_data['block_scripts'] ) ) {
			foreach ( $block_data['block_scripts'] as $key => $script ) {
				$localize_data = [];

				// Process localization data
				if ( isset( $block_data['block_localize'][ $script ] ) && is_array( $block_data['block_localize'][ $script ] ) ) {
					foreach ( $block_data['block_localize'][ $script ] as $localize_key => $localize_value ) {
						try {
							// Evaluate PHP code if it exists, otherwise keep the value as-is
							$localize_data[ $localize_key ] = strpos( $localize_value, '(' ) !== false
								? eval( 'return ' . $localize_value . ';' )
								: $localize_value;
						} catch ( Throwable $e ) {
							// Log error and skip this localization value
							error_log( "Error processing localization key '{$localize_key}': " . $e->getMessage() );
						}
					}
				}

				$block_assets['scripts'][] = [
					'handle'         => 'vt-block-' . $block_basename . '_' . md5( $key ),
					'src'            => THEME_DIST_URI . $script,
					'ver'            => get_last_modified( THEME_DIST_PATH . $script ),
					'localize'       => $localize_data,
					'block_name'     => $block_name,
					'block_basename' => $block_basename,
				];
			}
		}

		$block_assets['basename'] = $block_basename;
		$block_assets['name']     = $block_name;

		return $block_assets;
	}

	return null;
}

/**
 * Create custom block category for Gutenberg blocks
 *
 * @param array $categories : Array of block categories.
 *
 * @return array : Modified array with custom block category.
 * @hooked block_categories_all
 */
function vt_custom_block_category( array $categories, $post ): array {
	$custom_blocks = array(
		'slug'  => 'custom-blocks',
		'title' => __( 'Custom Blocks', THEME_DOMAIN ),
	);

	array_unshift( $categories, $custom_blocks ); // Add custom category at the beginning

	return $categories;
}
add_filter( 'block_categories_all', 'vt_custom_block_category', 10, 2 );

/**
 * Generate ACF Gutenberg block attributes.
 *
 * @param string $class : Custom block CSS classes.
 * @param array $block : ACF block data.
 *
 * @return string : Generated block attributes string.
 */
function vt_block_attributes( string $class = '', array $block = [] ): string {
	// Initialize the attribute array
	$attr = [];

	// Add the passed class
	if ( ! empty( $class ) ) {
		$attr['class'] = $class;
	}

	// Process the ACF block data
	if ( ! empty( $block ) ) {
		// Extract the block name
		$block_name      = explode( '/', $block['name'] );
		$block_name_slug = end( $block_name );

		// Add the block's custom className if it exists
		if ( isset( $block['className'] ) ) {
			$attr['class'] = isset( $attr['class'] ) ? $attr['class'] . ' ' . $block['className'] : $block['className'];
		}

		// Add the JavaScript-specific class
		$attr['class'] = isset( $attr['class'] ) ? $attr['class'] . ' js-' . $block_name_slug : 'js-' . $block_name_slug;

		// Handle the block ID (anchor)
		$attr['id'] = $block['anchor'] ?? $block_name_slug . '_' . md5( $block_name_slug );
	}

	// Build the attribute string
	$attr_string = '';

	foreach ( array_filter( $attr ) as $name => $val ) {
		$attr_string .= "{$name}='" . esc_attr( $val ) . "' ";
	}

	return trim( $attr_string );
}

/**
 * Register ACF blocks by scanning the blocks directory and registering each block.
 *
 * @return void
 * @hooked acf/init
 */
function vt_register_acf_blocks() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Get all block directories inside the 'blocks' folder
	$block_dirs = vt_get_block_dirs();

	// Loop through each block directory
	foreach ( $block_dirs as $block_dir ) {
		$block_name = basename( $block_dir );

		if ( file_exists( THEME_PATH . "/blocks/{$block_name}/block.json" ) ) {
			register_block_type( THEME_PATH . "/blocks/{$block_name}/block.json" );
		}
	}
}
add_action( 'init', 'vt_register_acf_blocks' );