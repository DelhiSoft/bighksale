<?php
$image = $_FILES['image'];
$mime = explode("/", $_FILES['image']['type']);
if ($mime[0] == 'image') {
    $brand = [
        "prod" => $r['product'],
        "image" => addslashes(file_get_contents($image['tmp_name'])),
        "mime" => $mime[0] . "/" . $mime[1],
        "updated_by" => $_SESSION['user']['id'],
    ];
    $db->insert("prodimg", $brand);
}
header("Location: /dcp/product/img/".$r['product']);
die;