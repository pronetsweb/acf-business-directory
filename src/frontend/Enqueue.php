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

namespace ACF_Business_Directory\Frontend;

use ACF_Business_Directory\Engine\Base;

/**
 * Enqueue stuff on the frontend
 */
class Enqueue extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		parent::initialize();

		$scripts = Enqueue::enqueue_scripts();
		foreach( $scripts as $handle => $script ) {
			$script['deps'] = !isset($script['deps']) ? array() : $script['deps'];
			$script['args'] = !isset($script['args']) ? array() : $script['args'];
			wp_enqueue_script( $handle, $script['src'], $script['deps'], ABD_VERSION, $script['args'] );
		}
	}


	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function enqueue_styles() {
		$styles = array();

		return $styles;
	}


	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function enqueue_scripts() {
		$scripts = array();
		return $scripts;
	}


}
