<?
include (__DIR__ . '/../config.php');
include (__DIR__ . '/../functions.php');

$clientId = $_SESSION['client_id'];
$array = getBrokerUserByClientId($db, $clientId);
$accountId = $array['user'];
?>

<select id="timeFrameSelect" class="ui dropdown">
    <option value="hours" selected>24 Stunden</option>
    <option value="days">7 Tage</option>
    <option value="weeks">4 Wochen</option>
    <option value="months">6 Monate</option>
</select>

<select id="chartTypeSelect" class="ui dropdown">
    <option value="line">Liniendiagramm</option>
    <option value="bar" selected>Balkendiagramm</option>
</select>
<canvas id="chartCanvas"></canvas>

<script>
    var currentChart;

    // AJAX-Anfrage zur Aktualisierung der Daten
    function updateChartData(timeFrame, chartType) {
        $.ajax({
            url: 'pages/chart_data.php', // Pfad zur PHP-Datei
            type: 'POST',
            data: {
                timeFrame: timeFrame,
                accountId: <?= $accountId ?> // Beispiel-Account-ID, anpassen nach Bedarf
            },
            success: function (data) {
                const parsedData = JSON.parse(data);
                const labels = parsedData.map(item => item.label);
                const profits = parsedData.map(item => item.profit);
                drawChart(labels, profits, chartType);
            }
        });
    }
    // Funktion zum Zeichnen des Charts mit farblich markierten positiven und negativen Werten
    function drawChart(labels, data, chartType) {
        const ctx = document.getElementById('chartCanvas').getContext('2d');

        if (currentChart) {
            currentChart.destroy(); // Zerstöre das aktuelle Chart, wenn vorhanden
        }

        const yAxisConfig = {
            beginAtZero: true,
            gridLines: {
                // Füge eine horizontale Linie am 0-Punkt hinzu
                zeroLine: {
                    color: 'red', // Graue Farbe
                    lineWidth: 1, // Ändere die Linienstärke auf 1 oder 2**
                    strokeStyle: 'solid'
                }
            }
        };

        currentChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gewinn',
                    data: data,
                    backgroundColor: data.map(value => value >= 0 ? 'rgba(54, 162, 235, 0.2)' : 'rgba(255, 99, 132, 0.2)'),
                    borderColor: data.map(value => value >= 0 ? 'rgba(54, 162, 235, 1)' : 'rgba(255, 99, 132, 1)'),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: yAxisConfig // Verwende die konfigurierte Y-Achse
                },
                plugins: {
                    // Konfiguration für das datalabels Plugin
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        formatter: (value) => {
                            // Stellt sicher, dass der Wert als Zahl behandelt wird, bevor toFixed angewendet wird
                            const numericValue = Number(value); // oder alternativ: const numericValue = +value;
                            return numericValue.toFixed(2) + '€';
                        },
                        color: '#444', // Setze die Textfarbe, optional
                        font: {
                            weight: 'bold' // Setze die Schriftart auf fett, optional
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Aktiviere das datalabels Plugin
        });
    }



    // Event-Listener für Dropdown-Änderungen
    document.getElementById('timeFrameSelect').addEventListener('change', function () {
        const timeFrame = this.value;
        const chartType = document.getElementById('chartTypeSelect').value;
        updateChartData(timeFrame, chartType);
    });

    document.getElementById('chartTypeSelect').addEventListener('change', function () {
        const chartType = this.value;
        const timeFrame = document.getElementById('timeFrameSelect').value;
        updateChartData(timeFrame, chartType);
    });

    // Initialisiere das Chart mit Standardwerten
    updateChartData('days', 'bar');
</script>