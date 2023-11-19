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

/**
 * Business Field Block of this plugin
 */
class BusinessFieldBlock extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		parent::initialize();

		\add_action( 'init', array( $this, 'register_block' ) );
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

        public function render( $block_attributes, $content ) {
            ob_start();
            var_dump( $block_attributes );
            var_dump( $content );
            return ob_get_clean();
        }

}
