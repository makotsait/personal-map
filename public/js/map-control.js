var ready = { api: false, ajax: false };
var map;
var mc;
// var mapData;
var mapOptions = {
center: { // �n�}�̈ܓx�o�x
    lat: 35.685614,
    lng: 139.752878
},
    zoom: 14, // �n�}�̊g�嗦
    mapTypeControl: false, // �}�b�v�؂�ւ��̃R���g���[����\�����邩�ǂ���
    streetViewControl: false // �X�g���[�g�r���[�̃R���g���[����\�����邩�ǂ���
}

    /**
    * Google Maps API�̏���������̏���
    */
   function api_ready() {
    ready['api'] = true;
    generate_map();
}

/**
* �n�}�𐶐�����
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

    // �}�[�J�[�̐ݒu
    var marker = new google.maps.Marker({
        position: item['latlng']
    });

    // �����o���̐���
    var ins = '<div class="map-window">';
    ins += '<p class="map-window_name">' + item['name'] + '</p>';
    ins += '</div>';
    var infoWindow = new google.maps.InfoWindow({
      content: ins
    });

    // �}�[�J�[�̃C�x���g�ݒ�
    add_event_to_marker(marker, infoWindow, i);

    // MarkerClusterer�p�Ƀ}�[�J�[�̏���z��ɂ܂Ƃ߂�
    markers.push(marker);
  }
  mc = new MarkerClusterer(map, markers);
}

/**
  * �}�[�J�[�ɃC�x���g��ǉ�����
  * @param {object} marker     (required) �}�[�J�[�̏��
  * @param {object} infoWindow (required) �����o���̏��
  * @param {number} index      (required) �n�}���̃C���f�b�N�X�ԍ�
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

  // �}�[�J�[�N���b�N���ɐ����o����\������
  item['marker'].addListener('click', function(e) {
      infoWindows_hide();
      item['infoWindow'].open(map, item['marker']);
  });
}
