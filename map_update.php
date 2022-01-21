<?php 
    $title = htmlspecialchars(trim($_POST['title']));
    $latlng = htmlspecialchars(trim($_POST['latlng']));
    $location = htmlspecialchars(trim($_POST['location']));
    $disaster_type = htmlspecialchars(trim($_POST['disaster_type']));
    $objectives = htmlspecialchars(trim($_POST['objectives']));
    $fundation_year = htmlspecialchars(trim($_POST['fundation_year']));
    $interest = htmlspecialchars(trim($_POST['interest']));
    $reference = htmlspecialchars(trim($_POST['reference']));
    $keyword = htmlspecialchars(trim($_POST['keyword']));
    $input_person = htmlspecialchars(trim($_POST['input_person']));

    $latlngs = explode(',', $latlng);
    $lat = $latlngs[0];
    $lng = $latlngs[1];
    if (!is_float($lat) || !is_float($lng)) {
        $message = "前の画面に戻って適切な緯度または経度を入力してください";
    }

?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>水歴史マップ入力入力確認</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <meta name="theme-color" content="#7952b3">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        html {
            padding: 0;
            margin: 0;
            height: 100%
        }

        body {
            padding-top: 56px;
            margin: 0;
            height: 100%
        }
    </style>

    <script>
        $(window).on('load resize', function() {
            // navbarの高さを取得する
            var height = $('.navbar').height();
            // bodyのpaddingにnavbarの高さを設定する
            $('body').css('padding-top', height);
        });
    </script>
    <!-- Custom styles for this template -->
    <!-- <link href="style.css" rel="stylesheet"> -->
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">水歴史マップデータ入力</a>
            <a href="https://docs.google.com/spreadsheets/d/1jOjbaxRrez2cjwgqZjdF_eotzcqNszAHMJXpe-ZZg4Q/edit#gid=0" target="_blank" style="color: white;">スプレッドシート</a>
        </div>
    </nav>

    <main class="container-fluid m-0 p-10">
        <h1 class="h1">入力確認</h1>
        <p>修正する時はブラウザの戻るボタンで戻ってください</p>
        <!-- フォーム表示部 -->
        <div id="form" class="container-fluid m-0 p-10">
            <form action="map_update2.php" method="POST">
                <div class="row row-cols-2">
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $title; ?>" id="title" name="title" readonly>
                        <label for="title" class="form-label">タイトル</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $latlng; ?>" id="latlng" name="latlng" readonly>
                        <label for="latlng" class="form-label">緯度,経度</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $location; ?>" id="location" name="location" readonly>
                        <label for="location" class="form-label">所在地</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $disaster_type; ?>" id="disaster_type" name="disaster_type" readonly>
                        <label for="disaster_type" class="form-label">災害別</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $objectives; ?>" id="objectives" name="objectives" readonly>
                        <label for="latlng" class="form-label">目的別</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $fundation_year; ?>" id="fundation_year" name="fundation_year" readonly>
                        <label for="latlng" class="form-label">建立年</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $interest; ?>" id="interest" name="interest" readonly>
                        <label for="latlng" class="form-label">特記事項</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $reference; ?>" id="reference" name="reference" value="「佐賀県の災害歴史遺産」佐賀県防災士会 誠文堂印刷株式会社 平成27年" readonly>
                        <label for="latlng" class="form-label">出典</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $keyword; ?>" id="keyword" name="keyword" readonly>
                        <label for="latlng" class="form-label">キーワード</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="input" class="form-control" value="<?php print $input_person; ?>" id="input_person" name="input_person" readonly>
                        <label for="latlng" class="form-label">入力者</label>
                    </div>
                </div>
                <!-- <input type="submit" class="btn btn-primary" value="送信"> -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">送信</button>
                </div>
            </form>
        </div>
    </main>


    <!-- /.container -->


</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</html>