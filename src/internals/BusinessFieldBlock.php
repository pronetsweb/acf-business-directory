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

        public function set_business( Business $business ) {
            $this->_business = $business;
        }

        public function get_business() {
            if( is_null( $this->_business ) ) {
                if( get_the_ID() != false ) {
                    $this->_business = new Business( get_the_ID() );
                }
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
                            'render_callback' => [ $this, 'render' ]
                        ]);
		if( $result === false ) {
			\abd_log( 'FAILED!' );
		}
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

        protected function render_address() {
            $business = $this->get_business();
            include $this->template_file( 'business-address.php' );
        }

        protected function render_hours() {
            $business = $this->get_business();
            include $this->template_file( 'business-hours.php' );
        }

        protected function render_map() {
            $business = $this->get_business();
            include $this->template_file( 'business-map.php' );
        }

        protected function render_photos() {
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
                $this->render_address();
                break;
            case 'hours':
                $this->render_hours();
                break;
            case 'map':
                $this->render_map();
                break;
            case 'photos':
                $this->render_photos();
                break;

            }
            return ob_get_clean();
        }

}
