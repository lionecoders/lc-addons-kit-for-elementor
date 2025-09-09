(function ($) {
    'use strict';

    const PieChartWidget = function ($scope) {
        const $outer = $scope.find('.lcake-kit-pie-chart__outer');
        if (!$outer.length) return;

        $outer.each(function () {
            const $wrap = $(this);
            const $container = $wrap.find('.lcake-kit-pie-chart__container').first();
            const $canvas = $container.find('canvas').first();

            if (!$container.length || !$canvas.length) return;

            // parse chart data from data-chart attribute
            let chartDataRaw = $container.attr('data-chart') || '';
            let chartData;
            try {
                chartData = JSON.parse(chartDataRaw);
            } catch (e) {
                // fallback to reading jQuery .data (if set)
                chartData = $container.data('chart') || null;
            }

            if (!chartData || !Array.isArray(chartData.labels) || !chartData.datasets || !chartData.datasets[0]) {
                return;
            }

            // Destroy previous instance (Elementor re-render)
            const prev = $container.data('chartInstance');
            if (prev && typeof prev.destroy === 'function') {
                prev.destroy();
                $container.data('chartInstance', null);
            }

            // build Chart.js config
            const config = {
                type: 'pie',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        data: chartData.datasets[0].data,
                        backgroundColor: chartData.datasets[0].backgroundColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: !!chartData.showLegend,
                            position: 'bottom',
                            labels: {
                                color: chartData.legendColor || undefined,
                                font: {
                                    size: chartData.legendFontSize || chartData.legendFontSize // fallback handled below
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw;
                                    if (chartData.showPercentage) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const perc = total ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                                        return label + ': ' + perc;
                                    }
                                    return label + ': ' + value;
                                }
                            }
                        }
                    }
                }
            };

            // chart font sizing fallbacks
            if (chartData.legendFontSize) {
                config.options.plugins.legend.labels.font.size = parseInt(chartData.legendFontSize, 10);
            }

            // create chart instance
            const ctx = $canvas[0].getContext('2d');
            const chartInstance = new Chart(ctx, config);

            // store instance for later destroy
            $container.data('chartInstance', chartInstance);
        });
    };

    // Init on Elementor frontend
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-pie-chart.default', PieChartWidget);
        }
    });

})(jQuery);
