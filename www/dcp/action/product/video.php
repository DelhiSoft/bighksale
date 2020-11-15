<?php

$product = [
    "video" => $r['video'] ?? '',
    "updated_by" => $_SESSION['user']['id'],
];
$db->update("product", $product, "where id={$r['id']}");
header("Location: /dcp/product");
die;
