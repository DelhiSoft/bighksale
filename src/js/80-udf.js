function do_ajax(t, e, i) { $.ajax({ url: e, method: "post", data: t, success: i }) }
checkout = function(e) {
    console.log(e);
    $("#makepayment").submit();
}