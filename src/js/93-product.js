var showImage = function(e) {
        src = e.querySelector("img").getAttribute("src");
        document.querySelector("#xzoom-default").setAttribute("src", src);
        document.querySelector("#xzoom-default").setAttribute("xoriginal", src);
    }