(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/amoja-slide-overlay.default', ($scope) => {
            let $contents = $scope.find('.elementor-slide-overlay-content');
            $('.elementor-slide-overlay-title',$scope).hover(function (e) {
                e.preventDefault();
                $contents.removeClass('elementor-active');
                let id =$(this).data('trigger')
                $('[data-target="'+id+'"]',$scope).addClass('elementor-active');
            });
        });
    });

})(jQuery);
