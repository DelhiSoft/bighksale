<?php
$path=explode(PATH_SEPARATOR,get_include_path());
$path[]=__DIR__;
$rootpath=__DIR__;
set_include_path(implode(PATH_SEPARATOR,$path));
$view="index.twig";
require_once "setup/init.php";
// header("content-type: text/text");print_r($data);die;
echo $twig->render($view,$data);