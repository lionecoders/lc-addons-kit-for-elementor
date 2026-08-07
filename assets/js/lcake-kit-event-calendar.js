(function ($, window) {
    'use strict';

    var MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var WEEKDAYS = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

    var WidgetLcakeEventCalendarHandler = function ($scope) {
        var $calendar = $scope.find('.lcake-event-calendar');
        if (!$calendar.length) {
            return;
        }

        var events = [];
        try {
            events = JSON.parse($calendar.attr('data-events') || '[]');
        } catch (e) {
            events = [];
        }

        var eventsByDate = {};
        events.forEach(function (event) {
            var d = new Date(event.date);
            if (isNaN(d.getTime())) {
                return;
            }
            var key = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate();
            eventsByDate[key] = eventsByDate[key] || [];
            eventsByDate[key].push(event);
        });

        var today = new Date();
        var current = new Date(today.getFullYear(), today.getMonth(), 1);

        var $weekdays = $calendar.find('.lcake-event-calendar-weekdays');
        WEEKDAYS.forEach(function (day) {
            $weekdays.append($('<span>').text(day));
        });

        var render = function () {
            var year = current.getFullYear();
            var month = current.getMonth();

            $calendar.find('.lcake-event-calendar-title').text(MONTH_NAMES[month] + ' ' + year);

            var $grid = $calendar.find('.lcake-event-calendar-grid').empty();
            var $list = $calendar.find('.lcake-event-calendar-list').empty();

            var firstDay = new Date(year, month, 1).getDay();
            var daysInMonth = new Date(year, month + 1, 0).getDate();

            for (var i = 0; i < firstDay; i++) {
                $grid.append($('<span>').addClass('lcake-event-calendar-day is-empty'));
            }

            for (var day = 1; day <= daysInMonth; day++) {
                var key = year + '-' + month + '-' + day;
                var dayEvents = eventsByDate[key] || [];
                var $day = $('<span>').addClass('lcake-event-calendar-day').text(day);

                if (dayEvents.length) {
                    $day.addClass('has-event');
                }

                var isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
                if (isToday) {
                    $day.addClass('is-today');
                }

                $grid.append($day);

                dayEvents.forEach(function (event) {
                    var $li = $('<li>');
                    var dateLabel = new Date(event.date).toLocaleDateString();
                    var $meta = $('<div>').addClass('lcake-event-calendar-meta');
                    
                    if (event.link) {
                        $meta.append($('<a>').attr('href', event.link).text(event.title));
                    } else {
                        $meta.append($('<strong>').text(event.title));
                    }
                    $meta.append($('<span>').text(dateLabel));
                    $li.append($meta);

                    if (event.description) {
                        $li.append($('<p>').addClass('lcake-event-calendar-desc').text(event.description));
                    }

                    $list.append($li);
                });
            }
        };

        $calendar.find('.lcake-event-calendar-prev').on('click', function () {
            current.setMonth(current.getMonth() - 1);
            render();
        });

        $calendar.find('.lcake-event-calendar-next').on('click', function () {
            current.setMonth(current.getMonth() + 1);
            render();
        });

        render();
    };

    var init = function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-event-calendar.default', WidgetLcakeEventCalendarHandler);
    };

    if (window.elementorFrontend) {
        init();
    } else {
        $(window).on('elementor/frontend/init', init);
    }

})(jQuery, window);
