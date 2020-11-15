<?php
require "vendor/autoload.php";
require_once "cart.php";
require_once "wishlist.php";

/* Initializing Twig */
session_start();

#unset($_SESSION['cart']);unset($_SESSION['wishlist']);

$cart=new Cart();
$wishlist=new Wishlist();

$loader = new \Twig\Loader\FilesystemLoader($rootpath.'/view');
$twig = new \Twig\Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/* Initializing Database */
$db=new optiwariindia\database(include "setup/database.php");
$db->mode(1);

$path=$_REQUEST['path']??'';
$r=$db->resa($_REQUEST);

if(isset($r['action'])){
  include "actions.php";
}

include "basicinfo.php";
include "routes.php";