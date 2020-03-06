<!DOCTYPE html>
<html>

<head>
    <title>PlaceLogs</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style_sp.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}">
    <script src="{{ asset('/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.sidebar.min.js') }}"></script>
    <script src="{{ asset('/js/perfect-scrollbar.min.js') }}"></script>
</head>

<body>
    <!-- <div style="display: none"> -->
    <div>
        <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
    </div>
    <div id="map" style="display:none"></div>
    <div id="infowindow-content">
        <span id="place-name" class="title"></span><br>
        <strong>Place ID:</strong> <span id="place-id"></span><br>
        <span id="place-address"></span>
    </div>
    @include('common.sidebar')

    <script>
        $("#section-sidebar-left").removeClass('sidebar left scroll_box');
        var place_detail;
        var place_name_text = document.getElementById('header-title');
        var address_text = document.getElementById('place_address');
        var place_header_image = document.getElementById('header-image');

        function getPlaceDetail(place_id) {
            $.ajax({
                type: 'POST',
                url: "{{route('get_place_detail')}}",
                dataType: 'json',
                data: {
                    place_id: place_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    place_name_text.innerHTML = data["result"]["name"];
                    document.getElementById('form_place_name').value = data["result"]["name"];
                    address_text.innerHTML = data["result"]["formatted_address"];
                    document.getElementById('form_place_address').value = data["result"]["formatted_address"];
                    getPlaceHeaderImg(data["result"]["photos"][0]["photo_reference"]);
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
                    console.log("画像取得失敗");
                }
            });
        }

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 35.742251,
                    lng: 139.7813826
                },
                zoom: 13
            });

            var input = document.getElementById('pac-input');

            var autocomplete = new google.maps.places.Autocomplete(input);
            // bounds:優先して検索する地域を指定(ここではmapの位置)
            autocomplete.bindTo('bounds', map);

            // Specify just the place data fields that you need.
            autocomplete.setFields(['place_id', 'geometry', 'name']);

            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // var infowindow = new google.maps.InfoWindow();
            var infowindowContent = document.getElementById('infowindow-content');
            // infowindow.setContent(infowindowContent);

            // var marker = new google.maps.Marker({
            //     map: map
            // });

            // marker.addListener('click', function() {
            //     infowindow.open(map, marker);
            // });

            // 場所を候補から選択したときの処理
            autocomplete.addListener('place_changed', function() {

                // infowindow.close();
                var place = autocomplete.getPlace();

                $("#section-sidebar-left").css('display', 'inline');

                // if (!place.geometry) {
                // return;
                // }

                // if (place.geometry.viewport) {
                // map.fitBounds(place.geometry.viewport);
                // } else {
                // map.setCenter(place.geometry.location);
                // map.setZoom(17);
                // }

                // Set the position of the marker using the place ID and location.
                // marker.setPlace({
                //     placeId: place.place_id,
                //     location: place.geometry.location
                // });
                // marker.setVisible(true);

                // var value1 = 'hoge';
                getPlaceDetail(place.place_id);
                localStorage.clear('ratings_json');

                getRatings(place.place_id, null);

                infowindowContent.children['place-name'].textContent = place.name;
                infowindowContent.children['place-id'].textContent = place.place_id;
                infowindowContent.children['place-address'].textContent = place.formatted_address;
                document.getElementById('place_name').value = place.name;
                document.getElementById('google_place_id').value = place.place_id;
                infowindow.open(map, marker);
            });
        }
        // フォーム送信後にControllerでリダイレクトにより呼び出される時に、元の値をセットし直す処理
        place_name_text.innerHTML = document.getElementById('form_place_name').value;
        address_text.innerHTML = document.getElementById('form_place_address').value;
        place_header_image.setAttribute('src', document.getElementById('form_header_img_url').value);

        localStorage.clear()
        getPlaceType();

        var sidebar_is_closed = true;
        if (document.getElementById('google_place_id').value) {
            $("#section-sidebar-left").css('display', 'inline');

            $(".sidebar.left").trigger("sidebar:open");
            sidebar_is_closed = false;
            $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
            setToggleBtnRotationSetting();
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&language=ja&libraries=places&callback=initMap" async defer></script>
</body>

</html>