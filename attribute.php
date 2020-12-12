<?php
// 認可に必要な属性とマジックプロトコルに用いる公開鍵をIdPに返すAPI
require_once "returnJson.php";
require_once "setup.php";

session_start();
$session_id = session_id();

// 必要な属性を含むJSONファイルを取ってくる
$attr_file = "/var/www/datas/attr.json";
$json = file_get_contents($attr_file);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$array = json_decode($json, true);

$attributes = $array['attributes']; // 属性

$setup = setup();
$key = [
    'a' => htmlspecialchars($setup['a']),
    'b' => htmlspecialchars($setup['b']),
    'p' => htmlspecialchars($setup['p']),
    'r' => htmlspecialchars($setup['r']),
    'Y' => $setup['Y']
];

$_SESSION['ID'] = $session_id;
$_SESSION['secret_key']['x'] = $setup['x'];
$_SESSION['secret_key']['G'] = $setup['G'];
$_SESSION['public_key']['a'] = $setup['a'];
$_SESSION['public_key']['b'] = $setup['b'];
$_SESSION['public_key']['p'] = $setup['p'];
$_SESSION['public_key']['r'] = $setup['r'];
$_SESSION['public_key']['Y'] = $setup['Y'];

// リクエスト受付
$returnOrigin = $_REQUEST['returnOrigin'];

// 返却値初期化
$result = [];

try {
    if(empty($returnOrigin) || empty($attributes) || empty($key)) {
        throw new Exception("no type...");
    }

    // 返却値の作成
    $num = 1;
    $result = [
        'result' => 'OK',
        'attributes' => $attributes,
        'key' => $key,
        'session_id' => $session_id
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage()
    ];
}

// レスポンスを返す
echo returnJson($result, $returnOrigin);
?>