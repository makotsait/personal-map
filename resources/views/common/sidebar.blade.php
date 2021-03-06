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
            <input type="hidden" name="form_place_name" id="form_place_name" value="{{old('form_place_name')}}">
            <input type="hidden" name="form_formatted_address" id="form_formatted_address" value="{{old('form_formatted_address')}}">
            <input type="hidden" name="form_header_img_url" id="form_header_img_url" value="{{old('form_header_img_url')}}">
            <input type="hidden" name="criterion_id" value="2">
            <input type="hidden" name="place_name" id="place_name" value="">
            <input type="hidden" name="form_place_type_id" id="form_place_type_id" value="{{old('form_place_type_id')}}">
            <input type="hidden" name="google_place_id" id="google_place_id" value="{{old('google_place_id')}}">
            <input type="hidden" name="form_latitude" id="form_latitude" value="{{old('form_latitude')}}">
            <input type="hidden" name="form_longitude" id="form_longitude" value="{{old('form_longitude')}}">
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
            </div>
            <div class="section-note-note-content" id="section-note-note-content">
                <textarea name="place_note" class="form-control section-note-text" id="section-note-text" rows="13">{{old('place_note')}}</textarea>
            </div>
            <div class="section-submit-cancel-btn-line">
                <input type="submit" class="btn btn-secondary section-submit-btn section-submit-cancel-btn" value="Save">
            </div>
        </form>
        <form action="ratings/delete" method='POST' name="delete_form" class="section-delete-btn" id="section-delete-btn">
            @csrf
            <!-- old('delete_google_place_id')は利用不可。挙動より上から1つ目のformの値のみが読み込まれていると推測。値は同じなのでgoogle_place_idで代用。 -->
            <input type="hidden" name="delete_google_place_id" id="delete_google_place_id" value="{{old('google_place_id')}}">
            <input type="submit" name="delete" value="Delete" class="btn-delete btn btn-secondary">
        </form>
        <button type="button" class="btn btn-secondary section-cancel-btn" id="cancel-btn">Cancel</button>
    </div>
</div>

