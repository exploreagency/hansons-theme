<?php
/**
 * Register theme menus.
 *
 * @return void
 * @hooked init
 */
function vt_register_theme_menus() {
	register_nav_menus(
		array(
			'header-menu' => esc_html__( 'Header Menu', THEME_DOMAIN ),
		)
	);
}
add_action( 'init', 'vt_register_theme_menus' );
