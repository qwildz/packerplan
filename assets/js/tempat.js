/**
 * Created by Muhammad Resna Rizki on 29/12/2014.
 */
var maps = [];

$(function() {
    $('.maps').each(function() {
        var thiss = $(this),
            id = thiss.attr('id'),
            lat = thiss.data('latitude'),
            lng = thiss.data('longitude');

        maps[id] = new GMaps({
            div: id,
            lat: lat,
            lng: lng,
            panControl: false,
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: true,
            streetViewControl: false,
            overviewMapControl: false
        });

        maps[id].addMarker({
            lat: lat,
            lng: lng
        });
    });

    $('.maps-static.locations').each(function() {
        var thiss = $(this),
            id = thiss.attr('id'),
            locations = thiss.data('locations');

        maps[id] = new GMaps({
            div: id,
            lat: locations[0].lat,
            lng: locations[0].lng,
            draggable: false,
            scrollwheel: false,
            panControl: false,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false
        });

        var bounds = new google.maps.LatLngBounds();
        for(var i = 0; i < locations.length; i++) {
            bounds.extend(new google.maps.LatLng(locations[i].lat, locations[i].lng));
            maps[id].addMarker({
                lat: locations[i].lat,
                lng: locations[i].lng
            });
        }

        maps[id].fitBounds(bounds);
    });

    var jumboHeight = $('.jumbotron').outerHeight();

    function parallax() {
        var scrolled = $(window).scrollTop();
        $('.jumbotron').css('height', (jumboHeight - scrolled) + 'px');
    }

    $(window).scroll(function (e) {
        parallax();
    });
});