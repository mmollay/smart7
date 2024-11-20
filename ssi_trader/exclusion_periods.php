<?
// Definieren Sie die Zeitfenster, die ausgeschlossen werden sollen
$exclusionPeriods = [
    ['start' => "2024-04-15", 'end' => "2024-04-19"],
    ['start' => "2024-05-08", 'end' => "2024-05-11"],
    ['start' => "2024-04-09", 'end' => "2024-04-10"],
    // Fügen Sie weitere Zeitfenster nach Bedarf hinzu
];

// Erstellen Sie eine Bedingung, die alle Zeitfenster ausschließt
$exclusionConditions = array_map(function ($period) {
    return '(o.time < UNIX_TIMESTAMP("' . $period['start'] . '") OR o.time > UNIX_TIMESTAMP("' . $period['end'] . '"))';
}, $exclusionPeriods);
$exclusionClause = implode(' AND ', $exclusionConditions);
