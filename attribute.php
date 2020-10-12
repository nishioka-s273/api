<?php
// 認可に必要な属性とマジックプロトコルに用いる公開鍵をIdPに返すAPI
require "returnJson.php";

// 必要な属性を含むJSONファイルを取ってくる
$attr_file = "/var/www/datas/attr.json";
$json = file_get_contents($attr_file);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$array = json_decode($json, true);

$attributes = $array['attributes']; // 属性

// opensslで公開鍵・秘密鍵のペアを取ってくる (予め用意する)
$keyPath = realpath("../")."/datas/public.pem";
$key = file_get_contents($keyPath);

// リクエスト受付
$returnOrigin = $_REQUEST['returnOrigin'];

// 返却値初期化
$result = [];

try {
    if(empty($returnOrigin) || empty($attributes)) {
        throw new Exception("no type...");
    }

    // 返却値の作成
    $num = 1;
    $result = [
        'result' => 'OK',
        'attributes' => $attributes,
        'key' => $key
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage()
    ];
}

// レスポンスを返す
returnJson($result, $returnOrigin);
?>