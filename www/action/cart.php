<?php
switch ($r['action']) {
    case 'cart-add':
    case "wishlist-movetocart":
        $item = [
            'product' => $r['product'],
            'quant' => $r['quant']??1,
        ];
        $cart->add($item);
        break;
    case "cart-moveToWishlist":
    case 'cart-delete':
        $cart->remove(['product' => $r['product']]);
        break;
    case "cart-update":
        $item = [
            'product' => $r['product'],
            'quant' => $r['quant']??1,
        ];
        $cart->change($item);
        print_r($cart->getCart());
    break;
    default:
        # code...
        break;
}
