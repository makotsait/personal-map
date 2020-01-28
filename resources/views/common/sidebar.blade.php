
@section('sidebar')

<div class="sidebar left" >Hello World
<img class="sidebar close btn" data-action="toggle" data-side="left" border="0" src="{{ asset('icon/icon_open_sidebar.png') }}" alt="イラスト1">
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