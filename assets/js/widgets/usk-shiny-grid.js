; (function ($, elementor) {
    'use strict';
    var GridColumn = function ($scope, $) {
        $scope.find('*[data-filter="yes"]').each(function () {
            var $element = $(this)[0];
            var filter = $(this).data('filter');
            if ($element) {
                if (filter === 'yes') {
                    $('.tab-option').on('click', function (e) {
                        var grid_column = $(this).data('grid-column');
                        var set_grid_data = localStorage.setItem('usk_grid_data', grid_column);
                        $(this).closest('.usk-grid-header').find('li').removeClass('usk-tabs-active');
                        $(this).parent().addClass('usk-tabs-active');
                        if (grid_column !== 'usk-list-2') {
                            $(this).closest('.usk-grid-header').parent().find('.usk-grid').removeClass().addClass('usk-grid usk-grid-layout ' + grid_column);
                        } else {
                            $(this).closest('.usk-grid-header').parent().find('.usk-grid').removeClass().addClass('usk-grid usk-list-layout ' + grid_column);
                        }
                    });
                    var editMode = Boolean(elementor.isEditMode());
                    if (!editMode) {
                        var get_grid_data = localStorage.getItem('usk_grid_data');
                        if (get_grid_data !== null) {
                            $("[data-grid-column=" + get_grid_data + "]").parent().addClass('usk-tabs-active');
                            if (get_grid_data !== 'usk-list-2') {
                                $(this).find('.usk-grid').removeClass().addClass('usk-grid usk-grid-layout ' + get_grid_data);
                            } else {
                                $(this).find('.usk-grid').removeClass().addClass('usk-grid usk-list-layout ' + get_grid_data);
                            }
                        }
                    }
                }
            }
        });
    };
    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-shiny-grid.default', GridColumn);
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-glossy-grid.default', GridColumn);
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-florence-grid.default', GridColumn);
    });

}(jQuery, window.elementorFrontend));