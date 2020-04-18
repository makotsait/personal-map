var ready = { map: false, locations: false };
var map;
var mc;
// var mapData;
var mapOptions = {
center: { // 地図の緯度経度
    lat: 35.685614,
    lng: 139.752878
},
    zoom: 14, // 地図の拡大率
    mapTypeControl: false, // マップ切り替えのコントロールを表示するかどうか
    streetViewControl: false // ストリートビューのコントロールを表示するかどうか
}

/**
* 地図を生成する
*/
function add_marker() {
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
        mc = new MarkerClusterer(map, markers);
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
        google_place_id = item['google_place_id'];

        fetchPlaceDetails(google_place_id);
        localStorage.clear('ratings_json');

        getRatings(google_place_id, null);
  });
}
