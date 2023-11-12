<?php

/**
 * ACF_Business_Directory
 *
 * @package   ACF_Business_Directory
 * @author    Zachary Tarvid-Richey <zr.public@gmail.com>
 * @copyright 2023 Zachary Tarvid-Richey
 * @license   GPL 2.0+
 * @link      https://zachuorice.com
 */

namespace ACF_Business_Directory\Backend;

use ACF_Business_Directory\Engine\Base;

/**
 * Create the settings page in the backend
 */
class Debug_Page extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() || !defined('WP_DEBUG') ) {
			return;
		}

		// Add the options page and menu item.
		\add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		$realpath        = (string) \realpath( __DIR__ );
		$plugin_basename = \plugin_basename( \plugin_dir_path( $realpath ) . ABD_TEXTDOMAIN . '.php' );
		\add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since {{plugin_version}}
	 * @return void
	 */
	public function add_plugin_admin_menu() {
		\add_menu_page( \__( 'ACF_Business_Directory Debug', ABD_TEXTDOMAIN ), 'ACF_Business_Directory Debug', 'manage_options', ABD_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ), 'dashicons-hammer', 90 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since {{plugin_version}}
	 * @return void
	 */
	public function display_plugin_admin_page() {
		include_once ABD_PLUGIN_ROOT . 'backend/views/Debug_Page.php';
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since {{plugin_version}}
	 * @param array $links Array of links.
	 * @return array
	 */
	public function add_action_links( array $links ) {
		return \array_merge(
			array(
				'debug' => '<a href="' . \admin_url( 'options-general.php?page=' . ABD_TEXTDOMAIN . '_debug' ) . '">' . \__( 'Debug', ABD_TEXTDOMAIN ) . '</a>'
			),
			$links
		);
	}

}