<?php

/**
 * ACF_Business_Directory
 *
 * @package   ACF_Business_Directory
 * @author    Zachary Tarvid-Richey <zr.public@gmail.com>
 * @copyright 2024 Zachary Tarvid-Richey
 * @license   GPL 2.0+
 * @link      https://zachuorice.com
 */

namespace ACF_Business_Directory\Internals;

use ACF_Business_Directory\Engine\Base;
use ACF_Business_Directory\Internals\Business;

/**
 * Code to handle schema changes in Business.
 */
class BusinessMigrations extends Base {
	private static $_business_version = 1;
	private static $_locked_migrations = [];

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	*/
	public function initialize() {
		parent::initialize();

		\add_action( 'save_post_business', array( $this, 'migrate_contacts' ), 10, 3 );
		\add_action( 'save_post_business', array( $this, 'set_version' ), 1000, 3 );
		abd_log( 'Initialized migrations...' );
	}

	private function _in_migration( $callback ) {
		// A tad bit overengineered, but fun!
		$key = debug_backtrace()[1]['function'];
		if(!isset(self::$_locked_migrations[$key])) {
			self::$_locked_migrations[$key] = true;
			call_user_func($callback);
			unset(self::$_locked_migrations[$key]);
		}
	}

	public function get_version( $post_id ) {
		$version = get_post_meta( $post_id, '_business_version', true );
		if( $version === '' ) {
			return 0;
		}
		return $version;;
	}

	public function migrate_contacts( $post_id, $post, $update ) {
		$this->_in_migration( function() use ( $post_id, $post, $update ) {
			if( $this->get_version( $post_id ) === 0 ) {
				$business = new Business( $post_id );
				$email = $business->get_email();
				$phone = $business->get_phone();
				$website = $business->get_website();
				$contacts = [];

				if( $email != '' ) {
					$contacts[] = [
						'type' => 'email',
						'value' => '',
						'value_url' => '',
						'value_email' => $email,
						'custom_label' => ''
					];
				}

				if( $phone != '' ) {
					$contacts[] = [
						'type' => 'phone',
						'value' => $phone,
						'value_url' => '',
						'value_email' => '',
						'custom_label' => ''
					];
				}

				if( $website != '' ) {
					$contacts[] = [
						'type' => 'website',
						'value' => '',
						'value_url' => $website,
						'value_email' => '',
						'custom_label' => ''
					];
				}

				abd_log( 'Migrating contacts...');
				abd_log( print_r( $contacts, true ) );
				$business->set_contacts( $contacts );
				$result = $business->save();
				abd_log( 'Saved? ' . print_r( $result, true ) );
			}
		} );
	}

	public function set_version( $post_id, $post, $update ) {
		update_post_meta( $post_id, '_business_version', self::$_business_version );
	}
}
