@section('sidebar')
<div class="sidebar left scroll_box" id="section-sidebar-left">
    <img class="sidebar-close-btn" data-action="toggle" data-side="left" border="0" src="{{ asset('icon/icon_open_sidebar.png') }}" alt="icon_sidebar_oc">
    <div class="section-sidebar-left-content inner">
        <div class="header-image">
            <img id="header-image" src="">
        </div>
        <div class="header-title-description">
            <h1 class="header-title" id="header-title">place name</h1>
            <span id="place_address">address</span>

            <div include="form-input-select()" class="sectin-place-type-block">
                <select required class="form-control" id="section-place-type">
                    <option value="" hidden>Now Loading</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                    <option value="4">Option 4</option>
                    <option value="5">Option 5</option>
                </select>
            </div>
        </div>

        <form action="ratings/update" method="POST" class="section">
            @csrf
            <input type="hidden" name="user_id" value="23">
            <!-- <input type="hidden" name="place_id" value="2"> -->
            <input type="hidden" name="form_place_name" id="form_place_name" value="{{old('form_place_name')}}">
            <input type="hidden" name="form_formatted_address" id="form_formatted_address" value="{{old('form_formatted_address')}}">
            <!-- <input type="hidden" name="form_place_address" id="form_place_address" value="{{old('form_place_address')}}"> -->
            <input type="hidden" name="form_header_img_url" id="form_header_img_url" value="{{old('form_header_img_url')}}">
            <input type="hidden" name="criterion_id" value="2">
            <input type="hidden" name="place_name" id="place_name" value="">
            <input type="hidden" name="form_place_type_id" id="form_place_type_id" value="{{old('form_place_type_id')}}">
            <input type="hidden" name="google_place_id" id="google_place_id" value="{{old('google_place_id')}}">
            <input type="hidden" name="form_latitude" id="form_latitude" value="{{old('form_latitude')}}">
            <input type="hidden" name="form_longitude" id="form_longitude" value="{{old('form_longitude')}}">
            <!-- <input type="hidden" name="criterion1-name-hidden" id="criterion1-name-hidden" value="{{old('criterion1-name-hidden')}}"> -->
            <input type="hidden" name="criterion1-name-hidden" class="criterion-name-hidden" value="{{old('criterion1-name-hidden')}}">
            <input type="hidden" name="criterion2-name-hidden" class="criterion-name-hidden" value="{{old('criterion2-name-hidden')}}">
            <input type="hidden" name="criterion3-name-hidden" class="criterion-name-hidden" value="{{old('criterion3-name-hidden')}}">
            <input type="hidden" name="criterion4-name-hidden" class="criterion-name-hidden" value="{{old('criterion4-name-hidden')}}">

            <div class="ratings">
                <div class="ratings-line" id="section-ratings-line-1">
                    <span class="rating rating-left" id="section-rating-group-1">
                        <span class="section-criterion-name-display">{{old('criterion1-name-hidden')}}</span>
                        <span class="range">
                            <input type="range" name="criterion1" class="custom-range" id="criterion1" min="0" max="5" value="{{old('criterion1')}}">
                        </span>
                        <span class="section-rating-value">{{old('criterion1')}}</span>
                    </span>
                    <span class="rating section-rating-inline-right" id="section-rating-group-2">
                        <span class="section-criterion-name-display">{{old('criterion2-name-hidden')}}</span>
                        <span class="range">
                            <input type="range" name="criterion2" class="custom-range" id="criterion2" min="0" max="5" value="{{old('criterion2')}}">
                        </span>
                        <span class="section-rating-value">{{old('criterion2')}}</span>
                    </span>
                    </span>
                </div>
                <div class="ratings-line" id="section-ratings-line-2">
                    <span class="rating rating-left" id="section-rating-group-3">
                        <span class="section-criterion-name-display">{{old('criterion3-name-hidden')}}</span>
                        <span class="range">
                            <input type="range" name="criterion3" class="custom-range" id="criterion3" min="0" max="5" value="{{old('criterion3')}}">
                        </span>
                        <span class="section-rating-value">{{old('criterion3')}}</span>
                    </span>
                    <span class="rating section-rating-inline-right" id="section-rating-group-4">
                        <span class="section-criterion-name-display">{{old('criterion4-name-hidden')}}</span>
                        <span class="range">
                            <input type="range" name="criterion4" class="custom-range" id="criterion4" min="0" max="5" value="{{old('criterion4')}}">
                        </span>
                        <span class="section-rating-value">{{old('criterion4')}}</span>
                    </span>
                </div>
                <!-- <div class="ratings-line" id="section-ratings-line-3">
                    <span class="rating rating-left" id="section-rating-group-5">
                        <span>要素5</span>
                        <span class="range">
                            <input type="range" name="criterion3" min="0" max="5" value="0">
                        </span>
                        <span class="section-rating-value">0</span>
                    </span>
                    <span class="rating section-rating-inline-right" id="section-rating-group-6">
                        <span>要素6</span>
                        <span class="range">
                            <input type="range" name="criterion4" min="0" max="5" value="0">
                        </span>
                        <span class="section-rating-value">0</span>
                    </span>
                </div> -->
            </div>
            <div class="section-note-note-content" id="section-note-note-content">
                <textarea name="place_note" class="form-control section-note-text" id="section-note-text" rows="13">{{old('place_note')}}</textarea>
            </div>
            <div class="section-submit-cancel-btn-line">

                <!-- <span class="login">
                    <a link rel="login" href="{{route('logout')}}">ログアウト</a>
                </span> -->
                <input type="submit" class="btn btn-secondary section-submit-btn section-submit-cancel-btn" value="Save">
            </div>
        </form>
        <form action="/logout" method="post" class="section-logout-btn">
            @csrf
            <input type="submit" value="Logout" class="btn btn-secondary">
        </form>
        <button type="button" Class="btn btn-secondary section-cancel-btn" id="cancel-btn">Cancel</button>
    </div>
