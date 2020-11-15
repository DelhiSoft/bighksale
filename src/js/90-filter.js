var filter = {
    category: {
        update: function(e) {
            var category = "";
            document.querySelectorAll("[filtercat]").forEach(function(t) {
                if (t.checked) {
                    if (category.length != 0) {
                        category += ",";
                    }
                    category += "" + t.getAttribute("filtercat");
                }
            });
            do_ajax({ category: category },
                "/filter/category",
                function(r) {
                    $(".product-container").html(r);
                }
            );
        }

    },
    brand: {
        update: function(e) {
            var brand = "";
            document.querySelectorAll("[brand]").forEach(function(t) {
                if (t.checked) {
                    if (brand.length != 0) {
                        brand += ",";
                    }
                    brand += "" + t.getAttribute("brand");
                }
            });
            do_ajax({ brand: brand },
                "/filter/brand",
                function(r) {
                    $(".product-container").html(r);
                }
            );
        }
    },
    price: {
        init: function(e) {
            $(".js-range-slider").ionRangeSlider({
                type: "double",
                min: e.min,
                max: e.max,
                from: e.from,
                to: e.to,
                prefix: "HKD "
            });
        },
        update: function(e) {
            console.log(e);
            do_ajax({ price: $(e).find(".irs-single").html() }, "/filter/price", function(r) {
                $(".product-container").html(r);
            });
        }
    }
}
$("[brand]").change(function() {
    filter.brand.update(this);
    console.log(this);
});
$("[filtercat]").change(function() {
    filter.category.update(this);
    console.log(this);
});