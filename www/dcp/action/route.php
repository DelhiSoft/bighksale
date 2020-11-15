<?php
$r = $db->resa($_REQUEST);
$action = $r['action'] ?? '';
switch ($action) {
    case 'login':
        include "action/auth/login.php";
        break;
    case "update-socials":
        include "action/socials/update.php";
        break;
    case "update-contactinfo":
        include "action/contactinfo/update.php";
        break;
    case 'add-pageseo':
        include "action/pageseo/add.php";
        break;
    case "add-video":
        case "update-video":
            include "action/videos/add.php";
        break;
    case 'add-slider':
        include "action/slider/add.php";
        break;
    case 'update-slider':
        include "action/slider/update.php";
        break;
    case "add-category":
        include "action/category/add.php";
        break;
    case "add-brand":
        include "action/brand/add.php";
        break;
    case "add-product-video":
        include "action/product/video.php";
        break;
    case "update-related-product":
        include "action/product/related.php";
        break;
    case "add-product":
        include "action/product/add.php";
        break;
    case "update-product":
        include "action/product/update.php";
        break;
    case "add-adsbanner":
        include "action/advertisement/add.php";
        break;
    case "add-deal":
        include "action/deals/add.php";
        break;
    case "add-policy":
        include "action/policy/add.php";
        break;
    case "update-navbar":
        include "action/navbar/update.php";
        break;
    case "prodimg":
        include "action/product/addimg.php";
        break;
    case "add-prod-specification":
        $page = explode("/", $r['path']);
        $db->debug();
        $db->insert("specifications", [
            "prod" => $page[2],
            "name" => $r['name'],
            "value" => $r['value'],
            "added_by" => $_SESSION['user']['id'],
            "added_from" => $_SERVER['REMOTE_ADDR'],
        ]);
        header("Location: /dcp/" . $r['path']);
        die;
    case "update-prod-specification":
        $db->update("specifications", [
            "name" => $r['name'],
            "value" => $r['value'],
            "added_by" => $_SESSION['user']['id'],
            "added_from" => $_SERVER['REMOTE_ADDR'],
        ], "where id={$r['id']}");
        header("Location: /dcp/" . $r['path']);
        die;
    default:
        print_r($_REQUEST);die;
        break;
}
