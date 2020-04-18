<!DOCTYPE html>
<html>

<head>
    <title>PlaceLogs</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}">
    <script src="{{ asset('/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.sidebar.min.js') }}"></script>
    <script src="{{ asset('/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/js/markerclusterer.js') }}"></script>
    <script src="{{ asset('/js/map-control.js') }}"></script>
</head>

<body>
    @include('common.sidebar')
    <div style="display:none">
        <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
    </div>
    <div id="map"></div>


    <script>
        var place_locations;
        var place_detail;
        var place_name_text = document.getElementById('header-title');
        var address_text = document.getElementById('place_address');
        var place_header_image = document.getElementById('header-image');
        fetchAllPlacesLocation();

        function fetchAllPlacesLocation() {
            console.log('testhoge');
            $.ajax({
                type: 'GET',
                url: "{{route('fetch.all.places.locations')}}",
                dataType: 'json',
                success: function(data) {
                    if (data != 'PLACE_NOT_FOUND') {
                        place_locations = data;
                        place_locations = data.map(function(str) {
                            return {
                                'google_place_id': str.google_place_id,
                                'name': str.name,
                                'latlng': {
                                    'lat': Number(str.latlng.lat),
                                    'lng': Number(str.latlng.lng)
                                }
                            }
                        })
                        ready['locations'] = true;
                        add_marker();
                    }
                },
                error: function() {
                    //取得失敗時に実行する処理
                    console.log('Fetching all places locations failed');
                }
            });
        }

        function setPalceHeaderImg(img_url) {
            document.getElementById('form_header_img_url').value = img_url;
            place_header_image.setAttribute('src', img_url);
            // 縦長の画像の場合、重要な対象が枠に収まらない恐れがあるため、画像中央を表示させる
            var img = new Image();
            // イメージ配置後に実行する
            img.addEventListener('load', function(event) {
                height = img.height;
                hidden_length = (height - 300) / 2;
                $("#header-image").css("transform", "translateY(-" + hidden_length + "px)");
            });
            img.src = img_url;
        }

        function setPlaceDetailToView(place_details) {
            document.getElementById('google_place_id').value = place_details['google_place_id'];
            place_name_text.innerHTML = place_details['place_name'];
            document.getElementById('form_place_name').value = place_details['place_name'];
            address_text.innerHTML = place_details['formatted_address'];
            document.getElementById('form_formatted_address').value = place_details['formatted_address'];
            document.getElementById('form_latitude').value = place_details["location"]["lat"];
            document.getElementById('form_longitude').value = place_details["location"]["lng"];
            // getPlaceHeaderImg(place_details['header_img_url']);
            setPalceHeaderImg(place_details['header_img_url']);

            // 座標の中心をずらす
            map.panTo(place_details["location"]);
            // map.setCenter(place_details["location"]);???動作未確認
        }

        function fetchPlaceDetails(google_place_id) {
            console.log('place_detail_runing');
            $.ajax({
                type: 'GET',
                url: "{{route('fetch.place.details')}}",
                dataType: 'json',
                data: {
                    google_place_id: google_place_id,
                },
                success: function(data) {
                    setPlaceDetailToView(data);
                },
                error: function() {
                    //取得失敗時に実行する処理
                    place_name_text.innerHTML = "取得失敗しました";
                    address_text.innerHTML = "取得失敗しました";
                }
            });
        }

        function getPlaceHeaderImg(photoreference) {
            $.ajax({
                type: 'GET',
                url: "{{route('get_header_image')}}",
                data: {
                    photoreference: photoreference
                },
                success: function(data) {
                    document.getElementById('form_header_img_url').value = data;
                    place_header_image.setAttribute('src', data);
                    // 縦長の画像の場合、重要な対象が枠に収まらない恐れがあるため、画像中央を表示させる
                    var img = new Image();
                    // イメージ配置後に実行する
                    img.addEventListener('load', function(event) {
                        height = img.height;
                        hidden_length = (height - 300) / 2;
                        $("#header-image").css("transform", "translateY(-" + hidden_length + "px)");
                    });
                    img.src = data;
                },
                error: function() {
                    //取得失敗時に実行する処理
                    console.log("Fetching place header image failed.");
                }
            });
        }

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            var input = document.getElementById('pac-input');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            // Specify just the place data fields that you need.
            autocomplete.setFields(['place_id', 'geometry', 'name']);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var marker = new google.maps.Marker({
                map: map
            });

            function setBounds(map, place) {
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                return map;
            }

            ready['map'] = true;
            add_marker()

            map.addListener('click', clickEventFunc);

            function clickEventFunc(event) {
                // Prevent the default info window from showing.
                event.stop();

                google_place_id = event.placeId;
                if (google_place_id) {
                    fetchPlaceDetails(google_place_id);
                    localStorage.clear('ratings_json');
                    getRatings(google_place_id, null);
                }
            }

            autocomplete.addListener('place_changed', function() {
                // infowindow.close();

                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                map = setBounds(map, place);

                // Set the position of the marker using the place ID and location.
                marker.setPlace({
                    placeId: place.place_id,
                    location: place.geometry.location
                });
                marker.setVisible(true);

                fetchPlaceDetails(place.place_id);
                localStorage.clear('ratings_json');

                getRatings(place.place_id, null);

                // infowindow.open(map, marker);
            });
        }

        // フォーム送信後にControllerでリダイレクトにより呼び出される時に、元の値をセットし直す処理
        place_name_text.innerHTML = document.getElementById('form_place_name').value;
        address_text.innerHTML = document.getElementById('form_formatted_address').value;
        place_header_image.setAttribute('src', document.getElementById('form_header_img_url').value);

        localStorage.clear()
        getPlaceType();

        var sidebar_is_closed = true;
        if (document.getElementById('google_place_id').value) {
            $(".sidebar.left").trigger("sidebar:open");
            sidebar_is_closed = false;
            $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
            setToggleBtnRotationSetting();
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&libraries=places&callback=initMap" async defer></script>
</body>

</html>