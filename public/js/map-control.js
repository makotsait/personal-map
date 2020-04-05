var ready = { api: false, ajax: false };
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
    * Google Maps APIの準備完了後の処理
    */
   function api_ready() {
    ready['api'] = true;
    generate_map();
}

/**
* 地図を生成する
*/
function generate_map() {
    if(ready['api'] && ready['ajax']) {
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        add_marker();
    }
}

function add_marker() {
  var markers = [];
  for (var i = 0; i < place_locations.length; i++) {
    var item = place_locations[i];

    // マーカーの設置
    var marker = new google.maps.Marker({
        position: item['latlng']
    });

    // 吹き出しの生成
    var ins = '<div class="map-window">';
    ins += '<p class="map-window_name">' + item['name'] + '</p>';
    ins += '</div>';
    var infoWindow = new google.maps.InfoWindow({
      content: ins
    });

    // マーカーのイベント設定
    add_event_to_marker(marker, infoWindow, i);

    // MarkerClusterer用にマーカーの情報を配列にまとめる
    markers.push(marker);
  }
  mc = new MarkerClusterer(map, markers);
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
  });
}
