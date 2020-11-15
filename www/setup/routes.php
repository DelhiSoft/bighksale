<?php
function trace($e)
{
    echo "<pre>" . print_r($e, 1) . "</pre>";
    die;
}
$page = explode('/', $path);
$db->debug();
function get_subcats($id = 0)
{
    global $db;
    $arr = [];
    foreach ($db->select("category", "id", "where parent=$id") as $key => $value) {
        foreach (get_subcats($value['id']) as $subcat) {
            $arr[] = $subcat;
        }
        $arr[] = $value['id'];
    }
    return $arr;
}
$data['cur']=$_SESSION['cur']??'HKD';
$prange = $db->select("product", "max(mrp) as mxm,max(dmrp) as mxd,min(mrp) as mim,min(dmrp) as mid")[0] ?? [];
$prange['max'] = ($prange['mxm'] < $prange['mxd']) ? $prange['mxd'] : $prange['mxm'];
$prange['min'] = ($prange['mim'] > $prange['mid']) ? $prange['mid'] : $prange['mim'];
$data['price'] = [
    "min" => $prange['min'],
    "max" => $prange['max'],
    "fmin" => $prange['min'],
    "fmax" => $prange['max'],
];

if (isset($_SESSION['price'])) {
    $data['price']['fmin'] = $_SESSION['price']['from'];
    $data['price']['fmax'] = $_SESSION['price']['to'];
}

