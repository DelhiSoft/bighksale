<?php
$image = $_FILES['image'];
$mime = explode("/", $_FILES['image']['type']);
if ($mime[0] == 'image') {
    $brand = [
        "name" => $r['name'],
        "image" => addslashes(file_get_contents($image['tmp_name'])),
        "mime" => $mime[0] . "/" . $mime[1],
        "updated_by" => $_SESSION['user']['id'],
    ];
    $db->insert("brand", $brand);
}
header("Location: /dcp/brand");
die;
