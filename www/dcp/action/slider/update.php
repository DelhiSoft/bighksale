<?php
$mime = explode("/", $_FILES['image']['type']);
if ($mime[0] == 'image') {
    $file = $_FILES['image'];
    $db->update("slider", [
        "image" => addslashes(file_get_contents($file['tmp_name'])),
        "mime" => mime_content_type($file['tmp_name']),
    ], "where id={$r['id']}");

}
$slide = [
    "alt" => $r['alt'],
    "text" => json_encode([
        $r['bt1'],
        $r['bt2'],
        $r['bt3'],
    ]),
    "btn_text" => $r['btn_txt'],
    "btn_link" => $r['btn_link'],
    "updated_by" => $_SESSION['user']['id'],
];
$db->update("slider",$slide,"where id={$r['id']}");
header("Location: /dcp/slider");
die;
