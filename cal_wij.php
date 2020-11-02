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
//$public_key = $pk['a']+$pk['b']+$pk['p']+$pk['r']+$pk['Y'][0]+$pk['Y'][1]+$sk['x']+$sk['G'][0]+$sk['G'][1];

// v_{ij}を作成する
$vij = [];
$i = 0;
foreach ($z as $zi) {
    // とりあえず 1<=z_{i}<=100とする
    for ($j=0; $j<100; $j++) {
        $zij = $zi + $j + 1;
        $vij[$i][$j] = decrypt($zij, $pk['r'], $sk['x'], $sk['G'], $pk['a'], $pk['b'], $pk['p']);
    }
    $i = $i + 1;
}

// 返却値初期化
$result = [];

try {
    if(empty($returnOrigin) || empty($z) || empty($vij)) {
        throw new Exception("no type...");
    }


    // 返却値の作成
    $num = 1;
    $result = [
        'result' => 'OK',
        'zi' => $z,
        'session_id' => $session_id,
        'w_ij' => $vij,
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage()
    ];
}

echo returnJson($result, $returnOrigin);
?>