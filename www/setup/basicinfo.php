<?php

// print_r($data);die;
$tables = $db->tables();
$contact = [];
foreach ($db->select("contact") as $ci) {
    $contact[$ci['type']] = [
        "link" => $ci['link'],
        "text" => $ci['text'],
    ];
}
$slider = [];
foreach ($db->select("slider", "id,alt,text,btn_text,btn_link,updated_by") as $slide) {
    $slider[] = [
        "banner" => "/image/slider/" . $slide['id'],
        "alt" => $slide['alt'],
        "text" => json_decode($slide['text']),
        "btn" => [
            "text" => $slide['btn_text'],
            "link" => $slide['btn_link'],
        ],
    ];
}
$data = [
    "page" => [
        "title" => "Big HK Sale",
        "description" => "BigHK Sale is one of the best sellers in the state",
        "keywords" => "BigHK Sale, Digitlism Developed this website",
        "slider" => $slider,
    ],
    "site" => [
        "contact" => $contact,
        "socials" => $db->select("social"),
    ],
    "bigdeal" => $db->select("product", "id,name,description,mrp,dmrp,hot", "where featured=1 order by id desc limit 5"),
    "categories" => $db->select("category", "id,name,link", "where deleted=0 and navbar=1 order by id"),
    "latest" => $db->select("product", "id,name,description,mrp,dmrp,hot", "where new=1 order by id desc limit 5"),
    "megadeal" => [
        "top" => $db->select("deals", "id,link", "order by id desc"),
    ],
    "brands" => $db->select("brand", "id,name", "where name not like 'others' order by id"),
    "footerlinks" => [
        [
            "href" => "/about",
            "text" => "About us",
        ],
        [
            "href" => "/contact",
            "text" => "Contact us",
        ],
    ],
    "policies" => $db->select("policy", "id,name"),
    "copyright" => "Copyright © 2007-2019",
    "add" => $db->select("ads", "id,link", "order by id desc limit 1")[0] ?? [],
];
$data['hotitem'] = $db->select("product", "*", "where hot=1 and deleted = 0");
function getCategoryList($id = 0, $name = "")
{
    global $db;
    $find = str_split("><.,?';:][}{\\|=+-_)(*&^%$$#@!~` ");
    $catList = "";
    $catinfo = $db->select("category", "*", "where parent ={$id} and deleted=false");
    foreach ($catinfo as $key => $value) {
        $catList .= $value['name'] . ":" . $name . "/" . str_replace($find, "-", strtolower($value['name'])) . ":" . $value['id'] . ",";
        $catList .= getCategoryList($value['id'], $name . "/" . str_replace($find, "-", strtolower($value['name'])));
    }
    return $catList;
}
$cat = [];
foreach (explode(",", getCategoryList()) as $value) {
    $temp = explode(":", $value);
    if (count($temp) == 3) {
        # code...
        $cat[$temp[2]] = [
            "path" => $temp[1],
            "name" => $temp[0],
        ];
    }
}
$api = new optiwariindia\webapi(base64_decode("aHR0cHM6Ly9hcGkuZXR1dG9yaWFscy5jby5pbi8=") . "currency");
$api->createcurl();
$temp = json_decode($api->__tostring(), 1);
$data['exrate'] = array_map(function ($e) {
    global $temp;
    return $e / $temp['exrate']['HKD'];
}, $temp['exrate']);
$data['exrate']['RMB']=$data['exrate']['CNY'];
$data['rate']=$data['exrate'][$_SESSION['cur']??'HKD'];
$data['cats'] = $cat;
$cat = [];
foreach (explode(",", getCategoryList()) as $value) {
    $temp = explode(":", $value);
    if (count($temp) == 3) {
        # code...
        $cat[] = [
            "id" => $temp[2],
            "path" => $temp[1],
            "name" => $temp[0],
        ];
    }
}
$data['videos']=$db->select("videos","id,url");
$data['catList'] = $cat;
