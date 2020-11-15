<?php
switch ($r['action']) {
    case "search":
        $search=[];
        //Product
        $clause="where name like '%{$r['search']}%' or description ='%{$r['search']}%'";
        $search['products'] = $db->select("product", "id,name,description,mrp,dmrp,brand,category ", $clause);
        break;

}