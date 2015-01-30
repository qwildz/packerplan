/**
 * Created by Muhammad Resna Rizki on 29/12/2014.
 */
var map, bounds;
var maps = [];
var rencana = [];
var i_rencana = 0;
$(function () {
    resize();

    map = new GMaps({
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

    bind();
});

function resize() {
    $('#rencana-map').height($(window).height() - 70);
    $('.rencana-full').height($(window).height() - 70);
}

function bind() {
    $('.rencana-add').on('click', function () {
        mapReset();

        var id = $(this).data('id');
        var lat = $(this).data('lat');
        var lng = $(this).data('lng') * 1;

        var e = $('#' + id);
        var clone = e.clone(true);
        clone.find('.rencana-add').addClass('hidden');
        clone.find('.rencana-remove').removeClass('hidden')
        $('.daftar-rute').append(clone);
        e.remove();

        rencana[i_rencana] = {id: id, lat: lat, lng: lng};
        i_rencana++;

        createBounds();
        createMarkers();
        createRoutes();

        map.fitBounds(bounds);
        fillRoute();
    });

    $('.rencana-remove').on('click', function () {
        mapReset();

        var id = $(this).data('id');
        var lat = $(this).data('lat');
        var lng = $(this).data('lng') * 1;
        var pos = $(this).data('pos') - 1;

        var e = $('#' + id);
        var index = e.index();
        var clone = e.clone(true);
        clone.find('.rencana-add').removeClass('hidden');
        clone.find('.rencana-remove').addClass('hidden')
        $(".daftar-tempat .rencana:nth-child(" + pos + ")").after(clone);
        e.remove();

        rencana.splice(index, 1);
        i_rencana--;

        createBounds();
        createMarkers();
        createRoutes();

        map.fitBounds(bounds);
        fillRoute();
    });
}

function mapReset() {
    map.removePolylines();
    map.removeMarkers();
}

function createMarkers() {
    for (var i = 0; i <= i_rencana - 1; i++) {
        map.addMarker({
            lat: rencana[i].lat,
            lng: rencana[i].lng
        });
    }
}

function createBounds() {
    bounds = new google.maps.LatLngBounds();
    if (i_rencana < 1) {
        bounds.extend(new google.maps.LatLng(-6.9147, 107.6098));
    }

    for (var i = 0; i <= i_rencana - 1; i++) {
        bounds.extend(new google.maps.LatLng(rencana[i].lat, rencana[i].lng));
    }
}

function createRoutes() {
    if (i_rencana > 1) {
        var callback = function (e) {
            if (e.length > 0) {
                map.drawPolyline({
                    path: e[e.length - 1].overview_path,
                    strokeColor: '#131540',
                    strokeOpacity: 0.6,
                    strokeWeight: 6
                });

                var jarak = 0;
                for (var iroute = 0; iroute <= e.length - 1; iroute++) {
                    var route = e[iroute];
                    if (route.legs.length > 0) {
                        var steps = route.legs[0].steps;
                        for (var i = 0, step; step = steps[i]; i++) {
                            step.step_number = i;
                            jarak += step.distance.value;
                        }
                    }
                }

                console.log(jarak + "Meter");
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
}

function fillRoute() {
    var routes = '';
    for (var i = 0; i <= i_rencana - 1; i++) {
        var id = rencana[i].id.replace('tempat-', '');
        if (i < i_rencana - 1)
            routes += id + ',';
        else
            routes += id;
    }
    $('#rute-form').val(routes);
    alert(routes);
}