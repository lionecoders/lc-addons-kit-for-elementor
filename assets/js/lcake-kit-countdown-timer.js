(function ($, elementorFrontend) {
    "use strict";

    var escapeHtml = function(e) {
        return e.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;")
    };

    var WidgetCountdownTimerHandler = function ($scope, $) {
        var t = $scope;
        var n = t.find(".lcake-countdown"),
            i = n.data(),
            o = "lcake-inner-container lcake-countdown-inner",
            s = "lcake-inner-container",
            a = "lcake-timer-content lcake-countdown-inner";

        for (let e in i) {
            if (i.hasOwnProperty(e) && "string" == typeof i[e]) {
                i[e] = escapeHtml(i[e]);
            }
        }

        if (n.length) {
            if (n.hasClass("lcake-countdown-timer-3")) {
                i.markup = '<div class="lcake-timer-container lcake-days"><div class="' + a + '"><div class="' + s + '"><span class="lcake-timer-count">%-D </span><span class="lcake-timer-title">' + i.dateLcakeDay + '</span></div></div></div><div class="lcake-timer-container lcake-hours"><div class="' + a + '"><div class="' + s + '"><span class="lcake-timer-count">%H </span><span class="lcake-timer-title">' + i.dateLcakeHour + '</span></div></div></div><div class="lcake-timer-container lcake-minutes"><div class="' + a + '"><div class="' + s + '"><span class="lcake-timer-count">%M </span><span class="lcake-timer-title">' + i.dateLcakeMinute + '</span></div></div></div><div class="lcake-timer-container lcake-seconds"><div class="' + a + '"><div class="' + s + '"><span class="lcake-timer-count">%S </span><span class="lcake-timer-title">' + i.dateLcakeSecond + '</span></div></div></div>';
            } else {
                i.markup = '<div class="lcake-timer-container lcake-days"><div class="' + o + '"><div class="lcake-timer-content"><span class="lcake-timer-count">%-D </span><span class="lcake-timer-title">' + i.dateLcakeDay + '</span></div></div></div><div class="lcake-timer-container lcake-hours"><div class="' + o + '"><div class="lcake-timer-content"><span class="lcake-timer-count">%H </span><span class="lcake-timer-title">' + i.dateLcakeHour + '</span></div></div></div><div class="lcake-timer-container lcake-minutes"><div class="' + o + '"><div class="lcake-timer-content"><span class="lcake-timer-count">%M </span><span class="lcake-timer-title">' + i.dateLcakeMinute + '</span></div></div></div><div class="lcake-timer-container lcake-seconds"><div class="' + o + '"><div class="lcake-timer-content"><span class="lcake-timer-count">%S </span><span class="lcake-timer-title">' + i.dateLcakeSecond + '</span></div></div></div>';
            }
            n.theFinalCountdown(i.lcakeCountdown, function (e) {
                this.innerHTML = e.strftime(i.markup);
            }).on("finish.countdown", function () {
                this.innerHTML = i.finishTitle + "<br />" + i.finishContent;
                if ("lcake-countdown-timer-4" === this.classList[0]) {
                    $(this).addClass("lcake-coundown-finish");
                }
            });
        }

        let l = t.find(".lcake-flip-clock"),
            r = l.data();

        if (l.length) {
            let e = [r.dateLcakeWeek, r.dateLcakeDay, r.dateLcakeHour, r.dateLcakeMinute, r.dateLcakeSecond],
                tc = ["lcake-wks", "lcake-days", "lcake-hrs", "lcake-mins", "lcake-secs"],
                htmlStr = "";

            e.forEach(function (val, idx) {
                const o_val = escapeHtml(val || "");
                htmlStr += '<div class="lcake-time ' + tc[idx] + ' lcake-countdown-inner"><span class="lcake-count lcake-curr lcake-top"></span><span class="lcake-count lcake-next lcake-top"></span><span class="lcake-count lcake-next lcake-bottom"></span><span class="lcake-count lcake-curr lcake-bottom"></span><span class="lcake-label">' + o_val + "</span></div>";
            });

            l.html(htmlStr);

            let $mins = l.children(".lcake-mins"),
                $secs = l.children(".lcake-secs"),
                $hrs = l.children(".lcake-hrs"),
                $days = l.children(".lcake-days"),
                $wks = l.children(".lcake-wks"),
                state = { s: "", m: "", h: "", d: "", w: "" };

            var flipClockAnimate = function (curr, next, el) {
                if (curr !== next) {
                    curr = 1 === curr.toString().length ? "0" + curr : curr;
                    next = 1 === next.toString().length ? "0" + next : next;
                    el.removeClass("lcake-flip");
                    el.children(".lcake-curr").text(curr);
                    el.children(".lcake-next").text(next);
                    setTimeout(function (target) {
                        target.addClass("lcake-flip");
                    }, 50, el);
                }
            };

            l.theFinalCountdown(r.lcakeCountdown, function (e) {
                flipClockAnimate(state.s, e.offset.seconds, $secs);
                flipClockAnimate(state.m, e.offset.minutes, $mins);
                flipClockAnimate(state.h, e.offset.hours, $hrs);
                flipClockAnimate(state.d, e.offset.days, $days);
                flipClockAnimate(state.w, e.offset.weeks, $wks);
                state.s = e.offset.seconds;
                state.m = e.offset.minutes;
                state.h = e.offset.hours;
                state.d = e.offset.days;
                state.w = e.offset.weeks;
            }).on("finish.countdown", function () {
                this.innerHTML = escapeHtml(r.finishTitle || "") + "<br/>" + escapeHtml(r.finishContent || "");
            });
        }
    };

    var initializeWidget = function () {
        if(typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-countdown-timer.default', WidgetCountdownTimerHandler);
        }
    };

    $(window).on('elementor/frontend/init', initializeWidget);

    // Initial trigger for editor mode
    $(document).ready(function () {
        if (typeof elementorFrontend !== 'undefined' && typeof elementorFrontend.isEditMode !== 'undefined' && !elementorFrontend.isEditMode()) {
            $('.elementor-widget-lcake-kit-countdown-timer').each(function () {
                WidgetCountdownTimerHandler($(this), $);
            });
        }
    });

})(jQuery, window.elementorFrontend);
