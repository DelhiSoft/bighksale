<?php
$image = $_FILES['image'];
$mime = explode("/", $_FILES['image']['type']);
if ($mime[0] == 'image') {
    $slide = [
        "image" => addslashes(file_get_contents($image['tmp_name'])),
        "mime" => $mime[0]."/".$mime[1],
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
    $db->insert("slider",$slide);
}
header("Location: /dcp/slider");
die;
