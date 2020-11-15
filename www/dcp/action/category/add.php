<?php
$image = $_FILES['image'];
$mime = explode("/", $_FILES['image']['type']);
if ($mime[0] == 'image') {
    $category = [
        "name" => $r['name'],
        "link" => $r['link'],
        "parent"=>$r['parent'],
        "image" => addslashes(file_get_contents($image['tmp_name'])),
        "mime" => $mime[0] . "/" . $mime[1],
        "navbar"=>$r['navbar'],
        "updated_by" => $_SESSION['user']['id'],
    ];
    $db->insert("category", $category);
}
header("Location: /dcp/category");

die;
