<?php
require "returnJson.php";
require "decrypt.php";
// IdP から z_i を受け取り，w_{ij}を計算して返す

// リクエストパラメータを取得
$returnOrigin = $_REQUEST['returnOrigin'];
$req_z = $_REQUEST['z'];
$req_z = substr($req_z, 1);
$req_z = substr($req_z, 0, -1);
$z = explode(",", $req_z);
$session_id = $_REQUEST['session_id'];

session_start();
//$session_id = session_id();

// 暗号化・復号に使う鍵をattribute.phpから取得 (同一セッション)
$pk = $_SESSION['public_key'];
$sk = $_SESSION['secret_key'];

// v_{i}{j}を作成する
$vij = [];
$i = 0;
foreach ($z as $zi) {
    // とりあえず 1<=z_{i}<=10とする
    // z_{i}{j}は，zij[$i+1][$j+1]に相当
    for ($j=0; $j<10; $j++) {
        $zij = $zi + $j + 1;
        $vij[$i][$j] = decrypt($zij, $pk['r'], $sk['x'], $sk['G'], $pk['a'], $pk['b'], $pk['p']);
    }
    $i = $i + 1;
}

// 閾値を取ってくる
$thres_file = "/var/www/datas/threshold.json";
$json = file_get_contents($thres_file);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$array = json_decode($json, true);

$thresholds = $array['thresholds'];

if (count($thresholds) !== count($z)) {
    die("threshold values and attribute values must be the same amount");
}

// 一方向ハッシュ関数を定義
$hash_function = 'hash_hmac'; // hash_hmacを使用
$algo = 'ripemd160'; // ripemd160 を使用
$key = 'secret';  // 共有鍵

// w_{i}{j}を作成する
$wij = [];
for ($k=0; $k<count($z); $k++) {
    for ($l=0; $l<$thresholds[$k]; $l++) {
        $wij[$k][$l] = hexdec(hash_hmac($algo, $vij[$k][$l], $key));
    }
    for ($l=$thresholds[$k]; $l<10; $l++) {
        $wij[$k][$l] = hexdec(hash_hmac($algo, $vij[$k][$l], $key)) + 1;
    }
}

// 返却値初期化
$result = [];

try {
    if(empty($returnOrigin) || empty($z) || empty($vij) || empty($wij)) {
        throw new Exception("no type...");
    }


    // 返却値の作成
    $num = 1;
    $result = [
        'result' => 'OK',
        'hash_function' => $hash_function,
        'algo' => $algo,
        'key' => $key,
        'w_ij' => $wij,
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage()
    ];
}

echo returnJson($result, $returnOrigin);
?>