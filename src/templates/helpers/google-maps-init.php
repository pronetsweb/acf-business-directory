<?php // Taken from example at: https://www.advancedcustomfields.com/resources/google-map/ ?>
<?php // TODO: Move to own script / styles that are dynamically loaded. ?>
<?php if(!ACF_Business_Directory\Internals\BusinessFieldBlock::is_map_script_initialized()): ?>
<style type="text/css">
.acf-map {
    width: 100%;
    height: 400px;
    border: #ccc solid 1px;
    margin: 20px 0;
}

// Fixes potential theme css conflict.
.acf-map img {
   max-width: inherit !important;
}
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr(ACF_BD_GOOGLE_MAPS_BROWSER_API_KEY); ?>&callback=Function.prototype"></script>
<script type="text/javascript">
(function() {
	function initMap( el ) {

		// Find marker elements within map.
		const markers = Array.from(el.childNodes).filter((node) => node.nodeType == Node.ELEMENT_NODE && node.matches('.marker'));

		// Create gerenic map.
		const mapArgs = {
			zoom        : ('zoom' in el.dataset ? parseInt(el.dataset.zoom) : 16),
			mapTypeId   : google.maps.MapTypeId.ROADMAP
		};
		const map = new google.maps.Map( el, mapArgs );

		// Add markers.
		map.markers = [];
		markers.forEach(function(node){
			initMarker( node, map );
		});

		// Center map based on markers.
		centerMap( map );

		// Return map instance.
		return map;
	}

	function initMarker( markerElement, map ) {

		// Get position from marker.
		const lat = markerElement.dataset.lat;
		const lng = markerElement.dataset.lng;
		const latLng = {
			lat: parseFloat( lat ),
			lng: parseFloat( lng )
		};

		// Create marker instance.
		const marker = new google.maps.Marker({
			position : latLng,
			map: map
		});

		// Append to reference for later use.
		map.markers.push( marker );

		// If marker contains HTML, add it to an infoWindow.
		if( markerElement.inneerHTML != '' ){

			// Create info window.
			var infowindow = new google.maps.InfoWindow({
				content: markerElement.innerHTML
			});

			// Show info window when marker is clicked.
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open( map, marker );
			});
		}
	}

	/**
	 * centerMap
	 *
	 * Centers the map showing all markers in view.
	 *
	 * @date    22/10/19
	 * @since   5.8.6
	 *
	 * @param   object The map instance.
	 * @return  void
	 */
	function centerMap( map ) {

		// Create map boundaries from all map markers.
		var bounds = new google.maps.LatLngBounds();
		map.markers.forEach(function( marker ){
			bounds.extend({
				lat: marker.position.lat(),
				lng: marker.position.lng()
			});
		});

		// Case: Single marker.
		if( map.markers.length == 1 ){
			map.setCenter( bounds.getCenter() );

		// Case: Multiple markers.
		} else{
			map.fitBounds( bounds );
		}
	}

	// Render maps on page load.
	addEventListener("DOMContentLoaded", function() {
		document.querySelectorAll('.acf-map').forEach(function(mapElement){
			var map = initMap( mapElement );
		});
	});
})();
</script>
<?php ACF_Business_Directory\Internals\BusinessFieldBlock::set_map_script_initialized(true); ?>
<?php endif; ?>
