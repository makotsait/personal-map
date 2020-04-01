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
</head>

<body>
  @include('common.sidebar')
  <div style="display:none">
    <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
  </div>
  <div id="map"></div>
  <div id="infowindow-content">
    <span id="place-name" class="title"></span><br>
    <strong>Place ID:</strong> <span id="place-id"></span><br>
    <span id="place-address"></span>
  </div>

  <script>
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
          document.getElementById('form_latitude').value = data["result"]["geometry"]["location"]["lat"];
          document.getElementById('form_longitude').value = data["result"]["geometry"]["location"]["lng"];
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
        zoom: 13,
        // mapTypeControl: false, // マップ切り替えのコントロールを表示しない
        streetViewControl: false, // ストリートビューのコントロールを表示しない
      });

      var place_locations = [
        {
            "name": "AKIBAカルチャーズZONE",
            "latlng": {
                "lat": 35.699519,
                "lng": 139.770388
            }
        }, {
            "name": "秋葉原ガチャポン会館",
            "latlng": {
                "lat": 35.701861,
                "lng": 139.771220
            }
        },{
            "name": "コミックとらのあな秋葉原店C",
            "latlng": {
                "lat": 35.700536,
                "lng": 139.771158
            }
        }];

      var input = document.getElementById('pac-input');

      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo('bounds', map);

      // Specify just the place data fields that you need.
      autocomplete.setFields(['place_id', 'geometry', 'name']);

      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      var infowindow = new google.maps.InfoWindow();
      var infowindowContent = document.getElementById('infowindow-content');
      infowindow.setContent(infowindowContent);

      var marker = new google.maps.Marker({
        map: map
      });

      marker.addListener('click', function() {
        infowindow.open(map, marker);
      });

      add_marker();

      function setBounds(map, place) {
        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport);
        } else {
          map.setCenter(place.geometry.location);
          map.setZoom(17);
        }
        return map;
      }

      /**
       * マーカーにイベントを追加する
       * @param {object} marker     (required) マーカーの情報
       * @param {object} infoWindow (required) 吹き出しの情報
       * @param {number} index      (required) 地図情報のインデックス番号
       */


      function infoWindows_hide() {
        for (var i = 0; i < place_locations.length; i++) {
          place_locations[i]['infoWindow'].close();
        }
      }
      
      function add_event_to_marker(marker, infoWindow, index) {
        var item = place_locations[index];
        item['marker'] = marker;
        item['infoWindow'] = infoWindow;
    
        // マーカークリック時に吹き出しを表示する
        item['marker'].addListener('click', function(e) {
            infoWindows_hide();
            item['infoWindow'].open(map, item['marker']);
            console.log('clicked');
        });
      }

      function add_marker() {
        for (var i = 0; i < place_locations.length; i++) {
          var item = place_locations[i];
          var marker = new google.maps.Marker({
            position: item['latlng'],
            map: map
          });
          // 吹き出しの生成
          var ins = '<div class="map-window">';
          ins += '<p class="map-window_name">' + 'helloworld' + '</p>';
          ins += '</div>';
          var infoWindow = new google.maps.InfoWindow({
            content: ins
          });

          // マーカーのイベント設定
          add_event_to_marker(marker, infoWindow, i);
        }
      }

      function setPlaceDetail(place) {
        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-id'].textContent = place.place_id;
        infowindowContent.children['place-address'].textContent = place.formatted_address;
        document.getElementById('place_name').value = place.name;
        document.getElementById('google_place_id').value = place.place_id;
      }

      autocomplete.addListener('place_changed', function() {
        infowindow.close();

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

        getPlaceDetail(place.place_id);
        localStorage.clear('ratings_json');

        getRatings(place.place_id, null);

        marker.setVisible(true);

        setPlaceDetail(place);
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
      $(".sidebar.left").trigger("sidebar:open");
      sidebar_is_closed = false;
      $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
      setToggleBtnRotationSetting();
    }
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&libraries=places&callback=initMap" async defer></script>
</body>

</html>