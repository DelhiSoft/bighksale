<?php
$img = explode("/", $_FILES['image']['type']);
if ($img[0] == 'image') {

    $data = [
        "url" => $r['url'],
        "title" => $r['title'],
        "description" => $r['description'],
        "keywords" => $r['keywords'],
        "image" => addslashes(file_get_contents($_FILES['image']['tmp_name'])),
        "mime" => $_FILES['image']['type'],
        "updated_by" => $_SESSION['user']['id'],
    ];
} else {
    $data = [
        "url" => $r['url'],
        "title" => $r['title'],
        "description" => $r['description'],
        "keywords" => $r['keywords'],
        "updated_by" => $_SESSION['user']['id'],
    ];
}
/* checking if insert or update */
$temp=$db->select("page_seo","*","where url like '{$data['url']}'");
if(count($temp)==0){
    $db->insert("page_seo",$data);
}else{
    $db->update("page_seo",$data,"where id={$temp[0]['id']}");
}
header("Location: /dcp/seo");
die;
