<?php
namespace Helper;
class ServerHelper{
    public function not_found(){
$html = <<<EOF
<!DOCTYPE html>
<html>
<head>
<title>Error</title>
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1>404</h1>
<p>页面不存在</p>
</body>
</html>
EOF;
        echo $html;exit;
    }
}