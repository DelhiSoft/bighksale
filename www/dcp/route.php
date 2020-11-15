<?php
# Admin Routes

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
        $cat[] = [
            "id" => $temp[2],
            "path" => $temp[1],
            "name" => $temp[0],
        ];
    }
}
$data['catList'] = $cat;
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
$data['cats'] = $cat;
$data['category'] = $db->select("category", "id,navbar", "where deleted=0 order by id");
$data['active'][$page[0] ?? 'contact'] = "active";
$table = [
    "orders" => "invoice",
    "product" => "product",
    "enquiry" => "enquiry",
    "brand" => "brand",
    "slider" => "slider",
    "category" => "category",
    "ad-banner" => "ads",
    "megadeal" => "deals",
    "social" => "social",
    "settings" => "contact",
    "policy" => "policy",
    "navbar" => "navbar",
    "videos"=>"videos"
];
$data['sidebar'] = [

    [
        "link" => "orders",
        "text" => "Orders",
    ],
    [
        "link" => "enquiry",
        "text" => "Enquiries",
    ],
    [
        "link" => "slider",
        "text" => "Home Page Banners",
    ],
    [
        "link"=>"videos",
        "text"=>"Videos"
    ],
    [
        "link" => "category",
        "text" => "Categories",
    ],
    [
        "link" => "brand",
        "text" => "Brands",
    ],
    [
        "link" => "product",
        "text" => "Products",
    ],
    [
        "link" => "ad-banner",
        "text" => "Advertisements",
    ],
    [
        "link" => "megadeal",
        "text" => "Mega Deals",
    ],
    [
        "link" => "social",
        "text" => "Social Links",
    ],
    [
        "link" => "settings",
        "text" => "Settings",
    ],
    [
        "link" => "policy",
        "text" => "Policies",
    ],
];
$data['brands'] = $db->select("brand");
$data['categories'] = $db->select("category");
switch ($page[0] ?? '') {
    case "":
        $data['active']['contact'] = "active";
        // $data['data'] = $db->select($table[$page[0]]);
        $data['form'] = "contacts.twig";
        break;
    case "product":
        if (file_exists(__DIR__ . "/view/comp/" . $page[0])) {
            switch ($page[1] ?? '') {
                case 'inventory':
                    $data['data'] = $db->select($table[$page[0]]);
                    $data['form'] = $page[0] . "/inventory.twig";
                break;
                case 'add':
                    $data['form'] = $page[0] . "/add.twig";
                    break;
                case 'update':
                    $temp = $db->select($table[$page[0]], "*", "where id={$page[2]}");
                    $data["info"] = $temp[0] ?? [];
                    $data['form'] = $page[0] . "/add.twig";
                    break;
                case 'delete':
                    $data[$table[$page[0]]] = $db->delete($table[$page[0]], "where id={$page[2]}");
                    header("Location: /dcp/" . $page[0]);
                    break;
                case "img":
                    $data['imgs'] = $db->select("prodimg", "id", "where prod={$page[2]}");
                    $data['product'] = $page[2];
                    $data['form'] = $page[0] . "/image.twig";
                    break;
                case "delimg":
                    $db->delete("prodimg", "where id={$page[2]}");
                    header("Location: /dcp/product/img/" . $page[3]);
                    break;
                case "specification":
                    $data['specifications'] = $db->select("specifications", "*", "where prod={$page[2]}");
                    $data['form'] = $page[0] . "/specifications.twig";
                    break;
                case "delspec":
                    $db->query("delete from specifications where id={$page[2]}");
                    header("Location: /dcp/product");
                    break;
                case "video":
                    $temp = $db->select($table[$page[0]], "*", "where id={$page[2]}");
                    $data["info"] = $temp[0] ?? [];
                    $data['form'] = $page[0] . "/video.twig";
                    break;
                case "delrel":
                    $temp = $db->select($table[$page[0]], "*", "where id={$page[2]}");
                    $list = $page[2];
                    if (count($temp) == 1) {
                        if ($temp[0]['related'] != '') {
                            $related = explode(",", $temp[0]['related']);
                            unset($related[array_search($page[3], $related)]);

                            $product = [
                                "related" => implode(",", $related),
                                "updated_by" => $_SESSION['user']['id'],
                            ];
                            $db->update("product", $product, "where id={$page[2]}");
                        }
                    }
                    header("Location:/dcp/product/related/{$page[2]}");
                    break;
                case "related":
                    $temp = $db->select($table[$page[0]], "*", "where id={$page[2]}");
                    $list = $page[2];
                    if (count($temp) == 1) {
                        if ($temp[0]['related'] != '') {
                            $related = $db->select($table[$page[0]], "*", "where id in ({$temp[0]['related']})");
                            $data['related'] = $related;
                            $list = implode(",", array_merge([$list], explode(",", $temp[0]['related'])));
                        }
                    }
                    $data['prods'] = $db->select($table[$page[0]], "id,name", "where id not in ($list)");
                    // print_r($data);die;
                    $data["info"] = $temp[0] ?? [];
                    $data['form'] = $page[0] . "/related.twig";
                    break;
                default:
                    $data['data'] = $db->select($table[$page[0]]);
                    $data['form'] = $page[0] . "/list.twig";
                    break;
            }
        } else {
            $data['form'] = "/404.twig";

            $data['info'] = "Module " . $page[0] . " is not installed. Please contact webmaster or system administrator for more details";
        }
        break;
    case "logout":
        session_destroy();
        header("Location: /dcp");
        break;
    case "orders":
        if (file_exists(__DIR__ . "/view/comp/" . $page[0])) {
            switch ($page[1] ?? '') {
                case 'details':
                    $data['data'] = $db->select($table[$page[0]], "*", "where id ={$page[2]}");
                    $data['infos'] = $db->select("`order`", "*", "where invoice={$page[2]}");
                    $products = [];
                    foreach ($db->select("product") as $key => $value) {
                        $products[$value['id']] = $value;
                    }
                    $data['products'] = $products;
                    $data['form'] = $page[0] . "/orders.twig";

                    break;
                case 'update':
                    $temp = $db->select($table[$page[0]], "*", "where id={$page[2]}");
                    $data["info"] = $temp[0] ?? [];
                    $data['form'] = $page[0] . "/add.twig";
                    break;
                case 'delete':
                    $data[$table[$page[0]]] = $db->delete($table[$page[0]], "where id={$page[2]}");
                    header("Location: /dcp/" . $page[0]);
                    break;
                default:
                    $data['data'] = $db->select($table[$page[0]], "*", "order by id desc");
                    $data['form'] = $page[0] . "/list.twig";
                    break;
            }
        } else {
            $data['form'] = "/404.twig";

            $data['info'] = "Module " . $page[0] . " is not installed. Please contact webmaster or system administrator for more details";
        }
        break;
    case "category":
        if (file_exists(__DIR__ . "/view/comp/" . $page[0])) {
            switch ($page[1] ?? '') {
                case 'add':
                    $data['form'] = $page[0] . "/add.twig";
                    break;
                case 'update':
                    $temp = $db->select($table[$page[0]], "*", "where id={$page[2]}");
                    $data["info"] = $temp[0] ?? [];
                    $data['form'] = $page[0] . "/add.twig";
                    break;
                case "hide":
                    $data[$table[$page[0]]] = $db->update($table[$page[0]], ["navbar" => 0], "where id={$page[2]}");
                    header("Location: /dcp/" . $page[0]);
                    break;
                case "show":
                    $data[$table[$page[0]]] = $db->update($table[$page[0]], ["navbar" => 1], "where id={$page[2]}");
                    header("Location: /dcp/" . $page[0]);
                    break;
                case 'delete':
                    $data[$table[$page[0]]] = $db->update($table[$page[0]], ["deleted" => 1], "where id={$page[2]}");
                    header("Location: /dcp/" . $page[0]);
                    break;
                default:
                    $data['form'] = $page[0] . "/list.twig";
                    break;
            }
        } else {
            $data['form'] = "/404.twig";

            $data['info'] = "Module " . $page[0] . " is not installed. Please contact webmaster or system administrator for more details";
        }
        break;
    default:
        if (file_exists(__DIR__ . "/view/comp/" . $page[0])) {
            switch ($page[1] ?? '') {
                case 'add':
                    $data['form'] = $page[0] . "/add.twig";
                    break;
                case 'update':
                    $db->mode(3);
                    $temp = $db->select($table[$page[0]], "*", "where id={$page[2]}");
                    $data["info"] = $temp[0] ?? [];
                    $data['form'] = $page[0] . "/add.twig";
                    break;
                case 'delete':
                    $data[$table[$page[0]]] = $db->delete($table[$page[0]], "where id={$page[2]}");
                    header("Location: /dcp/" . $page[0]);
                    break;
                default:
                    $data['data'] = $db->select($table[$page[0]]);
                    $data['form'] = $page[0] . "/list.twig";
                    break;
            }
        } else {
            $data['form'] = "/404.twig";

            $data['info'] = "Module " . $page[0] . " is not installed. Please contact webmaster or system administrator for more details";
        }
        break;
}
