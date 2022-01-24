<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
	<link rel="stylesheet" href="plugin/L.Icon.Pulse/L.Icon.Pulse.css" />
	<script type="text/javascript" src="plugin/L.Icon.Pulse/L.Icon.Pulse.js"></script>
	<link rel="stylesheet" href="plugin/Leaflet.Control.Opacity/L.Control.Opacity.css">
	<script src="plugin/Leaflet.Control.Opacity/L.Control.Opacity.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<style>
		body {
			padding: 0;
			margin: 0
		}

		html,
		body,
		#map {
			height: 100%;
			width: 100vw;
		}

		.rekishi-label {
			font-size: small;
			padding: 0;
		}
	</style>
	<title>水歴史マップ</title>
</head>

<body>
	<div id="map"></div>
</body>
<script>
	function copyToClipboard() {
		// コピー対象をJavaScript上で変数として定義する
		var copyTarget = document.getElementById("copyTarget");

		// コピー対象のテキストを選択する
		copyTarget.select();

		// 選択しているテキストをクリップボードにコピーする
		document.execCommand("Copy");

		// コピーをお知らせする
		//alert("座標をコピーできました！ : " + copyTarget.value);
		let copied = document.getElementById("copied");
		copied.innerText = "コピーしました";
	}

	function csvToArray(path) {
		var csvData = new Array();
		var req = new XMLHttpRequest();

		req.open("GET", path, false);
		req.send(null);

		var LF = String.fromCharCode(10);
		var lines = req.responseText.split(LF);

		for (var i = 0; i < lines.length; i++) {
			var cells = lines[i].split(',');
			csvData.push(cells);
		}

		return csvData;
	}

	const tile2 = L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: 'Map data &copy; 「電子国土基本図」<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>'
	});
	const tile2p = L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/pale/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: 'Map data &copy; 「電子国土基本図」<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>'
	});
	const tile3 = L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/seamlessphoto/{z}/{x}/{y}.jpg', {
		maxZoom: 17,
		attribution: 'Map data &copy; 「全国最新写真（シームレス）」<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>'
	});

	const map = L.map('map', {
		layers: [tile2p]
	});
	L.control.scale().addTo(map);
	//map.setView([33.279206, 130.266986], 13);

	// 浸水データ
	const data1 = L.tileLayer('https://disaportaldata.gsi.go.jp/raster/01_flood_l2_shinsuishin_kuni_data/{z}/{x}/{y}.png', {
		maxZoom: 17,
		attribution: 'Map data &copy; 「国管理河川_洪水浸水想定区域（想定最大規模）」国土交通省各地方整備局'
	});

	const data2 = L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/lcmfc2/{z}/{x}/{y}.png', {
		maxZoom: 17,
		attribution: 'Map data &copy; 「治水地形分類図 更新版」<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>'
	});

	// 歴史地名データ展開
	let rekishiGroup = L.layerGroup().addTo(map);
	const rekishi = csvToArray('saga-ogi-placename.csv');

	let data_rekishi = [];

	rekishi.forEach(function(el) {
		data_rekishi.push([el[0], el[1], el[2], el[9], el[10], el[11], el[12], el[17], el[18], el[19]]);
	});

	let j = 0;
	let markers_rekishi = [];
	let colorname = 'brown';
	let radius_size = 20;
	let opaticy = 1;

	while (data_rekishi.length > j) {
		//geolod_id,entry_id,body,body_variants,suffix,prefname,prefname_variants,countyname,countyname_variants,ne_class,hypernym,latitude,longitude,address,code,valid_from,valid_to,source,description
		//VaUi6l,10030594,筑紫海,,,,,,,水部/海・灘,肥前,33.125,130.31,,,,,http://codh.rois.ac.jp/historical-gis/nihu-map/?id=10030594,大日本地名辞書 4巻 252頁
		//["VaUi6l", "10030594", "筑紫海", "水部/海・灘", "肥前", "33.125", "130.31", "http://codh.rois.ac.jp/historical-gis/nihu-map/?id=10030594", "大日本地名辞書 4巻 252頁"]

		if (data_rekishi[j][3].indexOf("水部") > -1 || data_rekishi[j][3].indexOf("谷") > -1 || data_rekishi[j][3].indexOf("浜") > -1 || data_rekishi[j][3].indexOf("滝") > -1) {
			colorname = 'blue';
			opacity = 0.2;
			radius_size = 10;
		} else if (data_rekishi[j][3].indexOf("神社") > -1 || data_rekishi[j][3].indexOf("寺院") > -1) {
			colorname = 'red';
			opacity = 0.3;
			radius_size = 10;
		} else if (data_rekishi[j][9] == "1") {
			colorname = 'blue';
			opacity = 0.4;
			radius_size = 200;
		} else {
			colorname = 'black';
			opacity = 0.2;
			radius_size = 10;
		}

		markers_rekishi[j] = L.circle([data_rekishi[j][5], data_rekishi[j][6]], {
				radius: radius_size,
				color: colorname,
				fill: true,
				opacity: opacity,
				title: data_rekishi[j][2]
			})
			.bindTooltip(data_rekishi[j][2], {
				permanent: false,
				className: "rekishi-label",
				offset: [0, 0]
			})
			.bindPopup("<h3>歴史地名データ: " + data_rekishi[j][2] + "</h3><p>" + data_rekishi[j][0] + "<br>" + data_rekishi[j][1] + "<br>" + data_rekishi[j][3] + "<br>" + data_rekishi[j][4] + "<br>" + data_rekishi[j][5] + "<br>" + data_rekishi[j][6] + "<br>" + data_rekishi[j][7] + "<br>" + data_rekishi[j][8] + '</p>')
			.addTo(rekishiGroup);
		j += 1;
	}

	//ユーザ入力データ
	<?php
	include_once 'google-spread-sheet-api.php';
	$sheet_name = "シート1"; // シートを指定
	$sheet_range = "A2:K1000"; // 範囲を指定。開始から終了まで斜めで囲む感じです。
	$response = $sheet->spreadsheets_values->get($sheet_id, $sheet_name . '!' . $sheet_range);
	$records = $response->getValues();
	?>

	let data_memorials = <?php
							$vals = [];
							print "[";
							foreach ($records as $record) {
								// 緯度経度が入っているデータのみプロットする
								if ($record[1] != "" && $record[2] != "" && is_numeric($record[1]) && is_numeric($record[2])) {
									foreach ($record as $v) {
										$v2[] = '"' . $v . '"';
									}
									$vals[] = ("[" . implode(",", $v2) . "]");
									$v2 = [];
								}
							}
							print(implode(",", $vals));
							print "]";
							?>;	

	let k = 0;
	let markers_wm = [];
	let wmGroup = L.layerGroup().addTo(map);

	var greenIcon = L.icon({
		iconUrl: 'marker-icon-2x-green.png',
		shadowUrl: 'marker-shadow.png',
		iconSize: [25, 41],
		iconAnchor: [12, 41],
		popupAnchor: [1, -34],
		shadowSize: [41, 41]
	});

	while (data_memorials.length > k) {
		markers_wm[k] = L.marker([data_memorials[k][1], data_memorials[k][2]], {icon: greenIcon});

		markers_wm[k]
			.bindTooltip(data_memorials[k][0], {
				permanent: false,
				offset: [0, 0],
				direction: 'auto'
			})
			.bindPopup("<h3>佐賀県の災害歴史遺産</h3><h2>" + data_memorials[k][0] + "</h2><p>所在地　" + data_memorials[k][3] + "<br>災害別　" + data_memorials[k][4] + "<br>目的別　" + data_memorials[k][5] + "<br>建立年　" + data_memorials[k][6] + "<br>特記事項　" + data_memorials[k][7] + "<br>出典　" + data_memorials[k][8] + "</p>")
			.addTo(wmGroup);
		k += 1;
	}

	// 自然災害伝承碑（国土地理院）
	function onEachFeature(feature, layer) {
    // does this feature have a property named popupContent?
    if (feature.properties) {
        layer
				.bindTooltip(feature.properties.碑名, {
				permanent: false,
				offset: [0, 0],
				direction: 'auto'
				})
				.bindPopup(
					"<h3>自然災害伝承碑（国土地理院）</h3><h2>" + feature.properties.碑名 + "</h2><p>"
					+ "建立年　" + feature.properties.建立年 + "<br>"
					+ "所在地　" + feature.properties.所在地 + "<br>"
					+ "災害名　" + feature.properties.災害名 + "<br>"
					+ "災害種別　" + feature.properties.災害種別 + "<br>"
					+ "伝承内容　" + feature.properties.伝承内容 + "</p>"
				);
    }
	}

	const data_denshouhi = [<?php print(file_get_contents('shizen_saigai_denshouhi_20220114.geojson')); ?>];
	L.geoJSON(data_denshouhi, {
		onEachFeature: onEachFeature
	}).addTo(wmGroup);


	var marker = L.marker([33.0,130.0], {icon: greenIcon});

	//Mapをクリックした時ピンを立ててフォームに緯度経度を自動入力
	// function onMapClick(e) {
	// 	marker.on('click', function() { map.removeLayer(marker); });
			
	// 	marker
	// 			.setLatLng(e.latlng)
	// 			.bindPopup('<input id="copyTarget" type="text" value="' + e.latlng.lat + ',' + e.latlng.lng + '" readonly><button onclick="copyToClipboard();">copy</button><span id="copied" style="color: green; font-size: xx-small;"></span>')
	// 			.openPopup()
	// 			.addTo(map);
	// }
	// map.on('click', onMapClick);

	//レイヤー記述
	const baseLayer = {
		"電子国土基本図": tile2,
		"電子国土基本図（淡色）": tile2p,
		"全国最新写真（シームレス）": tile3
	}

	const myLayer = {
		"歴史地名データ": rekishiGroup,
		"災害歴史遺産・伝承碑": wmGroup,
		"浸水ハザードマップ": data1,
		'治水地形分類図 <a href="https://cyberjapandata.gsi.go.jp/legend/lcmfc2_legend.jpg" target="_blank">凡例</a>': data2,
	}

	const colorLayer = {
		"浸水ハザードマップ": data1,
		'治水地形分類図 <a href="https://cyberjapandata.gsi.go.jp/legend/lcmfc2_legend.jpg" target="_blank">凡例</a>': data2
	}

	L.control.layers(
		baseLayer,
		myLayer, {
			collapsed: true
		}
	).addTo(map);

	//OpacityControl
	L.control.opacity(
		colorLayer,
		{
			collapsed: true
		}
	).addTo(map);


	//現在地
	let myLoc;
	let lat;
	let lng;

	//現在地を取得できた場合
	const pulsingIcon = L.icon.pulse({
		iconSize: [10, 10],
		color: '#1199fb'
	});

	map.locate({
		watch: true
	});
	map.on('locationfound', function(evloc) {
		if (!myLoc) {
			myLoc = L.marker(evloc.latlng, {
				icon: pulsingIcon,
				zIndexOffset: 20
			}).bindTooltip('<p>現在地 (' + evloc.latitude + ',' + evloc.longitude + ')</p>').openTooltip().addTo(map);
		} else {
			myLoc.setLatLng(evloc.latlng);
			//console.log(ev.latlng);
		}
	});
	map.setView([33.26354300, 130.30083500], 13);
</script>

</html>