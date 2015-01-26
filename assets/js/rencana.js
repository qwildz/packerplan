/**
 * Created by Muhammad Resna Rizki on 29/12/2014.
 */
var maps = [];
var rencana = [];
var i_rencana = 0;
$(function () {
    resize();

    var map = new GMaps({
        div: 'rencana-map',
        lat: -6.9147,
        lng: 107.6098,
        panControl: false,
        zoomControl: true,
        zoomControlOpt: {
            style: 'SMALL',
            position: 'BOTTOM_LEFT'
        },
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: false
    });

    $(window).resize(function () {
        resize();
    });

    var bounds = new google.maps.LatLngBounds();

    $('.rencana-add').on('click', function () {
        map.removePolylines();

        var id = $(this).data('identifier');
        var lat = $(this).data('lat');
        var lng = $(this).data('lng') * 1;

        rencana[i_rencana] = {id: id, lat: lat, lng: lng};
        i_rencana++;

        bounds.extend(new google.maps.LatLng(lat, lng));
        map.addMarker({
            lat: lat,
            lng: lng
        });

        if (i_rencana > 1) {
            var callback = function (e) {
                alert(e);
                if (e.length > 0) {
                    map.drawPolyline({
                        path: e[e.length - 1].overview_path,
                        strokeColor: '#131540',
                        strokeOpacity: 0.6,
                        strokeWeight: 6
                    });

                    var jarak = 0;
                    for(var iroute = 0; iroute <= e.length - 1; iroute++) {
                        var route = e[iroute];
                        if (route.legs.length > 0) {
                            var steps = route.legs[0].steps;
                            for (var i = 0, step; step = steps[i]; i++) {
                                step.step_number = i;
                                jarak += step.distance.value;
                            }
                        }
                    }

                    alert(jarak + "Meter");
                }
            }

            if (i_rencana > 2) {
                var waypts = [];
                for (var i = 1; i <= i_rencana - 2; i++) {
                    waypts.push({
                        location: new google.maps.LatLng(rencana[i].lat, rencana[i].lng),
                        stopover: false
                    });
                }

                map.getRoutes({
                    origin: [rencana[0].lat, rencana[0].lng],
                    destination: [rencana[i_rencana - 1].lat, rencana[i_rencana - 1].lng],
                    waypoints: waypts,
                    travelMode: 'driving',
                    callback: callback
                });
            } else {
                map.getRoutes({
                    origin: [rencana[0].lat, rencana[0].lng],
                    destination: [rencana[1].lat, rencana[1].lng],
                    travelMode: 'driving',
                    callback: callback
                });
            }
        }

        map.fitBounds(bounds);
    });
});

function resize() {
    $('#rencana-map').height($(window).height() - 70);
    $('.rencana-full').height($(window).height() - 70);
}