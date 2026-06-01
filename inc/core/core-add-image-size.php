<?php
/**
 * Add custom image sizes.
 *
 * @return void
 * @hooked after_setup_theme
 */

function vt_image_sizes_setup() {
  add_image_size( 'testimonial-source', 40, 40, true );
}
add_action( 'after_setup_theme', 'vt_image_sizes_setup' );
