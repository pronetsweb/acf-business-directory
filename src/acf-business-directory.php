<?php

/**
 * @package   ACF_Business_Directory
 * @author    Zachary Tarvid-Richey <zr.public@gmail.com>
 * @copyright 2023 Zachary Tarvid-Richey
 * @license   GPL 2.0+
 * @link      https://zachuorice.com
 *
 * Plugin Name:     ACF Business Directory
 * Plugin URI:      @TODO
 * Description:     @TODO
 * Version:         1.0.0
 * Author:          Zachary Tarvid-Richey
 * Author URI:      https://zachuorice.com
 * Text Domain:     acf-business-directory
 * License:         GPL 2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.4
 * WordPress-Plugin-Boilerplate-Powered: v3.3.0
 */

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'ABD_VERSION', '1.0.0' );
define( 'ABD_TEXTDOMAIN', 'acf-business-directory' );
define( 'ABD_NAME', 'ACF Business Directory' );
define( 'ABD_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'ABD_PLUGIN_ABSOLUTE', __FILE__ );
define( 'ABD_MIN_PHP_VERSION', '7.4' );
define( 'ABD_WP_VERSION', '5.3' );

if ( version_compare( PHP_VERSION, ABD_MIN_PHP_VERSION, '<=' ) ) {
	add_action(
		'admin_init',
		static function() {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	);
	add_action(
		'admin_notices',
		static function() {
			echo wp_kses_post(
			sprintf(
				'<div class="notice notice-error"><p>%s</p></div>',
				__( '"ACF Business Directory" requires PHP 5.6 or newer.', ABD_TEXTDOMAIN )
			)
			);
		}
	);

	// Return early to prevent loading the plugin.
	return;
}

$acf_business_directory_libraries = require ABD_PLUGIN_ROOT . 'vendor/autoload.php'; //phpcs:ignore

require_once ABD_PLUGIN_ROOT . 'functions/functions.php';
require_once ABD_PLUGIN_ROOT . 'functions/debug.php';

// Add your new plugin on the wiki: https://github.com/WPBP/WordPress-Plugin-Boilerplate-Powered/wiki/Plugin-made-with-this-Boilerplate

$requirements = new \Micropackage\Requirements\Requirements(
	'ACF Business Directory',
	array(
		'php'            => ABD_MIN_PHP_VERSION,
		'php_extensions' => array( 'mbstring' ),
		'wp'             => ABD_WP_VERSION,
		// 'plugins'            => array(
		// array( 'file' => 'hello-dolly/hello.php', 'name' => 'Hello Dolly', 'version' => '1.5' )
		// ),
	)
);

if ( ! $requirements->satisfied() ) {
	$requirements->print_notice();

	return;
}




if ( ! wp_installing() ) {
	register_activation_hook( ABD_TEXTDOMAIN . '/' . ABD_TEXTDOMAIN . '.php', array( new \ACF_Business_Directory\Backend\ActDeact, 'activate' ) );
	register_deactivation_hook( ABD_TEXTDOMAIN . '/' . ABD_TEXTDOMAIN . '.php', array( new \ACF_Business_Directory\Backend\ActDeact, 'deactivate' ) );
	add_action(
		'plugins_loaded',
		static function () use ( $acf_business_directory_libraries ) {
			new \ACF_Business_Directory\Engine\Initialize( $acf_business_directory_libraries );
		}
	);
}
