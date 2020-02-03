
<!DOCTYPE html>
<html>
  <head>
    <title>Place ID Finder</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        background-color: #fff;
        border-radius: 2px;
        border: 1px solid transparent;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        box-sizing: border-box;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        height: 29px;
        margin-left: 17px;
        margin-top: 10px;
        outline: none;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      .controls:focus {
        border-color: #4d90fe;
      }
      .title {
        font-weight: bold;
      }
      #infowindow-content {
        display: none;
      }
      #map #infowindow-content {
        display: inline;
      }

    </style>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.sidebar.min.js') }}"></script>
  </head>
  <body>
  @include('common.sidebar')
    <div style="display: none">
        <input id="pac-input"
               class="controls"
               type="text"
               placeholder="Enter a location">
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
        <span id="place-name" class="title"></span><br>
        <strong>Place ID:</strong> <span id="place-id"></span><br>
        <span id="place-address"></span>
    </div>

    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 35.742251, lng: 139.7813826},
          zoom: 13
        });

        var input = document.getElementById('pac-input');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        // Specify just the place data fields that you need.
        autocomplete.setFields(['place_id', 'geometry', 'name']);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);

        var marker = new google.maps.Marker({map: map});

        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });

        function get_place_detail(place_id){
          var req = new XMLHttpRequest();		  // XMLHttpRequest オブジェクトを生成する
          // req.onreadystatechange = function() {		  // XMLHttpRequest オブジェクトの状態が変化した際に呼び出されるイベントハンドラ
          //   if(req.readyState == 4 && req.status == 200){ // サーバーからのレスポンスが完了し、かつ、通信が正常に終了した場合
          //     alert(req.responseText);		          // 取得した JSON ファイルの中身を表示
          //   }
          // };
          var api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
          var place_id="ChIJH7qx1tCMGGAR1f2s7PGhMhw";
          // var keyword = urlencode($keyword);
          var url = "https://maps.googleapis.com/maps/api/place/details/json?key={$api_key}&place_id={$place_id}&language=ja";
          req.open("GET", url, false); // HTTPメソッドとアクセスするサーバーの　URL　を指定
          // req.send(null);		
          alart(JSON.parse(req.send(null)));  
        }

        autocomplete.addListener('place_changed', function() {
          infowindow.close();

          var place = autocomplete.getPlace();

          if (!place.geometry) {
            return;
          }

          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
          }

          // Set the position of the marker using the place ID and location.
          marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location
          });
          var address_text = document.getElementById('place_address');
          var value1 = 'hoge';
          $.ajax({
            type: 'POST',
            url: "{{route('test')}}",
            dataType: 'text',
            data: {name1:place.place_id, _token: '{{ csrf_token() }}'},  
            success: function(data) {
              address_text.innerHTML = data;
              // alert(data);
            },
            error:function() {
            //取得失敗時に実行する処理
              address_text.innerHTML = "取得失敗しました";
              // alert("取得失敗");
            }
          });

          marker.setVisible(true);

          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-id'].textContent = place.place_id;
          infowindowContent.children['place-address'].textContent =
              place.formatted_address;
          infowindow.open(map, marker);
        });
      }
    </script>

    <script>
      $.ajax({
      type: 'GET',
      url: 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&libraries=places&callback=initMap',
      dataType: 'html',
      success: function(data) {
          //取得成功したら実行する処理
          console.log("ファイルの取得に成功しました");
      },
      error:function() {
          //取得失敗時に実行する処理
          console.log("何らかの理由で失敗しました");
      }
      });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&libraries=places&callback=initMap"
        async defer></script>
  </body>
</html>