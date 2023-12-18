<div class="map">
<?php if( defined('ACF_BD_GOOGLE_MAPS_API_KEY') && defined('ACF_BD_GOOGLE_MAPS_BROWSER_API_KEY') ) : ?>
<?php require_once "./helpers/google-maps-init.php"; ?>
<?php
$location = $business->get_business_location();
if( $location ): ?>
    <div class="acf-map" data-zoom="16">
		<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
			<?php echo apply_filters('acf_bd_business_map_marker_html', esc_html($business->get_title())); ?>
		</div>
    </div>
<?php endif; ?>
<?php elseif defined('ACF_BD_OSM_API_KEY') : ?>
	<?php // TODO ?>
<?php endif; ?>
</div>
