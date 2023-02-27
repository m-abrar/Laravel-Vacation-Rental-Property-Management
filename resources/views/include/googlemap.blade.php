<section>
<script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBHNcl7vQkboLdudfLcpgHx-jxf1mfXQ1s" type="text/javascript"></script> 

<div id="header-map" style="width: 100%; height: 450px;"></div>

<script type='text/javascript'>//<![CDATA[

function initialize() {
    var locations = [
        @foreach($properties as $property)
        ['<a href="{{url('show/'.$property->slug)}}"><img style="width:225px" src="{{asset($property->images->first()->image)}}" alt="{{$property->title}}"></a><br/><strong>{{$property->title}}</strong><br/>Bedrooms: {{$property->bedrooms}} | Bathrooms: {{$property->bathrooms}}<br/><a href="{{url('show/'.$property->slug)}}">View Detail</a>', {{$property->latitude}}, {{$property->longitude}}],
        @endforeach
    ];

    window.map = new google.maps.Map(document.getElementById('header-map'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
    });

    var infowindow = new google.maps.InfoWindow();

    var bounds = new google.maps.LatLngBounds();

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });

        bounds.extend(marker.position);

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function () {
        map.setZoom(3);
        google.maps.event.removeListener(listener);
    });
}


window.onload = initialize;
//]]> 

</script>

</section>
<!-- End of Sliders -->
