<?php
$policy=[
    "name"=>$r['name'],
    "body"=>$r['description'],
    "updated_by" => $_SESSION['user']['id'],
];
$db->insert("policy", $policy);
header("Location: /dcp/policy");
die;