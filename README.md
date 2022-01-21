# 佐賀水歴史マップ（UDC2021）

オープンデータと地元の紙資料を地理データにおこして同じ地図に重ねてマッピングするための簡単なツールです
Leaflet, Google API Clientでスプレッドシートのデータを読み書きします

この水歴史マップには以下のデータが入っています
- 「[電子国土基本図](https://maps.gsi.go.jp/development/ichiran.html)」国土地理院
- 「[国管理河川_洪水浸水想定区域（想定最大規模）](https://disaportal.gsi.go.jp/hazardmap/copyright/opendata.html#l2shinsuishin)」国土交通省各地方整備局（浸水ハザードマップ）
- 「[治水地形分類図 更新版](https://maps.gsi.go.jp/development/ichiran.html)」国土地理院
- 「佐賀県の災害歴史遺産」佐賀県防災士会 誠文堂印刷株式会社 平成27年から抽出した[地理データ](https://docs.google.com/spreadsheets/d/1VPCFGAjPtlZ-VbG1cnmNBH4UURTKLKXuFp2ebWKoxck/edit#gid=0)（入力者はanonymousに変えています）
- 「[歴史地名データ](https://www.nihu.jp/ja/publication/source_map)」大学共同利用機関法人人間文化研究機構、および、京都大学東南アジア地域研究研究所を主体とするH-GIS研究会 （佐賀県（肥前国）抜粋）　


## 特徴

- グループで書籍などの紙資料から地理データを抜き出してマッピングするために、データ入力ができるだけ簡単になるようにしました
- https://winter.ai.is.saga-u.ac.jp/water-map/map.php にデータ入力結果を載せています
- 以下の画像はグループで入力するときのデータ入力画面です
- スマートフォンなどで、地図をクリックして出てくる緯度経度をフォームにコピペします


### データ入力画面の画像

<img src="https://user-images.githubusercontent.com/2604408/150478503-839cd712-68d6-422b-b76f-c35c033e02d2.png" width="200px">


## 概要

- オープンデータ（例えば国土地理院の地図タイルやハザードマップなど）のリンクを集めます
- 緯度経度や地図上の地点が載った図など紙資料を集めます
- Googleスプレッドシートにて紙資料を地点の名前、緯度、経度、出典という形でデータ化します
- Googleのアカウントを持っている人と上記スプレッドシートを共有して、多人数で書き込みOKにします
- Google Spread Sheet APIにアクセスしてスプレッドシートのデータを地図にマッピングします
- google-spread-sheet-api.phpでAPIを使ったデータアップロードを行いますので、各自で登録したキーやスプレッドシートのIDをセットしてください
