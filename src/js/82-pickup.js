var pickup={
    select:function(){
        $("#pickup").modal();
    },
    collect:function(){
        $("#pickup").modal("hide");
        $("#store_pickup").modal();
    },
    deliver:function(){
        $("#pickup").modal("hide");
        $("#home_delivery").modal();
    },
    store:function(e){
        var frm=e.form.querySelectorAll("[name]");
        var data={};
        for (var index = 0; index < frm.length; index++) {
            var element = frm[index];
            data[element.name]=element.value;
        }
        do_ajax(data,
            "/api/checkout",
            function(r) {
                if(typeof r=="object"){
                    r=JSON.stringify(r);
                }
                resp=JSON.parse(r);
                if(resp.error.length!==0){
                    checkout();
                }
            }
        );
    },
    home:function(e){
        var frm=e.form.querySelectorAll("[name]");
        var data={};
        for (var index = 0; index < frm.length; index++) {
            var element = frm[index];
            data[element.name]=element.value;
        }
        do_ajax(data,
            "/api/checkout",
            function(r) {
                if(typeof r=="object"){
                    r=JSON.stringify(r);
                }
                resp=JSON.parse(r);
                if(resp.error.length!==0){
                    checkout();
                }
            }
        );
    }

}