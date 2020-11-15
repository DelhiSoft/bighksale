var video={
    open:function(e){
        $("#cartoonVideo").attr("src",e);
        $("#youtube").modal();
    },
    close:function(){
        $("#youtube").modal("hide");
        $("#cartoonVideo").attr("src","/");
    }
}