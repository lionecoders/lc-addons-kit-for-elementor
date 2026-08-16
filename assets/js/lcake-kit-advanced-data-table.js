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
        
        // Select All Checkbox logic
        var $selectAll = $table.find('.lcake-adv-table-select-all');
        if ($selectAll.length) {
            $selectAll.on('change', function () {
                var checked = $(this).prop('checked');
                $table.find('.lcake-adv-table-row-select').prop('checked', checked);
            });
            $table.on('change', '.lcake-adv-table-row-select', function () {
                var allChecked = $table.find('.lcake-adv-table-row-select').length === $table.find('.lcake-adv-table-row-select:checked').length;
                $selectAll.prop('checked', allChecked);
            });
        }

        // Pagination variables
        var hasPagination = $wrapper.find('.lcake-adv-table-footer').length > 0;
        var currentPage = 1;
        var pageSize = parseInt($wrapper.find('.lcake-adv-table-page-size').val()) || 10;

        function updatePagination() {
            if (!hasPagination) {
                return;
            }

            var $visibleRows = $rows.not('.is-filtered-out');
            var totalRows = $visibleRows.length;
            var totalPages = Math.ceil(totalRows / pageSize) || 1;

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }
            if (currentPage < 1) {
                currentPage = 1;
            }

            var start = (currentPage - 1) * pageSize;
            var end = start + pageSize;
            if (end > totalRows) {
                end = totalRows;
            }

            $rows.addClass('is-paginated-out');
            $visibleRows.slice(start, end).removeClass('is-paginated-out');

            // Update range text
            var rangeText = totalRows === 0 ? '0-0 of 0' : (start + 1) + '-' + end + ' of ' + totalRows;
            $wrapper.find('.lcake-adv-table-pagination-range').text(rangeText);

            // Enable/disable navigation buttons
            $wrapper.find('.lcake-adv-table-page-first').prop('disabled', currentPage === 1);
            $wrapper.find('.lcake-adv-table-page-prev').prop('disabled', currentPage === 1);
            $wrapper.find('.lcake-adv-table-page-next').prop('disabled', currentPage === totalPages);
            $wrapper.find('.lcake-adv-table-page-last').prop('disabled', currentPage === totalPages);
        }

        if (hasPagination) {
            $wrapper.find('.lcake-adv-table-page-size').on('change', function () {
                pageSize = parseInt($(this).val());
                currentPage = 1;
                updatePagination();
            });

            $wrapper.find('.lcake-adv-table-page-first').on('click', function () {
                currentPage = 1;
                updatePagination();
            });

            $wrapper.find('.lcake-adv-table-page-prev').on('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                }
            });

            $wrapper.find('.lcake-adv-table-page-next').on('click', function () {
                var $visibleRows = $rows.not('.is-filtered-out');
                var totalRows = $visibleRows.length;
                var totalPages = Math.ceil(totalRows / pageSize) || 1;
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                }
            });

            $wrapper.find('.lcake-adv-table-page-last').on('click', function () {
                var $visibleRows = $rows.not('.is-filtered-out');
                var totalRows = $visibleRows.length;
                var totalPages = Math.ceil(totalRows / pageSize) || 1;
                currentPage = totalPages;
                updatePagination();
            });
        }

        // Search action
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
            currentPage = 1; // Reset to first page
            updatePagination();
        });

        // Sorting action
        if ('yes' === $table.attr('data-sortable')) {
            $table.find('thead th').on('click', function (e) {
                // If clicked on checkbox, do not sort
                if ($(e.target).closest('.lcake-adv-table-select-all').length) {
                    return;
                }

                var $th = $(this);
                var index = $th.index();
                var isAsc = !$th.hasClass('is-sorted-asc');

                $th.siblings().removeClass('is-sorted-asc is-sorted-desc');
                $th.toggleClass('is-sorted-asc', isAsc).toggleClass('is-sorted-desc', !isAsc);

                var $tbody = $table.find('tbody');
                var sortedRows = $tbody.find('tr').get();

                sortedRows.sort(function (a, b) {
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

                $.each(sortedRows, function (i, row) {
                    $tbody.append(row);
                });

                // Update rows cache
                $rows = $table.find('tbody tr');
                updatePagination();
            });
        }

        // Initial render
        updatePagination();
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-advanced-data-table.default', WidgetLcakeAdvancedDataTableHandler);
    });

})(jQuery, window);
