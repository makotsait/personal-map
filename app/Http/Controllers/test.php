<body>
    <input type="button" value="JSONファイルを取得する" onclick="getJSON()">
    <script>
        function getJSON() {
            var req = new XMLHttpRequest(); // XMLHttpRequest オブジェクトを生成する
            // req.onreadystatechange = function () { // XMLHttpRequest オブジェクトの状態が変化した際に呼び出されるイベントハンドラ
            //     if (req.readyState == 4 && req.status == 200) { // サーバーからのレスポンスが完了し、かつ、通信が正常に終了した場合
            //         alert(req.responseText); // 取得した JSON ファイルの中身を表示
            //     }
            // };
            req.open('GET', "https://maps.googleapis.com/maps/api/place/details/json?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&place_id=ChIJH7qx1tCMGGAR1f2s7PGhMhw&language=ja", true);
            req.responseType = 'json';
            req.addEventListener('load', function (response) {
                print(response)
            });
            // req.open("GET",
            //     "https://maps.googleapis.com/maps/api/place/details/json?key=AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8&place_id=ChIJH7qx1tCMGGAR1f2s7PGhMhw&language=ja",
            //     false); // HTTPメソッドとアクセスするサーバーの　URL　を指定]
            req.send(); // 実際にサーバーへリクエストを送信
        }
    </script>

    <!-- <script>
        function getJSON() {
            var api_key = "AIzaSyA-OXjQyOAsZIuDqm6FDUDqp3vNRLMNhE8";
            var place_id = "ChIJH7qx1tCMGGAR1f2s7PGhMhw";
            // var keyword = urlencode($keyword);
            var url = "https://maps.googleapis.com/maps/api/place/details/json?key=" + api_key + "&place_id=" + place_id + "&language=ja";
            req.open("GET", url, false); // HTTPメソッドとアクセスするサーバーの　URL　を指定
            req.send(null);
            // alart(JSON.parse(req.send(null)));
        }
    </script> -->
</body>