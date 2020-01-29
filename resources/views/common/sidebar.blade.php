
@section('sidebar')

<div class="sidebar left" >Hello World
<img class="sidebar close btn" data-action="toggle" data-side="left" border="0" src="{{ asset('icon/icon_open_sidebar.png') }}" alt="icon_sidebar_oc">
<?php
$top_img_url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
$photo_ref = "photoreference=CmRaAAAAiVgVE_r8zAmHGceo65OoPPa4tUqawrI0OiuHrxH_wKVyJ2NCEv_bnvFUeuwbPX8liS2XGC_sfuBUJdh48leGihuC8UixzwBHtjPtxuhQnE1OTekd78nUr-eqQWPII3KoEhCv9Ixq_3zcDqMtEGFJLSN4GhSExSvn9LvQFJga4bqAmtqCYn7gAg";
$top_img_url =  $top_img_url."&".$photo_ref;
echo "<img src=$top_img_url>";
?>
</div>

<script>
$(document).ready(function () {
    // 向き
    var sides = ["left", "top", "right", "bottom"];

    // サイドバーの初期化
    for (var i = 0; i < sides.length; ++i) {
        var cSide = sides[i];
        $(".sidebar." + cSide).sidebar({side: cSide});
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

@show