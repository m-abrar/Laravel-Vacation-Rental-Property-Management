<style>
   /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
   #map {
   height: 100%;
   }
</style>

<div id="map"></div>

<script>
   function initMap() {
   
   var map = new google.maps.Map(document.getElementById('map'), {
   
   });
   var bounds = new google.maps.LatLngBounds();
   
   var infoWin = new google.maps.InfoWindow();
   // Add some markers to the map.
   // Note: The code uses the JavaScript Array.prototype.map() method to
   // create an array of markers based on a given "locations" array.
   // The map() method here has nothing to do with the Google Maps API.
   var markers = locations.map(function(location, i) {
   var marker = new google.maps.Marker({
     position: location
   });
   
   //extend the bounds to include each marker's position
   bounds.extend(marker.position);
   
   google.maps.event.addListener(marker, 'click', function(evt) {
     infoWin.setContent(location.info);
     infoWin.open(map, marker);
   })
   return marker;
   });

   //now fit the map to the newly inclusive bounds
   map.fitBounds(bounds);

   // markerCluster.setMarkers(markers);
   // Add a marker clusterer to manage the markers.
   var markerCluster = new MarkerClusterer(map, markers, {
   imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
   });
   
   }
   var locations = [

    @foreach($properties as $property)
    {
       lat: {{$property->latitude}},
       lng: {{$property->longitude}},
       info: '<a href="{{url('show/'.$property->slug)}}"><img style="width:225px" src="{{asset($property->images->first()->image)}}" alt="{{$property->title}}"></a><br/><strong>{{$property->title}}</strong><br/>Bedrooms: {{$property->bedrooms}} | Bathrooms: {{$property->bathrooms}}<br/><a href="{{url('show/'.$property->slug)}}">View Detail</a>'
       }, 
    @endforeach

   ];
   
   google.maps.event.addDomListener(window, "load", initMap);
</script>
<script src="{{ asset('resources/plugins/markerclusterer/markerclusterer.js') }}"></script>
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHNcl7vQkboLdudfLcpgHx-jxf1mfXQ1s&callback=initMap"></script>