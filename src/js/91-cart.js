var cart = {
    add: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            action: 'cart-add',
            quant: frm.find("[name=quant]").val()
        };
        console.log(data);
        do_ajax(data, "/api/cart/", function(e) {
            // location.href = "/cart";
            console.log(e);
        });
    },
    remove: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            action: "cart-delete"
        }
        do_ajax(data, "/api/cart/", function(r) {
            location.reload();
            console.log(r)
        });
    },
    update: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            quant: frm.find("[name=quant]").val(),
            action: "cart-update"
        }
        do_ajax(data, "/api/cart/", function(r) {
            location.reload();
            console.log(r)
        });
    },
    moveToWishlist: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            action: "cart-moveToWishlist"
        }
        do_ajax(data, "/api/cart/", function(r) {
            location.reload();
            console.log(r);
        });
    }
};