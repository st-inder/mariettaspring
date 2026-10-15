(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(amojaSwiperBase, {
                $element,
            });
        };

        $('.gallery-popup').on('click',function (e) {
            e.preventDefault();
            $('.elementor-item-slideshow-wrapper .swiper-slide.swiper-slide-active a').trigger('click');
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/babe-item-slideshow.default', addHandler);
    });
})(jQuery);