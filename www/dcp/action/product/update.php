<?php

$image = $_FILES['image']??[];
$mime = explode("/", $_FILES['image']['type']??'');

if ($mime[0] == 'image') {
    $product = [
        "image" => addslashes(file_get_contents($image['tmp_name'])),
        "mime" => $mime[0] . "/" . $mime[1],
        "name"=>$r['name'],
        "description"=>$r['description'],
        "mrp"=>$r['mrp'],
        "dmrp"=>$r['dmrp'],
        "brand"=>$r['brand'],
        "category"=>$r['category'],
        "featured"=>$r['featured']??0,
        "new"=>$r['new']??0,
        "hot"=>$r['hot']??0,
        "updated_by" => $_SESSION['user']['id'],
    ];
    $db->update("product", $product,"where id={$r['id']}");
}else{
    $product = [
        "name"=>$r['name'],
        "description"=>$r['description'],
        "mrp"=>$r['mrp'],
        "dmrp"=>$r['dmrp'],
        "brand"=>$r['brand'],
        "category"=>$r['category'],
        "featured"=>$r['featured']??0,
        "new"=>$r['new']??0,
        "hot"=>$r['hot']??0,
        "updated_by" => $_SESSION['user']['id'],
    ];
    $db->update("product", $product,"where id={$r['id']}");
}
header("Location: /dcp/product");
die;
