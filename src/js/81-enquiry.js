var enquiry = {
    validate: {
        email: function(em) {
            do_ajax({
                email: em.value,
                action: "email"
            }, "/validate", function(resp) {
                if (resp.length == 0) {
                    em.style = "background:red";
                } else {
                    em.style = "background:initial";
                }
            })
        }
    },
    submit: function(e) {
        var frm = e.form;
        var data = {
            name: $(frm).find("[name=name]").val(),
            email: $(frm).find("[name=email]").val(),
            phone: $(frm).find("[name=phone]").val(),
            action: "enquiry"
        }
        do_ajax(data, "/submit", function(resp) {
            console.log(resp);
        });
    }
}
var reg={
    validate:{
        name:function(e){
            if(e.validity.valid){
                e.style="";
            }else{
                e.style="background:red";
            }
        },
        phone:function(e){
            if(e.validity.valid){
                e.style="";
            }else{
                e.style="background:red";
            }
        },
        pass:function(e){
            frm=e.form;
            pass=frm.querySelector("[name=pass]");
            cnfpass=frm.querySelector("[name=cnfpass]");
            if(cnfpass.value==pass.value){
                cnfpass.style="";
            }else{
                cnfpass.style="background:red";
            }
            pass.style=(pass.value.length < 6)?"background:red":"";
            
        }
    },
    submit:function(e){
        frm=e.form;
        inp={};
        invalid=false;
        flds=frm.querySelectorAll("[name]");
        for(i=0;i<flds.length;i++){
            fld=flds[i];
            if(fld.validity.valid){
                console.log(fld.name + "is valid");
                inp[fld.name]=fld.value;
            }else{
                invalid=true;
                fld.focus();
            }
        }
        if(invalid){
            alert("Please fill the form properly");
        }else{
            frm.submit();
        }
    }
}