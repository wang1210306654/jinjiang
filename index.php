<?php 
$controller = $_GET['c'];
$method = $_GET['m'];
$c_name = $controller.'Controller';

$file = './controller/'.$c_name . '.php';
if (file_exists($file)) {
    require_once $file; // 引入PHP文件
} else {
    require_once './helper/server.php';
    $server = new Helper\ServerHelper();
    $server->not_found();
}
$c = new $c_name();
$c->$method();
