(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/amoja-button-popup.default', ($scope) => {
            let $button = $scope.find('.amoja-button-popup-menu .button-popup-menu');
            let $body = $('body');
            let $html = $('html');
            let $popup_content = $scope.find('.button-popup-menu-content');

            if ($body.hasClass('elementor-editor-active')) {
                return;
            }
            if ($button.length > 0) {
                $button.on('click', function () {
                    $button.toggleClass('active');
                    $html.toggleClass('show-menu');

                    $('.elementor-widget', $popup_content).each(function () {
                        let $thas = $(this);
                        const dataSettings = $thas.attr('data-settings');
                        if (dataSettings) {
                            const settings = JSON.parse(dataSettings);

                            if (settings._animation) {
                                if ($thas.hasClass('animated')) {
                                    $thas.addClass('elementor-invisible-effect');
                                    setTimeout(function () {
                                        $thas.removeClass(settings._animation).removeClass('animated').addClass('elementor-invisible');
                                        $thas.removeClass('elementor-invisible-effect');
                                    }, 500)
                                } else {
                                    setTimeout(function () {
                                        $thas.addClass(settings._animation).addClass('animated').removeClass('elementor-invisible');
                                    }, settings._animation_delay)
                                }
                            }
                        }
                    });

                })
            }
        });
    });

})(jQuery);