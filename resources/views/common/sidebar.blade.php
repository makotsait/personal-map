@section('sidebar')
<div class="sidebar left scroll_box">
    <img class="sidebar close btn" data-action="toggle" data-side="left" border="0" src="{{ asset('icon/icon_open_sidebar.png') }}" alt="icon_sidebar_oc">
    <div class="section-sidebar-left-content inner">

        <div class="header-image">
            <img id="header-image" src="">
            <?php
            // $top_img_url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
            // $photo_ref = "photoreference=CmRaAAAAiVgVE_r8zAmHGceo65OoPPa4tUqawrI0OiuHrxH_wKVyJ2NCEv_bnvFUeuwbPX8liS2XGC_sfuBUJdh48leGihuC8UixzwBHtjPtxuhQnE1OTekd78nUr-eqQWPII3KoEhCv9Ixq_3zcDqMtEGFJLSN4GhSExSvn9LvQFJga4bqAmtqCYn7gAg";
            // $top_img_url =  $top_img_url . "&" . $photo_ref;
            // echo "<img src=$top_img_url>";
            ?>
        </div>
        <div class="header-title-description">
            <h1 class="header-title" id="header-title">place name</h1>
            <span id="place_address">address</span>
        </div>

        <form action="ratings/update" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="23">
            <!-- <input type="hidden" name="place_id" value="2"> -->
            <input type="hidden" name="criterion_id" value="2">
            <!-- <input type="hidden" name="num_criteria" value="2"> -->
            <input type="hidden" name="google_place_id" id="google_place_id" value="a">
            <div class="ratings">
                <div class="ratings-line" id="section-ratings-line-1">
                    <span class="rating rating-left" id="section-rating-group-1">
                        <span>要素1</span>
                        <span class="range">
                            <input type="range" name="criterion1" id="criterion1" min="0" max="5" value="0">
                        </span>
                        <span class="section-rating-value">0</span>
                    </span>
                    <span class="rating section-rating-inline-right" id="section-rating-group-2">
                        <span>要素2</span>
                        <span class="range">
                            <input type="range" name="criterion2" id="criterion2" min="0" max="5" value="0">
                        </span>
                        <span class="section-rating-value">0</span>
                    </span>
                </div>
                <div class="ratings-line" id="section-ratings-line-2">
                    <span class="rating rating-left" id="section-rating-group-3">
                        <span>要素3</span>
                        <span class="range">
                            <input type="range" name="criterion3" id="criterion3" min="0" max="5" value="0">
                        </span>
                        <span class="section-rating-value">0</span>
                    </span>
                    <span class="rating section-rating-inline-right" id="section-rating-group-4">
                        <span>要素4</span>
                        <span class="range">
                            <input type="range" name="criterion4" id="criterion4" min="0" max="5" value="0">
                        </span>
                        <span class="section-rating-value">0</span>
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
                <textarea name="place_note" class="section-note-text" id="section-note-text" rows="20"></textarea>
            </div>
            <div class="section-submit-cancel-btn-line">
                <span class="login">
                    <a link rel="login" href="">ログイン</a>
                </span>
                <input type="submit" class="section-submit-btn section-submit-cancel-btn" value="Save">
                <input type="submit" class="section-cancel-btn section-submit-cancel-btn" value="Cancel">
            </div>
        </form>
    </div>
</div>

<script>
    // perfect-scrollbrの処理
    // var ps = new PerfectScrollbar('.scroll_box');
</script>
<script>
    function getRatings(google_place_id) {
        $.ajax({
            type: 'GET',
            url: "{{route('get_ratings')}}",
            data: {
                user_id: 23,
                google_place_id: google_place_id
            },
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                var rating_values = document.getElementsByClassName('section-rating-value');
                for (let i = 1; i <= data['num_of_criteria']; i++) {
                    // alert(data['rating'][i]['rating']);
                    var rating = data['rating'][i]['rating'];
                    var elem_id = 'criterion' + i;
                    document.getElementById(elem_id).value = rating;
                    rating_values[i - 1].innerHTML = rating;
                }
                document.getElementById("section-note-text").value = data['note'];

            },
            error: function() {
                //取得失敗時に実行する処理
                alert("取得失敗2");
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        // 向き
        var sides = ["left", "top", "right", "bottom"];

        // サイドバーの初期化
        for (var i = 0; i < sides.length; ++i) {
            var cSide = sides[i];
            // $(".sidebar." + cSide).sidebar({side: cSide}{close:true});
            $(".sidebar." + cSide).sidebar({
                side: cSide
            });
        }

        // ボタンのクリックにより...
        $(".btn[data-action]").on("click", function() {
            var $this = $(this);
            var action = $this.attr("data-action");
            var side = $this.attr("data-side");
            $(".sidebar." + side).trigger("sidebar:" + action);
            return false;
        });
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
</script>

@show