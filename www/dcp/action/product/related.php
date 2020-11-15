<pre><?php
$temp = $db->select("product", "id,name,related", "where id = {$r['id']}");
$related = explode(",", $temp[0]['related']);

if ($related[count($related) - 1] == '') {
    $related[count($related) - 1] = $r['relprod'];
} else {
    $related[] = $r['relprod'];
}

$product = [
    "related" => implode(",",$related),
    "updated_by" => $_SESSION['user']['id'],
];
$db->update("product", $product, "where id={$r['id']}");
header("Location: /dcp/product/related/{$r['id']}");
die;
