<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Umsatz Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="ui form">
        <div class="field">
            <label for="timeFrameSelect">Zeitraum:</label>
            <select id="timeFrameSelect" class="ui dropdown">
                <option value="hours">24 Stunden</option>
                <option value="days" selected>7 Tage</option>
                <option value="weeks">4 Wochen</option>
                <option value="months">6 Monate</option>
            </select>
        </div>
        <div class="field">
            <label for="chartTypeSelect">Diagrammtyp:</label>
            <select id="chartTypeSelect" class="ui dropdown">
                <option value="bar" selected>Balkendiagramm</option>
                <option value="line">Liniendiagramm</option>
            </select>
        </div>
        <div class="field">
            <label for="accountTypeSelect">Account Typ:</label>
            <select id="accountTypeSelect" class="ui dropdown">
                <option value="0">Alle Accounts</option>
                <option value="1" selected>Real Accounts</option>
                <option value="2">Demo Accounts</option>
            </select>
        </div>
        <div class="field">
            <label for="profitFilter">Gewinnfilter:</label>
            <select id="profitFilter" class="ui dropdown">
                <option value="all">Alle Gewinne/Verluste</option>
                <option value="positive" selected>Nur positive Gewinne</option>
                <option value="negative">Nur negative Gewinne</option>
            </select>
        </div>
    </div>

    <canvas id="chartCanvas"></canvas>

    <script src="chart_test.js"></script> <!-- External JS for cleaner code -->
</body>

</html>