$data['count'] = [
    'cart' => $cart->count(),
    'wishlist' => $wishlist->count(),
];
$data['active']=$page[1]??'';
switch ($page[0]) {
    case "image":
        $data = $db->select($page[1], "image,mime", "where id={$page[2]}");
        if (count($data) == 1) {
            if ($data[0]['mime'] == '') {
                include "images/user.png";
            } else {
                header("Content-type: " . $data[0]['mime']);
                echo $data[0]['image'];
                die;
            }
        }
        break;
    case "cur":
        $_SESSION['cur']=$page[1];
        header("Location: /");
    break;
    case "filter":
        $clause = "";
        $r = $db->resa($_REQUEST);
        if (isset($r['price'])) {
            $r['price'] = explode("—", str_replace(str_split(" HKD"), "", $r['price']));
            if (count($r['price']) == 2) {
                $_SESSION['price'] = ['from' => $r['price'][0], 'to' => $r['price'][1]];
            }
        }
        if (isset($r['brand'])) {
            $_SESSION['brand'] = $r['brand'];
        }
        if (isset($r['category'])) {
            $_SESSION['catfilter'] = $r['category'];
        }
        if (isset($_SESSION['price'])) {
            if ($clause != '') {
                $clause .= " and ";
            }
            $clause = " mrp <= {$_SESSION['price']['to']} and  mrp >= {$_SESSION['price']['from']}";
        }
        if (isset($_SESSION['brand'])) {
            if ($_SESSION['brand'] != '') {
                if ($clause != '') {
                    $clause .= " and ";
                }
                $clause .= " brand in ({$_SESSION['brand']})";
            }
        }
        if (isset($_SESSION['catfilter'])) {
            if ($_SESSION['catfilter'] != '') {

                if ($clause != '') {
                    $clause .= " and ";
                }
                $clause .= " category in ({$_SESSION['catfilter']})";
            }
        }
        if ($clause != "") {
            $clause = "where " . $clause;
        }

        $data['products'] = $db->select("product", "id,name,description,mrp,dmrp,brand,category,featured,new ", $clause);
        $view = "filter.twig";
        break;
    case "search":
        $r = $db->resa($_REQUEST);
        $prods = $db->select("product", "id,name,description,mrp,dmrp,brand,category,featured,new ", "where name like '%{$r['search']}%' or description like '%{$r['search']}%'");
        $data['products'] = $prods;
        $view = "shop.twig";
        break;
    case "category":
        $catid = $page[count($page) - 1];
        $subcat = get_subcats($catid);
        $subcat[] = $catid;
        $subcat = implode(",", $subcat);
        $prods = $db->select("product", "id,name,description,mrp,dmrp,brand,category,featured,new ", "where category in ({$subcat})");
        $data['products'] = $prods;
        $view = "shop.twig";
        break;
    case "shop":
        unset($_SESSION['price']);
        $_SESSION['brand'] = "";
        $_SESSION['catfilter'] = "";
        $clause = "";
        $db->debug();
        $data['products'] = $db->select("product", "id,name,description,mrp,dmrp,brand,category,featured,new ", $clause);
        $view = "shop.twig";
        break;
    case "deal":
        $data['deals'] = $db->select("deals", "id,link");
        $view = "deals.twig";

        break;
    case "new-arrivals":
        $data['products'] = $db->select("product", "id,name,description,mrp,dmrp,brand,category,featured", "where new=1");
        $view = "shop.twig";
        break;
    case "categories":
        $data['categories'] = $db->select("category", "id,name");
        $view = "category.twig";
        break;
    case "brands":
        $view = "brands.twig";
        break;
    case "product":
        $data['product'] = $db->select(
            "product",
            "id,name,description,mrp,dmrp,brand,category,featured,new,video,related",
            "where id ={$page[1]}")[0] ?? [];
            $rel=[];
            if($data['product']['related']!=""){
                $rel=$db->select("product","*","where id in ({$data['product']['related']})");
            }
        $data['related']=$rel;
        $data['prodimgs'] = $db->select("prodimg", "id", "where prod={$page[1]}");
        $data['product']['highlights'] = $data['product']['description'] ?? '';
        $data['product']['specifications'] = $db->select("specifications", "name,value", "where prod={$page[1]}");
        $rating = [];
        $avg = [0, 0];
        $rating['avg'] = 0;
        $rating[1] = 0;
        $rating[2] = 0;
        $rating[3] = 0;
        $rating[4] = 0;
        $rating[5] = 0;
        $rating['total'] = 1;
        foreach ($db->select("review", "rating,count(*) as rate", "where product={$page[1]} group by 1") as $value) {
            $avg[0] += $value['rate'];
            $avg[1] += $value['rating'] * $value['rate'];
            $rating[$value['rating']] = $value['rate'];
            $rating['total'] += $value['rate'];
        }

        if ($avg[0] != 0) {
            $rating['avg'] = $avg[1] / $avg[0];
        }

        $data['product']['rating'] = [
            "stars" => $rating['avg'],
        ];

        $data['product']['ratingDesc'] = [
            ["count" => $rating[1], "percent" => ($rating[1] * 100) / $rating['total']],
            ["count" => $rating[2], "percent" => ($rating[2] * 100) / $rating['total']],
            ["count" => $rating[3], "percent" => ($rating[3] * 100) / $rating['total']],
            ["count" => $rating[4], "percent" => ($rating[4] * 100) / $rating['total']],
            ["count" => $rating[5], "percent" => ($rating[5] * 100) / $rating['total']],
        ];
        $db->mode(3);
        $review = $db->select("review", "client,rating,review", "where product={$page[1]} order by id desc");
        // header("content-type: application/json");echo json_encode($review);die;
        $data['product']['reviews'] = $review;
        $view = "product.twig";
        break;
    case "policy":
        $data['policy'] = $db->select("policy", "id,name,body", "where id ={$page[1]}")[0] ?? [];
        $view = "policy.twig";
        break;
    case "wishlist":
    case "cart":
        $data['wishlist'] = [];
        
        // print_r($data['brand']);die;
        // trace([$cart->getCart()]);
        foreach ($wishlist->getWishlist() as $key => $value) {
            $data['wishlist'][] = ["product" => $db->select("product", "*", "where id={$value['product']}")[0] ?? []];
        }
        $mycart = [];
        $db->debug();
        foreach ($cart->getCart() as $key => $value) {
            if (isset($value['product'])) {
                $mycart[] = [
                    "product" => $db->select("product", "id,name,description,brand,category,mrp,dmrp", "where id={$value['product']}")[0] ?? [],
                    "quant" => $value['quant'],
                ];
            }

        }
        $data['cart'] = $mycart;
        // trace($data['cart']);
        $view = "cart.twig";
        break;
    case "checkout":
        $view = "checkout.twig";
        break;

    case "gift-sets":
        break;
    case "wholesale":
        break;
    case "communities":
        break;
    case "about":
        $view = "about.twig";
        break;
    case "contact":
        $view = "contact.twig";
        break;
    case "logout":
        session_destroy();
        header("Location: /");
        break;
    case "order":
    case "profile":
    case "address":
    case "payment":
    case "claims":
    case "login":
    case "register":
    case "returns":
    case "returns-new":
    case "secrets-credits":
        $view = $page[0] . ".twig";
        break;
    default:
        break;
}
// trace($data);