<script>
    function getRatings(google_place_id, place_type_id, require_rewrite_note = true) {
        let ratings_json = localStorage.getItem('ratings_json');
        if (!ratings_json) {
            $.ajax({
                type: 'GET',
                url: "{{route('get.ratings')}}",
                data: {
                    google_place_id: google_place_id
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log('Fetching ratings successed.');
                    console.log(data);
                    ratings_json = JSON.stringify(data);
                    localStorage.setItem('ratings_json', ratings_json);
                    setRatings(place_type_id, require_rewrite_note);
                },
                error: function() {
                    //取得失敗時に実行する処理
                    console.log('Fetching ratings failed.');
                }
            });
        } else {
            setRatings(place_type_id, require_rewrite_note);
        }
    }

    function setRatings(place_type_id, require_rewrite_note) {
        const ratings_json = localStorage.getItem('ratings_json');
        const ratings = JSON.parse(ratings_json);

        if (!place_type_id) {
            if (ratings['place_type_id']) {
                place_type_id = ratings['place_type_id'];
            } else {
                // placeが未登録の場合
                place_type_id = 1;
            }
        }

        if (ratings['user_order'][place_type_id]) {
            place_type_ratings = ratings['user_order'][place_type_id];
        } else {
            place_type_ratings = ratings['default_order'][place_type_id];
        }

        let html_criterion_names = document.getElementsByClassName('section-criterion-name-display');
        let html_criterion_names_hidden = document.getElementsByClassName('criterion-name-hidden');
        let html_rating_values = document.getElementsByClassName('section-rating-value');
        for (let i = 0; i < Object.keys(place_type_ratings['criterion_id']).length; i++) {
            html_criterion_names[i].innerHTML = place_type_ratings['criterion_name_ja'][i];
            html_criterion_names_hidden[i].value = place_type_ratings['criterion_name_ja'][i];

            let elem_id = 'criterion' + (i + 1);
            let rating = place_type_ratings['ratings'][i];
            document.getElementById(elem_id).value = rating;
            html_rating_values[i].innerHTML = rating;
        }

        if (require_rewrite_note) {
            document.getElementById("section-note-text").value = ratings['note'];
        }
        document.getElementById('form_place_type_id').value = place_type_id;
        document.getElementById('section-place-type').value = place_type_id;

        $(".sidebar.left").trigger("sidebar:open");
        is_sidebar_closed = false;
        $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
        setToggleBtnRotationSetting();

    }

    function getPlaceType() {
        console.log('getPlaceType starts');
        place_types_json = localStorage.getItem('place_types_json');
        if (!place_types_json) {
            $.ajax({
                type: 'GET',
                url: "{{route('get.place.type.options')}}",
                data: {},
                dataType: 'JSON',
                success: function(place_types) {
                    console.log('Fetching place type options successed.');
                    console.log(place_types);
                    // place_typesデータの保存
                    var place_types_json = JSON.stringify(place_types);
                    localStorage.setItem('place_types_json', place_types_json);
                    setPlaceType();
                },
                error: function() {
                    console.log('Fetching place type options failed.');
                }
            });
        } else {
            setPlaceType();
        }
    }

    function setPlaceType() {
        place_types_json = localStorage.getItem('place_types_json');
        var place_types_array = JSON.parse(place_types_json);
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
            dropdown.appendChild(option);
        }
        // 施設タイプを選択
        var place_type_options = dropdown.getElementsByClassName('section-place-type-option');

        place_type_options[0].setAttribute("selected", "");
        place_type_id = document.getElementById('form_place_type_id').value;
        dropdown.value = place_type_id;

        //プルダウン選択時の処理を設定
        var options = document.querySelectorAll("#section-place-type option");
        dropdown.addEventListener('change', function() {
            var google_place_id = document.getElementById('google_place_id').value;

            //選択されたoption番号を取得
            var index = this.selectedIndex;
            place_type_id = options[index].value;

            getRatings(google_place_id, place_type_id, false);
        });
    }

    function setToggleBtnRotationSetting() {
        if ($(".sidebar-close-btn").css('cursor') != "pointer") {
            $(".sidebar-close-btn").css("cursor", "pointer");

            // 開閉ボタンクリック時の処理
            $(".sidebar-close-btn").on("click", function() {
                var $this = $(this);
                if (is_sidebar_closed) {
                    $this.trigger("sidebar:open");
                    is_sidebar_closed = false;
                    $(".sidebar-close-btn").css("transform", "rotateY(180deg)");
                } else {
                    $this.trigger("sidebar:close");
                    is_sidebar_closed = true;
                    $(".sidebar-close-btn").css("transform", "");
                }
                return false;
            });
        }
    }

    // 削除確認ダイアログをセット
    $(function() {
        $(".btn-delete").click(function() {
            if (confirm("本当に削除しますか？")) {
                // 処理を止めずに続行
            } else {
                // 処理をキャンセル
                return false;
            }
        });
    });

    $(document).ready(function() {
        $(".sidebar.left").sidebar({
            side: "left"
        });
        if (document.getElementById('google_place_id').value) {
            $(".sidebar.left").trigger("sidebar:open");
        }
    });

    // スライドバーに評価値を表示する
    let html_range = document.getElementsByClassName('range');
    let html_rating_values = document.getElementsByClassName('section-rating-value');

    let rangeValue = function(bar, target) {
        return function(evt) {
            target.innerHTML = bar.value;
        }
    }
    for (var i = 0; i < html_range.length; i++) {
        bar = html_range[i].getElementsByTagName('input')[0];
        target = html_rating_values[i];
        bar.addEventListener('input', rangeValue(bar, target));
    }

    // 入力・ 更新のキャンセル
    document.getElementById("cancel-btn").onclick = function() {
        getPlaceType();
        const google_place_id = document.getElementById('google_place_id').value;
        getRatings(google_place_id, null);
    };
</script>

@show