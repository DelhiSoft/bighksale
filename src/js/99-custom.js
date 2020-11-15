(function($) {
    $(function() {
        $(document).off('click.bs.tab.data-api', '[data-hover="tab"]');
        $(document).on('mouseenter.bs.tab.data-api', '[data-toggle="tab"], [data-hover="tab"]', function() {
            $(this).tab('show');
        });
    });
})(jQuery);
/* 
$(".owl-one").owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    responsive: {
        0: {
            items: 1
        }
    }
});
$(".owl-two").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: false,
    autoplayTimeout: 3000,
    autoplayHoverPause: false,
    responsive: {
        0: {
            items: 1
        },
        767: {
            items: 1
        },
        991: {
            items: 5
        }
    }
});
$(".owl-three").owlCarousel({
    loop: true,
    margin: 10,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 3000,
    autoplayHoverPause: false,
    responsive: {
        0: {
            items: 1
        },
        767: {
            items: 1
        },
        991: {
            items: 5
        }
    }
});
$(".owl-four").owlCarousel({
    loop: true,
    margin: 10,
    dots: false,
    nav: true,
    autoplay: false,
    autoplayTimeout: 3000,
    autoplayHoverPause: false,
    responsive: {
        0: {
            items: 1
        },
        767: {
            items: 1
        },
        991: {
            items: 4
        }
    }
});
 */
$(".mobile-triger button").click(function() {
    $(".navigation_bar").addClass("active");
});
$(".navigation_bar ul > a").click(function() {
    $(".navigation_bar").removeClass("active");
});

$(document).ready(function() {
    $(".xzoom, .xzoom-gallery").xzoom({
        zoomWidth: 400,
        title: true,
        tint: "#333",
        Xoffset: 15
    });

});