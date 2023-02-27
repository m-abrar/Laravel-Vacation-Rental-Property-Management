<section>
<script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBHNcl7vQkboLdudfLcpgHx-jxf1mfXQ1s" type="text/javascript"></script> 


   <div id="header-map" style="width: 100%; height: 600px;"></div> 

   <script type="text/javascript"> 

   var map = new google.maps.Map(document.getElementById('header-map'), { 
     mapTypeId: google.maps.MapTypeId.TERRAIN,
     scrollwheel: false,
     draggable: true,
   });

   var markerBounds = new google.maps.LatLngBounds();

   var randomPoint, i;

   for (i = 0; i < 10; i++) {

     randomPoint = new google.maps.LatLng( 50.00 + (Math.random() - 0.5) * 20, 
                                          17.00 + (Math.random() - 0.5) * 20);


     // Draw a marker for each random point
     var marker = new google.maps.Marker({
       position: randomPoint, 
       map: map,
       title: 'Uluru (Ayers Rock)'
     });



     // Extend markerBounds with each random point.
     markerBounds.extend(randomPoint);
   }

   // At the end markerBounds will be the smallest bounding box to contain
   // our 10 random points

   // Finally we can call the Map.fitBounds() method to set the map to fit
   // our markerBounds
   map.fitBounds(markerBounds);

   </script>

</section>
<!-- End of Sliders -->
