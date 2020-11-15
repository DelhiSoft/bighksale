var wishlist = {
    add: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            action: 'wishlist-add',
        };
        do_ajax(data, "/api/wishlist/", function(r) {
            console.log(r);
            $("[data=wishlist]").html(r.length);
        });
    },
    remove: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            action: 'wishlist-remove',
        };
        do_ajax(data, "/api/wishlist/", function(r) {
            console.log(r);
            location.reload();
        });
    },
    toggle: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            action: 'wishlist-toggle',
        };
        $(e).find(".icon-wishlist").toggleClass('in-wishlist');
        do_ajax(data, "/api/wishlist/", function(r) {
            console.log(r);
            console.log(r.length);
            $("[data=wishlist]").html(r.length);
        });
    },
    clear: function() {
        var data = {
            action: 'wishlist-clear',
        };
        do_ajax(data, "/api/wishlist/", function(r) {
            $("[data=wishlist]").html(r.length);
        });
    },
    moveToCart: function(e) {
        var frm = $(e.form);
        var data = {
            product: frm.find("[name=product]").val(),
            size: frm.find("[name=size]").val(),
            action: 'wishlist-movetocart',
        };
        do_ajax(data, "/api/wishlist/", function(r) {
            location.reload();
        });
    }
};