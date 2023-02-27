/*
 *  awesomePOI - v1.0
 *  A jump-start for jQuery plugins development.
 *  http://jqueryboilerplate.com
 *
 *  Made by Jan Skwara
 *  License: https://codecanyon.net/licenses/terms/regular
 */

 
;( function( $, window, document, undefined ) {

	"use strict";
		var jsFileLocation = $('script[src*="jquery.awesomePOI"]').attr('src');  // the js file path
		jsFileLocation = jsFileLocation.replace(/jquery\.awesomePOI\.js.*$/, '');
		
		//plugin name nad default settings
		var pluginName = "awesomePOI",
			defaults = {
				
				filterClass: 'apoi-filter',
				start: 'point', //point, type or both
				startTypes: '',
				startPointIcon: jsFileLocation + 'icons/icon-pin1-blue.png',
				startTypesIcon: jsFileLocation + 'icons/icon-pin1-red.png',
				address: '',
				pyrmont: {lat: 40.718941, lng: -73.994594},
				radius: 500,
				streetView: true,
				switchStreetClass: 'apoi-switch-street',
				switchMapClass: 'apoi-switch-map',
				autocomplete: true,
				autocompleteId: 'apoi-autocomplete',
				userLocation: true,				
				userLocationId: 'apoi-geolocation',
				routeMode: true,
				modeName: 'apoi-mode',
				placesList: true,
				placesListId: 'apoi-list',
				placeDetails: true,
				placeDetailsId: 'apoi-details-container',
				routeTime: true,
				routeTimeId: 'apoi-route-time',
				route: true,
				routeId: 'apoi-route',
				multiple: true,
				iconSize: 'large',
				iconType: 'pin1',
				iconColor: 'blue',
				kmlFile: '',
				geoJOSNFile: '',
				jsonFile: '',				
				cluster: true,
				clusterIcon: jsFileLocation + 'icons/pin-empty.png',
				zoom: 16,
				wheelScroll: false,
				debug: false,
				mapStyle: false,
				
				onMapInit: function( map ) { console.log( 'onMapInit ' + map ); },
				onAfterSearch: function() { console.log( 'onAfterSearch' ); },
				onAfterSearchJSON: function() { console.log( 'onAfterSearchJSON' ); },
				onDetailsShow: function( place ) { console.log( 'onDetailsShow ' +  place ); },
				onAfterRoute: function( route ) { console.log( 'onAfterRoute ' + route ); },
				onGeolocation: function( geolocation ) { console.log( 'onGeolocation ' +  geolocation ); },
				onAutocomplete: function( loc ) { console.log( 'onAutocomplete ' + loc ); },
				onModeChange: function( mode ) { console.log( 'onModeChange ' + mode ); },
			};
			
		//global variables
		var map;    
		var infowindow;
		var service;
		var markersArray = [];
		var clusteredMarkers = [];	 
		var placeId;
		var random = Math.floor( ( Math.random() * 1000000 ) + 1 );
		var mapID = 'apoi-map' + random;
		var streetID = 'apoi-street-view' + random;
		var detailsStreetID = 'apoi-details-street-view' + random;
		var listBar;
		var detailsBar;
		
		var jsonArray = {};
		var placesArray = {};
		var currentIconImg = null;
		var currentIconFont = null;
		var currentColor = null;
		var currentStroke = null;
		var directionsService = new google.maps.DirectionsService;
		var directionsDisplay;
		var bound = new google.maps.LatLngBounds();
		var sv = new google.maps.StreetViewService();
		var sv = new google.maps.StreetViewService();
		

		var pl;
		
		// The actual plugin constructor
		function Plugin ( element, options ) {
			this.element = element;
			this.settings = $.extend( {}, defaults, options, $( this.element ).data() );
			this._defaults = defaults;
			this._name = pluginName;
			this.init();
		}

		// Avoid Plugin.prototype conflicts
		$.extend( Plugin.prototype, {
			init: function() {
				pl = this;
				
				if( pl.settings.start === 'point' || !pl.settings.startTypes ) {
					$( "#" + pl.settings.placesListId ).hide();
				}
				$( "#" + pl.settings.placeDetailsId ).hide();
				$( "#" + pl.settings.routeTimeId ).hide();
				$( "input[name='apoi-mode']" ).hide();
				$( "input[name='apoi-mode'] + label" ).hide();

				this.createMarkup();
				if( this.settings.placeDetails === true && this.settings.placeDetailsId && $( "#" + this.settings.placeDetailsId ).length && this.settings.route === true && this.settings.start !== 'type' ) {
					directionsDisplay = new google.maps.DirectionsRenderer({ polylineOptions:{strokeColor:"#3797dd",strokeWeight:5}, suppressMarkers:true, panel: document.getElementById( 'apoi-route' ) });
				} else {
					directionsDisplay = new google.maps.DirectionsRenderer({ polylineOptions:{strokeColor:"#3797dd",strokeWeight:5}, suppressMarkers:true });					
				}
				
				if( this.settings.placeDetails === true && this.settings.placeDetailsId && !$( "#" + this.settings.placeDetailsId ).length ) {
					pl.debugLog( 'Missing: ' + "#" + this.settings.placeDetailsId );
				}
				
				this.mapInit();
				this.mapStartData();
				if( this.settings.streetView === true && $('#' + this.settings.switchStreetClass ).length && $('#' + this.settings.switchMapClass ).length ) {
					this.streetViewInit();
				} else if( this.settings.streetView === true ) {
					pl.debugLog( 'Element missing: #' + this.settings.switchStreetClass + ' or #' + this.settings.switchMapClass );
				} else {
					$('#' + this.settings.switchStreetClass ).hide();
				}
				
				if( this.settings.autocomplete === true && this.settings.autocompleteId && $( "#" + this.settings.autocompleteId ).length ) {          
					this.autocompleteInit(); 
				} else if( this.settings.autocomplete === true ) {
					pl.debugLog( 'Missing: ' + "#" + this.settings.autocompleteId );
				}
				
				if( this.settings.jsonFile ) {          
					this.processJSON( this.settings.jsonFile ); 
				}							
			  
				if( this.settings.kmlFile ) {
					this.addKML( this.settings.kmlFile );
				}
				if( this.settings.geoJOSNFile ) {
					map.data.loadGeoJson( this.settings.geoJOSNFile );
				}
				
				$('.' + this.settings.filterClass ).click( function() {
					
					var types = new Array();
					if( pl.settings.multiple ) {
						if( $(this).hasClass( 'selected' ) ) {
							$(this).removeClass( 'selected' );
						} else {
							$(this).addClass( 'selected' );
						}						
						$('.' + pl.settings.filterClass + '.selected').each( function() {
							var currType = { 'type': $(this).data('types'), 'icon': $(this).data('icon-img'), 'font': $(this).data('icon-font'), 'source': $(this).data('source') };
							types.push(currType);
						});
					} else {
						var currType = { 'type': $(this).data('types'), 'icon': $(this).data('icon-img'), 'font': $(this).data('icon-font'), 'source': $(this).data('source') };
						types.push(currType);
					}

					directionsDisplay.setDirections( { routes: [] } );
					if( types ) {
						$( "#" + pl.settings.placesListId ).show();
					} else {
						$( "#" + pl.settings.placesListId ).hide();						
					}
					$( "#" + pl.settings.placeDetailsId ).hide();
					$( "#" + pl.settings.routeTimeId ).hide();
					$( "input[name='" + pl.settings.modeName + "']" ).hide();
					$( "input[name='" + pl.settings.modeName + "'] + label" ).hide();

					pl.processNearby( $(this), types ); 
				});
				
				if( this.settings.streetView === true ) {
					if( !$('#' + this.settings.switchStreetClass ).length || !$('#' + this.settings.switchMapClass ).length ) {
						pl.debugLog( 'Element missing: #' + this.settings.switchStreetClass + 'or #' + this.settings.switchMapClass );
					} else {
						$('#' + this.settings.switchStreetClass ).click( function(e) {
							e.preventDefault();
							$('#' + streetID ).css( 'left', '0px' );
							$('#' + pl.settings.switchMapClass ).css( 'display', 'block' );
							$('#' + pl.settings.switchStreetClass ).css( 'display', 'none' );
						});
						
						$('#' + this.settings.switchMapClass ).click( function(e) {
							e.preventDefault();
							$('#' + streetID ).css( 'left', '-100%' );
							$('#' + pl.settings.switchMapClass ).css( 'display', 'none' );
							$('#' + pl.settings.switchStreetClass ).css( 'display', 'block' );
						});
					}
				}
				
				//Click event that display Place Details
				$(document).on( 'click', '.apoi-short-details', function(e){
					e.preventDefault();
					placeId = $(this).data('place-id');
					if( pl.settings.placeDetails === true && pl.settings.placeDetailsId && $( "#" + pl.settings.placeDetailsId ).length ) {
						service.getDetails( { placeId: placeId }, pl.detailsCallback );
					} else if( pl.settings.placeDetails === true ) {
						pl.debugLog( 'Missing: ' + "#" + pl.settings.placeDetailsId );
					}
					
					pl.calculateAndDisplayRoute(directionsService, directionsDisplay, placeId );

					
				} );
				
				//Click event that display Place Details for JSON file
				$(document).on( 'click', '.apoi-short-details-json', function(e){
					e.preventDefault();
					placeId = $(this).data('place-id');
					var thisType = $(this).data('place-type');
					if( pl.settings.placeDetails === true && pl.settings.placeDetailsId && $( "#" + pl.settings.placeDetailsId ).length ) {
						
							for (var j = 0, k = jsonArray[ thisType ].items.item.length; j < k; j++) {
								var item = jsonArray[ thisType ].items.item[ j ];
								if( placeId == item.lat.replace('.','') + item.lng.replace('.','')) {
									pl.detailsCallbackJSON( item );
									var loc = new google.maps.LatLng(item.lat, item.lng);
									pl.calculateAndDisplayRoute(directionsService, directionsDisplay, loc );
								}
							}
	
						
					} else if( pl.settings.placeDetails === true ) {
						pl.debugLog( 'Missing: ' + "#" + pl.settings.placeDetailsId );
					}
				
					
				} );
				
				
				//Change event that changes transport mode for route display
				if( this.settings.routeMode === true && this.settings.modeName && $('input[name="' + this.settings.modeName + '"]').length ) {
					$('input[name="' + this.settings.modeName + '"]').change( function(e) {
						e.preventDefault();
						
						pl.calculateAndDisplayRoute( directionsService, directionsDisplay, placeId );
						pl.settings.onModeChange( $( 'input[name="' + pl.settings.modeName + '"]:checked' ).val() );
					});
				} else if( this.settings.routeMode === true ) {
					pl.debugLog( 'Missing: input[name="' + this.settings.modeName + '"]' );
				}
				
				//Click event that findes currrent location (geolocation)
				if( this.settings.userLocation === true && this.settings.userLocationId && $( "#" + this.settings.userLocationId ).length ) {
					$('#' + this.settings.userLocationId ).click( function(e) {
						e.preventDefault();
						pl.geoLocation();
					});
				} else if( this.settings.userLocation === true ) {
						pl.debugLog( 'Missing: ' + "#" + this.settings.userLocationId );
					}
				
				//Click event that scrolls details to the route.
				$( '#apoi-route-link' ).click( function(e) {					
					$( '#' + pl.settings.placeDetailsId ).animate({						
						scrollTop: $( '#apoi-route' ).offset().top - $( '#' + pl.settings.placeDetailsId ).offset().top + $( '#' + pl.settings.placeDetailsId ).scrollTop()
					}, 1000 );
				});
				
				//Click event that hide details container
				$( '.details-hide' ).click( function(e) {					
					$( '#' + pl.settings.placeDetailsId ).hide( 750 );
				});
				
				//Click event that hide list container
				$( '.list-hide' ).click( function(e) {					
					$( '#' + pl.settings.placesListId ).hide( 750 );
				});
	  
			},
			
			/**
			* Initializes the map and other required objects
			* 
			*/
			mapInit: function() {

				map = new google.maps.Map( document.getElementById( mapID ), {
					center: this.settings.pyrmont,
					zoom: this.settings.zoom,
					scrollwheel: this.settings.wheelScroll,
					styles: this.settings.mapStyle,
					mapTypeControl: true,
					mapTypeControlOptions: {
						style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
						position: google.maps.ControlPosition.BOTTOM_CENTER
					},
					zoomControl: true,
					zoomControlOptions: {
						position: google.maps.ControlPosition.LEFT_CENTER
					},
					scaleControl: true,
					streetViewControl: false,
					fullscreenControl: false

				});	
				if( this.settings.start !== 'type' ) {
					directionsDisplay.setMap( map );
				}
				
				var offset = 60;			
				if( this.settings.iconSize == 'medium' ) {
					offset = 48;
				} else if( this.settings.iconSize == 'small' ) {
					offset = 36;
				}
				infowindow = new google.maps.InfoWindow( { pixelOffset: new google.maps.Size(0, -offset ) } );
				service = new google.maps.places.PlacesService( map );
				
				
				
			},
			
			/**
			* Creates required HTML markup
			* 
			*/
			createMarkup: function() {
				if( this.settings.streetView === true ) {
					var add = '<div id="' + mapID + '" class="apoi-map"></div><div id="' + streetID + '" class="apoi-street-view"></div>';
				} else {
					var add = '<div id="' + mapID + '" class="apoi-map"></div>';
				}
				$( this.element ).html( add );
				
				var route = '';
				if( this.settings.route === true ) {
					route = '<a href="#" id="apoi-route-link"><span class="apoi-map-icon map-icon-location-arrow"></span></a>'
				}
				
				if( this.settings.placeDetails === true && this.settings.placeDetailsId && $( "#" + this.settings.placeDetailsId ).length ) {
					$('#' + this.settings.placeDetailsId ).html('<div class="apoi-place-image"></div><div class="details-hide"><span class="apoi-map-icon map-icon-zoom-in"></span></div><div class="apoi-place-name"><h4></h4><span></span>' + route + '</div><div class="apoi-place-address"></div><div class="apoi-place-phone"></div><div class="apoi-place-web"></div><div class="apoi-place-hours"></div><div class="apoi-place-photos"></div><div id="' + detailsStreetID + '" class="apoi-place-street-view"></div><div class="apoi-place-reviews"></div><div id="apoi-route"></div>' );					
				} else if( this.settings.placeDetails === true ) {
					pl.debugLog( 'Missing: ' + "#" + this.settings.placeDetailsId );
				}
				if( this.settings.placesList === true && this.settings.placesListId && $( "#" + this.settings.placesListId ).length ) {
					$('#' + this.settings.placesListId ).html('<div class="list-hide"><span class="apoi-map-icon map-icon-zoom-in"></span></div><div class="apoi-list-inner"></div>' );					
				} else if( this.settings.placesList === true ) {
					pl.debugLog( 'Missing: ' + "#" + this.settings.placesListId );
				}			
				
				listBar = $('#' + this.settings.placesListId ).niceScroll( {horizrailenabled: false, cursoropacitymax: 0.8, cursorcolor:"#636363",cursorwidth:"14px",cursorborder: "4px solid transparent",cursorborderradius:14} );
				detailsBar = $('#' + this.settings.placeDetailsId ).niceScroll( {horizrailenabled: false, cursoropacitymax: 0.8, cursorcolor:"#636363",cursorwidth:"14px",cursorborder: "4px solid transparent",cursorborderradius:14} );
				
			},
			
			/**
			* Filling a map with starting data
			* 
			*/
			mapStartData: function() {
				if ( ( this.settings.start === 'point' || this.settings.start === 'both' ) && this.settings.address ) {
						var geocoder = new google.maps.Geocoder();
						geocoder.geocode({
							'address': pl.settings.address
							}, 
							function( results, status ) {
								if( status == google.maps.GeocoderStatus.OK ) {
									pl.settings.pyrmont = results[0].geometry.location;
									
									var startMarker = new google.maps.Marker({
									position: pl.settings.pyrmont,
									map: map,
									title: '',
										icon: pl.settings.startPointIcon		
									});
									map.setCenter( pl.settings.pyrmont );
								}
							});
				}
				else if( ( this.settings.start === 'point' || this.settings.start === 'both' ) && this.settings.pyrmont ) {
					var startMarker = new google.maps.Marker({
					position: this.settings.pyrmont,
					map: map,
					title: '',
						icon: this.settings.startPointIcon		
					});
				}
				if( ( this.settings.start === 'type' || this.settings.start === 'both' ) && this.settings.startTypes ) {   
					var typeArray = this.settings.startTypes.split( ',' );
					currentIconImg = this.settings.startTypesIcon;
					for (var i = 0, len = typeArray.length; i < len; i++ ) {
						this.nearbyPlaceSearch( typeArray[ i ] );
					}
				}
				this.settings.onMapInit( map );
			},
			
			/**
			* Initializes the autocomplete filed and add a listner to this field.
			* 
			*/
			autocompleteInit: function() {
				var input = document.getElementById( this.settings.autocompleteId );
				var autocomplete = new google.maps.places.Autocomplete( input );

				autocomplete.addListener( 'place_changed', function() {
		 
					var place = autocomplete.getPlace();
					placeId = place.geometry.location;
					pl.calculateAndDisplayRoute( directionsService, directionsDisplay, placeId );
					pl.settings.onAutocomplete( place );
				});
			},
			
			/**
			* Process Google Nearby Search for the given place type
			* 
			*@param String placeType place type accepted by the Google
			*
			*/
			nearbyPlaceSearch: function( placeType, iconImg, iconFont ) {
				
				service.nearbySearch({
				location: this.settings.pyrmont,
				radius: this.settings.radius,
				
				type: [placeType]
				}, function (results, status) { pl.callback(results, status, iconImg, iconFont ); });
			},
			
			/**
			* Callback function fired after Nearby Place Search
			* 
			*@param Object results search result
			*@param PlacesServiceStatus status status of the search
			*
			*/
			callback: function( results, status, iconImg, iconFont ) {

				if ( status === google.maps.places.PlacesServiceStatus.OK ) {
					for ( var i = 0; i < results.length; i++ ) {

						pl.createMarker( results[ i ], iconImg, iconFont );
						if( pl.settings.cluster === true ) {
							var markerClusterStyle = [{
								url: pl.settings.clusterIcon,
								height: 60,
								width: 60,
								textSize: 16,
								textColor: "#5a5f66"
							}];	
						}
						if( pl.settings.placesList === true && pl.settings.placesListId && $( "#" + pl.settings.placesListId ).length ) {
							pl.displayShortDetails( results[i] );
						} else if( pl.settings.placesList === true ) {
							pl.debugLog( 'Missing: ' + "#" + pl.settings.placesListId );
						}
					}
					map.fitBounds(bound);
					if( pl.settings.cluster === true ) {
						var markerCluster = new MarkerClusterer( map, markersArray, { styles: markerClusterStyle } );
						clusteredMarkers.push( markerCluster );
						var minClusterZoom = 16;
						markerCluster.setMaxZoom( minClusterZoom );
					}

				} else {
					pl.debugLog('PlacesServiceStatus: ' + status);
				}
			},
			
			/**
			* Callback function fired after place details request
			* 
			*@param Object place detailed place object
			*@param PlacesServiceStatus status status of the search
			*
			*/
			detailsCallback: function( place, status ) {
	
				if ( status == google.maps.places.PlacesServiceStatus.OK ) {
					
					$( "#" + pl.settings.placeDetailsId ).show();
					$( "#" + pl.settings.routeTimeId ).show();
					$( "input[name='" + pl.settings.modeName + "']" ).show();
					$( "input[name='" + pl.settings.modeName + "'] + label" ).show();
					

					var stars = Math.round( place.rating * 2 ) / 2;
					var full = Math.round( place.rating );
					var half = stars - full > 0 ? 1 : 0;
					var empty = 5 - full - half;
					var rank = '';
					for( var i = 0; i < full; i++ ) {
						rank += '<span class="apoi-rank-full2"></span>';
					}
					if( half ) {
						rank += '<span class="apoi-rank-half2"></span>';
					}
					for( var i = 0; i < empty; i++ ) {
						rank += '<span class="apoi-rank-empty2"></span>';
					}
					
					if( typeof place.photos !== 'undefined' && place.photos.length > 0 ) {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-image' ).html( '<img src="' + place.photos[ 0 ].getUrl({ 'maxWidth': 340 }) + '" />' );
					} else {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-image' ).html( '' );
					}
					if( typeof place.name !== 'undefined' && place.name ) { 
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name h4' ).html( place.name );
					} else {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name h4' ).html( '' );
					}
					if( typeof place.rank !== 'undefined' && place.rank ) { 
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name > span' ).html( rank );
					} else {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name > span' ).html( '' );
					}
					if( typeof place.formatted_address !== 'undefined' && place.formatted_address ) { 
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-address' ).html( place.formatted_address );
					} else {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-address' ).html( '' );
					}
					if( typeof place.formatted_phone_number !== 'undefined' && place.formatted_phone_number ) { 
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-phone' ).html( '<a href="tel:' + place.formatted_phone_number + '">' + place.formatted_phone_number + '</a>' );
					} else {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-phone' ).html( '' );
					}
					if( typeof place.website !== 'undefined' && place.website ) { 
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-web' ).html( '<a href="' + place.website + '" target="blank">' + place.website + '</a>');
					} else {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-web' ).html( '' );
					}
					var photos = '';
					
					//JOSN
					if( typeof place.photos !== 'undefined' && typeof place.photos.url !== 'undefined' && place.photos.url.length > 0 ) {
						for( var i = 0; i < ( place.photos.url.length > 5 ? 6 : place.photos.url.length ); i++ ) {
							photos += '<div><img src="' + place.photos.url[ i ] + '" /></div>';
						}	
					//GOOGLE
					} else if( typeof place.photos !== 'undefined' && place.photos.length > 0 ) {
						for( var i = 0; i < ( place.photos.length > 5 ? 6 : place.photos.length ); i++ ) {
							photos += '<div><img src="' + place.photos[ i ].getUrl({ 'maxWidth': 340 }) + '" /></div>';
						}				
					}
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-photos' ).html( photos );
					
					var reviews = '';
					if( typeof place.reviews !== 'undefined' && place.reviews.length > 0 ) {
						for( var i = 0; i < ( place.reviews.length > 2 ? 3 : place.reviews.length ); i++ ) {
							var stars2 = Math.round( place.reviews[i].rating * 2 ) / 2;
							var full2 = Math.round( place.reviews[i].rating );
							var half2 = stars2 - full2 > 0 ? 1 : 0;
							var empty2 = 5 - full2 - half2;
							var rank2 = '';
							for( var j = 0; j < full2; j++ ) {
								rank2 += '<span class="apoi-rank-full"></span>';
							}
							if( half2 ) {
								rank2 += '<span class="apoi-rank-half"></span>';
							}
							for( var j = 0; j < empty2; j++ ) {
								rank2 += '<span class="apoi-rank-empty"></span>';
							}
							reviews += '<div class="apoi-review"><h4>' + place.reviews[i].author_name + '</h4><span>' + rank2 + '<span class="apoi-review-date">' + place.reviews[i].relative_time_description + '</span></span><p>' + place.reviews[i].text + '</p></div>';
						}						
					}
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-reviews' ).html( reviews );										
					
					pl.detailsStreetViewInit( place.geometry.location );
					
					
					pl.settings.onDetailsShow( place.geometry.location );
				} else {
					pl.debugLog('PlacesServiceStatus: ' + status);
				}
				
			},
			
			/**
			* Displays details of the Google Place
			* 
			*@param Object place Google Place object
			*
			*/
			displayShortDetails: function( place ) {

				var stars = Math.round( place.rating * 2 ) / 2;
				var full = Math.round( place.rating );
				var half = stars - full > 0 ? 1 : 0;
				var empty = 5 - full - half;
				
				var rank = '';
				for( var i = 0; i < full; i++ ) {
					rank += '<span class="apoi-rank-full"></span>';
				}
				if( half ) {
					rank += '<span class="apoi-rank-half"></span>';
				}
				for( var i = 0; i < empty; i++ ) {
					rank += '<span class="apoi-rank-empty"></span>';
				}
				var photo = '';
				if( ( place.photos ) ) {
					photo = '<img src="' + place.photos[ 0 ].getUrl({ 'maxWidth': 170 }) + '" alt="' + place.name + '" /></div>';
				}
				$('#' + this.settings.placesListId + ' .apoi-list-inner' ).append( '<div id="' + place.place_id + '" class="apoi-short-details" data-place-id="' + place.place_id + '"><div class="apoi-short-left"><h4>' + place.name + '</h4><address>' + place.vicinity + '</address><span class="apoi-rank">' + rank + '</span></div><div class="apoi-details-photo">' + photo + '</div></div>' );
				listBar.resize();
			},
			
			
			/**
			* Creates a marker on the map
			* 
			*@param Object place Google Place object
			*
			*/
			createMarker: function( place, iconImg, iconFont ) {
				var currentIcon;

				if( iconImg ) {
					currentIcon = iconImg;
					var label = '';
				} else {
					if( iconFont ) {
						var iconText = iconFont;
						currentIcon = {
							path: '',
							scale: 0.8,
							fillColor: '#ffffff',
							fillOpacity: 0,
							strokeColor: '#ffffff',
							strokeWeight: 0
						};
						var label = '';
					} else {
						var currentPlaceTypes = place[ 'types' ][ 0 ];
						if( currentPlaceTypes == 'shoe_store' ) {
							currentPlaceTypes = 'convenience_store';
						} else if( currentPlaceTypes == 'home_goods_store' ) {
							currentPlaceTypes = 'store';
						} else if( currentPlaceTypes == 'local_government_office' ) {
							currentPlaceTypes = 'local_government';
						} else if( currentPlaceTypes == 'meal_delivery' ) {
							currentPlaceTypes = 'food';
						} else if( currentPlaceTypes == 'meal_takeaway' ) {
							currentPlaceTypes = 'food';
						}
						var iconText = 'map-icon-' + currentPlaceTypes.replace( '_', '-' );
						currentIcon = {
							path: '',
							scale: 0.8,
							fillColor:  '#ffffff',
							fillOpacity: 0,
							strokeColor:  '#ffffff',
							strokeWeight: 0
						};
					}
					var label = '<span class="apoi-map-icon ' + iconText + ' apoi-size-' + pl.settings.iconSize + ' apoi-type-' + pl.settings.iconType + ' apoi-color-' + pl.settings.iconColor + '"></span>';
					
				}
				var placeLoc = place.geometry.location;
				var marker = new mapIcons.Marker({
					map: map,
					position: place.geometry.location,
					icon: currentIcon,
					map_icon_label: label
					

			
				});
				markersArray.push( marker );
				bound.extend( marker.getPosition() );
				
				var photo = '';
				if( ( place.photos ) ) {
					photo = '<div class="infobox-photo"><img src="' + place.photos[ 0 ].getUrl({ 'maxWidth': 270 }) + '" /></div>';
				}
				google.maps.event.addListener( marker, 'click', function() {
					
					
					infowindow.setContent( photo + '<div class="infobox-text"><h4>' + place.name + '</h4><address>' + place.vicinity + '</address></div><div class="clearfix"></div>');
					infowindow.open( map, this );

					placeId = marker.position;

					pl.calculateAndDisplayRoute( directionsService, directionsDisplay, marker.position );
					if( pl.settings.placeDetails === true && pl.settings.placeDetailsId && $( "#" + pl.settings.placeDetailsId ).length ) {
						service.getDetails( { placeId: place.place_id }, pl.detailsCallback );
					}  else if( pl.settings.placeDetails === true ) {
						pl.debugLog( 'Missing: ' + "#" + pl.settings.placeDetailsId );
					}
					if( pl.settings.placesList === true && pl.settings.placesListId && $( "#" + pl.settings.placesListId ).length ) {
						$( '#' + pl.settings.placesListId ).animate({						
							scrollTop: $("#" + place.place_id ).offset().top - $( '#' + pl.settings.placesListId ).offset().top + $( '#' + pl.settings.placesListId ).scrollTop()
						}, 2000);
					}
				});
			},
			
			
			/**
			* Clears all markers and searched objects.
			*
			*/
			clearOverlays: function() {
				for (var i = 0; i < markersArray.length; i++ ) {
					markersArray[i].setMap(null);
				}
				markersArray.length = 0;
				for (var i = 0; i < clusteredMarkers.length; i++ ) {
					clusteredMarkers[i].clearMarkers();
				}

				if( pl.settings.placesList === true && pl.settings.placesListId && $( "#" + pl.settings.placesListId ).length ) {
					$('#' + this.settings.placesListId + ' .apoi-list-inner' ).html('');
				}
			},
			
			/**
			* Prepares data and calls nearby places search.
			* 
			*@param Object link jQuery object that was clicked
			*@param String currentType places types that need to be searched
			*
			*/
			processNearby: function( link, currentType ) {
				this.clearOverlays(); 
				if( currentType ) {

					for( var i = 0, len = currentType.length; i < len; i++ ) {

						var iconImg = null;
						var iconFont = null;
						
						var typeArray = currentType[i].type.split( ',' );
						if( typeof currentType[i].icon !== 'undefined' && currentType[i].icon != '' ) {
							iconImg = currentType[i].icon;
						} else if (  typeof currentType[i].font !== 'undefined' && currentType[i].font != '' ){
							iconFont = currentType[i].font;
						}
						if( currentType[i].source == 'json' ) {
							for( var l = 0, m = typeArray.length; l < m; l++ ) {
								for (var j = 0, k = jsonArray[ typeArray[ l ] ].items.item.length; j < k; j++) {
									this.createMarkerJSON( jsonArray[ typeArray[ l ] ].items.item[ j ], jsonArray[ typeArray[ l ] ].icon );
									pl.displayShortDetailsJSON( jsonArray[ typeArray[ l ] ].items.item[ j ], typeArray[ l ] );
								}
							}
							if( pl.settings.cluster === true ) {

								var markerClusterStyle = [{
									url: pl.settings.clusterIcon,
									height: 60,
									width: 60,
									textSize: 16,
									textColor: "#5a5f66"
								}];	
								var markerCluster = new MarkerClusterer( map, markersArray, { styles: markerClusterStyle } );
								clusteredMarkers.push( markerCluster );
								var minClusterZoom = 16;
								markerCluster.setMaxZoom( minClusterZoom );
							}							
							//map.fitBounds(bound);
							this.settings.onAfterSearchJSON();
						} else {
							for( var j = 0, k = typeArray.length; j < k; j++ ) {
								this.nearbyPlaceSearch( typeArray[ j ], iconImg, iconFont );								
							}
							this.settings.onAfterSearch();
						}
					}					
					map.fitBounds(bound);
				}				
			},
			
			/**
			* Creates a marker on the map for the place from JSON file
			* 
			*@param Object item place object form JSON file
			*@param String icon place object
			*
			*/
			createMarkerJSON: function( item, icon ) {

                var marker = new mapIcons.Marker({
                    map: map,
                    position: { lat: parseFloat( item.lat ), lng: parseFloat( item.lng ) },
                    icon: icon

                });
                markersArray.push( marker );
				bound.extend( marker.getPosition() );

				var photo = '';
				var name = item.name;

				if( ( item.photos.url.length ) ) {
					photo = '<div class="infobox-photo"><img src="' + item.photos.url[ 0 ] + '" /></div>';

				}
				google.maps.event.addListener( marker, 'click', function() {
					infowindow.setContent( photo + '<div class="infobox-text"><h4>' + name + '</h4><address>' + item.formatted_address + '</address></div><div class="clearfix"></div>');
					infowindow.open( map, this );

					placeId = marker.position;
					pl.calculateAndDisplayRoute( directionsService, directionsDisplay, marker.position );
					
					if( pl.settings.placeDetails === true && pl.settings.placeDetailsId && $( "#" + pl.settings.placeDetailsId ).length ) {
						pl.detailsCallbackJSON( item );
					}  else if( pl.settings.placeDetails === true ) {
						pl.debugLog( 'Missing: ' + "#" + pl.settings.placeDetailsId );
					}
					if( pl.settings.placesList === true && pl.settings.placesListId && $( "#" + pl.settings.placesListId ).length ) {
						$( '#' + pl.settings.placesListId ).animate({						
							scrollTop: $("#" + item.lat.replace('.','') + item.lng.replace('.','') ).offset().top - $( '#' + pl.settings.placesListId ).offset().top + $( '#' + pl.settings.placesListId ).scrollTop()
						}, 2000);
					}
				});
			},
			
			/**
			* Displays details of the Place form JOSN file
			* 
			*@param Object place Place object
			*@param String type place type
			*
			*/
			displayShortDetailsJSON: function( place, type ) {
				var stars = Math.round( place.rating * 2 ) / 2;
				var full = Math.round( place.rating );
				var half = stars - full > 0 ? 1 : 0;
				var empty = 5 - full - half;
				
				var rank = '';
				for( var i = 0; i < full; i++ ) {
					rank += '<span class="apoi-rank-full"></span>';
				}
				if( half ) {
					rank += '<span class="apoi-rank-half"></span>';
				}
				for( var i = 0; i < empty; i++ ) {
					rank += '<span class="apoi-rank-empty"></span>';
				}
				var photo = '';
				if( ( place.photos ) ) {
					photo = '<img src="' + place.photos.url[ 0 ] + '" alt="' + place.name + '" /></div>';
				}
				$('#' + this.settings.placesListId + ' .apoi-list-inner' ).append( '<div id="' + place.lat.replace('.','') + place.lng.replace('.','') + '" class="apoi-short-details-json" data-place-id="' + place.lat.replace('.','') + place.lng.replace('.','') + '" data-place-type="' + type + '"><div class="apoi-short-left"><h4>' + place.name + '</h4><span>' + rank + '</span><address>' + place.formatted_address + '</address></div><div class="apoi-details-photo">' + photo + '</div></div>' );
				listBar.resize();
			},
			
			/**
			* Callback function fired after place details request. For places from JSON file.
			* 
			*@param Object place detailed place object
			*
			*/
			detailsCallbackJSON: function( place ) {
				
					$( "#" + pl.settings.placeDetailsId ).show();
					$( "#" + pl.settings.routeTimeId ).show();
					$( "input[name='" + pl.settings.modeName + "']" ).show();
					$( "input[name='" + pl.settings.modeName + "'] + label" ).show();
					

					var stars = Math.round( place.rating * 2 ) / 2;
					var full = Math.round( place.rating );
					var half = stars - full > 0 ? 1 : 0;
					var empty = 5 - full - half;
					var rank = '';
					for( var i = 0; i < full; i++ ) {
						rank += '<span class="apoi-rank-full2"></span>';
					}
					if( half ) {
						rank += '<span class="apoi-rank-half2"></span>';
					}
					for( var i = 0; i < empty; i++ ) {
						rank += '<span class="apoi-rank-empty2"></span>';
					}
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name h4' ).html( '' );
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name > span' ).html( '' );
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-address' ).html( '' );
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-phone' ).html( '' );
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-web' ).html( '' );
					
					if( typeof place.photos.url !== 'undefined' && place.photos.url.length > 0 ) {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-image' ).html( '<img src="' + place.photos.url[ 0 ] + '" />' );
					}
					if( typeof place.name !== 'undefined' && place.name ) {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name h4' ).html( place.name );
					}
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-name > span' ).html( rank );
					
					if( typeof place.formatted_address !== 'undefined' && place.formatted_address  ) {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-address' ).html( place.formatted_address );
					}
					if( typeof place.formatted_phone_number !== 'undefined' && place.formatted_phone_number  ) {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-phone' ).html( '<a href="tel:' + place.formatted_phone_number + '">' + place.formatted_phone_number + '</a>' );
					}
					if( typeof place.website !== 'undefined' && place.website  ) {
						$( '#' + pl.settings.placeDetailsId + ' .apoi-place-web' ).html( '<a href="' + place.website + '" target="blank">' + place.website + '</a>');
					}
					var photos = '';
					
					//JOSN
					if( typeof place.photos.url !== 'undefined' && place.photos.url.length > 0 ) {
						for( var i = 0; i < ( place.photos.url.length > 5 ? 6 : place.photos.url.length ); i++ ) {
							photos += '<div><img src="' + place.photos.url[ i ] + '" /></div>';
						}	
					//GOOGLE
					} else if( typeof place.photos !== 'undefined' && place.photos.length > 0 ) {
						for( var i = 0; i < ( place.photos.length > 5 ? 6 : place.photos.length ); i++ ) {
							photos += '<div><img src="' + place.photos[ i ].getUrl({ 'maxWidth': 340 }) + '" /></div>';
						}				
					}
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-photos' ).html( photos );
					
					var reviews = '';

					if( typeof place.reviews !== 'undefined' && place.reviews.length > 0 ) {
						for( var i = 0; i < ( place.reviews.length > 2 ? 3 : place.reviews.length ); i++ ) {
							if( place.reviews[i].author_name && ( place.reviews[i].rating || place.reviews[i].date ) ) {
		
								var stars2 = Math.round( place.reviews[i].rating * 2 ) / 2;
								var full2 = Math.round( place.reviews[i].rating - 0.1 );
								var half2 = stars2 - full2 > 0 ? 1 : 0;
								var empty2 = 5 - full2 - half2;
								var rank2 = '';
								for( var j = 0; j < full2; j++ ) {
									rank2 += '<span class="apoi-rank-full"></span>';
								}
								if( half2 ) {
									rank2 += '<span class="apoi-rank-half"></span>';
								}
								for( var j = 0; j < empty2; j++ ) {
									rank2 += '<span class="apoi-rank-empty"></span>';
								}
								reviews += '<div class="apoi-review"><h4>' + place.reviews[i].author_name + '</h4><span>' + rank2 + '<span class="apoi-review-date">' + (place.reviews[i].relative_time_description ? place.reviews[i].relative_time_description : '')  + '</span></span><p>' + (place.reviews[i].text ? place.reviews[i].text : '') + '</p></div>';
							}
						}						
					}
					$( '#' + pl.settings.placeDetailsId + ' .apoi-place-reviews' ).html( reviews );
					
					var loc = new google.maps.LatLng(place.lat, place.lng);
					
					pl.detailsStreetViewInit( loc );
					pl.settings.onDetailsShow( loc );
				
			},
			
			/**
			* Initializes Street View
			*
			*/
			streetViewInit: function() {			
				var panorama = new google.maps.StreetViewPanorama(
				document.getElementById( streetID ), {
					position: this.settings.pyrmont,
					scrollwheel: this.settings.wheelScroll,
					pov: {
					  heading: 34,
					  pitch: 10
					}
				});
			},
			
			/**
			* Initializes Street View for the object details
			* 
			*@param Object location object location
			*
			*/
			detailsStreetViewInit: function( location ) {
				$( '#' + detailsStreetID ).show();
				sv.getPanoramaByLocation(location, 50, function(data, status) {
					if (status == 'OK') {
						var panorama = new google.maps.StreetViewPanorama(
						document.getElementById( detailsStreetID ), {
							position: location,
							scrollwheel: pl.settings.wheelScroll,
							pov: {
							  heading: 34,
							  pitch: 10
							}
						});			
					}
					else {
						$( '#' + detailsStreetID ).hide();
						pl.debugLog('no Street View for this address');
					}
				});
				
				
			},
			
			/**
			* Displays route 
			* 
			*@param Object directionsService Google object
			*@param Object directionsDisplay Google object
			*@param String placeId Google place id
			*
			*/
			calculateAndDisplayRoute: function( directionsService, directionsDisplay, placeId ) {
				var origin;
				if( typeof placeId === 'string' ) {
					origin = { placeId: placeId };
				} else {
					origin = placeId;
				}
				if( this.settings.routeMode === true && this.settings.modeName && $( 'input[name="' + this.settings.modeName + '"]' ).length  ) {
					var mode = $( 'input[name="' + this.settings.modeName + '"]:checked' ).val();
				} else if( this.settings.routeMode === true && this.settings.modeName ) {
					pl.debugLog( 'Missing: ' + 'input[name="' + this.settings.modeName + '"]' );
					var mode = 'DRIVING'
				} else if( this.settings.modeName ) {
					var mode = 'DRIVING';
					$( 'input[name="' + this.settings.modeName + '"]' ).parent().css('display', 'none');
					$( 'input[name="' + this.settings.modeName + '"]' ).css('display', 'none');
					
				}
				directionsService.route({
					origin: origin,
					destination: this.settings.pyrmont,
					travelMode: mode
				}, function( response, status ) {
					if ( status === 'OK' ) {
						if( pl.settings.routeTime === true && pl.settings.routeTimeId && $( '#' + pl.settings.routeTimeId ).length  ) {
							$('#' + pl.settings.routeTimeId ).html( response.routes[ 0 ].legs[ 0 ].distance.text + ' (' + response.routes[ 0 ].legs[ 0 ].duration.text + ')' );
						} else if( pl.settings.routeTime === true ) {
							pl.debugLog( 'Missing: ' + '#' + pl.settings.routeTimeId );
						} else if( pl.settings.routeTimeId ) {
							$('#' + pl.settings.routeTimeId ).css('display','none');
						}
						directionsDisplay.setDirections( response );
					} else {
						pl.debugLog( 'Directions request failed due to ' + status );
					}
					pl.settings.onAfterRoute( response );
				});
			},
			
			/**
			* Get the current user location form the browser 
			*
			*/			
			geoLocation: function() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition( function( position ) {
						placeId = {
						  lat: position.coords.latitude,
						  lng: position.coords.longitude
						};

						pl.calculateAndDisplayRoute( directionsService, directionsDisplay, placeId );
						pl.settings.onGeolocation( navigator.geolocation );
					}, function() {
						pl.debugLog( 'Browser doesn\'t support Geolocation' );
					});
				} else {
					pl.debugLog( 'Browser doesn\'t support Geolocation' );
				}
				
			},
			
			/**
			* Adds KML file to the map
			* 
			*@param String file URL to the KML file
			*
			*/
			addKML: function( file ) {
				var ctaLayer = new google.maps.KmlLayer({
				  url: file,
				  map: map
				});


			},
			
			/**
			* Process the JSON file with custom places
			* 
			*@param String file URL or PATH to the JOSN file
			*
			*/
			processJSON: function( jsonFile ) {
				$.getJSON( jsonFile, function( json ) {
					for( var i = 0, l = json.types.type.length; i < l; i++ ) {
						jsonArray[ json.types.type[ i ].name ] = json.types.type[ i ];
						for( var j = 0, k = json.types.type[ i ].items.item.length; j < k; j++ ) {
							placesArray[ json.types.type[ i ].items.item[ j ].name ] = json.types.type[ i ].items.item[ j ];
						}
					}
				});
			},
			
			/**
			* Display debuf info
			* 
			*@param String txt debug message
			*
			*/
			debugLog: function( txt ) {
				if( pl.settings.debug === true ) {
					console.log( txt );
				}
			},
		} );

		// plugin wrapper around the constructor,
		// preventing against multiple instantiations
		$.fn[ pluginName ] = function( options ) {
			return this.each( function() {
				if ( !$.data( this, "plugin_" + pluginName ) ) {
					$.data( this, "plugin_" +
						pluginName, new Plugin( this, options ) );
				}
			} );
		};

} )( jQuery, window, document );



