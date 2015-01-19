<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        html, body, #map-canvas { height: 100%; margin: 0; padding: 0;}
    </style>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvG5hU-RANSe9b2FjFJxlYOPfzl9iLcVU&libraries=places">
    </script>
    <script type="text/javascript">
        var map;
        var infowindow;

        function initialize() {
            var bandung = new google.maps.LatLng(-7.164362, 107.357881);

            var mapOptions = {
                center: bandung,
                zoom: 18
            };

            var request = {
                location: bandung,
                radius: 1000,
                types: ['all']
            };

            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            infowindow = new google.maps.InfoWindow();

            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch(request, callback);
        }

        function callback(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);
                }
            }
        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });

            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent(place.name);
                infowindow.open(map, this);
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>
<div id="map-canvas"></div>
</body>
</html>