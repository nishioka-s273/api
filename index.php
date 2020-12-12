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
        require_once('/var/www/simplesaml/lib/_autoload.php');
        $as = new SimpleSAML_Auth_Simple('default-sp');
        $as->requireAuth();
        $attr=$as->getAttributes();
        $name=$as->getAuthData("saml:sp:NameID");

        print_r($attr);
        ?></pre>
        <a href="logout.php">LOG OUT</a>
    </body>
</html>