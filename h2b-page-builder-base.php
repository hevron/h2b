<?php
/**
 * Plugin Name: H2B Post Builder
 * Plugin URI: https://themeforest.net/user/hevron
 * Description: Turn your WordPress Blog Into a WikiHow website concept.
 * Version: 1.0.0
 * Author: Hevron
 * Author URI: https://themeforest.net/user/hevron
 * Text Domain: h2b-post-builder
 * @author Hevron <hi@hevronroger.com>
 * @copyright Copyright (c) 2017, Hevron Roger
**/

/* Do not access this file directly */
if ( ! defined( 'WPINC' ) ) { die; }

/* Constants
------------------------------------------ */

/* Set plugin version constant. */
define( 'H2B_PBBASE_VERSION', '1.0.0' );

/* Set constant path to the plugin directory. */
define( 'H2B_PBBASE_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );

/* Set the constant path to the plugin directory URI. */
define( 'H2B_PBBASE_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );


/* Includes
------------------------------------------ */

/* Functions */
require_once( H2B_PBBASE_PATH . 'includes/functions.php' );

/* H2B Post Builder */
if( is_admin() ){
	require_once( H2B_PBBASE_PATH . 'includes/page-builder.php' );
	require_once( H2B_PBBASE_PATH . 'includes/page-builder-settings.php' );
}

/* Functions */
require_once( H2B_PBBASE_PATH . 'includes/front-end.php' );

