var ready = { map: false, locations: false };
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
* �n�}�𐶐�����
*/
function generate_map() {
    if(ready['map'] && ready['locations']) {
        // map = new google.maps.Map(document.getElementById('map'), mapOptions);
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
    item = place_locations[index];
    item['marker'] = marker;
    // item['infoWindow'] = infoWindow;

     // �}�[�J�[�N���b�N���ɐ����o����\������
    item['marker'].addListener('click', function(e) {
        google_place_id = item['google_place_id'];

        //�I�����ꂽoption�ԍ����擾
        // var index = this.selectedIndex;
        // document.getElementById('form_place_type_id').value = options[index].value;
        // place_type_id = options[inplace_type_iddex].value;

        getPlaceDetail(google_place_id);
        localStorage.clear('ratings_json');

        getRatings(google_place_id, null);
        // setPlaceDetail(place);
        //   infoWindows_hide();
        //   item['infoWindow'].open(map, item['marker']);
  });
}
