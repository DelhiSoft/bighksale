<?php
switch ($r['action']) {
    case 'wishlist-add':
    case "cart-moveToWishlist":
        $item = [
            'product' => $r['product'],
        ];
        $wishlist->add($item);
        break;
    case 'wishlish-delete':
    case "wishlist-remove":
    case "wishlist-movetocart":
        $wishlist->remove([
            'product' => $r['product'],
        ]);
        break;
    // wishlist-toggle
    case 'wishlist-toggle':
        $wishlist->toggle([
            'product' => $r['product'],
        ]);
        break;
    case "wishlist-clear":
        $wishlist->clear();
    break;
    default:
        # code...
        break;
}
header('Content-Type: application/json');
echo json_encode($wishlist->getWishlist());
