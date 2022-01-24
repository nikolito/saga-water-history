<?php
//Google Spread Sheet APIにアクセス
require __DIR__ . '/vendor/autoload.php';

$key = '*****.json'; サービスアカウント
$sheet_id = "*****"; //water_history_memorials sheet ID

$client = new \Google_Client();
$client->setAuthConfig($key);
$client->addScope(\Google_Service_Sheets::SPREADSHEETS);
$client->setApplicationName("saga-water-history"); // 適当な名前でOK
$sheet = new \Google_Service_Sheets($client);
?>