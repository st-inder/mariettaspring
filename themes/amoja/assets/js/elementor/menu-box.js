(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/amoja-menu-box.default', ($scope) => {
            var $button = $scope.find('a.button-popup');
            let isMouseInside = false;
            $button.on("mouseenter", function () {
                isMouseInside = true;
                $(this).on("mousemove", function (event) {
                    if (isMouseInside) {
                        var offset = $(this).offset();
                        var x = event.pageX - offset.left;
                        var y = event.pageY - offset.top;
                        $(this).find("span").css({
                            left: x + "px",
                            top: y + "px"
                        });
                    }
                });
            });
            $button.on("mouseleave", function () {
                isMouseInside = false;
                $(this).off("mousemove");
            });

            if ($('body').hasClass('elementor-editor-active')) {
                return;
            }
            if ($button.length > 0) {
                $button.magnificPopup({
                    type: 'inline',
                    removalDelay: 500,
                    closeBtnInside: true,
                    showCloseBtn: false,
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = 'mfp-zoom-in menu-popup-main mfp-fade';
                        }
                    },
                    midClick: true
                });
            }
        });
    });

})(jQuery);