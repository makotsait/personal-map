
@section('sidebar')

<div class="sidebar left" >
    <img class="sidebar close btn" data-action="toggle" data-side="left" border="0" src="{{ asset('icon/icon_open_sidebar.png') }}" alt="icon_sidebar_oc">
    <div class = "header-image">   
        <?php
        $top_img_url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
        $photo_ref = "photoreference=CmRaAAAAiVgVE_r8zAmHGceo65OoPPa4tUqawrI0OiuHrxH_wKVyJ2NCEv_bnvFUeuwbPX8liS2XGC_sfuBUJdh48leGihuC8UixzwBHtjPtxuhQnE1OTekd78nUr-eqQWPII3KoEhCv9Ixq_3zcDqMtEGFJLSN4GhSExSvn9LvQFJga4bqAmtqCYn7gAg";
        $top_img_url =  $top_img_url."&".$photo_ref;
        echo "<img src=$top_img_url>";
        ?>
    </div>
    <div class = "header-title-description">
        <h1 class = "header-title">東京駅</h1>
    </div>
    <div class = "ratings">
        <div class = "ratings-line">
            <span class = "rating rating-left">
                <span>味</span>
                <span class="range">
                    <input type="range" min="0" max="5" value="0">
                    <span>0</span>
                </span>
            </span>
            <span class = "rating">
                <span>コスパ</span>
                <span class="range">
                    <input type="range" min="0" max="5" value="0">
                    <span>0</span>
                </span>
            </span>
        </div>
        <div class = "ratings-line">
            <span class = "rating rating-left">
                <span>接客</span>
                <span class="range">
                    <input type="range" min="0" max="5" value="0">
                    <span>0</span>
                </span>
            </span>
            <span class = "rating">
                <span>デザイン</span>
                <span class="range">
                    <input type="range" min="0" max="5" value="0">
                    <span>0</span>
                </span>
            </span>
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function () {
        // 向き
        var sides = ["left", "top", "right", "bottom"];

        // サイドバーの初期化
        for (var i = 0; i < sides.length; ++i) {
            var cSide = sides[i];
            $(".sidebar." + cSide).sidebar({side: cSide}{close:true});
        }

        // ボタンのクリックにより...
        $(".btn[data-action]").on("click", function () {
            var $this = $(this);
            var action = $this.attr("data-action");
            var side = $this.attr("data-side");
            $(".sidebar." + side).trigger("sidebar:" + action);
            return false;
        });
    });
</script>

<!-- スライドバーの現在地値を表示するスクリプト -->
<script>
 　var elem = document.getElementsByClassName('range');
　 var rangeValue = function (elem, target) {
　 　　return function(evt){
　　　 　　target.innerHTML = elem.value;
 　　　}
　 }
　 for(var i = 0; i < elem.length; i++){
 　　　bar = elem[i].getElementsByTagName('input')[0];
 　　　target = elem[i].getElementsByTagName('span')[0];
　　　 bar.addEventListener('input', rangeValue(bar, target));
　 }
</script>

@show