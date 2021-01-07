<?php
require_once "returnJson.php";
require_once "crypt.php";

// リクエストパラメータを取得
$returnOrigin = $_REQUEST['returnOrigin'];
$rand = [$_REQUEST['random0'], $_REQUEST['random1']];
$key = [
    'a' => $_REQUEST['key_a'],
    'b' => $_REQUEST['key_b'],
    'p' => $_REQUEST['key_p'],
    'r' => $_REQUEST['key_r'],
    'Y' => [$_REQUEST['key_Y0'], $_REQUEST['key_Y1']]
];
$session_id = $_REQUEST['session_id'];

session_start();
$sid = session_id();

// 今回は1番目のオーダーを紛失通信で受け取る
$x = random_int(1,100);
$q = encrypt($key['r'], $x, $key['Y'], $key['a'], $key['b'], $key['p']);
$q += $rand[0];

// 返却値初期化
$result = [];

$file = '/var/www/datas/data.json';
$current = file_get_contents($file);
$current = substr($current, 0, -1);  // "}"を消去
$current .= ',"'.$session_id.'":'.$x.'}'; // ["session_id" : x]を追加
$bytes = file_put_contents($file, $current);

try {
    if(empty($returnOrigin) || empty($key)){
        throw new Exception("no type...");
    }

    // 返却値の作成
    $result = [
        'result' => 'OK',
        'q' => $q,
        'x' => $x,
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage(),
    ];
}

echo returnJson($result, $returnOrigin);
?>