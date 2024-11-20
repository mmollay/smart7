$(document).ready(function () {

    $(document).ready(function () {
        var accountColors = [
            "#1f77b4", "#ff7f0e", "#9467bd", "#8c564b", "#e377c2",
            "#7f7f7f", "#bcbd22", "#17becf", "#1a55FF", "#FF5733",
            "#33FF57", "#8E44AD", "#3498DB", "#F1C40F", "#E67E22",
            "#E74C3C", "#2ECC71", "#16A085", "#17202A", "#F4D03F",
            "#7D3C98", "#76D7C4", "#F7DC6F", "#6E2C00", "#1ABC9C",
            "#2E4053", "#D35400", "#145A32", "#C39BD3", "#5499C7",
            "#48C9B0", "#154360", "#F39C12", "#85C1E9", "#F1948A",
            "#BB8FCE", "#EC7063", "#AAB7B8", "#566573", "#2ECC40"
        ];

        let currentChart = null;

        function updateChartData() {
            const timeFrame = $('#timeFrameSelect').val();
            const chartType = $('#chartTypeSelect').val();
            const accountType = $('#accountTypeSelect').val();
            const profitFilter = $('#profitFilter').val();

            $.ajax({
                url: 'ajax/content_chart_data.php', // Stellen Sie sicher, dass diese URL korrekt ist
                type: 'POST',
                data: {
                    timeFrame: timeFrame,
                    chartType: chartType,
                    accountType: accountType,
                    profitFilter: profitFilter
                },
                success: function (data) {
                    const responseData = JSON.parse(data);
                    if (responseData.length === 0) {
                        console.error('Keine Daten zum Anzeigen');
                        return;
                    }
                    drawChart(responseData, chartType);
                },
                error: function (xhr, status, error) {
                    console.error('Fehler beim Abrufen der Daten:', error);
                }
            });
        }

        function drawChart(accountsData, chartType) {
            const ctx = $('#chartCanvas')[0].getContext('2d');
            const labels = accountsData[0].data.map(item => item.label);
            const datasets = accountsData.map((account, index) => ({
                label: account.title,
                data: account.data.map(item => +item.profit),
                backgroundColor: accountColors[index % accountColors.length],
                borderColor: accountColors[index % accountColors.length],
                borderWidth: 1,
                fill: chartType === 'bar'
            }));

            if (currentChart) {
                currentChart.destroy();
            }

            currentChart = new Chart(ctx, {
                type: chartType,
                data: { labels, datasets },
                options: getChartOptions(timeFrame)
            });
        }

        function getChartOptions(timeFrame) {
            const timeFrameLabel = {
                'hours': '24 Stunden',
                'days': '7 Tage',
                'weeks': '4 Wochen',
                'months': '6 Monate'
            }[timeFrame] || '';

            return {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Gewinn/Verlust (€)' },
                        ticks: { callback: value => `€${value.toFixed(2)}` }
                    },
                    x: { title: { display: true, text: timeFrameLabel } }
                },
                plugins: {
                    title: { display: true, text: 'Umsatzentwicklung ' + timeFrameLabel },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: (value, context) => value !== 0 ? `€${value.toFixed(2)}` : null,
                        color: '#444',
                        font: { weight: 'bold' }
                    }
                }
            };
        }

        // Event-Listener für Dropdown-Änderungen
        $('select').on('change', updateChartData);

        // Initialisiere das Diagramm mit den gespeicherten oder Standardwerten
        updateChartData();
    });

    let currentChart = null;

    function updateChartData() {
        const timeFrame = $('#timeFrameSelect').val();
        const chartType = $('#chartTypeSelect').val();
        const accountType = $('#accountTypeSelect').val();
        const profitFilter = $('#profitFilter').val();

        $.ajax({
            url: 'ajax/content_chart_data.php', // Stellen Sie sicher, dass diese URL korrekt ist
            type: 'POST',
            data: {
                timeFrame: timeFrame,
                chartType: chartType,
                accountType: accountType,
                profitFilter: profitFilter
            },
            success: function (data) {
                const responseData = JSON.parse(data);
                if (responseData.length === 0) {
                    console.error('Keine Daten zum Anzeigen');
                    return;
                }
                drawChart(responseData, chartType);
            },
            error: function (xhr, status, error) {
                console.error('Fehler beim Abrufen der Daten:', error);
            }
        });
    }

    function drawChart(accountsData, chartType) {
        const ctx = $('#chartCanvas')[0].getContext('2d');
        const labels = accountsData[0].data.map(item => item.label);
        const datasets = accountsData.map((account, index) => ({
            label: account.title,
            data: account.data.map(item => +item.profit),
            backgroundColor: accountColors[index % accountColors.length],
            borderColor: accountColors[index % accountColors.length],
            borderWidth: 1,
            fill: chartType === 'bar'
        }));

        if (currentChart) {
            currentChart.destroy();
        }

        currentChart = new Chart(ctx, {
            type: chartType,
            data: { labels, datasets },
            options: getChartOptions(timeFrame)
        });
    }

    function getChartOptions(timeFrame) {
        const timeFrameLabel = {
            'hours': '24 Stunden',
            'days': '7 Tage',
            'weeks': '4 Wochen',
            'months': '6 Monate'
        }[timeFrame] || '';

        return {
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Gewinn/Verlust (€)' },
                    ticks: { callback: value => `€${value.toFixed(2)}` }
                },
                x: { title: { display: true, text: timeFrameLabel } }
            },
            plugins: {
                title: { display: true, text: 'Umsatzentwicklung ' + timeFrameLabel },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: (value, context) => value !== 0 ? `€${value.toFixed(2)}` : null,
                    color: '#444',
                    font: { weight: 'bold' }
                }
            }
        };
    }

    // Event-Listener für Dropdown-Änderungen
    $('select').on('change', updateChartData);

    // Initialisiere das Diagramm mit den gespeicherten oder Standardwerten
    updateChartData();
});