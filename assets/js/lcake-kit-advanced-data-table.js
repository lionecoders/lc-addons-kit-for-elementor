(function ($, window) {
    'use strict';

    var WidgetLcakeAdvancedDataTableHandler = function ($scope) {
        var $wrapper = $scope.find('.lcake-adv-table-wrapper');
        if (!$wrapper.length) {
            return;
        }

        var $table = $wrapper.find('.lcake-adv-table');
        var $rows = $table.find('tbody tr');
        var $search = $wrapper.find('.lcake-adv-table-search');
        var $empty = $wrapper.find('.lcake-adv-table-empty');

        $search.on('input', function () {
            var term = $(this).val().toLowerCase();
            var visibleCount = 0;

            $rows.each(function () {
                var match = $(this).text().toLowerCase().indexOf(term) !== -1;
                $(this).toggleClass('is-filtered-out', !match);
                if (match) {
                    visibleCount++;
                }
            });

            $empty.toggle(0 === visibleCount);
        });

        if ('yes' === $table.attr('data-sortable')) {
            $table.find('thead th').on('click', function () {
                var $th = $(this);
                var index = $th.index();
                var isAsc = !$th.hasClass('is-sorted-asc');

                $th.siblings().removeClass('is-sorted-asc is-sorted-desc');
                $th.toggleClass('is-sorted-asc', isAsc).toggleClass('is-sorted-desc', !isAsc);

                var $tbody = $table.find('tbody');
                var rows = $tbody.find('tr').get();

                rows.sort(function (a, b) {
                    var aText = $(a).children().eq(index).text().trim().toLowerCase();
                    var bText = $(b).children().eq(index).text().trim().toLowerCase();
                    var aNum = parseFloat(aText);
                    var bNum = parseFloat(bText);

                    var result;
                    if (!isNaN(aNum) && !isNaN(bNum)) {
                        result = aNum - bNum;
                    } else {
                        result = aText.localeCompare(bText);
                    }

                    return isAsc ? result : -result;
                });

                $.each(rows, function (i, row) {
                    $tbody.append(row);
                });
            });
        }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-advanced-data-table.default', WidgetLcakeAdvancedDataTableHandler);
    });

})(jQuery, window);
