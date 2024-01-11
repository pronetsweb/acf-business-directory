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

namespace ACF_Business_Directory\Internals;

use ACF_Business_Directory\Engine\Base;
use ACF_Business_Directory\Internals\Business;

/**
 * Business Field Block of this plugin
 */
class BusinessFieldBlock extends Base {

	protected static bool $_map_script_initialized = false;
	protected ?Business $_business = null;

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	*/
	public function initialize() {
		parent::initialize();

		\add_action( 'init', array( $this, 'register_block' ) );
	}

	public static function is_map_script_initialized() {
		return self::$_map_script_initialized;
	}

	public static function set_map_script_initialized() {
		self::$_map_script_initialized = true;
	}

	public function set_business( Business $business ) {
		$this->_business = $business;
	}

	public function get_business() {
		if ( get_the_ID() != false && ( is_null( $this->_business) || get_the_ID() != $this->_business->get_id() ) ) {
			$this->_business = new Business( get_the_ID() );
		} else if ( get_the_ID() === false ) {
			$this->_business = null;
		}
		return $this->_business;
	}

	/**
	 * Registers and enqueue the block assets
	 *
	 * @since 1.0.0
	 * @return void
	*/
	public function register_block() {
		// Register the block by passing the location of block.json to register_block_type.
		$json = \ABD_PLUGIN_ROOT . 'assets/build/business-field';
		\abd_log( \ABD_PLUGIN_ROOT );

		\abd_log( 'Registering Block: ' . $json );
		$result = \register_block_type( $json,
			[
				'render_callback' => [ $this, 'render' ],
				'title' => __('Business Field', 'acf-business-directory')
			]);
		if( $result === false ) {
			\abd_log( 'FAILED!' );
		}
	}

	/* Check if we're rendering in Gutenberg editor - https://wordpress.stackexchange.com/a/343592 */
	protected function is_in_editor() {
		return defined( 'REST_REQUEST' ) && REST_REQUEST;
	}

	protected function template_file( $filename ) {
		$theme_file = get_stylesheet_directory() . '/acf-business-directory/' . $filename;
		$builtin_file = \ABD_PLUGIN_ROOT . 'templates/' . $filename;
		if( is_file( $theme_file ) ) {
			return $theme_file;
		} else {
			return $builtin_file;
		}
	}

	protected function render_contact($content, $field) {
		$business = $this->get_business();
		$value = '';
		switch( $field ) {
			case 'email':
				$value = $business->get_email();
				break;
			case 'phone':
				$value = $business->get_phone('view');
				$link = $business->try_make_phone_link();
				break;
			case 'website':
				$value = $business->get_website();
				break;
			case 'socials':
				$value = false;
				break;
		}
		include $this->template_file( 'business-contact.php' );
	}

	protected function render_address($content) {
		$business = $this->get_business();
		include $this->template_file( 'business-address.php' );
	}

	protected function render_hours($content) {
		$business = $this->get_business();
		$hours_sets = $business->get_hours();
		$has_hours = false;

		// Sort and group the hours for display, Mo - Su.
		$sorted_hours = [
			'Mo' => [],
			'Tu' => [],
			'We' => [],
			'Thu' => [],
			'Fri' => [],
			'Sat' => [],
			'Sun' => []
		];

		foreach( $hours_sets as $hours_set ) {
			$has_hours = true;
			if( $hours_set['24_hours'] ) {
				foreach( $hours_set['days'] as $day ) {
					$sorted_hours[$day['value']] = [
						'all_day' => true,
						'start' => [],
						'end' => []
					];
				}
			} else {
				foreach( $hours_set['days'] as $day ) {
					if( !isset( $sorted_hours[$day['value']] ) || $sorted_hours[$day['value']] == [] ) {
						$sorted_hours[$day['value']] = [
							'all_day' => false,
							'start' => [],
							'end' => []
						];
					}

					if( !$sorted_hours[$day['value']]['all_day'] ) {
						$sorted_hours[$day['value']]['start'][] = $hours_set['start'];
						$sorted_hours[$day['value']]['end'][] = $hours_set['end'];
					}
				}
			}
		}
		include $this->template_file( 'business-hours.php' );
	}

	protected function render_map($content) {
		$business = $this->get_business();
		include $this->template_file( 'business-map.php' );
	}

	protected function render_photos($content) {
		$business = $this->get_business();
		include $this->template_file( 'business-photos.php' );
	}

	public function render( $block_attributes, $content ) {
		if( !isset( $block_attributes['select_field'] ) || empty( $block_attributes['select_field'] ) ) {
			$block_attributes['select_field'] = 'address';
		}

		ob_start();
		switch( $block_attributes['select_field'] ) {
			case 'address':
				$this->render_address($content);
				break;
			case 'hours':
				$this->render_hours($content);
				break;
			case 'map':
				$this->render_map($content);
				break;
			case 'photos':
				$this->render_photos($content);
				break;
			case 'email':
			case 'phone':
			case 'website':
			case 'socials':
				$this->render_contact($content, $block_attributes['select_field']);
				break;
		}
		return '<div class="wp-block-business-field wp-block-business-field-' . $block_attributes['select_field'] . '">' . ob_get_clean() . '</div>';
	}

}
