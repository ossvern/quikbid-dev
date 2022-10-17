var map, marker;

function initMap() {
    var myLatlng = new google.maps.LatLng(50.74531228180484, 25.32688021427357);

    if (window.screen.width > 768)
        var myLatlng_r = new google.maps.LatLng(50.74531228180484, 25.32688021427357);
    else
        var myLatlng_r = myLatlng;


    var mapOptions = {
        zoom: 18,
        center: myLatlng_r,
        // mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        navigationControl: true,
        mapTypeControl: true,
        scaleControl: true,
        control: true,
        disableDefaultUI: true,
        mapTypeControl: true,
        disableDefaultUI: true,
        draggable: true,
        zoomControl: true,
        styles:
            [
                {
                    "featureType": "all",
                    "stylers": [
                        {
                            "saturation": 0
                        },
                        {
                            "hue": "#e7ecf0"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "stylers": [
                        {
                            "saturation": -70
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "stylers": [
                        {
                            "visibility": "simplified"
                        },
                        {
                            "saturation": -60
                        }
                    ]
                }
            ]

    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    marker = new google.maps.Marker({
        map: map,
        draggable: false,
        position: myLatlng,
        icon: 'https://printing.lutsk.ua/img/map.png'

    });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}

function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}