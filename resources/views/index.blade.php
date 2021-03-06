<!DOCTYPE html>
<html>

<head>
    <title>PersonalMap</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.sidebar.min.js') }}"></script>
    <script src="{{ asset('/js/markerclusterer.js') }}"></script>
    <script src="{{ asset('/js/map-control.js') }}"></script>
</head>

<body>
    @include('common.sidebar')
    <div style="display:none">
        <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
    </div>
    <div class="account-control-style">
        <form action="/logout" method="post" class="account-control-section-logout-btn">
            @csrf
            <input type="submit" value="Logout" class=" map-btn btn btn-default">
        </form>
    </div>

    <div id="map"></div>

    <script>
        function fetchAllPlacesLocation() {
            $.ajax({
                type: 'GET',
                url: "{{route('fetch.all.places.locations')}}",
                dataType: 'json',
                success: function(data) {
                    if (data != 'PLACE_NOT_FOUND') {
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
                        add_registered_place_markers();
                        console.log(data);
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
            document.getElementById('header-image').setAttribute('src', img_url);
            // 縦長の画像の場合、重要な対象が枠に収まらない恐れがあるため、画像中央を表示させる
            var img = new Image();
            // イメージ配置後に実行する
            img.addEventListener('load', function(event) {
                height = img.height;
                hidden_length = (height - 500) / 2;
                if (hidden_length > 0) {
                    $("#header-image").css("transform", "translateY(-" + hidden_length + "px)");
                } else {
                    $("#header-image").css("transform", "translateY(0px)");
                }
            });
            img.src = img_url;
        }

        function setPlaceDetailToView(place_details) {
            document.getElementById('google_place_id').value = place_details['google_place_id'];
            document.getElementById('delete_google_place_id').value = place_details['google_place_id'];
            document.getElementById('header-title').innerHTML = place_details['place_name'];
            document.getElementById('form_place_name').value = place_details['place_name'];
            document.getElementById('place_address').innerHTML = place_details['formatted_address'];
            document.getElementById('form_formatted_address').value = place_details['formatted_address'];
            document.getElementById('form_latitude').value = place_details["location"]["lat"];
            document.getElementById('form_longitude').value = place_details["location"]["lng"];
            setPalceHeaderImg(place_details['header_img_url']);

            // 座標の中心をずらす
            map.panTo(new google.maps.LatLng(place_details["location"]["lat"], place_details["location"]["lng"]));
        }

        function fetchPlaceDetails(google_place_id) {
            $.ajax({
                type: 'GET',
                url: "{{route('fetch.place.details')}}",
                dataType: 'json',
                data: {
                    google_place_id: google_place_id,
                },
                success: function(data) {
                    console.log('Fetching place details ended.');
                    console.log(data);
                    setPlaceDetailToView(data);
                },
                error: function() {
                    console.log('Fetching place details failed.');
                    document.getElementById('header-title').innerHTML = "取得失敗しました";
                    document.getElementById('place_address').innerHTML = "取得失敗しました";
                }
            });
        }

        function setBounds(place) {
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
        }

        function setAutocomplete() {
            const input = document.getElementById('pac-input');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            autocomplete.setFields(['place_id', 'geometry', 'name']); // Specify just the place data fields that you need.
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            autocomplete.addListener('place_changed', function() {
                place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                setBounds(place);

                add_selected_place_marker(place.place_id, place.geometry.location)

                fetchPlaceDetails(place.place_id);
                localStorage.clear('ratings_json');

                getRatings(place.place_id, null);
            });
        }

        function initMap() {
            fetchAllPlacesLocation();
            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            ready['map'] = true;
            add_registered_place_markers();

            setAutocomplete();

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

            map.addListener('click', clickEventFunc);
        }

        // フォーム送信後にControllerでリダイレクトにより呼び出された時に、元の値をセットし直す処理
        document.getElementById('header-title').innerHTML = document.getElementById('form_place_name').value;
        document.getElementById('place_address').innerHTML = document.getElementById('form_formatted_address').value;
        document.getElementById('header-image').setAttribute('src', document.getElementById('form_header_img_url').value);

        localStorage.clear()
        getPlaceType();

        is_sidebar_closed = true;
        if (document.getElementById('google_place_id').value) {
            $(".sidebar.left").trigger("sidebar:open");
            is_sidebar_closed = false;
            $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
            setToggleBtnRotationSetting();
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_place_api_js')}}&libraries=places&callback=initMap" async defer></script>
</body>

</html>