<?php
$user = $_SESSION['user'] ?? '';
$page = explode("/", $_REQUEST['path'] ?? '');
if (is_array($user)) {
    $data['user']=$user;
    $view = "index.twig";
    include "route.php";
} else {
    $view = "login.twig";
}
