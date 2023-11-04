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

namespace ACF_Business_Directory\Engine;

/**
 * Base skeleton of the plugin
 */
class Base {
	/**
	 * @var array The settings of the plugin.
	 */
	public $settings = array();

	/**
	 * Initialize the class and get the plugin settings
	 *
	 * @return bool
	 */
	public function initialize() {
		$this->settings = \abd_get_settings();

		return true;
	}

}
