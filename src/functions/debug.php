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

$abd_debug = new WPBP_Debug( __( 'ACF Business Directory', ABD_TEXTDOMAIN ) );

/**
 * Log text inside the debugging plugins.
 *
 * @param string $text The text.
 * @return void
 */
function abd_log( string $text ) {
	if( !isset($GLOBALS['abd_debug']) || !$GLOBALS['abd_debug'] ) {
		return;
	}

	global $abd_debug;
	$abd_debug->log( $text );
}
