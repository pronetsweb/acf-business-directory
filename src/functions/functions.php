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

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
function abd_get_settings() {
	return apply_filters( 'abd_get_settings', get_option( ABD_TEXTDOMAIN . '-settings' ) );
}

function abd_google_maps_init() {
	require ABD_PLUGIN_ROOT . 'templates/helpers/google-maps-init.php';
}
