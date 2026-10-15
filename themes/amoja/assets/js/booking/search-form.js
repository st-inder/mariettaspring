(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/babe-search-form.default', ($scope) => {

            $('.add_input_field .add_ids_title').on('click', function (event) {
                event.preventDefault();
                $('.add_ids_list').removeClass('active');
                if ($(this).parent().find('.add_ids_list').hasClass('amoja-active')) {
                    $(this).parent().find('.add_ids_list').removeClass('amoja-active');
                    search_add_list_close(this);
                } else {
                    $('.add_ids_list').removeClass('amoja-active');
                    search_add_list_close('.add_ids_title');
                    $(this).parent().find('.add_ids_list').addClass('amoja-active');
                    search_add_list_open(this);
                }
            });


            $('.add_input_field .add_ids_list .term_item').on('click', function (event) {
                var parent = $(this).closest('.add_ids_title');
                search_add_input_toggle(parent);
            });

            $(document).on('click', function (event) {
                var par = $(event.target).closest('.add_input_field');
                if (par.length) {
                    $(par).siblings().each(function (ind, elm) {
                        search_add_input_close(this);
                    });
                } else {
                    $(document).find('.add_input_field .add_ids_list.amoja-active').parents().eq(1).each(function (ind, elm) {
                        search_add_input_close(this);
                    });
                }
            });

            function search_add_input_toggle(item) {
                $(item).parent().find('.add_ids_list').toggleClass('amoja-active');
                $(item).parent().find('.add_ids_title .js-amoja-icon').toggleClass('active');
            }

            function search_add_input_close(item) {
                $(item).find('.add_ids_list').removeClass('amoja-active');
                $(item).parent().find('.add_ids_title .js-amoja-icon').toggleClass('active');
            }

            function search_add_list_open(item) {
                $(item).parent().find('.add_ids_title .js-amoja-icon').toggleClass('active');
            }

            function search_add_list_close(item) {
                $(item).parent().find('.add_ids_title .js-amoja-icon').toggleClass('active');
            }
            const dateRangePicker = $('#date_from.search_date',$scope);
            if (dateRangePicker) {

                dateRangePicker.on('show.daterangepicker', function (ev, picker) {
                    let $parret = $(this).closest('.field-search-group');
                    setTimeout(function () {
                        $('.daterangepicker').addClass('effect-active');
                    },100);
                    if ($parret) {
                        $('.daterangepicker').css({
                            marginLeft: -($(this).offset().left - $parret.offset().left)
                        })
                    }

                }).on('hide.daterangepicker', function () {
                    $('.daterangepicker').removeClass('effect-active').addClass('effect-deactive');
                    setTimeout(function () {
                        $('.daterangepicker').removeClass('effect-deactive');
                    },500);
                });

                if ($scope.hasClass('taxonomies-search-dropdown-top')) {
                    $('#date_from.search_date', $scope).on('showCalendar.daterangepicker', function (ev, picker) {
                        picker.drops = "up";
                    });
                }
                if ($scope.hasClass('taxonomies-search-layout-traditional')) {
                    $('.daterangepicker').addClass('layout-traditional');
                }
            }
        });
    });

})(jQuery);
