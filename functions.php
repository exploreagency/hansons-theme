<?php
/**
 * venture-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package venture-theme
 */

if ( ! defined( 'THEME_VERSION' ) ) {
	define( 'THEME_VERSION', '1.0.0' );
}

if ( ! defined( 'THEME_DOMAIN' ) ) {
	define( 'THEME_DOMAIN', 'venture-theme' );
}

define( 'THEME_PATH', get_stylesheet_directory() );
define( 'THEME_URI', get_stylesheet_directory_uri() );

define( 'THEME_INC_PATH', THEME_PATH . '/inc' );
define( 'THEME_INC_URI', THEME_URI . '/inc' );

define( 'THEME_CORE_PATH', THEME_INC_PATH . '/core' );
define( 'THEME_CORE_URI', THEME_INC_URI . '/core' );

define( 'THEME_SRC_PATH', THEME_PATH . '/src' );
define( 'THEME_SRC_URI', THEME_URI . '/src' );

define( 'THEME_DIST_PATH', THEME_PATH . '/dist' );
define( 'THEME_DIST_URI', THEME_URI . '/dist' );

/**
 * Setup/include security files for theme
 */
// require_once THEME_INC_PATH . '/security/security-acf.php';
// require_once THEME_INCL_PATH . '/security/security-theme.php'; // Disable theme editing

/**
 * Setup/include helpers and custom functions files for theme
 */
// require_once THEME_INC_PATH . '/helpers.php';
// require_once THEME_INC_PATH . '/custom-functions.php';


/**
 * Setup/include core files for theme
 */
require_once THEME_CORE_PATH . '/core-theme-support.php';
// require_once THEME_CORE_PATH . '/core-login-page.php';
require_once THEME_CORE_PATH . '/core-register-menu.php';
require_once THEME_CORE_PATH . '/core-enqueue-scripts-styles.php';
require_once THEME_CORE_PATH . '/core-gutenberg.php';
require_once THEME_CORE_PATH . '/core-add-image-size.php';
// require_once THEME_CORE_PATH . '/core-tiny-mce.php';

/**
 * Setup/include additional files for theme
 */
require_once THEME_INC_PATH . '/acf.php';
// require_once THEME_INC_PATH . '/shortcodes.php';
// require_once THEME_INC_PATH . '/theme-ajax.php';