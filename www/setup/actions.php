<?php
switch ($r['action']) {
  case 'contact':
    case 'enquiry':
      $db->debug();
      $email=explode("@",$r['email']??'');
      $mxhosts=[];
      getmxrr ($email[1]??'' , $mxhosts ) ;
      if(count($mxhosts)==0){
        $resp['error']="Please type a valid email address";
      }else{
        $db->insert("enquiry",[
          "name"=>$r['name'],
          "email"=>$r['email'],
          "phone"=>$r['phone'],
          "added_from"=>$_SERVER['REMOTE_ADDR']
          ]);
      $resp['message']="Your request has been submitted. One of our correspondent will get back to you shortly.";
    }
    header("content-type: application/json");
    echo json_encode($resp);
    die;
    break;
  case "email":
    $email=explode("@",$r['email']??'');
    $mxhosts=[];
    getmxrr ($email[1]??'' , $mxhosts ) ;
    header("content-type: application/json");
    echo json_encode($mxhosts);
    die;
  break;  
  case "wishlist-add":
    case "wishlist-delete":
    case "wishlist-remove":
    case "wishlist-toggle":
    case "wishlist-clear":
        require "action/wishlist.php";
        die;
        break;
    case "cart-add":
    case "cart-delete":
    case "cart-update":
        require "action/cart.php";
        die;
        break;
    case "purchase":
        require "action/purchase.php";
        break;
    case "register":
    case "login":
        require "action/auth.php";
        break;
    case "wishlist-movetocart":
    case "cart-moveToWishlist":
        require "action/wishlist.php";
        require "action/cart.php";
        die;
        break;
    case "add-review":
      $review=[
        "product"=>$r['product'],
        "rating"=>$r['rating'],
        "review"=>$r['review'],
        "added_from"=>$_SERVER['REMOTE_ADDR'],
        "client"=>json_encode($_SESSION['client']??[
          "firstname"=>"Anonymous",
          "lastname"=>"Anonymous",
          "image"=>"/images/user.svg"
        ])
      ];
      $db->insert("review",$review);
      header("Location: /".$r['path']);
    break;
    case "deliver-home":
      unset($r['path']);
      unset($r['action']);
      $_SESSION['type']="home";
      $_SESSION['deliver']=$r;
      header("content-type: application/json");
      echo json_encode(["status"=>"ok","error"=>""]);
      die;
    break;
    case "store-pickup":
      unset($r['path']);
      unset($r['action']);
      $_SESSION['pickup']=$r;
      $_SESSION['type']="store";
      header("content-type: application/json");
      echo json_encode(["status"=>"ok","error"=>""]);
      die;
    break;
    default:
        print_r($r);die;
        break;
}