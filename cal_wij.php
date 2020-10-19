<?php
require "returnJson.php";
// IdP から z_i を受け取り，w_{ij}を計算して返す

$returnOrigin = $_REQUEST['returnOrigin'];
$zi = $_REQUEST['z'];
$zi = substr($zi, 1);
$zi = substr($zi, 0, -1);
$z = explode(",", $zi);
//print_r($z);

// 返却値初期化
$result = [];

try {
    if(empty($returnOrigin) || empty($z)) {
        throw new Exception("no type...");
    }

    // 返却値の作成
    $num = 1;
    $result = [
        'zi' => $z
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage()
    ];
}

echo returnJson($result, $returnOrigin);