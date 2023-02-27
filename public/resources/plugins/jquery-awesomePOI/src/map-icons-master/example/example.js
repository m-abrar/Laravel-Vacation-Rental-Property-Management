function initialise() {
	var mapCanvas = document.getElementById('map-canvas');
	
	// Center
	var center = new google.maps.LatLng(-27.46834, 153.02365);

	// Map Options		
	var mapOptions = {
		zoom: 16,
		center: center,
		scrollwheel: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		styles: [
			{stylers: [{ visibility: 'simplified' }]},
			{elementType: 'labels', stylers: [{ visibility: 'off' }]}
		]
	};
	
	// Create the Map
	map = new google.maps.Map(mapCanvas, mapOptions);

	var marker1 = new mapIcons.Marker({
		map: map,
		position: new google.maps.LatLng(-27.46577, 153.02303),
		icon: {
			path: mapIcons.shapes.SQUARE_PIN,
			fillColor: '#00CCBB',
			fillOpacity: 1,
			strokeColor: '',
			strokeWeight: 0
		},
		map_icon_label: '<span class="map-icon map-icon-point-of-interest"></span>'
	});
	
	var marker2 = new mapIcons.Marker({
		map: map,
		position: new google.maps.LatLng(52.557309, 13.618357),
		icon: {
			path: mapIcons.shapes.ROUTE,
			fillColor: '#1998F7',
			fillOpacity: 1,
			strokeColor: '',
			strokeWeight: 0
		},
		map_icon_label: '<span class="map-icon map-icon-transit-station"></span>'
	});
	
	var marker3 = new mapIcons.Marker({
		map: map,
		position: new google.maps.LatLng(-27.46870, 153.02335),
		icon: {
			path: mapIcons.shapes.MAP_PIN,
			fillColor: '#6331AE',
			fillOpacity: 1,
			strokeColor: '',
			strokeWeight: 0
		},
		map_icon_label: '<span class="map-icon map-icon-city-hall"></span>'
	});
	
	var marker4 = new mapIcons.Marker({
		map: map,
		position: new google.maps.LatLng(-27.46900, 153.02009),
		icon: {
			path: mapIcons.shapes.SQUARE_ROUNDED,
			fillColor: '#6331AE',
			fillOpacity: 1,
			strokeColor: '',
			strokeWeight: 0
		},
		map_icon_label: '<span class="map-icon map-icon-courthouse"></span>'
	});
	
	var marker5 = new mapIcons.Marker({
		map: map,
		position: new google.maps.LatLng(-27.46904, 153.02754),
		icon: {
			path: mapIcons.shapes.SQUARE,
			fillColor: '#00CCBB',
			fillOpacity: 1,
			strokeColor: '',
			strokeWeight: 0
		},
		map_icon_label: '<span class="map-icon map-icon-grocery-or-supermarket"></span>'
	});
	
	var marker6 = new mapIcons.Marker({
		map: map,
		position: new google.maps.LatLng(-27.47167, 153.02580),
		icon: {
			path: mapIcons.shapes.SHIELD,
			fillColor: '#6331AE',
			fillOpacity: 1,
			strokeColor: '',
			strokeWeight: 0
		},
		map_icon_label: '<span class="map-icon map-icon-police"></span>'
	});
};

google.maps.event.addDomListener(window, 'load', initialise);