// Marker Clusterer – A Google Maps JavaScript API utility library
// ==============

// A Google Maps JavaScript API v3 library to create and manage per-zoom-level clusters for large amounts of markers.
// ![Analytics](https://ga-beacon.appspot.com/UA-12846745-20/js-marker-clusterer/readme?pixel)

// [Reference documentation](https://googlemaps.github.io/js-marker-clusterer/docs/reference.html)

// ## License

// Copyright 2014 Google Inc. All rights reserved.

// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

    // http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

(function(){var d=null;function e(a){return function(b){this[a]=b}}function h(a){return function(){return this[a]}}var j;
function k(a,b,c){this.extend(k,google.maps.OverlayView);this.c=a;this.a=[];this.f=[];this.ca=[53,56,66,78,90];this.j=[];this.A=!1;c=c||{};this.g=c.gridSize||60;this.l=c.minimumClusterSize||2;this.J=c.maxZoom||d;this.j=c.styles||[];this.X=c.imagePath||this.Q;this.W=c.imageExtension||this.P;this.O=!0;if(c.zoomOnClick!=void 0)this.O=c.zoomOnClick;this.r=!1;if(c.averageCenter!=void 0)this.r=c.averageCenter;l(this);this.setMap(a);this.K=this.c.getZoom();var f=this;google.maps.event.addListener(this.c,
"zoom_changed",function(){var a=f.c.getZoom();if(f.K!=a)f.K=a,f.m()});google.maps.event.addListener(this.c,"idle",function(){f.i()});b&&b.length&&this.C(b,!1)}j=k.prototype;j.Q="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m";j.P="png";j.extend=function(a,b){return function(a){for(var b in a.prototype)this.prototype[b]=a.prototype[b];return this}.apply(a,[b])};j.onAdd=function(){if(!this.A)this.A=!0,n(this)};j.draw=function(){};
function l(a){if(!a.j.length)for(var b=0,c;c=a.ca[b];b++)a.j.push({url:a.X+(b+1)+"."+a.W,height:c,width:c})}j.S=function(){for(var a=this.o(),b=new google.maps.LatLngBounds,c=0,f;f=a[c];c++)b.extend(f.getPosition());this.c.fitBounds(b)};j.z=h("j");j.o=h("a");j.V=function(){return this.a.length};j.ba=e("J");j.I=h("J");j.G=function(a,b){for(var c=0,f=a.length,g=f;g!==0;)g=parseInt(g/10,10),c++;c=Math.min(c,b);return{text:f,index:c}};j.$=e("G");j.H=h("G");
j.C=function(a,b){for(var c=0,f;f=a[c];c++)q(this,f);b||this.i()};function q(a,b){b.s=!1;b.draggable&&google.maps.event.addListener(b,"dragend",function(){b.s=!1;a.L()});a.a.push(b)}j.q=function(a,b){q(this,a);b||this.i()};function r(a,b){var c=-1;if(a.a.indexOf)c=a.a.indexOf(b);else for(var f=0,g;g=a.a[f];f++)if(g==b){c=f;break}if(c==-1)return!1;b.setMap(d);a.a.splice(c,1);return!0}j.Y=function(a,b){var c=r(this,a);return!b&&c?(this.m(),this.i(),!0):!1};
j.Z=function(a,b){for(var c=!1,f=0,g;g=a[f];f++)g=r(this,g),c=c||g;if(!b&&c)return this.m(),this.i(),!0};j.U=function(){return this.f.length};j.getMap=h("c");j.setMap=e("c");j.w=h("g");j.aa=e("g");
j.v=function(a){var b=this.getProjection(),c=new google.maps.LatLng(a.getNorthEast().lat(),a.getNorthEast().lng()),f=new google.maps.LatLng(a.getSouthWest().lat(),a.getSouthWest().lng()),c=b.fromLatLngToDivPixel(c);c.x+=this.g;c.y-=this.g;f=b.fromLatLngToDivPixel(f);f.x-=this.g;f.y+=this.g;c=b.fromDivPixelToLatLng(c);b=b.fromDivPixelToLatLng(f);a.extend(c);a.extend(b);return a};j.R=function(){this.m(!0);this.a=[]};
j.m=function(a){for(var b=0,c;c=this.f[b];b++)c.remove();for(b=0;c=this.a[b];b++)c.s=!1,a&&c.setMap(d);this.f=[]};j.L=function(){var a=this.f.slice();this.f.length=0;this.m();this.i();window.setTimeout(function(){for(var b=0,c;c=a[b];b++)c.remove()},0)};j.i=function(){n(this)};
function n(a){if(a.A)for(var b=a.v(new google.maps.LatLngBounds(a.c.getBounds().getSouthWest(),a.c.getBounds().getNorthEast())),c=0,f;f=a.a[c];c++)if(!f.s&&b.contains(f.getPosition())){for(var g=a,u=4E4,o=d,v=0,m=void 0;m=g.f[v];v++){var i=m.getCenter();if(i){var p=f.getPosition();if(!i||!p)i=0;else var w=(p.lat()-i.lat())*Math.PI/180,x=(p.lng()-i.lng())*Math.PI/180,i=Math.sin(w/2)*Math.sin(w/2)+Math.cos(i.lat()*Math.PI/180)*Math.cos(p.lat()*Math.PI/180)*Math.sin(x/2)*Math.sin(x/2),i=6371*2*Math.atan2(Math.sqrt(i),
Math.sqrt(1-i));i<u&&(u=i,o=m)}}o&&o.F.contains(f.getPosition())?o.q(f):(m=new s(g),m.q(f),g.f.push(m))}}function s(a){this.k=a;this.c=a.getMap();this.g=a.w();this.l=a.l;this.r=a.r;this.d=d;this.a=[];this.F=d;this.n=new t(this,a.z(),a.w())}j=s.prototype;
j.q=function(a){var b;a:if(this.a.indexOf)b=this.a.indexOf(a)!=-1;else{b=0;for(var c;c=this.a[b];b++)if(c==a){b=!0;break a}b=!1}if(b)return!1;if(this.d){if(this.r)c=this.a.length+1,b=(this.d.lat()*(c-1)+a.getPosition().lat())/c,c=(this.d.lng()*(c-1)+a.getPosition().lng())/c,this.d=new google.maps.LatLng(b,c),y(this)}else this.d=a.getPosition(),y(this);a.s=!0;this.a.push(a);b=this.a.length;b<this.l&&a.getMap()!=this.c&&a.setMap(this.c);if(b==this.l)for(c=0;c<b;c++)this.a[c].setMap(d);b>=this.l&&a.setMap(d);
a=this.c.getZoom();if((b=this.k.I())&&a>b)for(a=0;b=this.a[a];a++)b.setMap(this.c);else if(this.a.length<this.l)z(this.n);else{b=this.k.H()(this.a,this.k.z().length);this.n.setCenter(this.d);a=this.n;a.B=b;a.ga=b.text;a.ea=b.index;if(a.b)a.b.innerHTML=b.text;b=Math.max(0,a.B.index-1);b=Math.min(a.j.length-1,b);b=a.j[b];a.da=b.url;a.h=b.height;a.p=b.width;a.M=b.textColor;a.e=b.anchor;a.N=b.textSize;a.D=b.backgroundPosition;this.n.show()}return!0};
j.getBounds=function(){for(var a=new google.maps.LatLngBounds(this.d,this.d),b=this.o(),c=0,f;f=b[c];c++)a.extend(f.getPosition());return a};j.remove=function(){this.n.remove();this.a.length=0;delete this.a};j.T=function(){return this.a.length};j.o=h("a");j.getCenter=h("d");function y(a){a.F=a.k.v(new google.maps.LatLngBounds(a.d,a.d))}j.getMap=h("c");
function t(a,b,c){a.k.extend(t,google.maps.OverlayView);this.j=b;this.fa=c||0;this.u=a;this.d=d;this.c=a.getMap();this.B=this.b=d;this.t=!1;this.setMap(this.c)}j=t.prototype;
j.onAdd=function(){this.b=document.createElement("DIV");if(this.t)this.b.style.cssText=A(this,B(this,this.d)),this.b.innerHTML=this.B.text;this.getPanes().overlayMouseTarget.appendChild(this.b);var a=this;google.maps.event.addDomListener(this.b,"click",function(){var b=a.u.k;google.maps.event.trigger(b,"clusterclick",a.u);b.O&&a.c.fitBounds(a.u.getBounds())})};function B(a,b){var c=a.getProjection().fromLatLngToDivPixel(b);c.x-=parseInt(a.p/2,10);c.y-=parseInt(a.h/2,10);return c}
j.draw=function(){if(this.t){var a=B(this,this.d);this.b.style.top=a.y+"px";this.b.style.left=a.x+"px"}};function z(a){if(a.b)a.b.style.display="none";a.t=!1}j.show=function(){if(this.b)this.b.style.cssText=A(this,B(this,this.d)),this.b.style.display="";this.t=!0};j.remove=function(){this.setMap(d)};j.onRemove=function(){if(this.b&&this.b.parentNode)z(this),this.b.parentNode.removeChild(this.b),this.b=d};j.setCenter=e("d");
function A(a,b){var c=[];c.push("background-image:url("+a.da+");");c.push("background-position:"+(a.D?a.D:"0 0")+";");typeof a.e==="object"?(typeof a.e[0]==="number"&&a.e[0]>0&&a.e[0]<a.h?c.push("height:"+(a.h-a.e[0])+"px; padding-top:"+a.e[0]+"px;"):c.push("height:"+a.h+"px; line-height:"+a.h+"px;"),typeof a.e[1]==="number"&&a.e[1]>0&&a.e[1]<a.p?c.push("width:"+(a.p-a.e[1])+"px; padding-left:"+a.e[1]+"px;"):c.push("width:"+a.p+"px; text-align:center;")):c.push("height:"+a.h+"px; line-height:"+a.h+
"px; width:"+a.p+"px; text-align:center;");c.push("cursor:pointer; top:"+b.y+"px; left:"+b.x+"px; color:"+(a.M?a.M:"black")+"; position:absolute; font-size:"+(a.N?a.N:11)+"px; font-family:Arial,sans-serif; font-weight:bold");return c.join("")}window.MarkerClusterer=k;k.prototype.addMarker=k.prototype.q;k.prototype.addMarkers=k.prototype.C;k.prototype.clearMarkers=k.prototype.R;k.prototype.fitMapToMarkers=k.prototype.S;k.prototype.getCalculator=k.prototype.H;k.prototype.getGridSize=k.prototype.w;
k.prototype.getExtendedBounds=k.prototype.v;k.prototype.getMap=k.prototype.getMap;k.prototype.getMarkers=k.prototype.o;k.prototype.getMaxZoom=k.prototype.I;k.prototype.getStyles=k.prototype.z;k.prototype.getTotalClusters=k.prototype.U;k.prototype.getTotalMarkers=k.prototype.V;k.prototype.redraw=k.prototype.i;k.prototype.removeMarker=k.prototype.Y;k.prototype.removeMarkers=k.prototype.Z;k.prototype.resetViewport=k.prototype.m;k.prototype.repaint=k.prototype.L;k.prototype.setCalculator=k.prototype.$;
k.prototype.setGridSize=k.prototype.aa;k.prototype.setMaxZoom=k.prototype.ba;k.prototype.onAdd=k.prototype.onAdd;k.prototype.draw=k.prototype.draw;s.prototype.getCenter=s.prototype.getCenter;s.prototype.getSize=s.prototype.T;s.prototype.getMarkers=s.prototype.o;t.prototype.onAdd=t.prototype.onAdd;t.prototype.draw=t.prototype.draw;t.prototype.onRemove=t.prototype.onRemove;
})();

