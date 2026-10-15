
(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/amoja-tabimage-effect.default', ($scope) => {

            let useSwiper = $scope.find('swiper');
            if (useSwiper) {
                elementorFrontend.elementsHandler.addHandler(amojaSwiperBase, {
                    $element: $scope,
                });
            }
            let $wrapper = $scope.find('.elementor-tabimage-wrapper');
            if ($wrapper) {
                $wrapper.find('.elementor-active').show();
                $wrapper.find('.elementor-tabimage-item').hover(function (e) {
                    e.preventDefault();
                    let id = $(this).data('trigger');
                    $wrapper.find('.elementor-tabimage-item').removeClass('elementor-active');
                    $(this).addClass('elementor-active');
                    $wrapper.find('[data-target="' + id + '"]').addClass('elementor-active');
                });
            }
        });
    });
})(jQuery);
