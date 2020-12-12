<?php
require_once "returnJson.php";
require_once "decrypt.php";
require_once "bdd.php";

// リクエストパラメータを取得
$returnOrigin = $_REQUEST['returnOrigin'];
$count = $_REQUEST['count'];
$q = $_REQUEST['q'];
$session_id = $_REQUEST['session_id'];

session_start();
$sid = session_id();

$depth = $az_bdd->depth; // BDDの深さ(変数の数)

// 同一セッションで用いているランダム値と公開鍵・秘密鍵
$random = $_SESSION['random'];
$pk = $_SESSION['public_key'];
$sk = $_SESSION['secret_key'];

// 鍵パラメータ
$r = $pk['r'];
$a = $pk['a'];
$b = $pk['b'];
$p = $pk['p'];
$x = $sk['x'];
$G = $sk['G'];

// 返却値用
$y = [];
$i = 0;
$c = [];

if (empty($random)) {
    throw new Exception ("random int is null");
}
else {
    foreach ($random[$count] as $rand) {
        $y[$i] = decrypt($q - $rand, $r, $x, $G, $a, $b, $p);
        $i ++;
    }

    // 第一回問い合わせに対して
    if ($count == 0) {
        $parent = $c1->name; // 親ノード
        $c[0] = $y[0] + $c1->next0->name;
        $c[1] = $y[1] + $c1->next1->name;
    }
    // 第二回以降
    else {
        $j = 0;
        foreach($az_bdd->v_node[$count] as $vn) {
            $c[$j] = $y[$j] + $vn->next0->name;
            $c[$j+1] = $y[$j+1] + $vn->next1->name;
            $j += 2;
        }
    }

}

// 返却値初期化
$result = [];

try {
    if(empty($returnOrigin) || empty($c) || empty($y)){
        throw new Exception("no type...");
    }

    // 返却値の作成
    $result = [
        'result' => 'OK',
        'c' => $c,
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage(),
        'debug' => $c,
    ];
}

echo returnJson($result, $returnOrigin);
?>