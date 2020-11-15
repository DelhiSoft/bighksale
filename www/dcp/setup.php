<?php

session_start();
$arr = explode(PATH_SEPARATOR, get_include_path());
$arr[0] = __DIR__;
$dir = explode("/", __DIR__);
unset($dir[count($dir) - 1]);
// unset($dir[count($dir) - 1]);
array_unshift($arr, implode("/", $dir));
array_unshift($arr, ".");
set_include_path(implode(PATH_SEPARATOR, $arr));

require_once "vendor/autoload.php";
$db = new optiwariindia\database(include "setup/database.php");
$db->mode(1);
$db->debug();

if (isset($_REQUEST['action'])) {
    require_once "action/route.php";
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/view');
$twig = new \Twig\Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$data = [];