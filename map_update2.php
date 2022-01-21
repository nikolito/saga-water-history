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

	include_once 'google-spread-sheet-api.php';

    try {
        $values = array(array($title,$lat,$lng,$location,$disaster_type,$objectives,$fundation_year,$interest,$reference,$keyword,$input_person));

        $range = "A2:K1000"; // 範囲を指定。開始から終了まで斜めで囲む感じです。
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = ['valueInputOption' => 'USER_ENTERED'];   // 入力方法 ※
        $result = $sheet->spreadsheets_values->append($sheet_id, $range, $body, $params);

    } catch (\Exception $e) {

        // エラー処理
        print("何らかのエラーが起きました。ごめんなさい！");
        exit;
        
    }

    header("location: index.php");
?>