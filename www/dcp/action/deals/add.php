<?php
$image = $_FILES['image'];
$mime = explode("/", $_FILES['image']['type']);

if ($mime[0] == 'image') {
    $ad = [
        "image" => addslashes(file_get_contents($image['tmp_name'])),
        "mime" => $mime[0] . "/" . $mime[1],
        "link" => $r['link'],
        "updated_by" => $_SESSION['user']['id'],
    ];
    $db->insert("deals", $ad);
}
header("Location: /dcp/megadeal");
die;
