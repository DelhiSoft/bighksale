<?php
switch ($r['action']) {
    case "category-filter":
        $_SESSION['filter']['category'] = $r['category'];
        break;
    case "brand-filter":
        $_SESSION['filter']['brand'] = $r['brand'];
        break;
    case "price-filter":
        $price = explode(" — ", $r['price']);
        $_SESSION['filter']['price']['from'] = $price[0];
        $_SESSION['filter']['price']['to'] = $price[1];
        break;
    default:
}
$data = [
];
$temp=[];
$clause = " 1=1";
if (isset($_SESSION['filter']['category'])) {
    $temp[] = "category in ({$_SESSION['filter']['category']})";
}

if (isset($_SESSION['filter']['brand'])) {
    $temp[] = "brand in ({$_SESSION['filter']['brand']})";
}

if (isset($_SESSION['filter']['price'])) {
    $temp[] = "mrp <= {$_SESSION['filter']['price']['to']} and mrp >= {$_SESSION['filter']['price']['from']}";
}

if (count($temp) > 0) {
    $clause = implode(" and ", $temp);
}
$data['products'] = $db->select("prod p,prodVars pv", "p.id,p.name,p.summary,p.brand,p.category,pv.mrp,pv.discount,pv.name as size,pv.id as sizeid", " where pv.prod=p.id and " . $clause . " order by pv.mrp desc,p.id");
$view = "filterdata.twig";
echo $twig->render($view, $data);
die;
header('Content-Type: application/json');
echo json_encode(['action' => 'reloadpage', "session" => $_SESSION]);
