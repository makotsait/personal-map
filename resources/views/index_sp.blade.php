<!DOCTYPE html>
<html>

<head>
    <title>PersonalMap</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style_sp.css') }}">
    <script src="{{ asset('/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.sidebar.min.js') }}"></script>
</head>

<body>
    <div>
        <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
    </div>
    <div id="map" style="display:none"></div>
    @include('common.sidebar')

    <script>
        $("#section-sidebar-left").removeClass('sidebar left scroll_box');

        function setPalceHeaderImg(img_url) {
            document.getElementById('form_header_img_url').value = img_url;
            document.getElementById('header-image').setAttribute('src', img_url);
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
            document.getElementById('header-title').innerHTML = place_details['place_name'];
            document.getElementById('form_place_name').value = place_details['place_name'];
            document.getElementById('place_address').innerHTML = place_details['formatted_address'];
            document.getElementById('form_formatted_address').value = place_details['formatted_address'];
            document.getElementById('form_latitude').value = place_details["location"]["lat"];
            document.getElementById('form_longitude').value = place_details["location"]["lng"];
            setPalceHeaderImg(place_details['header_img_url']);

            $("#section-sidebar-left").css('display', 'inline');
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

                fetchPlaceDetails(place.place_id);
                localStorage.clear('ratings_json');

                getRatings(place.place_id, null);
            });
        }

        function initMap() {
            const mapOptions = {
                center: { // 地図の緯度経度
                    lat: 35.685614,
                    lng: 139.752878
                },
                zoom: 14, // 地図の拡大率
                mapTypeControl: false, // マップ切り替えのコントロールを表示するかどうか
                streetViewControl: false // ストリートビューのコントロールを表示するかどうか
            }

            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            setAutocomplete();
        }

        @if(Session::get('is_with_input'))
        $("#section-sidebar-left").css('display', 'inline');
        // フォーム送信後にControllerでリダイレクトにより呼び出された時に、元の値をセットし直す処理
        document.getElementById('header-title').innerHTML = document.getElementById('form_place_name').value;
        document.getElementById('place_address').innerHTML = document.getElementById('form_formatted_address').value;
        document.getElementById('header-image').setAttribute('src', document.getElementById('form_header_img_url').value);
        @endif

        localStorage.clear()
        getPlaceType();
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_place_api')}}&libraries=places&callback=initMap" async defer></script>
</body>

</html>