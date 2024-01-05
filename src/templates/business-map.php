<?php if( defined('ACF_BD_GOOGLE_MAPS_API_KEY') && defined('ACF_BD_GOOGLE_MAPS_BROWSER_API_KEY') ) : ?>
	<?php if ( $this->is_in_editor() ): ?>
		<p>Map Will Appear Here.</p>
	<?php else: ?>
		<?php require_once "helpers/google-maps-init.php"; ?>
		<?php
		$location = $business->get_business_location();
		ob_start();
		?>
<p><strong><?php echo apply_filters('acf_bd_business_map_marker_title', esc_html($business->get_title())); ?></strong></p>
<p><?php echo apply_filters('acf_bd_business_map_marker_excerpt', esc_html($business->get_excerpt())); ?></p>
		<?php
		$marker_html = ob_get_clean();

		if( $location ): ?>
			<?php echo $content; ?>
			<div class="acf-bd-map" data-zoom="16">
				<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
					<?php echo apply_filters('acf_bd_business_map_marker_html', $marker_html); ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endif ;?>
<?php elseif ( defined('ACF_BD_OSM_API_KEY') ) : ?>
		<?php // TODO ?>
<?php endif; ?>
