<?php // Taken from example at: https://www.advancedcustomfields.com/resources/google-map/ ?>
<script>
  (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
	key: "<?php echo ACF_BD_GOOGLE_MAPS_BROWSER_API_KEY; ?>",
    v: "weekly",
    // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
    // Add other bootstrap parameters as needed, using camel case.
  });
</script>
<script type="text/javascript">
(function() {
	async function initMap( el ) {
		const { Map } = await google.maps.importLibrary("maps");
		const { Marker } = await google.maps.importLibrary("marker");

		// Find marker elements within map.
		const markers = Array.from(el.childNodes).filter((node) => node.nodeType == Node.ELEMENT_NODE && node.matches('.marker'));

		// Create gerenic map.
		const mapArgs = {
			zoom        : ('zoom' in el.dataset ? parseInt(el.dataset.zoom) : 16),
			mapTypeId   : google.maps.MapTypeId.ROADMAP
		};
		const map = new Map( el, mapArgs );

		// Add markers.
		map.markers = [];
		markers.forEach(function(node){
			initMarker( node, map, Marker );
		});

		// Center map based on markers.
		centerMap( map );

		// Return map instance.
		return map;
	}

	function initMarker( markerElement, map, Marker ) {
		// Get position from marker.
		const lat = markerElement.dataset.lat;
		const lng = markerElement.dataset.lng;
		const latLng = {
			lat: parseFloat( lat ),
			lng: parseFloat( lng )
		};

		// Create marker instance.
		const marker = new Marker({
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
	async function centerMap( map ) {
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
		document.querySelectorAll('.acf-bd-map').forEach(function(mapElement){
			var map = initMap( mapElement );
		});
	});
})();
</script>