/**
 * Map Icons created by Scott de Jonge
 *
 * @version 3.0.0
 * @url http://map-icons.com
 *
 */

var mapIcons = {};

+function () {

    'use strict';

    // Define Marker Shapes
    mapIcons.shapes = {
        MAP_PIN : 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
        SQUARE_PIN : 'M22-48h-44v43h16l6 5 6-5h16z',
        SHIELD : 'M18.8-31.8c.3-3.4 1.3-6.6 3.2-9.5l-7-6.7c-2.2 1.8-4.8 2.8-7.6 3-2.6.2-5.1-.2-7.5-1.4-2.4 1.1-4.9 1.6-7.5 1.4-2.7-.2-5.1-1.1-7.3-2.7l-7.1 6.7c1.7 2.9 2.7 6 2.9 9.2.1 1.5-.3 3.5-1.3 6.1-.5 1.5-.9 2.7-1.2 3.8-.2 1-.4 1.9-.5 2.5 0 2.8.8 5.3 2.5 7.5 1.3 1.6 3.5 3.4 6.5 5.4 3.3 1.6 5.8 2.6 7.6 3.1.5.2 1 .4 1.5.7l1.5.6c1.2.7 2 1.4 2.4 2.1.5-.8 1.3-1.5 2.4-2.1.7-.3 1.3-.5 1.9-.8.5-.2.9-.4 1.1-.5.4-.1.9-.3 1.5-.6.6-.2 1.3-.5 2.2-.8 1.7-.6 3-1.1 3.8-1.6 2.9-2 5.1-3.8 6.4-5.3 1.7-2.2 2.6-4.8 2.5-7.6-.1-1.3-.7-3.3-1.7-6.1-.9-2.8-1.3-4.9-1.2-6.4z',
        ROUTE : 'M24-28.3c-.2-13.3-7.9-18.5-8.3-18.7l-1.2-.8-1.2.8c-2 1.4-4.1 2-6.1 2-3.4 0-5.8-1.9-5.9-1.9l-1.3-1.1-1.3 1.1c-.1.1-2.5 1.9-5.9 1.9-2.1 0-4.1-.7-6.1-2l-1.2-.8-1.2.8c-.8.6-8 5.9-8.2 18.7-.2 1.1 2.9 22.2 23.9 28.3 22.9-6.7 24.1-26.9 24-28.3z',
        SQUARE : 'M-24-48h48v48h-48z',
        SQUARE_ROUNDED : 'M24-8c0 4.4-3.6 8-8 8h-32c-4.4 0-8-3.6-8-8v-32c0-4.4 3.6-8 8-8h32c4.4 0 8 3.6 8 8v32z'
    };


    // Marker constructor
    mapIcons.Marker = function (options) {

        var Marker = function (options) {
            // draw marker (shape)
            google.maps.Marker.apply(this, [options]);
            // draw label (html)
            if (options.map_icon_label) {
                this.MarkerLabel = new mapIcons.MarkerLabel({
                        map : this.map,
                        marker : this,
                        text : options.map_icon_label
                    });
                this.MarkerLabel.bindTo('position', this, 'position');
            }
        };

		// Apply the inheritance
        mapIcons.fn.inherits(Marker, google.maps.Marker);

        // Custom Marker SetMap
        Marker.prototype.setMap = mapIcons.fn.setMap;

        return new Marker(options);
    };


	// Marker label overlay constructor
    mapIcons.MarkerLabel = function (options) {

		var Label = function (options) {

			var self = this;
			this.setValues(options);

			// Create the label container
			this.div = document.createElement('div');
			this.div.className = 'map-icon-label';

			// Trigger the marker click handler if clicking on the label
			google.maps.event.addDomListener(this.div, 'click', function (e) {
				(e.stopPropagation) && e.stopPropagation();
				google.maps.event.trigger(self.marker, 'click');
			});
		};

        Label.prototype = new google.maps.OverlayView();
        Label.prototype.onRemove = mapIcons.fn.labelOnRemove;
        Label.prototype.draw = mapIcons.fn.labelDraw;
        Label.prototype.onAdd = mapIcons.fn.labelOnAdd;

        return new Label(options);
    }


	// Helper functions
    mapIcons.fn = {

        // Function to do the inheritance properly
        // Inspired by: http://stackoverflow.com/questions/9812783/cannot-inherit-google-maps-map-v3-in-my-custom-class-javascript
        inherits : function (childCtor, parentCtor) {
            function tempCtor() {};
            tempCtor.prototype = parentCtor.prototype;
            childCtor.superClass_ = parentCtor.prototype;
            childCtor.prototype = new tempCtor();
            childCtor.prototype.constructor = childCtor;
        },

		// Custom Marker SetMap
        setMap : function (options) {
            google.maps.Marker.prototype.setMap.apply(this, [options]);
            (this.MarkerLabel) && this.MarkerLabel.setMap.apply(this.MarkerLabel, [options]);
        },

        // Marker Label onAdd
        labelOnAdd : function () {
            var pane = this.getPanes().overlayImage.appendChild(this.div);
            var self = this;

            this.listeners = [
                google.maps.event.addListener(this, 'position_changed', function () {
                    self.draw();
                }),
                google.maps.event.addListener(this, 'text_changed', function () {
                    self.draw();
                }),
                google.maps.event.addListener(this, 'zindex_changed', function () {
                    self.draw();
                })
            ];
        },

        // Marker Label onRemove
        labelOnRemove : function () {
            this.div.parentNode.removeChild(this.div);

            for (var i = 0, I = this.listeners.length; i < I; ++i) {
                google.maps.event.removeListener(this.listeners[i]);
            }
        },

        // Implement draw
        labelDraw : function () {

            var projection = this.getProjection();
            var position = projection.fromLatLngToDivPixel(this.get('position'));
            var div = this.div;

            this.div.innerHTML = this.get('text').toString();

            div.style.zIndex = this.get('zIndex'); // Allow label to overlay marker
            div.style.position = 'absolute';
            div.style.display = 'block';
            div.style.left = (position.x - (div.offsetWidth / 2)) + 'px';
            div.style.top = (position.y - div.offsetHeight) + 'px';
        }
    }

}();

