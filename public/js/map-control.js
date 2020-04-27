var ready = { map: false, locations: false };
// var mc;  
// var mapData;
mapOptions = {
center: { // �n�}�̈ܓx�o�x
    lat: 35.685614,
    lng: 139.752878
},
    zoom: 12, // �n�}�̊g�嗦
    mapTypeControl:    false, // �}�b�v�؂�ւ��̃R���g���[����\�����邩�ǂ���
    fullscreenControl: false, //�S��ʕ\���R���g���[��
    streetViewControl: false  // �X�g���[�g�r���[�̃R���g���[����\�����邩�ǂ���
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

            // �}�[�J�[�̐ݒu
            var marker = new google.maps.Marker({
                position: item['latlng']
            });

            // �}�[�J�[�̃C�x���g�ݒ�
            add_event_to_marker(marker, i);

            // MarkerClusterer�p�Ƀ}�[�J�[�̏���z��ɂ܂Ƃ߂�
            markers.push(marker);
        }
        var mc = new MarkerClusterer(map, markers);
    }
}

/**
  * �}�[�J�[�ɃC�x���g��ǉ�����
  * @param {object} marker     (required) �}�[�J�[�̏��
  * @param {number} index      (required) �n�}���̃C���f�b�N�X�ԍ�
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
