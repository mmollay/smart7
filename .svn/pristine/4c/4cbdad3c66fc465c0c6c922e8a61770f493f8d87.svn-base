<?php
// Der PHP-Teil ist hauptsächlich serverseitig und für die Einrichtung der initialen Seite zuständig.
// Stellen Sie sicher, dass Ihre AJAX-Endpunkte korrekt konfiguriert sind, um Daten für alle Accounts abzurufen.
$accountColors = [
    "#1f77b4",
    "#ff7f0e",
    "#9467bd",
    "#8c564b",
    "#e377c2",
    "#7f7f7f",
    "#bcbd22",
    "#17becf",
    "#1a55FF",
    "#FF5733",
    "#33FF57",
    "#8E44AD",
    "#3498DB",
    "#F1C40F",
    "#E67E22",
    "#E74C3C",
    "#2ECC71",
    "#16A085"
];
?>

<select id="timeFrameSelect" class="ui dropdown">
    <option value="hours">24 Stunden</option>
    <option value="days" selected>7 Tage</option>
    <option value="weeks">4 Wochen</option>
    <option value="months">6 Monate</option>
</select>

<select id="chartTypeSelect" class="ui dropdown">
    <option value="line">Liniendiagramm</option>
    <option value="bar" selected>Balkendiagramm</option>
</select>


<canvas id="chartCanvas"></canvas>

<script>
    $(document).ready(function () {
        const accountColors = <?php echo json_encode($accountColors); ?>;
        var currentChart;
        // Deklariere timeFrame und chartType außerhalb der Funktionen, um sie überall zugänglich zu machen
        var timeFrame = localStorage.getItem('timeFrame') || 'days'; // Standardwert als Fallback
        var chartType = localStorage.getItem('chartType') || 'bar'; // Standardwert als Fallback

        $('#timeFrameSelect').val(timeFrame);
        $('#chartTypeSelect').val(chartType);

        function getTimeFrameLabel(timeFrame) {
            switch (timeFrame) {
                case 'hours':
                    return '24 Stunden';
                case 'days':
                    return '7 Tage';
                case 'weeks':
                    return '4 Wochen';
                case 'months':
                    return '6 Monate';
                default:
                    return ''; // Standardwert oder Fehlerbehandlung
            }
        }

        function updateChartData(tf, ct) {
            // Aktualisiere globale Variablen mit aktuellen Werten
            timeFrame = tf;
            chartType = ct;

            $.ajax({
                url: 'ajax/content_chart_data.php',
                type: 'POST',
                data: { timeFrame: timeFrame },
                success: function (data) {
                    const responseData = JSON.parse(data);
                    drawChart(responseData);
                }
            });
        }

        function drawChart(accountsData) {
            const ctx = $('#chartCanvas')[0].getContext('2d');
            if (currentChart) {
                currentChart.destroy(); // Zerstöre das aktuelle Chart, wenn vorhanden
            }

            const datasets = accountsData.map((account, index) => {
                const data = account.data.map(item => +item.profit);
                const accountColor = accountColors[index % accountColors.length];

                return {
                    label: account.title,
                    data: data,
                    backgroundColor: accountColor,
                    borderColor: accountColor,
                    borderWidth: 1
                };
            });

            const labels = accountsData[0].data.map(item => item.label);
            const timeFrameLabel = getTimeFrameLabel(timeFrame);

            currentChart = new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: true,
                                color: function (context) {
                                    if (context.tick.value === 0) {
                                        return 'black';
                                    }
                                    return 'rgba(0, 0, 0, 0.1)'; // Farbe der anderen Gitterlinien
                                },
                                lineWidth: function (context) {
                                    if (context.tick.value === 0) {
                                        return 2;
                                    }
                                    return 1; // Dicke der anderen Gitterlinien
                                }
                            }
                        }
                    },

                    plugins: {
                        title: {
                            display: true,
                            text: 'Umsatzentwicklung ' + timeFrameLabel
                        },

                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            formatter: (value, context) => {
                                // Überprüfe, ob der Wert ungleich 0 ist und basiere die Anzeige auch auf der Anzahl der Labels
                                if (value !== 0 && context.chart.data.labels.length < 5) {
                                    return Number(value).toFixed(2) + '€';
                                } else {
                                    return null; // Kein Label anzeigen
                                }
                            },
                            color: '#444',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }

        // Initialisiere das Chart mit gespeicherten oder Standardwerten
        updateChartData(timeFrame, chartType);

        // Event-Listener für die Speicherung der Auswahl im Local Storage und Aktualisierung des Charts
        $('#timeFrameSelect').on('change', function () {
            updateChartData($(this).val(), chartType);
            localStorage.setItem('timeFrame', $(this).val());
        });

        $('#chartTypeSelect').on('change', function () {
            updateChartData(timeFrame, $(this).val());
            localStorage.setItem('chartType', $(this).val());
        });
    });
</script>