<html lang="ja">
    <head>
    <meta charset="UTF-8">
        <title>TEST PAGE</title>
        <style type="text/css">
        body,
        input,
        button {
            font-size:: 30px;
        }
        </style>
    </head>
    <body>
        <h2>検証用ページ</h2>
        <pre><?php
        //session_start();
        require_once('/var/www/simplesaml/lib/_autoload.php');
        $as = new SimpleSAML_Auth_Simple('default-sp');
        $as->requireAuth();
        $attr=$as->getAttributes();
        $name=$as->getAuthData("saml:sp:NameID");

        $data_file = "/var/www/datas/data.json";
        $json = file_get_contents($data_file);
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $array = json_decode($json, true);

        $session_id = $attr['session_id'][0];
        try {
            if (empty($array[$session_id])) {
                throw new Exception ("no value");
            }
            $x = $array[$session_id];
            echo $x;
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
        

        $thres_file = "/var/www/datas/threshold.json";
        $json = file_get_contents($thres_file);
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $array = json_decode($json, true);
        $thresholds = $array['thresholds'];
        echo "<br>thresholds<br>";
        print_r($thresholds);

        print_r($attr);

        $uidnum = $attr['retuid'][0] - $x;

        // 認可失敗
        if($uidnum == 0){
            echo "<h3>認可に失敗しました</h3>";
        }
        else {
            echo "<h3>ようこそ user".$uidnum." さん</h3>";
        }
        ?></pre>
        <a href="logout.php">LOG OUT</a>
    </body>
</html>