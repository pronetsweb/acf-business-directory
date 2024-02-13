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
 * Version:         1.1.0
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

define( 'ABD_VERSION', '1.1.0' );
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

$requirements = array(
	// Minimum Requirements
	new \Micropackage\Requirements\Requirements(
		'ACF Business Directory',
		array(
			'php'            => ABD_MIN_PHP_VERSION,
			'php_extensions' => array( 'mbstring' ),
			'wp'             => ABD_WP_VERSION,
			'plugins'            => array(
				array( 'file' => 'advanced-custom-fields/acf.php', 'name' => 'Advanced Custom Fields', 'version' => '6.2.2' )
			),
		)
	),
	// Ideal Requirements
	new \Micropackage\Requirements\Requirements(
		'ACF Business Directory',
		array(
			'php'            => ABD_MIN_PHP_VERSION,
			'php_extensions' => array( 'mbstring' ),
			'wp'             => ABD_WP_VERSION,
			'plugins'            => array(
				array( 'file' => 'advanced-custom-fields-pro/acf.php', 'name' => 'Advanced Custom Fields PRO', 'version' => '6.2.2' )
			),
		)
	)
);

// Find any truthy values from $requirements[i]->satisfied()
$requirements_satisfied = array_filter(
	array_map(
		function( $val ) {
			return $val->satisfied();
		}, $requirements
	), function( $val ) { return $val == true; }
);


if(count($requirements_satisfied) == 0) {
	$requirements[0]->print_notice();
	add_action( 'admin_init', function() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	});
	return;
}

if( defined('ACF_BD_GOOGLE_MAPS_API_KEY') ) {
	function acf_bd_google_maps_key() {
		acf_update_setting('google_api_key', ACF_BD_GOOGLE_MAPS_API_KEY);
	}
	add_action('acf/init', 'acf_bd_google_maps_key');
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
