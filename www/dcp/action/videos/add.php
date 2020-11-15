<?php
$image = $_FILES['image'];
$mime = explode("/", $_FILES['image']['type']);
if ($mime[0] == 'image') {
    $slide = [
        "image" => addslashes(file_get_contents($image['tmp_name'])),
        "mime" => $mime[0]."/".$mime[1],
        "url"=>$_REQUEST['url'],
        "added_by" => $_SESSION['user']['id'],
    ];
    switch ($r['action']) {
        case 'add-video':
            $db->insert("videos",$slide);
            break;
        
        default:
            $db->update ("videos",$slide,"where id={$r['id']}");
            break;
    }
}
header("Location: /dcp/videos");
die;
