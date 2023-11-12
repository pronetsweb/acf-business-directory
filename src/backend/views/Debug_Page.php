<?php
/**
 * Represents the view for the debug page.
 *
 * This page is a holding ground for various test functions & buttons.
 *
 * @package   ACF_Business_Directory
 * @author    Zachary Tarvid-Richey <zr.public@gmail.com>
 * @copyright 2023 Zachary Tarvid-Richey
 * @license   GPL 2.0+
 * @link      https://zachuorice.com
 */
?>

<?php

use ACF_Business_Directory\Internals\Business;

if( isset( $_POST ) && isset( $_POST['debug'] ) ) {
	switch( $_POST['debug'] ) {
		case 'new':
		case 'new_existing':
			$business = new Business();
			$business->set_title( 'New Business Test' );
			$business->set_content( 'Hallo!' );
			$business->set_slug( 'hallo-business' );
			$business->set_address_line_1( '123 Test Street' );
			$business->set_city( 'Placeville' );
			$business->set_state( 'VA' );
			$business->set_hours( [
				[
					'start' => '8:00 am',
					'end' => '6:00 pm',
					'24_hours' => false,
					'days' => ['Mo', 'Tu', 'We']
				]
			] );
			$business->set_status('publish');
			\abd_log(print_r($business->save(), true));
			if( $_POST['debug'] == 'new_existing' ) {
				$business = new Business( $business->get_id() );
				\abd_log('EXISTING: ');
				\abd_log(print_r($business, true));
				\abd_log(print_r($business->get_hours(), true));
				\abd_log($business->get_address_line_1());
				\abd_log($business->get_title());
			}
			break;
		case 'existing':
			// todo
			break;
	}
}

?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<div>
		<h3>Business Model - Test New</h3>
		<form method="POST">
			<input type="hidden" name="debug" value="new" />
			<?php submit_button( 'Test New Business via Model', 'primary', 'submit', false ); ?>
		</form>
	</div>

	<div>
		<h3>Business Model - Test New & Existing</h3>
		<form method="POST">
			<input type="hidden" name="debug" value="new_existing" />
			<?php submit_button( 'Test New + Existing Business via Model', 'primary', 'submit', false ); ?>
		</form>
	</div>

	<div>
		<h3>Business Model - Test Existing</h3>
		<form method="POST">
			<input type="hidden" name="debug" value="existing" />
			<input type="text" name="post_id" value="" />
			<?php submit_button( 'Test Existing Business via Model', 'primary', 'submit', false ); ?>
		</form>
	</div>
</div>