/* Sliders */
var sliders = [
    {
        selector: ".owl-brand",
        config: {
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        }
    },
    {
        selector: ".owl-one",
        config: {
            loop: true,
            margin: 0,
            nav: true,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout:3000,
            responsive: {
                0: {
                    items: 1
                }
            }
        }
    },
    {
        selector: ".owl-two",
        config: {
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
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
        }
    },
    {
        selector: ".owl-three",
        config: {
            loop: true,
            margin: 10,
            dots: false,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
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
        }
    },
    {
        selector: ".owl-mega",
        config: {
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 2
                },
                992: {
                    items: 5
                }
            }
        }
    },
]
sliders.forEach(function(item)  {
    var slider = document.querySelector(item.selector);
    if (slider != null) {
        $(item.selector).owlCarousel(item.config);
    }
});