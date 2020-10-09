<?php
// SPが認可に使う属性値および認可ポリシーを受け取り認可結果を返すAPI

function returnJson($resultArray) {
    if(array_key_exists('callback', $_GET)){
        $json = $_GET['callback'] . "(" . json_encode($resultArray) . ");";
    } else {
        $json = json_encode($resultArray);
    }

    header("Access-Control-Allow-Origin: https://idp1.local");
    echo $json;
    exit(0);
}

// リクエスト受付
$attr = explode(',', $_REQUEST['attr']);
$attr_val = explode(',', $_REQUEST['attr_val']);

// 初期化
// $user_list = [];

// 返却値初期化
$result = [];

try {
    if(empty($attr) || empty($attr_val)) {
        throw new Exception("no type...");
    }

    // 返却値の作成
    $num = 1;
    $result = [
        'result' => 'OK',
        'attribute1' => $attr[0],
        'attribute2' => $attr[1],
        'attribute3' => $attr[2],
        'value1' => $attr_val[0],
        'value2' => $attr_val[1],
        'value3' => $attr_val[2]
    ];
} catch (Exception $e) {
    $result = [
        'result' => 'NG',
        'message' => $e->getMessage()
    ];
}

// レスポンスを返す
returnJson($result);
?>