</div>

<script>
    // perfect-scrollbrの処理
    // var ps = new PerfectScrollbar('.scroll_box');
</script>

<script>
    function getRatings(google_place_id, place_type_id) {
        // place_type_id = $('#section-place-type option:selected').val();
        // document.getElementById('form_place_type_id').value = place_type_id;
        // console.log('place_type_id: ' + place_type_id);
        // var ratings_json = localStorage.getItem('ratings_json');
        var ratings_json = localStorage.getItem('ratings_json');
        if (!ratings_json) {
            $.ajax({
                type: 'GET',
                url: "{{route('get.ratings')}}",
                data: {
                    // user_id: 23,
                    google_place_id: google_place_id
                    // place_type_id: place_type_id
                },
                dataType: 'JSON',
                success: function(data) {
                    var ratings_json = JSON.stringify(data);
                    localStorage.setItem('ratings_json', ratings_json);
                    setRatings(place_type_id);
                },
                error: function() {
                    //取得失敗時に実行する処理
                    console.log('ratingsの取得失敗');
                }
            });
        } else {
            setRatings(place_type_id);
        }
    }

    function setRatings(place_type_id) {
        var ratings_json = localStorage.getItem('ratings_json');
        var ratings = JSON.parse(ratings_json);
        console.log('setratings');
        console.log(ratings);

        if (!place_type_id) {
            if (ratings['place_type_id']) {
                place_type_id = ratings['place_type_id'];
            } else {
                // placeが未登録の場合
                place_type_id = 1;
            }
        }

        // place_type_idの取得
        // var place_type_id = ratings['place_type_id'];
        // var place_type_id = $('#section-place-type option:selected').val();
        // document.getElementById('form_place_type_id').value = place_type_id;

        if (ratings['user_order'][place_type_id]) {
            place_type_ratings = ratings['user_order'][place_type_id];
        } else {
            place_type_ratings = ratings['default_order'][place_type_id];
        }

        // console.log('getratingreturn' + data);
        var criterion_names = document.getElementsByClassName('section-criterion-name-display');
        var criterion_names_hidden = document.getElementsByClassName('criterion-name-hidden');
        var rating_values = document.getElementsByClassName('section-rating-value');
        for (let i = 0; i < Object.keys(place_type_ratings['criterion_id']).length; i++) {
            criterion_names[i].innerHTML = place_type_ratings['criterion_name_ja'][i];
            criterion_names_hidden[i].value = place_type_ratings['criterion_name_ja'][i];
            var elem_id = 'criterion' + (i + 1);
            var rating = place_type_ratings['ratings'][i];
            document.getElementById(elem_id).value = rating;
            rating_values[i].innerHTML = rating;
        }

        document.getElementById("section-note-text").value = ratings['note'];
        document.getElementById('form_place_type_id').value = place_type_id;

        dropdown = document.getElementById('section-place-type');
        dropdown.value = place_type_id;

        $(".sidebar.left").trigger("sidebar:open");
        sidebar_is_closed = false;
        $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
        setToggleBtnRotationSetting();

    }

    function getPlaceType() {
        console.log('getPlaceType starts');
        place_types_json = localStorage.getItem('place_types_json');
        console.log(place_types_json);
        if (!place_types_json) {
            $.ajax({
                type: 'GET',
                url: "{{route('get.place.type.options')}}",
                data: {},
                dataType: 'JSON',
                success: function(place_types) {
                    // place_typesデータの保存
                    var place_types_json = JSON.stringify(place_types);
                    localStorage.setItem('place_types_json', place_types_json);
                    setPlaceType();
                },
                error: function() {
                    console.log('place_type_optionsの取得失敗');
                }
            });
        } else {
            setPlaceType();
        }
    }

    function setPlaceType() {
        place_types_json = localStorage.getItem('place_types_json');
        var place_types_array = JSON.parse(place_types_json);
        console.log(place_types_array);
        // console.log(place_types_array['place_type_name_ja'][place_types_array['place_type_id'].indexOf(4)]);
        // console.log(place_types);
        var dropdown = document.getElementById('section-place-type');
        // 子要素の削除
        while (dropdown.firstChild) {
            dropdown.removeChild(dropdown.firstChild);
        }
        // 子要素の新規追加
        for (var i = 0; i < Object.keys(place_types_array['place_type_id']).length; i++) {
            var option = document.createElement('option');
            option.classList.add('section-place-type-option');
            option.value = place_types_array['place_type_id'][i];
            option.innerHTML = place_types_array['place_type_name_ja'][i];
            option.setAttribute("id", 'place-type-' + (i + 1));
            // if (i == 0) {
            //     option.setAttribute("selected", "");
            // }
            dropdown.appendChild(option);
        }
        // 施設タイプを選択
        var place_type_options = dropdown.getElementsByClassName('section-place-type-option');
        // console.log('place_type_options: ' + place_type_options[0].innerHTML);

        place_type_options[0].setAttribute("selected", "");
        place_type_id = document.getElementById('form_place_type_id').value;
        // console.log('place_type_id: ' + place_type_id);
        dropdown.value = place_type_id;

        //プルダウン選択時の処理を設定
        var options = document.querySelectorAll("#section-place-type option");
        dropdown.addEventListener('change', function() {
            var google_place_id = document.getElementById('google_place_id').value;

            //選択されたoption番号を取得
            var index = this.selectedIndex;
            // document.getElementById('form_place_type_id').value = options[index].value;
            place_type_id = options[index].value;

            getRatings(google_place_id, place_type_id);
        });
    }

    function setToggleBtnRotationSetting() {
        if ($(".sidebar-close-btn").css('cursor') != "pointer") {
            $(".sidebar-close-btn").css("cursor", "pointer");

            // 開閉ボタンクリック時の処理
            $(".sidebar-close-btn").on("click", function() {
                var $this = $(this);
                if (sidebar_is_closed) {
                    $this.trigger("sidebar:open");
                    sidebar_is_closed = false;
                    $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
                } else {
                    $this.trigger("sidebar:close");
                    sidebar_is_closed = true;
                    $(".sidebar-close-btn").css("transform", "");
                }
                return false;
            });
        }
    }
</script>

<script>
    $(document).ready(function() {
        $(".sidebar.left").sidebar({
            side: "left"
        });
        if (document.getElementById('google_place_id').value) {
            $(".sidebar.left").trigger("sidebar:open");
        }
    });
</script>

<!-- スライドバーに評価値を表示するスクリプト -->
<script>
    var elem = document.getElementsByClassName('range');
    var rating_values = document.getElementsByClassName('section-rating-value');
    var rangeValue = function(bar, target) {
        return function(evt) {
            target.innerHTML = bar.value;
        }
    }
    for (var i = 0; i < elem.length; i++) {
        bar = elem[i].getElementsByTagName('input')[0];
        target = rating_values[i];
        bar.addEventListener('input', rangeValue(bar, target));
    }

    // 入力・ 更新のキャンセル
    document.getElementById("cancel-btn").onclick = function() {
        getPlaceType();
        var google_place_id = document.getElementById('google_place_id').value;
        getRatings(google_place_id, null);
    };
</script>

@show