/* jquery.nicescroll v3.7.6 InuYaksa - MIT - https://nicescroll.areaaperta.com */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){"use strict";var o=!1,t=!1,r=0,i=2e3,s=0,n=e,l=document,a=window,c=n(a),d=[],u=a.requestAnimationFrame||a.webkitRequestAnimationFrame||a.mozRequestAnimationFrame||!1,h=a.cancelAnimationFrame||a.webkitCancelAnimationFrame||a.mozCancelAnimationFrame||!1;if(u)a.cancelAnimationFrame||(h=function(e){});else{var p=0;u=function(e,o){var t=(new Date).getTime(),r=Math.max(0,16-(t-p)),i=a.setTimeout(function(){e(t+r)},r);return p=t+r,i},h=function(e){a.clearTimeout(e)}}var m=a.MutationObserver||a.WebKitMutationObserver||!1,f=Date.now||function(){return(new Date).getTime()},g={zindex:"auto",cursoropacitymin:0,cursoropacitymax:1,cursorcolor:"#424242",cursorwidth:"6px",cursorborder:"1px solid #fff",cursorborderradius:"5px",scrollspeed:40,mousescrollstep:27,touchbehavior:!1,emulatetouch:!1,hwacceleration:!0,usetransition:!0,boxzoom:!1,dblclickzoom:!0,gesturezoom:!0,grabcursorenabled:!0,autohidemode:!0,background:"",iframeautoresize:!0,cursorminheight:32,preservenativescrolling:!0,railoffset:!1,railhoffset:!1,bouncescroll:!0,spacebarenabled:!0,railpadding:{top:0,right:0,left:0,bottom:0},disableoutline:!0,horizrailenabled:!0,railalign:"right",railvalign:"bottom",enabletranslate3d:!0,enablemousewheel:!0,enablekeyboard:!0,smoothscroll:!0,sensitiverail:!0,enablemouselockapi:!0,cursorfixedheight:!1,directionlockdeadzone:6,hidecursordelay:400,nativeparentscrolling:!0,enablescrollonselection:!0,overflowx:!0,overflowy:!0,cursordragspeed:.3,rtlmode:"auto",cursordragontouch:!1,oneaxismousemode:"auto",scriptpath:function(){var e=l.currentScript||function(){var e=l.getElementsByTagName("script");return!!e.length&&e[e.length-1]}(),o=e?e.src.split("?")[0]:"";return o.split("/").length>0?o.split("/").slice(0,-1).join("/")+"/":""}(),preventmultitouchscrolling:!0,disablemutationobserver:!1,enableobserver:!0,scrollbarid:!1},v=!1,w=function(){if(v)return v;var e=l.createElement("DIV"),o=e.style,t=navigator.userAgent,r=navigator.platform,i={};return i.haspointerlock="pointerLockElement"in l||"webkitPointerLockElement"in l||"mozPointerLockElement"in l,i.isopera="opera"in a,i.isopera12=i.isopera&&"getUserMedia"in navigator,i.isoperamini="[object OperaMini]"===Object.prototype.toString.call(a.operamini),i.isie="all"in l&&"attachEvent"in e&&!i.isopera,i.isieold=i.isie&&!("msInterpolationMode"in o),i.isie7=i.isie&&!i.isieold&&(!("documentMode"in l)||7===l.documentMode),i.isie8=i.isie&&"documentMode"in l&&8===l.documentMode,i.isie9=i.isie&&"performance"in a&&9===l.documentMode,i.isie10=i.isie&&"performance"in a&&10===l.documentMode,i.isie11="msRequestFullscreen"in e&&l.documentMode>=11,i.ismsedge="msCredentials"in a,i.ismozilla="MozAppearance"in o,i.iswebkit=!i.ismsedge&&"WebkitAppearance"in o,i.ischrome=i.iswebkit&&"chrome"in a,i.ischrome38=i.ischrome&&"touchAction"in o,i.ischrome22=!i.ischrome38&&i.ischrome&&i.haspointerlock,i.ischrome26=!i.ischrome38&&i.ischrome&&"transition"in o,i.cantouch="ontouchstart"in l.documentElement||"ontouchstart"in a,i.hasw3ctouch=(a.PointerEvent||!1)&&(navigator.maxTouchPoints>0||navigator.msMaxTouchPoints>0),i.hasmstouch=!i.hasw3ctouch&&(a.MSPointerEvent||!1),i.ismac=/^mac$/i.test(r),i.isios=i.cantouch&&/iphone|ipad|ipod/i.test(r),i.isios4=i.isios&&!("seal"in Object),i.isios7=i.isios&&"webkitHidden"in l,i.isios8=i.isios&&"hidden"in l,i.isios10=i.isios&&a.Proxy,i.isandroid=/android/i.test(t),i.haseventlistener="addEventListener"in e,i.trstyle=!1,i.hastransform=!1,i.hastranslate3d=!1,i.transitionstyle=!1,i.hastransition=!1,i.transitionend=!1,i.trstyle="transform",i.hastransform="transform"in o||function(){for(var e=["msTransform","webkitTransform","MozTransform","OTransform"],t=0,r=e.length;t<r;t++)if(void 0!==o[e[t]]){i.trstyle=e[t];break}i.hastransform=!!i.trstyle}(),i.hastransform&&(o[i.trstyle]="translate3d(1px,2px,3px)",i.hastranslate3d=/translate3d/.test(o[i.trstyle])),i.transitionstyle="transition",i.prefixstyle="",i.transitionend="transitionend",i.hastransition="transition"in o||function(){i.transitionend=!1;for(var e=["webkitTransition","msTransition","MozTransition","OTransition","OTransition","KhtmlTransition"],t=["-webkit-","-ms-","-moz-","-o-","-o","-khtml-"],r=["webkitTransitionEnd","msTransitionEnd","transitionend","otransitionend","oTransitionEnd","KhtmlTransitionEnd"],s=0,n=e.length;s<n;s++)if(e[s]in o){i.transitionstyle=e[s],i.prefixstyle=t[s],i.transitionend=r[s];break}i.ischrome26&&(i.prefixstyle=t[1]),i.hastransition=i.transitionstyle}(),i.cursorgrabvalue=function(){var e=["grab","-webkit-grab","-moz-grab"];(i.ischrome&&!i.ischrome38||i.isie)&&(e=[]);for(var t=0,r=e.length;t<r;t++){var s=e[t];if(o.cursor=s,o.cursor==s)return s}return"url(https://cdnjs.cloudflare.com/ajax/libs/slider-pro/1.3.0/css/images/openhand.cur),n-resize"}(),i.hasmousecapture="setCapture"in e,i.hasMutationObserver=!1!==m,e=null,v=i,i},b=function(e,p){function v(){var e=T.doc.css(P.trstyle);return!(!e||"matrix"!=e.substr(0,6))&&e.replace(/^.*\((.*)\)$/g,"$1").replace(/px/g,"").split(/, +/)}function b(){var e=T.win;if("zIndex"in e)return e.zIndex();for(;e.length>0;){if(9==e[0].nodeType)return!1;var o=e.css("zIndex");if(!isNaN(o)&&0!==o)return parseInt(o);e=e.parent()}return!1}function x(e,o,t){var r=e.css(o),i=parseFloat(r);if(isNaN(i)){var s=3==(i=I[r]||0)?t?T.win.outerHeight()-T.win.innerHeight():T.win.outerWidth()-T.win.innerWidth():1;return T.isie8&&i&&(i+=1),s?i:0}return i}function S(e,o,t,r){T._bind(e,o,function(r){var i={original:r=r||a.event,target:r.target||r.srcElement,type:"wheel",deltaMode:"MozMousePixelScroll"==r.type?0:1,deltaX:0,deltaZ:0,preventDefault:function(){return r.preventDefault?r.preventDefault():r.returnValue=!1,!1},stopImmediatePropagation:function(){r.stopImmediatePropagation?r.stopImmediatePropagation():r.cancelBubble=!0}};return"mousewheel"==o?(r.wheelDeltaX&&(i.deltaX=-.025*r.wheelDeltaX),r.wheelDeltaY&&(i.deltaY=-.025*r.wheelDeltaY),!i.deltaY&&!i.deltaX&&(i.deltaY=-.025*r.wheelDelta)):i.deltaY=r.detail,t.call(e,i)},r)}function z(e,o,t,r){T.scrollrunning||(T.newscrolly=T.getScrollTop(),T.newscrollx=T.getScrollLeft(),D=f());var i=f()-D;if(D=f(),i>350?A=1:A+=(2-A)/10,e=e*A|0,o=o*A|0,e){if(r)if(e<0){if(T.getScrollLeft()>=T.page.maxw)return!0}else if(T.getScrollLeft()<=0)return!0;var s=e>0?1:-1;X!==s&&(T.scrollmom&&T.scrollmom.stop(),T.newscrollx=T.getScrollLeft(),X=s),T.lastdeltax-=e}if(o){if(function(){var e=T.getScrollTop();if(o<0){if(e>=T.page.maxh)return!0}else if(e<=0)return!0}()){if(M.nativeparentscrolling&&t&&!T.ispage&&!T.zoomactive)return!0;var n=T.view.h>>1;T.newscrolly<-n?(T.newscrolly=-n,o=-1):T.newscrolly>T.page.maxh+n?(T.newscrolly=T.page.maxh+n,o=1):o=0}var l=o>0?1:-1;B!==l&&(T.scrollmom&&T.scrollmom.stop(),T.newscrolly=T.getScrollTop(),B=l),T.lastdeltay-=o}(o||e)&&T.synched("relativexy",function(){var e=T.lastdeltay+T.newscrolly;T.lastdeltay=0;var o=T.lastdeltax+T.newscrollx;T.lastdeltax=0,T.rail.drag||T.doScrollPos(o,e)})}function k(e,o,t){var r,i;return!(t||!q)||(0===e.deltaMode?(r=-e.deltaX*(M.mousescrollstep/54)|0,i=-e.deltaY*(M.mousescrollstep/54)|0):1===e.deltaMode&&(r=-e.deltaX*M.mousescrollstep*50/80|0,i=-e.deltaY*M.mousescrollstep*50/80|0),o&&M.oneaxismousemode&&0===r&&i&&(r=i,i=0,t&&(r<0?T.getScrollLeft()>=T.page.maxw:T.getScrollLeft()<=0)&&(i=r,r=0)),T.isrtlmode&&(r=-r),z(r,i,t,!0)?void(t&&(q=!0)):(q=!1,e.stopImmediatePropagation(),e.preventDefault()))}var T=this;this.version="3.7.6",this.name="nicescroll",this.me=p;var E=n("body"),M=this.opt={doc:E,win:!1};if(n.extend(M,g),M.snapbackspeed=80,e)for(var L in M)void 0!==e[L]&&(M[L]=e[L]);if(M.disablemutationobserver&&(m=!1),this.doc=M.doc,this.iddoc=this.doc&&this.doc[0]?this.doc[0].id||"":"",this.ispage=/^BODY|HTML/.test(M.win?M.win[0].nodeName:this.doc[0].nodeName),this.haswrapper=!1!==M.win,this.win=M.win||(this.ispage?c:this.doc),this.docscroll=this.ispage&&!this.haswrapper?c:this.win,this.body=E,this.viewport=!1,this.isfixed=!1,this.iframe=!1,this.isiframe="IFRAME"==this.doc[0].nodeName&&"IFRAME"==this.win[0].nodeName,this.istextarea="TEXTAREA"==this.win[0].nodeName,this.forcescreen=!1,this.canshowonmouseevent="scroll"!=M.autohidemode,this.onmousedown=!1,this.onmouseup=!1,this.onmousemove=!1,this.onmousewheel=!1,this.onkeypress=!1,this.ongesturezoom=!1,this.onclick=!1,this.onscrollstart=!1,this.onscrollend=!1,this.onscrollcancel=!1,this.onzoomin=!1,this.onzoomout=!1,this.view=!1,this.page=!1,this.scroll={x:0,y:0},this.scrollratio={x:0,y:0},this.cursorheight=20,this.scrollvaluemax=0,"auto"==M.rtlmode){var C=this.win[0]==a?this.body:this.win,N=C.css("writing-mode")||C.css("-webkit-writing-mode")||C.css("-ms-writing-mode")||C.css("-moz-writing-mode");"horizontal-tb"==N||"lr-tb"==N||""===N?(this.isrtlmode="rtl"==C.css("direction"),this.isvertical=!1):(this.isrtlmode="vertical-rl"==N||"tb"==N||"tb-rl"==N||"rl-tb"==N,this.isvertical="vertical-rl"==N||"tb"==N||"tb-rl"==N)}else this.isrtlmode=!0===M.rtlmode,this.isvertical=!1;if(this.scrollrunning=!1,this.scrollmom=!1,this.observer=!1,this.observerremover=!1,this.observerbody=!1,!1!==M.scrollbarid)this.id=M.scrollbarid;else do{this.id="ascrail"+i++}while(l.getElementById(this.id));this.rail=!1,this.cursor=!1,this.cursorfreezed=!1,this.selectiondrag=!1,this.zoom=!1,this.zoomactive=!1,this.hasfocus=!1,this.hasmousefocus=!1,this.railslocked=!1,this.locked=!1,this.hidden=!1,this.cursoractive=!0,this.wheelprevented=!1,this.overflowx=M.overflowx,this.overflowy=M.overflowy,this.nativescrollingarea=!1,this.checkarea=0,this.events=[],this.saved={},this.delaylist={},this.synclist={},this.lastdeltax=0,this.lastdeltay=0,this.detected=w();var P=n.extend({},this.detected);this.canhwscroll=P.hastransform&&M.hwacceleration,this.ishwscroll=this.canhwscroll&&T.haswrapper,this.isrtlmode?this.isvertical?this.hasreversehr=!(P.iswebkit||P.isie||P.isie11):this.hasreversehr=!(P.iswebkit||P.isie&&!P.isie10&&!P.isie11):this.hasreversehr=!1,this.istouchcapable=!1,P.cantouch||!P.hasw3ctouch&&!P.hasmstouch?!P.cantouch||P.isios||P.isandroid||!P.iswebkit&&!P.ismozilla||(this.istouchcapable=!0):this.istouchcapable=!0,M.enablemouselockapi||(P.hasmousecapture=!1,P.haspointerlock=!1),this.debounced=function(e,o,t){T&&(T.delaylist[e]||!1||(T.delaylist[e]={h:u(function(){T.delaylist[e].fn.call(T),T.delaylist[e]=!1},t)},o.call(T)),T.delaylist[e].fn=o)},this.synched=function(e,o){T.synclist[e]?T.synclist[e]=o:(T.synclist[e]=o,u(function(){T&&(T.synclist[e]&&T.synclist[e].call(T),T.synclist[e]=null)}))},this.unsynched=function(e){T.synclist[e]&&(T.synclist[e]=!1)},this.css=function(e,o){for(var t in o)T.saved.css.push([e,t,e.css(t)]),e.css(t,o[t])},this.scrollTop=function(e){return void 0===e?T.getScrollTop():T.setScrollTop(e)},this.scrollLeft=function(e){return void 0===e?T.getScrollLeft():T.setScrollLeft(e)};var R=function(e,o,t,r,i,s,n){this.st=e,this.ed=o,this.spd=t,this.p1=r||0,this.p2=i||1,this.p3=s||0,this.p4=n||1,this.ts=f(),this.df=o-e};if(R.prototype={B2:function(e){return 3*(1-e)*(1-e)*e},B3:function(e){return 3*(1-e)*e*e},B4:function(e){return e*e*e},getPos:function(){return(f()-this.ts)/this.spd},getNow:function(){var e=(f()-this.ts)/this.spd,o=this.B2(e)+this.B3(e)+this.B4(e);return e>=1?this.ed:this.st+this.df*o|0},update:function(e,o){return this.st=this.getNow(),this.ed=e,this.spd=o,this.ts=f(),this.df=this.ed-this.st,this}},this.ishwscroll){this.doc.translate={x:0,y:0,tx:"0px",ty:"0px"},P.hastranslate3d&&P.isios&&this.doc.css("-webkit-backface-visibility","hidden"),this.getScrollTop=function(e){if(!e){var o=v();if(o)return 16==o.length?-o[13]:-o[5];if(T.timerscroll&&T.timerscroll.bz)return T.timerscroll.bz.getNow()}return T.doc.translate.y},this.getScrollLeft=function(e){if(!e){var o=v();if(o)return 16==o.length?-o[12]:-o[4];if(T.timerscroll&&T.timerscroll.bh)return T.timerscroll.bh.getNow()}return T.doc.translate.x},this.notifyScrollEvent=function(e){var o=l.createEvent("UIEvents");o.initUIEvent("scroll",!1,!1,a,1),o.niceevent=!0,e.dispatchEvent(o)};var _=this.isrtlmode?1:-1;P.hastranslate3d&&M.enabletranslate3d?(this.setScrollTop=function(e,o){T.doc.translate.y=e,T.doc.translate.ty=-1*e+"px",T.doc.css(P.trstyle,"translate3d("+T.doc.translate.tx+","+T.doc.translate.ty+",0)"),o||T.notifyScrollEvent(T.win[0])},this.setScrollLeft=function(e,o){T.doc.translate.x=e,T.doc.translate.tx=e*_+"px",T.doc.css(P.trstyle,"translate3d("+T.doc.translate.tx+","+T.doc.translate.ty+",0)"),o||T.notifyScrollEvent(T.win[0])}):(this.setScrollTop=function(e,o){T.doc.translate.y=e,T.doc.translate.ty=-1*e+"px",T.doc.css(P.trstyle,"translate("+T.doc.translate.tx+","+T.doc.translate.ty+")"),o||T.notifyScrollEvent(T.win[0])},this.setScrollLeft=function(e,o){T.doc.translate.x=e,T.doc.translate.tx=e*_+"px",T.doc.css(P.trstyle,"translate("+T.doc.translate.tx+","+T.doc.translate.ty+")"),o||T.notifyScrollEvent(T.win[0])})}else this.getScrollTop=function(){return T.docscroll.scrollTop()},this.setScrollTop=function(e){T.docscroll.scrollTop(e)},this.getScrollLeft=function(){return T.hasreversehr?T.detected.ismozilla?T.page.maxw-Math.abs(T.docscroll.scrollLeft()):T.page.maxw-T.docscroll.scrollLeft():T.docscroll.scrollLeft()},this.setScrollLeft=function(e){return setTimeout(function(){if(T)return T.hasreversehr&&(e=T.detected.ismozilla?-(T.page.maxw-e):T.page.maxw-e),T.docscroll.scrollLeft(e)},1)};this.getTarget=function(e){return!!e&&(e.target?e.target:!!e.srcElement&&e.srcElement)},this.hasParent=function(e,o){if(!e)return!1;for(var t=e.target||e.srcElement||e||!1;t&&t.id!=o;)t=t.parentNode||!1;return!1!==t};var I={thin:1,medium:3,thick:5};this.getDocumentScrollOffset=function(){return{top:a.pageYOffset||l.documentElement.scrollTop,left:a.pageXOffset||l.documentElement.scrollLeft}},this.getOffset=function(){if(T.isfixed){var e=T.win.offset(),o=T.getDocumentScrollOffset();return e.top-=o.top,e.left-=o.left,e}var t=T.win.offset();if(!T.viewport)return t;var r=T.viewport.offset();return{top:t.top-r.top,left:t.left-r.left}},this.updateScrollBar=function(e){var o,t;if(T.ishwscroll)T.rail.css({height:T.win.innerHeight()-(M.railpadding.top+M.railpadding.bottom)}),T.railh&&T.railh.css({width:T.win.innerWidth()-(M.railpadding.left+M.railpadding.right)});else{var r=T.getOffset();if(o={top:r.top,left:r.left-(M.railpadding.left+M.railpadding.right)},o.top+=x(T.win,"border-top-width",!0),o.left+=T.rail.align?T.win.outerWidth()-x(T.win,"border-right-width")-T.rail.width:x(T.win,"border-left-width"),(t=M.railoffset)&&(t.top&&(o.top+=t.top),t.left&&(o.left+=t.left)),T.railslocked||T.rail.css({top:o.top,left:o.left,height:(e?e.h:T.win.innerHeight())-(M.railpadding.top+M.railpadding.bottom)}),T.zoom&&T.zoom.css({top:o.top+1,left:1==T.rail.align?o.left-20:o.left+T.rail.width+4}),T.railh&&!T.railslocked){o={top:r.top,left:r.left},(t=M.railhoffset)&&(t.top&&(o.top+=t.top),t.left&&(o.left+=t.left));var i=T.railh.align?o.top+x(T.win,"border-top-width",!0)+T.win.innerHeight()-T.railh.height:o.top+x(T.win,"border-top-width",!0),s=o.left+x(T.win,"border-left-width");T.railh.css({top:i-(M.railpadding.top+M.railpadding.bottom),left:s,width:T.railh.width})}}},this.doRailClick=function(e,o,t){var r,i,s,n;T.railslocked||(T.cancelEvent(e),"pageY"in e||(e.pageX=e.clientX+l.documentElement.scrollLeft,e.pageY=e.clientY+l.documentElement.scrollTop),o?(r=t?T.doScrollLeft:T.doScrollTop,s=t?(e.pageX-T.railh.offset().left-T.cursorwidth/2)*T.scrollratio.x:(e.pageY-T.rail.offset().top-T.cursorheight/2)*T.scrollratio.y,T.unsynched("relativexy"),r(0|s)):(r=t?T.doScrollLeftBy:T.doScrollBy,s=t?T.scroll.x:T.scroll.y,n=t?e.pageX-T.railh.offset().left:e.pageY-T.rail.offset().top,i=t?T.view.w:T.view.h,r(s>=n?i:-i)))},T.newscrolly=T.newscrollx=0,T.hasanimationframe="requestAnimationFrame"in a,T.hascancelanimationframe="cancelAnimationFrame"in a,T.hasborderbox=!1,this.init=function(){if(T.saved.css=[],P.isoperamini)return!0;if(P.isandroid&&!("hidden"in l))return!0;M.emulatetouch=M.emulatetouch||M.touchbehavior,T.hasborderbox=a.getComputedStyle&&"border-box"===a.getComputedStyle(l.body)["box-sizing"];var e={"overflow-y":"hidden"};if((P.isie11||P.isie10)&&(e["-ms-overflow-style"]="none"),T.ishwscroll&&(this.doc.css(P.transitionstyle,P.prefixstyle+"transform 0ms ease-out"),P.transitionend&&T.bind(T.doc,P.transitionend,T.onScrollTransitionEnd,!1)),T.zindex="auto",T.ispage||"auto"!=M.zindex?T.zindex=M.zindex:T.zindex=b()||"auto",!T.ispage&&"auto"!=T.zindex&&T.zindex>s&&(s=T.zindex),T.isie&&0===T.zindex&&"auto"==M.zindex&&(T.zindex="auto"),!T.ispage||!P.isieold){var i=T.docscroll;T.ispage&&(i=T.haswrapper?T.win:T.doc),T.css(i,e),T.ispage&&(P.isie11||P.isie)&&T.css(n("html"),e),!P.isios||T.ispage||T.haswrapper||T.css(E,{"-webkit-overflow-scrolling":"touch"});var d=n(l.createElement("div"));d.css({position:"relative",top:0,float:"right",width:M.cursorwidth,height:0,"background-color":M.cursorcolor,border:M.cursorborder,"background-clip":"padding-box","-webkit-border-radius":M.cursorborderradius,"-moz-border-radius":M.cursorborderradius,"border-radius":M.cursorborderradius}),d.addClass("nicescroll-cursors"),T.cursor=d;var u=n(l.createElement("div"));u.attr("id",T.id),u.addClass("nicescroll-rails nicescroll-rails-vr");var h,p,f=["left","right","top","bottom"];for(var g in f)p=f[g],(h=M.railpadding[p]||0)&&u.css("padding-"+p,h+"px");u.append(d),u.width=Math.max(parseFloat(M.cursorwidth),d.outerWidth()),u.css({width:u.width+"px",zIndex:T.zindex,background:M.background,cursor:"default"}),u.visibility=!0,u.scrollable=!0,u.align="left"==M.railalign?0:1,T.rail=u,T.rail.drag=!1;var v=!1;!M.boxzoom||T.ispage||P.isieold||(v=l.createElement("div"),T.bind(v,"click",T.doZoom),T.bind(v,"mouseenter",function(){T.zoom.css("opacity",M.cursoropacitymax)}),T.bind(v,"mouseleave",function(){T.zoom.css("opacity",M.cursoropacitymin)}),T.zoom=n(v),T.zoom.css({cursor:"pointer",zIndex:T.zindex,backgroundImage:"url("+M.scriptpath+"zoomico.png)",height:18,width:18,backgroundPosition:"0 0"}),M.dblclickzoom&&T.bind(T.win,"dblclick",T.doZoom),P.cantouch&&M.gesturezoom&&(T.ongesturezoom=function(e){return e.scale>1.5&&T.doZoomIn(e),e.scale<.8&&T.doZoomOut(e),T.cancelEvent(e)},T.bind(T.win,"gestureend",T.ongesturezoom))),T.railh=!1;var w;if(M.horizrailenabled&&(T.css(i,{overflowX:"hidden"}),(d=n(l.createElement("div"))).css({position:"absolute",top:0,height:M.cursorwidth,width:0,backgroundColor:M.cursorcolor,border:M.cursorborder,backgroundClip:"padding-box","-webkit-border-radius":M.cursorborderradius,"-moz-border-radius":M.cursorborderradius,"border-radius":M.cursorborderradius}),P.isieold&&d.css("overflow","hidden"),d.addClass("nicescroll-cursors"),T.cursorh=d,(w=n(l.createElement("div"))).attr("id",T.id+"-hr"),w.addClass("nicescroll-rails nicescroll-rails-hr"),w.height=Math.max(parseFloat(M.cursorwidth),d.outerHeight()),w.css({height:w.height+"px",zIndex:T.zindex,background:M.background}),w.append(d),w.visibility=!0,w.scrollable=!0,w.align="top"==M.railvalign?0:1,T.railh=w,T.railh.drag=!1),T.ispage)u.css({position:"fixed",top:0,height:"100%"}),u.css(u.align?{right:0}:{left:0}),T.body.append(u),T.railh&&(w.css({position:"fixed",left:0,width:"100%"}),w.css(w.align?{bottom:0}:{top:0}),T.body.append(w));else{if(T.ishwscroll){"static"==T.win.css("position")&&T.css(T.win,{position:"relative"});var x="HTML"==T.win[0].nodeName?T.body:T.win;n(x).scrollTop(0).scrollLeft(0),T.zoom&&(T.zoom.css({position:"absolute",top:1,right:0,"margin-right":u.width+4}),x.append(T.zoom)),u.css({position:"absolute",top:0}),u.css(u.align?{right:0}:{left:0}),x.append(u),w&&(w.css({position:"absolute",left:0,bottom:0}),w.css(w.align?{bottom:0}:{top:0}),x.append(w))}else{T.isfixed="fixed"==T.win.css("position");var S=T.isfixed?"fixed":"absolute";T.isfixed||(T.viewport=T.getViewport(T.win[0])),T.viewport&&(T.body=T.viewport,/fixed|absolute/.test(T.viewport.css("position"))||T.css(T.viewport,{position:"relative"})),u.css({position:S}),T.zoom&&T.zoom.css({position:S}),T.updateScrollBar(),T.body.append(u),T.zoom&&T.body.append(T.zoom),T.railh&&(w.css({position:S}),T.body.append(w))}P.isios&&T.css(T.win,{"-webkit-tap-highlight-color":"rgba(0,0,0,0)","-webkit-touch-callout":"none"}),M.disableoutline&&(P.isie&&T.win.attr("hideFocus","true"),P.iswebkit&&T.win.css("outline","none"))}if(!1===M.autohidemode?(T.autohidedom=!1,T.rail.css({opacity:M.cursoropacitymax}),T.railh&&T.railh.css({opacity:M.cursoropacitymax})):!0===M.autohidemode||"leave"===M.autohidemode?(T.autohidedom=n().add(T.rail),P.isie8&&(T.autohidedom=T.autohidedom.add(T.cursor)),T.railh&&(T.autohidedom=T.autohidedom.add(T.railh)),T.railh&&P.isie8&&(T.autohidedom=T.autohidedom.add(T.cursorh))):"scroll"==M.autohidemode?(T.autohidedom=n().add(T.rail),T.railh&&(T.autohidedom=T.autohidedom.add(T.railh))):"cursor"==M.autohidemode?(T.autohidedom=n().add(T.cursor),T.railh&&(T.autohidedom=T.autohidedom.add(T.cursorh))):"hidden"==M.autohidemode&&(T.autohidedom=!1,T.hide(),T.railslocked=!1),P.cantouch||T.istouchcapable||M.emulatetouch||P.hasmstouch){T.scrollmom=new y(T);T.ontouchstart=function(e){if(T.locked)return!1;if(e.pointerType&&("mouse"===e.pointerType||e.pointerType===e.MSPOINTER_TYPE_MOUSE))return!1;if(T.hasmoving=!1,T.scrollmom.timer&&(T.triggerScrollEnd(),T.scrollmom.stop()),!T.railslocked){var o=T.getTarget(e);if(o&&/INPUT/i.test(o.nodeName)&&/range/i.test(o.type))return T.stopPropagation(e);var t="mousedown"===e.type;if(!("clientX"in e)&&"changedTouches"in e&&(e.clientX=e.changedTouches[0].clientX,e.clientY=e.changedTouches[0].clientY),T.forcescreen){var r=e;(e={original:e.original?e.original:e}).clientX=r.screenX,e.clientY=r.screenY}if(T.rail.drag={x:e.clientX,y:e.clientY,sx:T.scroll.x,sy:T.scroll.y,st:T.getScrollTop(),sl:T.getScrollLeft(),pt:2,dl:!1,tg:o},T.ispage||!M.directionlockdeadzone)T.rail.drag.dl="f";else{var i={w:c.width(),h:c.height()},s=T.getContentSize(),l=s.h-i.h,a=s.w-i.w;T.rail.scrollable&&!T.railh.scrollable?T.rail.drag.ck=l>0&&"v":!T.rail.scrollable&&T.railh.scrollable?T.rail.drag.ck=a>0&&"h":T.rail.drag.ck=!1}if(M.emulatetouch&&T.isiframe&&P.isie){var d=T.win.position();T.rail.drag.x+=d.left,T.rail.drag.y+=d.top}if(T.hasmoving=!1,T.lastmouseup=!1,T.scrollmom.reset(e.clientX,e.clientY),o&&t){if(!/INPUT|SELECT|BUTTON|TEXTAREA/i.test(o.nodeName))return P.hasmousecapture&&o.setCapture(),M.emulatetouch?(o.onclick&&!o._onclick&&(o._onclick=o.onclick,o.onclick=function(e){if(T.hasmoving)return!1;o._onclick.call(this,e)}),T.cancelEvent(e)):T.stopPropagation(e);/SUBMIT|CANCEL|BUTTON/i.test(n(o).attr("type"))&&(T.preventclick={tg:o,click:!1})}}},T.ontouchend=function(e){if(!T.rail.drag)return!0;if(2==T.rail.drag.pt){if(e.pointerType&&("mouse"===e.pointerType||e.pointerType===e.MSPOINTER_TYPE_MOUSE))return!1;T.rail.drag=!1;var o="mouseup"===e.type;if(T.hasmoving&&(T.scrollmom.doMomentum(),T.lastmouseup=!0,T.hideCursor(),P.hasmousecapture&&l.releaseCapture(),o))return T.cancelEvent(e)}else if(1==T.rail.drag.pt)return T.onmouseup(e)};var z=M.emulatetouch&&T.isiframe&&!P.hasmousecapture,k=.3*M.directionlockdeadzone|0;T.ontouchmove=function(e,o){if(!T.rail.drag)return!0;if(e.targetTouches&&M.preventmultitouchscrolling&&e.targetTouches.length>1)return!0;if(e.pointerType&&("mouse"===e.pointerType||e.pointerType===e.MSPOINTER_TYPE_MOUSE))return!0;if(2==T.rail.drag.pt){"changedTouches"in e&&(e.clientX=e.changedTouches[0].clientX,e.clientY=e.changedTouches[0].clientY);var t,r;if(r=t=0,z&&!o){var i=T.win.position();r=-i.left,t=-i.top}var s=e.clientY+t,n=s-T.rail.drag.y,a=e.clientX+r,c=a-T.rail.drag.x,d=T.rail.drag.st-n;if(T.ishwscroll&&M.bouncescroll)d<0?d=Math.round(d/2):d>T.page.maxh&&(d=T.page.maxh+Math.round((d-T.page.maxh)/2));else if(d<0?(d=0,s=0):d>T.page.maxh&&(d=T.page.maxh,s=0),0===s&&!T.hasmoving)return T.ispage||(T.rail.drag=!1),!0;var u=T.getScrollLeft();if(T.railh&&T.railh.scrollable&&(u=T.isrtlmode?c-T.rail.drag.sl:T.rail.drag.sl-c,T.ishwscroll&&M.bouncescroll?u<0?u=Math.round(u/2):u>T.page.maxw&&(u=T.page.maxw+Math.round((u-T.page.maxw)/2)):(u<0&&(u=0,a=0),u>T.page.maxw&&(u=T.page.maxw,a=0))),!T.hasmoving){if(T.rail.drag.y===e.clientY&&T.rail.drag.x===e.clientX)return T.cancelEvent(e);var h=Math.abs(n),p=Math.abs(c),m=M.directionlockdeadzone;if(T.rail.drag.ck?"v"==T.rail.drag.ck?p>m&&h<=k?T.rail.drag=!1:h>m&&(T.rail.drag.dl="v"):"h"==T.rail.drag.ck&&(h>m&&p<=k?T.rail.drag=!1:p>m&&(T.rail.drag.dl="h")):h>m&&p>m?T.rail.drag.dl="f":h>m?T.rail.drag.dl=p>k?"f":"v":p>m&&(T.rail.drag.dl=h>k?"f":"h"),!T.rail.drag.dl)return T.cancelEvent(e);T.triggerScrollStart(e.clientX,e.clientY,0,0,0),T.hasmoving=!0}return T.preventclick&&!T.preventclick.click&&(T.preventclick.click=T.preventclick.tg.onclick||!1,T.preventclick.tg.onclick=T.onpreventclick),T.rail.drag.dl&&("v"==T.rail.drag.dl?u=T.rail.drag.sl:"h"==T.rail.drag.dl&&(d=T.rail.drag.st)),T.synched("touchmove",function(){T.rail.drag&&2==T.rail.drag.pt&&(T.prepareTransition&&T.resetTransition(),T.rail.scrollable&&T.setScrollTop(d),T.scrollmom.update(a,s),T.railh&&T.railh.scrollable?(T.setScrollLeft(u),T.showCursor(d,u)):T.showCursor(d),P.isie10&&l.selection.clear())}),T.cancelEvent(e)}return 1==T.rail.drag.pt?T.onmousemove(e):void 0},T.ontouchstartCursor=function(e,o){if(!T.rail.drag||3==T.rail.drag.pt){if(T.locked)return T.cancelEvent(e);T.cancelScroll(),T.rail.drag={x:e.touches[0].clientX,y:e.touches[0].clientY,sx:T.scroll.x,sy:T.scroll.y,pt:3,hr:!!o};var t=T.getTarget(e);return!T.ispage&&P.hasmousecapture&&t.setCapture(),T.isiframe&&!P.hasmousecapture&&(T.saved.csspointerevents=T.doc.css("pointer-events"),T.css(T.doc,{"pointer-events":"none"})),T.cancelEvent(e)}},T.ontouchendCursor=function(e){if(T.rail.drag){if(P.hasmousecapture&&l.releaseCapture(),T.isiframe&&!P.hasmousecapture&&T.doc.css("pointer-events",T.saved.csspointerevents),3!=T.rail.drag.pt)return;return T.rail.drag=!1,T.cancelEvent(e)}},T.ontouchmoveCursor=function(e){if(T.rail.drag){if(3!=T.rail.drag.pt)return;if(T.cursorfreezed=!0,T.rail.drag.hr){T.scroll.x=T.rail.drag.sx+(e.touches[0].clientX-T.rail.drag.x),T.scroll.x<0&&(T.scroll.x=0);var o=T.scrollvaluemaxw;T.scroll.x>o&&(T.scroll.x=o)}else{T.scroll.y=T.rail.drag.sy+(e.touches[0].clientY-T.rail.drag.y),T.scroll.y<0&&(T.scroll.y=0);var t=T.scrollvaluemax;T.scroll.y>t&&(T.scroll.y=t)}return T.synched("touchmove",function(){T.rail.drag&&3==T.rail.drag.pt&&(T.showCursor(),T.rail.drag.hr?T.doScrollLeft(Math.round(T.scroll.x*T.scrollratio.x),M.cursordragspeed):T.doScrollTop(Math.round(T.scroll.y*T.scrollratio.y),M.cursordragspeed))}),T.cancelEvent(e)}}}if(T.onmousedown=function(e,o){if(!T.rail.drag||1==T.rail.drag.pt){if(T.railslocked)return T.cancelEvent(e);T.cancelScroll(),T.rail.drag={x:e.clientX,y:e.clientY,sx:T.scroll.x,sy:T.scroll.y,pt:1,hr:o||!1};var t=T.getTarget(e);return P.hasmousecapture&&t.setCapture(),T.isiframe&&!P.hasmousecapture&&(T.saved.csspointerevents=T.doc.css("pointer-events"),T.css(T.doc,{"pointer-events":"none"})),T.hasmoving=!1,T.cancelEvent(e)}},T.onmouseup=function(e){if(T.rail.drag)return 1!=T.rail.drag.pt||(P.hasmousecapture&&l.releaseCapture(),T.isiframe&&!P.hasmousecapture&&T.doc.css("pointer-events",T.saved.csspointerevents),T.rail.drag=!1,T.cursorfreezed=!1,T.hasmoving&&T.triggerScrollEnd(),T.cancelEvent(e))},T.onmousemove=function(e){if(T.rail.drag){if(1!==T.rail.drag.pt)return;if(P.ischrome&&0===e.which)return T.onmouseup(e);if(T.cursorfreezed=!0,T.hasmoving||T.triggerScrollStart(e.clientX,e.clientY,0,0,0),T.hasmoving=!0,T.rail.drag.hr){T.scroll.x=T.rail.drag.sx+(e.clientX-T.rail.drag.x),T.scroll.x<0&&(T.scroll.x=0);var o=T.scrollvaluemaxw;T.scroll.x>o&&(T.scroll.x=o)}else{T.scroll.y=T.rail.drag.sy+(e.clientY-T.rail.drag.y),T.scroll.y<0&&(T.scroll.y=0);var t=T.scrollvaluemax;T.scroll.y>t&&(T.scroll.y=t)}return T.synched("mousemove",function(){T.cursorfreezed&&(T.showCursor(),T.rail.drag.hr?T.scrollLeft(Math.round(T.scroll.x*T.scrollratio.x)):T.scrollTop(Math.round(T.scroll.y*T.scrollratio.y)))}),T.cancelEvent(e)}T.checkarea=0},P.cantouch||M.emulatetouch)T.onpreventclick=function(e){if(T.preventclick)return T.preventclick.tg.onclick=T.preventclick.click,T.preventclick=!1,T.cancelEvent(e)},T.onclick=!P.isios&&function(e){return!T.lastmouseup||(T.lastmouseup=!1,T.cancelEvent(e))},M.grabcursorenabled&&P.cursorgrabvalue&&(T.css(T.ispage?T.doc:T.win,{cursor:P.cursorgrabvalue}),T.css(T.rail,{cursor:P.cursorgrabvalue}));else{var L=function(e){if(T.selectiondrag){if(e){var o=T.win.outerHeight(),t=e.pageY-T.selectiondrag.top;t>0&&t<o&&(t=0),t>=o&&(t-=o),T.selectiondrag.df=t}if(0!==T.selectiondrag.df){var r=-2*T.selectiondrag.df/6|0;T.doScrollBy(r),T.debounced("doselectionscroll",function(){L()},50)}}};T.hasTextSelected="getSelection"in l?function(){return l.getSelection().rangeCount>0}:"selection"in l?function(){return"None"!=l.selection.type}:function(){return!1},T.onselectionstart=function(e){T.ispage||(T.selectiondrag=T.win.offset())},T.onselectionend=function(e){T.selectiondrag=!1},T.onselectiondrag=function(e){T.selectiondrag&&T.hasTextSelected()&&T.debounced("selectionscroll",function(){L(e)},250)}}if(P.hasw3ctouch?(T.css(T.ispage?n("html"):T.win,{"touch-action":"none"}),T.css(T.rail,{"touch-action":"none"}),T.css(T.cursor,{"touch-action":"none"}),T.bind(T.win,"pointerdown",T.ontouchstart),T.bind(l,"pointerup",T.ontouchend),T.delegate(l,"pointermove",T.ontouchmove)):P.hasmstouch?(T.css(T.ispage?n("html"):T.win,{"-ms-touch-action":"none"}),T.css(T.rail,{"-ms-touch-action":"none"}),T.css(T.cursor,{"-ms-touch-action":"none"}),T.bind(T.win,"MSPointerDown",T.ontouchstart),T.bind(l,"MSPointerUp",T.ontouchend),T.delegate(l,"MSPointerMove",T.ontouchmove),T.bind(T.cursor,"MSGestureHold",function(e){e.preventDefault()}),T.bind(T.cursor,"contextmenu",function(e){e.preventDefault()})):P.cantouch&&(T.bind(T.win,"touchstart",T.ontouchstart,!1,!0),T.bind(l,"touchend",T.ontouchend,!1,!0),T.bind(l,"touchcancel",T.ontouchend,!1,!0),T.delegate(l,"touchmove",T.ontouchmove,!1,!0)),M.emulatetouch&&(T.bind(T.win,"mousedown",T.ontouchstart,!1,!0),T.bind(l,"mouseup",T.ontouchend,!1,!0),T.bind(l,"mousemove",T.ontouchmove,!1,!0)),(M.cursordragontouch||!P.cantouch&&!M.emulatetouch)&&(T.rail.css({cursor:"default"}),T.railh&&T.railh.css({cursor:"default"}),T.jqbind(T.rail,"mouseenter",function(){if(!T.ispage&&!T.win.is(":visible"))return!1;T.canshowonmouseevent&&T.showCursor(),T.rail.active=!0}),T.jqbind(T.rail,"mouseleave",function(){T.rail.active=!1,T.rail.drag||T.hideCursor()}),M.sensitiverail&&(T.bind(T.rail,"click",function(e){T.doRailClick(e,!1,!1)}),T.bind(T.rail,"dblclick",function(e){T.doRailClick(e,!0,!1)}),T.bind(T.cursor,"click",function(e){T.cancelEvent(e)}),T.bind(T.cursor,"dblclick",function(e){T.cancelEvent(e)})),T.railh&&(T.jqbind(T.railh,"mouseenter",function(){if(!T.ispage&&!T.win.is(":visible"))return!1;T.canshowonmouseevent&&T.showCursor(),T.rail.active=!0}),T.jqbind(T.railh,"mouseleave",function(){T.rail.active=!1,T.rail.drag||T.hideCursor()}),M.sensitiverail&&(T.bind(T.railh,"click",function(e){T.doRailClick(e,!1,!0)}),T.bind(T.railh,"dblclick",function(e){T.doRailClick(e,!0,!0)}),T.bind(T.cursorh,"click",function(e){T.cancelEvent(e)}),T.bind(T.cursorh,"dblclick",function(e){T.cancelEvent(e)})))),M.cursordragontouch&&(this.istouchcapable||P.cantouch)&&(T.bind(T.cursor,"touchstart",T.ontouchstartCursor),T.bind(T.cursor,"touchmove",T.ontouchmoveCursor),T.bind(T.cursor,"touchend",T.ontouchendCursor),T.cursorh&&T.bind(T.cursorh,"touchstart",function(e){T.ontouchstartCursor(e,!0)}),T.cursorh&&T.bind(T.cursorh,"touchmove",T.ontouchmoveCursor),T.cursorh&&T.bind(T.cursorh,"touchend",T.ontouchendCursor)),M.emulatetouch||P.isandroid||P.isios?(T.bind(P.hasmousecapture?T.win:l,"mouseup",T.ontouchend),T.onclick&&T.bind(l,"click",T.onclick),M.cursordragontouch?(T.bind(T.cursor,"mousedown",T.onmousedown),T.bind(T.cursor,"mouseup",T.onmouseup),T.cursorh&&T.bind(T.cursorh,"mousedown",function(e){T.onmousedown(e,!0)}),T.cursorh&&T.bind(T.cursorh,"mouseup",T.onmouseup)):(T.bind(T.rail,"mousedown",function(e){e.preventDefault()}),T.railh&&T.bind(T.railh,"mousedown",function(e){e.preventDefault()}))):(T.bind(P.hasmousecapture?T.win:l,"mouseup",T.onmouseup),T.bind(l,"mousemove",T.onmousemove),T.onclick&&T.bind(l,"click",T.onclick),T.bind(T.cursor,"mousedown",T.onmousedown),T.bind(T.cursor,"mouseup",T.onmouseup),T.railh&&(T.bind(T.cursorh,"mousedown",function(e){T.onmousedown(e,!0)}),T.bind(T.cursorh,"mouseup",T.onmouseup)),!T.ispage&&M.enablescrollonselection&&(T.bind(T.win[0],"mousedown",T.onselectionstart),T.bind(l,"mouseup",T.onselectionend),T.bind(T.cursor,"mouseup",T.onselectionend),T.cursorh&&T.bind(T.cursorh,"mouseup",T.onselectionend),T.bind(l,"mousemove",T.onselectiondrag)),T.zoom&&(T.jqbind(T.zoom,"mouseenter",function(){T.canshowonmouseevent&&T.showCursor(),T.rail.active=!0}),T.jqbind(T.zoom,"mouseleave",function(){T.rail.active=!1,T.rail.drag||T.hideCursor()}))),M.enablemousewheel&&(T.isiframe||T.mousewheel(P.isie&&T.ispage?l:T.win,T.onmousewheel),T.mousewheel(T.rail,T.onmousewheel),T.railh&&T.mousewheel(T.railh,T.onmousewheelhr)),T.ispage||P.cantouch||/HTML|^BODY/.test(T.win[0].nodeName)||(T.win.attr("tabindex")||T.win.attr({tabindex:++r}),T.bind(T.win,"focus",function(e){o=T.getTarget(e).id||T.getTarget(e)||!1,T.hasfocus=!0,T.canshowonmouseevent&&T.noticeCursor()}),T.bind(T.win,"blur",function(e){o=!1,T.hasfocus=!1}),T.bind(T.win,"mouseenter",function(e){t=T.getTarget(e).id||T.getTarget(e)||!1,T.hasmousefocus=!0,T.canshowonmouseevent&&T.noticeCursor()}),T.bind(T.win,"mouseleave",function(e){t=!1,T.hasmousefocus=!1,T.rail.drag||T.hideCursor()})),T.onkeypress=function(e){if(T.railslocked&&0===T.page.maxh)return!0;e=e||a.event;var r=T.getTarget(e);if(r&&/INPUT|TEXTAREA|SELECT|OPTION/.test(r.nodeName)&&(!(r.getAttribute("type")||r.type||!1)||!/submit|button|cancel/i.tp))return!0;if(n(r).attr("contenteditable"))return!0;if(T.hasfocus||T.hasmousefocus&&!o||T.ispage&&!o&&!t){var i=e.keyCode;if(T.railslocked&&27!=i)return T.cancelEvent(e);var s=e.ctrlKey||!1,l=e.shiftKey||!1,c=!1;switch(i){case 38:case 63233:T.doScrollBy(72),c=!0;break;case 40:case 63235:T.doScrollBy(-72),c=!0;break;case 37:case 63232:T.railh&&(s?T.doScrollLeft(0):T.doScrollLeftBy(72),c=!0);break;case 39:case 63234:T.railh&&(s?T.doScrollLeft(T.page.maxw):T.doScrollLeftBy(-72),c=!0);break;case 33:case 63276:T.doScrollBy(T.view.h),c=!0;break;case 34:case 63277:T.doScrollBy(-T.view.h),c=!0;break;case 36:case 63273:T.railh&&s?T.doScrollPos(0,0):T.doScrollTo(0),c=!0;break;case 35:case 63275:T.railh&&s?T.doScrollPos(T.page.maxw,T.page.maxh):T.doScrollTo(T.page.maxh),c=!0;break;case 32:M.spacebarenabled&&(l?T.doScrollBy(T.view.h):T.doScrollBy(-T.view.h),c=!0);break;case 27:T.zoomactive&&(T.doZoom(),c=!0)}if(c)return T.cancelEvent(e)}},M.enablekeyboard&&T.bind(l,P.isopera&&!P.isopera12?"keypress":"keydown",T.onkeypress),T.bind(l,"keydown",function(e){(e.ctrlKey||!1)&&(T.wheelprevented=!0)}),T.bind(l,"keyup",function(e){e.ctrlKey||!1||(T.wheelprevented=!1)}),T.bind(a,"blur",function(e){T.wheelprevented=!1}),T.bind(a,"resize",T.onscreenresize),T.bind(a,"orientationchange",T.onscreenresize),T.bind(a,"load",T.lazyResize),P.ischrome&&!T.ispage&&!T.haswrapper){var C=T.win.attr("style"),N=parseFloat(T.win.css("width"))+1;T.win.css("width",N),T.synched("chromefix",function(){T.win.attr("style",C)})}if(T.onAttributeChange=function(e){T.lazyResize(T.isieold?250:30)},M.enableobserver&&(T.isie11||!1===m||(T.observerbody=new m(function(e){if(e.forEach(function(e){if("attributes"==e.type)return E.hasClass("modal-open")&&E.hasClass("modal-dialog")&&!n.contains(n(".modal-dialog")[0],T.doc[0])?T.hide():T.show()}),T.me.clientWidth!=T.page.width||T.me.clientHeight!=T.page.height)return T.lazyResize(30)}),T.observerbody.observe(l.body,{childList:!0,subtree:!0,characterData:!1,attributes:!0,attributeFilter:["class"]})),!T.ispage&&!T.haswrapper)){var R=T.win[0];!1!==m?(T.observer=new m(function(e){e.forEach(T.onAttributeChange)}),T.observer.observe(R,{childList:!0,characterData:!1,attributes:!0,subtree:!1}),T.observerremover=new m(function(e){e.forEach(function(e){if(e.removedNodes.length>0)for(var o in e.removedNodes)if(T&&e.removedNodes[o]===R)return T.remove()})}),T.observerremover.observe(R.parentNode,{childList:!0,characterData:!1,attributes:!1,subtree:!1})):(T.bind(R,P.isie&&!P.isie9?"propertychange":"DOMAttrModified",T.onAttributeChange),P.isie9&&R.attachEvent("onpropertychange",T.onAttributeChange),T.bind(R,"DOMNodeRemoved",function(e){e.target===R&&T.remove()}))}!T.ispage&&M.boxzoom&&T.bind(a,"resize",T.resizeZoom),T.istextarea&&(T.bind(T.win,"keydown",T.lazyResize),T.bind(T.win,"mouseup",T.lazyResize)),T.lazyResize(30)}if("IFRAME"==this.doc[0].nodeName){var _=function(){T.iframexd=!1;var o;try{(o="contentDocument"in this?this.contentDocument:this.contentWindow._doc).domain}catch(e){T.iframexd=!0,o=!1}if(T.iframexd)return"console"in a&&console.log("NiceScroll error: policy restriced iframe"),!0;if(T.forcescreen=!0,T.isiframe&&(T.iframe={doc:n(o),html:T.doc.contents().find("html")[0],body:T.doc.contents().find("body")[0]},T.getContentSize=function(){return{w:Math.max(T.iframe.html.scrollWidth,T.iframe.body.scrollWidth),h:Math.max(T.iframe.html.scrollHeight,T.iframe.body.scrollHeight)}},T.docscroll=n(T.iframe.body)),!P.isios&&M.iframeautoresize&&!T.isiframe){T.win.scrollTop(0),T.doc.height("");var t=Math.max(o.getElementsByTagName("html")[0].scrollHeight,o.body.scrollHeight);T.doc.height(t)}T.lazyResize(30),T.css(n(T.iframe.body),e),P.isios&&T.haswrapper&&T.css(n(o.body),{"-webkit-transform":"translate3d(0,0,0)"}),"contentWindow"in this?T.bind(this.contentWindow,"scroll",T.onscroll):T.bind(o,"scroll",T.onscroll),M.enablemousewheel&&T.mousewheel(o,T.onmousewheel),M.enablekeyboard&&T.bind(o,P.isopera?"keypress":"keydown",T.onkeypress),P.cantouch?(T.bind(o,"touchstart",T.ontouchstart),T.bind(o,"touchmove",T.ontouchmove)):M.emulatetouch&&(T.bind(o,"mousedown",T.ontouchstart),T.bind(o,"mousemove",function(e){return T.ontouchmove(e,!0)}),M.grabcursorenabled&&P.cursorgrabvalue&&T.css(n(o.body),{cursor:P.cursorgrabvalue})),T.bind(o,"mouseup",T.ontouchend),T.zoom&&(M.dblclickzoom&&T.bind(o,"dblclick",T.doZoom),T.ongesturezoom&&T.bind(o,"gestureend",T.ongesturezoom))};this.doc[0].readyState&&"complete"===this.doc[0].readyState&&setTimeout(function(){_.call(T.doc[0],!1)},500),T.bind(this.doc,"load",_)}},this.showCursor=function(e,o){if(T.cursortimeout&&(clearTimeout(T.cursortimeout),T.cursortimeout=0),T.rail){if(T.autohidedom&&(T.autohidedom.stop().css({opacity:M.cursoropacitymax}),T.cursoractive=!0),T.rail.drag&&1==T.rail.drag.pt||(void 0!==e&&!1!==e&&(T.scroll.y=e/T.scrollratio.y|0),void 0!==o&&(T.scroll.x=o/T.scrollratio.x|0)),T.cursor.css({height:T.cursorheight,top:T.scroll.y}),T.cursorh){var t=T.hasreversehr?T.scrollvaluemaxw-T.scroll.x:T.scroll.x;T.cursorh.css({width:T.cursorwidth,left:!T.rail.align&&T.rail.visibility?t+T.rail.width:t}),T.cursoractive=!0}T.zoom&&T.zoom.stop().css({opacity:M.cursoropacitymax})}},this.hideCursor=function(e){T.cursortimeout||T.rail&&T.autohidedom&&(T.hasmousefocus&&"leave"===M.autohidemode||(T.cursortimeout=setTimeout(function(){T.rail.active&&T.showonmouseevent||(T.autohidedom.stop().animate({opacity:M.cursoropacitymin}),T.zoom&&T.zoom.stop().animate({opacity:M.cursoropacitymin}),T.cursoractive=!1),T.cursortimeout=0},e||M.hidecursordelay)))},this.noticeCursor=function(e,o,t){T.showCursor(o,t),T.rail.active||T.hideCursor(e)},this.getContentSize=T.ispage?function(){return{w:Math.max(l.body.scrollWidth,l.documentElement.scrollWidth),h:Math.max(l.body.scrollHeight,l.documentElement.scrollHeight)}}:T.haswrapper?function(){return{w:T.doc[0].offsetWidth,h:T.doc[0].offsetHeight}}:function(){return{w:T.docscroll[0].scrollWidth,h:T.docscroll[0].scrollHeight}},this.onResize=function(e,o){if(!T||!T.win)return!1;var t=T.page.maxh,r=T.page.maxw,i=T.view.h,s=T.view.w;if(T.view={w:T.ispage?T.win.width():T.win[0].clientWidth,h:T.ispage?T.win.height():T.win[0].clientHeight},T.page=o||T.getContentSize(),T.page.maxh=Math.max(0,T.page.h-T.view.h),T.page.maxw=Math.max(0,T.page.w-T.view.w),T.page.maxh==t&&T.page.maxw==r&&T.view.w==s&&T.view.h==i){if(T.ispage)return T;var n=T.win.offset();if(T.lastposition){var l=T.lastposition;if(l.top==n.top&&l.left==n.left)return T}T.lastposition=n}return 0===T.page.maxh?(T.hideRail(),T.scrollvaluemax=0,T.scroll.y=0,T.scrollratio.y=0,T.cursorheight=0,T.setScrollTop(0),T.rail&&(T.rail.scrollable=!1)):(T.page.maxh-=M.railpadding.top+M.railpadding.bottom,T.rail.scrollable=!0),0===T.page.maxw?(T.hideRailHr(),T.scrollvaluemaxw=0,T.scroll.x=0,T.scrollratio.x=0,T.cursorwidth=0,T.setScrollLeft(0),T.railh&&(T.railh.scrollable=!1)):(T.page.maxw-=M.railpadding.left+M.railpadding.right,T.railh&&(T.railh.scrollable=M.horizrailenabled)),T.railslocked=T.locked||0===T.page.maxh&&0===T.page.maxw,T.railslocked?(T.ispage||T.updateScrollBar(T.view),!1):(T.hidden||(T.rail.visibility||T.showRail(),T.railh&&!T.railh.visibility&&T.showRailHr()),T.istextarea&&T.win.css("resize")&&"none"!=T.win.css("resize")&&(T.view.h-=20),T.cursorheight=Math.min(T.view.h,Math.round(T.view.h*(T.view.h/T.page.h))),T.cursorheight=M.cursorfixedheight?M.cursorfixedheight:Math.max(M.cursorminheight,T.cursorheight),T.cursorwidth=Math.min(T.view.w,Math.round(T.view.w*(T.view.w/T.page.w))),T.cursorwidth=M.cursorfixedheight?M.cursorfixedheight:Math.max(M.cursorminheight,T.cursorwidth),T.scrollvaluemax=T.view.h-T.cursorheight-(M.railpadding.top+M.railpadding.bottom),T.hasborderbox||(T.scrollvaluemax-=T.cursor[0].offsetHeight-T.cursor[0].clientHeight),T.railh&&(T.railh.width=T.page.maxh>0?T.view.w-T.rail.width:T.view.w,T.scrollvaluemaxw=T.railh.width-T.cursorwidth-(M.railpadding.left+M.railpadding.right)),T.ispage||T.updateScrollBar(T.view),T.scrollratio={x:T.page.maxw/T.scrollvaluemaxw,y:T.page.maxh/T.scrollvaluemax},T.getScrollTop()>T.page.maxh?T.doScrollTop(T.page.maxh):(T.scroll.y=T.getScrollTop()/T.scrollratio.y|0,T.scroll.x=T.getScrollLeft()/T.scrollratio.x|0,T.cursoractive&&T.noticeCursor()),T.scroll.y&&0===T.getScrollTop()&&T.doScrollTo(T.scroll.y*T.scrollratio.y|0),T)},this.resize=T.onResize;var O=0;this.onscreenresize=function(e){clearTimeout(O);var o=!T.ispage&&!T.haswrapper;o&&T.hideRails(),O=setTimeout(function(){T&&(o&&T.showRails(),T.resize()),O=0},120)},this.lazyResize=function(e){return clearTimeout(O),e=isNaN(e)?240:e,O=setTimeout(function(){T&&T.resize(),O=0},e),T},this.jqbind=function(e,o,t){T.events.push({e:e,n:o,f:t,q:!0}),n(e).on(o,t)},this.mousewheel=function(e,o,t){var r="jquery"in e?e[0]:e;if("onwheel"in l.createElement("div"))T._bind(r,"wheel",o,t||!1);else{var i=void 0!==l.onmousewheel?"mousewheel":"DOMMouseScroll";S(r,i,o,t||!1),"DOMMouseScroll"==i&&S(r,"MozMousePixelScroll",o,t||!1)}};var Y=!1;if(P.haseventlistener){try{var H=Object.defineProperty({},"passive",{get:function(){Y=!0}});a.addEventListener("test",null,H)}catch(e){}this.stopPropagation=function(e){return!!e&&((e=e.original?e.original:e).stopPropagation(),!1)},this.cancelEvent=function(e){return e.cancelable&&e.preventDefault(),e.stopImmediatePropagation(),e.preventManipulation&&e.preventManipulation(),!1}}else Event.prototype.preventDefault=function(){this.returnValue=!1},Event.prototype.stopPropagation=function(){this.cancelBubble=!0},a.constructor.prototype.addEventListener=l.constructor.prototype.addEventListener=Element.prototype.addEventListener=function(e,o,t){this.attachEvent("on"+e,o)},a.constructor.prototype.removeEventListener=l.constructor.prototype.removeEventListener=Element.prototype.removeEventListener=function(e,o,t){this.detachEvent("on"+e,o)},this.cancelEvent=function(e){return(e=e||a.event)&&(e.cancelBubble=!0,e.cancel=!0,e.returnValue=!1),!1},this.stopPropagation=function(e){return(e=e||a.event)&&(e.cancelBubble=!0),!1};this.delegate=function(e,o,t,r,i){var s=d[o]||!1;s||(s={a:[],l:[],f:function(e){for(var o=s.l,t=!1,r=o.length-1;r>=0;r--)if(!1===(t=o[r].call(e.target,e)))return!1;return t}},T.bind(e,o,s.f,r,i),d[o]=s),T.ispage?(s.a=[T.id].concat(s.a),s.l=[t].concat(s.l)):(s.a.push(T.id),s.l.push(t))},this.undelegate=function(e,o,t,r,i){var s=d[o]||!1;if(s&&s.l)for(var n=0,l=s.l.length;n<l;n++)s.a[n]===T.id&&(s.a.splice(n),s.l.splice(n),0===s.a.length&&(T._unbind(e,o,s.l.f),d[o]=null))},this.bind=function(e,o,t,r,i){var s="jquery"in e?e[0]:e;T._bind(s,o,t,r||!1,i||!1)},this._bind=function(e,o,t,r,i){T.events.push({e:e,n:o,f:t,b:r,q:!1}),Y&&i?e.addEventListener(o,t,{passive:!1,capture:r}):e.addEventListener(o,t,r||!1)},this._unbind=function(e,o,t,r){d[o]?T.undelegate(e,o,t,r):e.removeEventListener(o,t,r)},this.unbindAll=function(){for(var e=0;e<T.events.length;e++){var o=T.events[e];o.q?o.e.unbind(o.n,o.f):T._unbind(o.e,o.n,o.f,o.b)}},this.showRails=function(){return T.showRail().showRailHr()},this.showRail=function(){return 0===T.page.maxh||!T.ispage&&"none"==T.win.css("display")||(T.rail.visibility=!0,T.rail.css("display","block")),T},this.showRailHr=function(){return T.railh&&(0===T.page.maxw||!T.ispage&&"none"==T.win.css("display")||(T.railh.visibility=!0,T.railh.css("display","block"))),T},this.hideRails=function(){return T.hideRail().hideRailHr()},this.hideRail=function(){return T.rail.visibility=!1,T.rail.css("display","none"),T},this.hideRailHr=function(){return T.railh&&(T.railh.visibility=!1,T.railh.css("display","none")),T},this.show=function(){return T.hidden=!1,T.railslocked=!1,T.showRails()},this.hide=function(){return T.hidden=!0,T.railslocked=!0,T.hideRails()},this.toggle=function(){return T.hidden?T.show():T.hide()},this.remove=function(){T.stop(),T.cursortimeout&&clearTimeout(T.cursortimeout);for(var e in T.delaylist)T.delaylist[e]&&h(T.delaylist[e].h);T.doZoomOut(),T.unbindAll(),P.isie9&&T.win[0].detachEvent("onpropertychange",T.onAttributeChange),!1!==T.observer&&T.observer.disconnect(),!1!==T.observerremover&&T.observerremover.disconnect(),!1!==T.observerbody&&T.observerbody.disconnect(),T.events=null,T.cursor&&T.cursor.remove(),T.cursorh&&T.cursorh.remove(),T.rail&&T.rail.remove(),T.railh&&T.railh.remove(),T.zoom&&T.zoom.remove();for(var o=0;o<T.saved.css.length;o++){var t=T.saved.css[o];t[0].css(t[1],void 0===t[2]?"":t[2])}T.saved=!1,T.me.data("__nicescroll","");var r=n.nicescroll;r.each(function(e){if(this&&this.id===T.id){delete r[e];for(var o=++e;o<r.length;o++,e++)r[e]=r[o];--r.length&&delete r[r.length]}});for(var i in T)T[i]=null,delete T[i];T=null},this.scrollstart=function(e){return this.onscrollstart=e,T},this.scrollend=function(e){return this.onscrollend=e,T},this.scrollcancel=function(e){return this.onscrollcancel=e,T},this.zoomin=function(e){return this.onzoomin=e,T},this.zoomout=function(e){return this.onzoomout=e,T},this.isScrollable=function(e){var o=e.target?e.target:e;if("OPTION"==o.nodeName)return!0;for(;o&&1==o.nodeType&&o!==this.me[0]&&!/^BODY|HTML/.test(o.nodeName);){var t=n(o),r=t.css("overflowY")||t.css("overflowX")||t.css("overflow")||"";if(/scroll|auto/.test(r))return o.clientHeight!=o.scrollHeight;o=!!o.parentNode&&o.parentNode}return!1},this.getViewport=function(e){for(var o=!(!e||!e.parentNode)&&e.parentNode;o&&1==o.nodeType&&!/^BODY|HTML/.test(o.nodeName);){var t=n(o);if(/fixed|absolute/.test(t.css("position")))return t;var r=t.css("overflowY")||t.css("overflowX")||t.css("overflow")||"";if(/scroll|auto/.test(r)&&o.clientHeight!=o.scrollHeight)return t;if(t.getNiceScroll().length>0)return t;o=!!o.parentNode&&o.parentNode}return!1},this.triggerScrollStart=function(e,o,t,r,i){if(T.onscrollstart){var s={type:"scrollstart",current:{x:e,y:o},request:{x:t,y:r},end:{x:T.newscrollx,y:T.newscrolly},speed:i};T.onscrollstart.call(T,s)}},this.triggerScrollEnd=function(){if(T.onscrollend){var e=T.getScrollLeft(),o=T.getScrollTop(),t={type:"scrollend",current:{x:e,y:o},end:{x:e,y:o}};T.onscrollend.call(T,t)}};var B=0,X=0,D=0,A=1,q=!1;if(this.onmousewheel=function(e){if(T.wheelprevented||T.locked)return!1;if(T.railslocked)return T.debounced("checkunlock",T.resize,250),!1;if(T.rail.drag)return T.cancelEvent(e);if("auto"===M.oneaxismousemode&&0!==e.deltaX&&(M.oneaxismousemode=!1),M.oneaxismousemode&&0===e.deltaX&&!T.rail.scrollable)return!T.railh||!T.railh.scrollable||T.onmousewheelhr(e);var o=f(),t=!1;if(M.preservenativescrolling&&T.checkarea+600<o&&(T.nativescrollingarea=T.isScrollable(e),t=!0),T.checkarea=o,T.nativescrollingarea)return!0;var r=k(e,!1,t);return r&&(T.checkarea=0),r},this.onmousewheelhr=function(e){if(!T.wheelprevented){if(T.railslocked||!T.railh.scrollable)return!0;if(T.rail.drag)return T.cancelEvent(e);var o=f(),t=!1;return M.preservenativescrolling&&T.checkarea+600<o&&(T.nativescrollingarea=T.isScrollable(e),t=!0),T.checkarea=o,!!T.nativescrollingarea||(T.railslocked?T.cancelEvent(e):k(e,!0,t))}},this.stop=function(){return T.cancelScroll(),T.scrollmon&&T.scrollmon.stop(),T.cursorfreezed=!1,T.scroll.y=Math.round(T.getScrollTop()*(1/T.scrollratio.y)),T.noticeCursor(),T},this.getTransitionSpeed=function(e){return 80+e/72*M.scrollspeed|0},M.smoothscroll)if(T.ishwscroll&&P.hastransition&&M.usetransition&&M.smoothscroll){var j="";this.resetTransition=function(){j="",T.doc.css(P.prefixstyle+"transition-duration","0ms")},this.prepareTransition=function(e,o){var t=o?e:T.getTransitionSpeed(e),r=t+"ms";return j!==r&&(j=r,T.doc.css(P.prefixstyle+"transition-duration",r)),t},this.doScrollLeft=function(e,o){var t=T.scrollrunning?T.newscrolly:T.getScrollTop();T.doScrollPos(e,t,o)},this.doScrollTop=function(e,o){var t=T.scrollrunning?T.newscrollx:T.getScrollLeft();T.doScrollPos(t,e,o)},this.cursorupdate={running:!1,start:function(){var e=this;if(!e.running){e.running=!0;var o=function(){e.running&&u(o),T.showCursor(T.getScrollTop(),T.getScrollLeft()),T.notifyScrollEvent(T.win[0])};u(o)}},stop:function(){this.running=!1}},this.doScrollPos=function(e,o,t){var r=T.getScrollTop(),i=T.getScrollLeft();if(((T.newscrolly-r)*(o-r)<0||(T.newscrollx-i)*(e-i)<0)&&T.cancelScroll(),M.bouncescroll?(o<0?o=o/2|0:o>T.page.maxh&&(o=T.page.maxh+(o-T.page.maxh)/2|0),e<0?e=e/2|0:e>T.page.maxw&&(e=T.page.maxw+(e-T.page.maxw)/2|0)):(o<0?o=0:o>T.page.maxh&&(o=T.page.maxh),e<0?e=0:e>T.page.maxw&&(e=T.page.maxw)),T.scrollrunning&&e==T.newscrollx&&o==T.newscrolly)return!1;T.newscrolly=o,T.newscrollx=e;var s=T.getScrollTop(),n=T.getScrollLeft(),l={};l.x=e-n,l.y=o-s;var a=0|Math.sqrt(l.x*l.x+l.y*l.y),c=T.prepareTransition(a);T.scrollrunning||(T.scrollrunning=!0,T.triggerScrollStart(n,s,e,o,c),T.cursorupdate.start()),T.scrollendtrapped=!0,P.transitionend||(T.scrollendtrapped&&clearTimeout(T.scrollendtrapped),T.scrollendtrapped=setTimeout(T.onScrollTransitionEnd,c)),T.setScrollTop(T.newscrolly),T.setScrollLeft(T.newscrollx)},this.cancelScroll=function(){if(!T.scrollendtrapped)return!0;var e=T.getScrollTop(),o=T.getScrollLeft();return T.scrollrunning=!1,P.transitionend||clearTimeout(P.transitionend),T.scrollendtrapped=!1,T.resetTransition(),T.setScrollTop(e),T.railh&&T.setScrollLeft(o),T.timerscroll&&T.timerscroll.tm&&clearInterval(T.timerscroll.tm),T.timerscroll=!1,T.cursorfreezed=!1,T.cursorupdate.stop(),T.showCursor(e,o),T},this.onScrollTransitionEnd=function(){if(T.scrollendtrapped){var e=T.getScrollTop(),o=T.getScrollLeft();if(e<0?e=0:e>T.page.maxh&&(e=T.page.maxh),o<0?o=0:o>T.page.maxw&&(o=T.page.maxw),e!=T.newscrolly||o!=T.newscrollx)return T.doScrollPos(o,e,M.snapbackspeed);T.scrollrunning&&T.triggerScrollEnd(),T.scrollrunning=!1,T.scrollendtrapped=!1,T.resetTransition(),T.timerscroll=!1,T.setScrollTop(e),T.railh&&T.setScrollLeft(o),T.cursorupdate.stop(),T.noticeCursor(!1,e,o),T.cursorfreezed=!1}}}else this.doScrollLeft=function(e,o){var t=T.scrollrunning?T.newscrolly:T.getScrollTop();T.doScrollPos(e,t,o)},this.doScrollTop=function(e,o){var t=T.scrollrunning?T.newscrollx:T.getScrollLeft();T.doScrollPos(t,e,o)},this.doScrollPos=function(e,o,t){var r=T.getScrollTop(),i=T.getScrollLeft();((T.newscrolly-r)*(o-r)<0||(T.newscrollx-i)*(e-i)<0)&&T.cancelScroll();var s=!1;if(T.bouncescroll&&T.rail.visibility||(o<0?(o=0,s=!0):o>T.page.maxh&&(o=T.page.maxh,s=!0)),T.bouncescroll&&T.railh.visibility||(e<0?(e=0,s=!0):e>T.page.maxw&&(e=T.page.maxw,s=!0)),T.scrollrunning&&T.newscrolly===o&&T.newscrollx===e)return!0;T.newscrolly=o,T.newscrollx=e,T.dst={},T.dst.x=e-i,T.dst.y=o-r,T.dst.px=i,T.dst.py=r;var n=0|Math.sqrt(T.dst.x*T.dst.x+T.dst.y*T.dst.y),l=T.getTransitionSpeed(n);T.bzscroll={};var a=s?1:.58;T.bzscroll.x=new R(i,T.newscrollx,l,0,0,a,1),T.bzscroll.y=new R(r,T.newscrolly,l,0,0,a,1);f();var c=function(){if(T.scrollrunning){var e=T.bzscroll.y.getPos();T.setScrollLeft(T.bzscroll.x.getNow()),T.setScrollTop(T.bzscroll.y.getNow()),e<=1?T.timer=u(c):(T.scrollrunning=!1,T.timer=0,T.triggerScrollEnd())}};T.scrollrunning||(T.triggerScrollStart(i,r,e,o,l),T.scrollrunning=!0,T.timer=u(c))},this.cancelScroll=function(){return T.timer&&h(T.timer),T.timer=0,T.bzscroll=!1,T.scrollrunning=!1,T};else this.doScrollLeft=function(e,o){var t=T.getScrollTop();T.doScrollPos(e,t,o)},this.doScrollTop=function(e,o){var t=T.getScrollLeft();T.doScrollPos(t,e,o)},this.doScrollPos=function(e,o,t){var r=e>T.page.maxw?T.page.maxw:e;r<0&&(r=0);var i=o>T.page.maxh?T.page.maxh:o;i<0&&(i=0),T.synched("scroll",function(){T.setScrollTop(i),T.setScrollLeft(r)})},this.cancelScroll=function(){};this.doScrollBy=function(e,o){z(0,e)},this.doScrollLeftBy=function(e,o){z(e,0)},this.doScrollTo=function(e,o){var t=o?Math.round(e*T.scrollratio.y):e;t<0?t=0:t>T.page.maxh&&(t=T.page.maxh),T.cursorfreezed=!1,T.doScrollTop(e)},this.checkContentSize=function(){var e=T.getContentSize();e.h==T.page.h&&e.w==T.page.w||T.resize(!1,e)},T.onscroll=function(e){T.rail.drag||T.cursorfreezed||T.synched("scroll",function(){T.scroll.y=Math.round(T.getScrollTop()/T.scrollratio.y),T.railh&&(T.scroll.x=Math.round(T.getScrollLeft()/T.scrollratio.x)),T.noticeCursor()})},T.bind(T.docscroll,"scroll",T.onscroll),this.doZoomIn=function(e){if(!T.zoomactive){T.zoomactive=!0,T.zoomrestore={style:{}};var o=["position","top","left","zIndex","backgroundColor","marginTop","marginBottom","marginLeft","marginRight"],t=T.win[0].style;for(var r in o){var i=o[r];T.zoomrestore.style[i]=void 0!==t[i]?t[i]:""}T.zoomrestore.style.width=T.win.css("width"),T.zoomrestore.style.height=T.win.css("height"),T.zoomrestore.padding={w:T.win.outerWidth()-T.win.width(),h:T.win.outerHeight()-T.win.height()},P.isios4&&(T.zoomrestore.scrollTop=c.scrollTop(),c.scrollTop(0)),T.win.css({position:P.isios4?"absolute":"fixed",top:0,left:0,zIndex:s+100,margin:0});var n=T.win.css("backgroundColor");return(""===n||/transparent|rgba\(0, 0, 0, 0\)|rgba\(0,0,0,0\)/.test(n))&&T.win.css("backgroundColor","#fff"),T.rail.css({zIndex:s+101}),T.zoom.css({zIndex:s+102}),T.zoom.css("backgroundPosition","0 -18px"),T.resizeZoom(),T.onzoomin&&T.onzoomin.call(T),T.cancelEvent(e)}},this.doZoomOut=function(e){if(T.zoomactive)return T.zoomactive=!1,T.win.css("margin",""),T.win.css(T.zoomrestore.style),P.isios4&&c.scrollTop(T.zoomrestore.scrollTop),T.rail.css({"z-index":T.zindex}),T.zoom.css({"z-index":T.zindex}),T.zoomrestore=!1,T.zoom.css("backgroundPosition","0 0"),T.onResize(),T.onzoomout&&T.onzoomout.call(T),T.cancelEvent(e)},this.doZoom=function(e){return T.zoomactive?T.doZoomOut(e):T.doZoomIn(e)},this.resizeZoom=function(){if(T.zoomactive){var e=T.getScrollTop();T.win.css({width:c.width()-T.zoomrestore.padding.w+"px",height:c.height()-T.zoomrestore.padding.h+"px"}),T.onResize(),T.setScrollTop(Math.min(T.page.maxh,e))}},this.init(),n.nicescroll.push(this)},y=function(e){var o=this;this.nc=e,this.lastx=0,this.lasty=0,this.speedx=0,this.speedy=0,this.lasttime=0,this.steptime=0,this.snapx=!1,this.snapy=!1,this.demulx=0,this.demuly=0,this.lastscrollx=-1,this.lastscrolly=-1,this.chkx=0,this.chky=0,this.timer=0,this.reset=function(e,t){o.stop(),o.steptime=0,o.lasttime=f(),o.speedx=0,o.speedy=0,o.lastx=e,o.lasty=t,o.lastscrollx=-1,o.lastscrolly=-1},this.update=function(e,t){var r=f();o.steptime=r-o.lasttime,o.lasttime=r;var i=t-o.lasty,s=e-o.lastx,n=o.nc.getScrollTop()+i,l=o.nc.getScrollLeft()+s;o.snapx=l<0||l>o.nc.page.maxw,o.snapy=n<0||n>o.nc.page.maxh,o.speedx=s,o.speedy=i,o.lastx=e,o.lasty=t},this.stop=function(){o.nc.unsynched("domomentum2d"),o.timer&&clearTimeout(o.timer),o.timer=0,o.lastscrollx=-1,o.lastscrolly=-1},this.doSnapy=function(e,t){var r=!1;t<0?(t=0,r=!0):t>o.nc.page.maxh&&(t=o.nc.page.maxh,r=!0),e<0?(e=0,r=!0):e>o.nc.page.maxw&&(e=o.nc.page.maxw,r=!0),r?o.nc.doScrollPos(e,t,o.nc.opt.snapbackspeed):o.nc.triggerScrollEnd()},this.doMomentum=function(e){var t=f(),r=e?t+e:o.lasttime,i=o.nc.getScrollLeft(),s=o.nc.getScrollTop(),n=o.nc.page.maxh,l=o.nc.page.maxw;o.speedx=l>0?Math.min(60,o.speedx):0,o.speedy=n>0?Math.min(60,o.speedy):0;var a=r&&t-r<=60;(s<0||s>n||i<0||i>l)&&(a=!1);var c=!(!o.speedy||!a)&&o.speedy,d=!(!o.speedx||!a)&&o.speedx;if(c||d){var u=Math.max(16,o.steptime);if(u>50){var h=u/50;o.speedx*=h,o.speedy*=h,u=50}o.demulxy=0,o.lastscrollx=o.nc.getScrollLeft(),o.chkx=o.lastscrollx,o.lastscrolly=o.nc.getScrollTop(),o.chky=o.lastscrolly;var p=o.lastscrollx,m=o.lastscrolly,g=function(){var e=f()-t>600?.04:.02;o.speedx&&(p=Math.floor(o.lastscrollx-o.speedx*(1-o.demulxy)),o.lastscrollx=p,(p<0||p>l)&&(e=.1)),o.speedy&&(m=Math.floor(o.lastscrolly-o.speedy*(1-o.demulxy)),o.lastscrolly=m,(m<0||m>n)&&(e=.1)),o.demulxy=Math.min(1,o.demulxy+e),o.nc.synched("domomentum2d",function(){if(o.speedx){o.nc.getScrollLeft();o.chkx=p,o.nc.setScrollLeft(p)}if(o.speedy){o.nc.getScrollTop();o.chky=m,o.nc.setScrollTop(m)}o.timer||(o.nc.hideCursor(),o.doSnapy(p,m))}),o.demulxy<1?o.timer=setTimeout(g,u):(o.stop(),o.nc.hideCursor(),o.doSnapy(p,m))};g()}else o.doSnapy(o.nc.getScrollLeft(),o.nc.getScrollTop())}},x=e.fn.scrollTop;e.cssHooks.pageYOffset={get:function(e,o,t){var r=n.data(e,"__nicescroll")||!1;return r&&r.ishwscroll?r.getScrollTop():x.call(e)},set:function(e,o){var t=n.data(e,"__nicescroll")||!1;return t&&t.ishwscroll?t.setScrollTop(parseInt(o)):x.call(e,o),this}},e.fn.scrollTop=function(e){if(void 0===e){var o=!!this[0]&&(n.data(this[0],"__nicescroll")||!1);return o&&o.ishwscroll?o.getScrollTop():x.call(this)}return this.each(function(){var o=n.data(this,"__nicescroll")||!1;o&&o.ishwscroll?o.setScrollTop(parseInt(e)):x.call(n(this),e)})};var S=e.fn.scrollLeft;n.cssHooks.pageXOffset={get:function(e,o,t){var r=n.data(e,"__nicescroll")||!1;return r&&r.ishwscroll?r.getScrollLeft():S.call(e)},set:function(e,o){var t=n.data(e,"__nicescroll")||!1;return t&&t.ishwscroll?t.setScrollLeft(parseInt(o)):S.call(e,o),this}},e.fn.scrollLeft=function(e){if(void 0===e){var o=!!this[0]&&(n.data(this[0],"__nicescroll")||!1);return o&&o.ishwscroll?o.getScrollLeft():S.call(this)}return this.each(function(){var o=n.data(this,"__nicescroll")||!1;o&&o.ishwscroll?o.setScrollLeft(parseInt(e)):S.call(n(this),e)})};var z=function(e){var o=this;if(this.length=0,this.name="nicescrollarray",this.each=function(e){return n.each(o,e),o},this.push=function(e){o[o.length]=e,o.length++},this.eq=function(e){return o[e]},e)for(var t=0;t<e.length;t++){var r=n.data(e[t],"__nicescroll")||!1;r&&(this[this.length]=r,this.length++)}return this};!function(e,o,t){for(var r=0,i=o.length;r<i;r++)t(e,o[r])}(z.prototype,["show","hide","toggle","onResize","resize","remove","stop","doScrollPos"],function(e,o){e[o]=function(){var e=arguments;return this.each(function(){this[o].apply(this,e)})}}),e.fn.getNiceScroll=function(e){return void 0===e?new z(this):this[e]&&n.data(this[e],"__nicescroll")||!1},(e.expr.pseudos||e.expr[":"]).nicescroll=function(e){return void 0!==n.data(e,"__nicescroll")},n.fn.niceScroll=function(e,o){void 0!==o||"object"!=typeof e||"jquery"in e||(o=e,e=!1);var t=new z;return this.each(function(){var r=n(this),i=n.extend({},o);if(e){var s=n(e);i.doc=s.length>1?n(e,r):s,i.win=r}!("doc"in i)||"win"in i||(i.win=r);var l=r.data("__nicescroll")||!1;l||(i.doc=i.doc||r,l=new b(i,r),r.data("__nicescroll",l)),t.push(l)}),1===t.length?t[0]:t},a.NiceScroll={getjQuery:function(){return e}},n.nicescroll||(n.nicescroll=new z,n.nicescroll.options=g)});