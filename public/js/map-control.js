var ready = { map: false, locations: false };
// var mc;  
// var mapData;
mapOptions = {
center: { // 地図の緯度経度
    lat: 35.685614,
    lng: 139.752878
},
    zoom: 12, // 地図の拡大率
    mapTypeControl:    false, // マップ切り替えのコントロールを表示するかどうか
    fullscreenControl: false, //全画面表示コントロール
    streetViewControl: false  // ストリートビューのコントロールを表示するかどうか
}

function add_selected_place_marker(google_place_id, location) {
    var marker = new google.maps.Marker({
        map: map
    });
    // Set the position of the marker using the place ID and location.
    marker.setPlace({
        placeId: google_place_id,
        location: location
    });
    marker.setVisible(true);
}

function add_registered_place_markers() {
    if(ready['map'] && ready['locations']) {
        var markers = [];
        for (var i = 0; i < place_locations.length; i++) {
            var item = place_locations[i];

            // マーカーの設置
            var marker = new google.maps.Marker({
                position: item['latlng']
            });

            // マーカーのイベント設定
            add_event_to_marker(marker, i);

            // MarkerClusterer用にマーカーの情報を配列にまとめる
            markers.push(marker);
        }
        var mc = new MarkerClusterer(map, markers);
    }
}

/**
  * マーカーにイベントを追加する
  * @param {object} marker     (required) マーカーの情報
  * @param {number} index      (required) 地図情報のインデックス番号
  */

function add_event_to_marker(marker, index) {
    let item = place_locations[index];
    item['marker'] = marker;
    item['marker'].addListener('click', function() {
        const google_place_id = item['google_place_id'];

        fetchPlaceDetails(google_place_id);
        localStorage.clear('ratings_json');

        getRatings(google_place_id, null);
    });
}
