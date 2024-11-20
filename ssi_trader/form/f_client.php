<?php
//$user_id = $_SESSION['user_id'];

$arr['ajax'] = [
    'success' => "afterFormSubmit(data)", // Angepasster Funktionsname
    'dataType' => "html"
];

$arr['sql'] = [
    'query' => "SELECT * FROM ssi_trader.clients WHERE client_id = '{$_POST['update_id']}'" // Angepasst auf die clients Tabelle
];

// Felddefinitionen für das Formular
$arr['field'] = [
    'email' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'Email (Username)',
        'focus' => true
    ],
    'password' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'Password'
    ],
    ['type' => 'div', 'class' => 'fields width'],
    'first_name' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'First Name',
    ],
    'last_name' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'Last Name',
    ],
    ['type' => 'div_close'],
    'phone' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'Phone'
    ],
    ['type' => 'div', 'class' => 'equal fields'],
    'address' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'Address',
        'wide' => 'eight'
    ],
    'city' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'City',
        'wide' => 'eight'
    ],
    'state' => [
        'tab' => '1',
        'type' => 'dropdown',
        'array' => 'country',
        'label' => 'State',
        'wide' => 'eight'
    ],
    'zip' => [
        'tab' => '1',
        'type' => 'input',
        'label' => 'ZIP Code',
        'wide' => 'four'
    ],
    ['type' => 'div_close'],

];

//Shows just server that are not already assigned to the user
// $query_serverlist = "
// SELECT s.server_id, CONCAT(s.name, ' (', s.url, ')') AS name
// FROM ssi_trader.servers AS s
// WHERE s.server_id NOT IN (
//     SELECT c.server_id 
//     FROM ssi_trader.clients AS c 
//     WHERE c.server_id IS NOT NULL AND c.client_id != '" . $_POST['update_id'] . "'
// ) OR s.server_id IN (
//     SELECT c.server_id
//     FROM ssi_trader.clients AS c
//     WHERE c.client_id = '" . $_POST['update_id'] . "'
// )
// ORDER BY s.name ASC
// ";

// //$query_serverlist = "SELECT server_id, CONCAT(name, ' (', url, ')') AS name FROM ssi_trader.server ORDER BY name ASC";

// $arr['field']['server_id'] = array(
//     'tab' => '1',
//     'type' => 'dropdown',
//     'label' => 'Windows Server',
//     'array_mysql' => $query_serverlist,
//     'text' => 'name',
//     'class' => 'fluid search selection'
// );

// Listet Broker auf, die dem Benutzer noch nicht zugewiesen sind, und den Broker, der ihm zugewiesen ist
$query_brokerlist = "
SELECT user account, CONCAT(b.title,' (',b.user,')') AS name
FROM ssi_trader.broker AS b
WHERE b.broker_id NOT IN (
    SELECT c.broker_id 
    FROM ssi_trader.clients AS c 
    WHERE c.broker_id IS NOT NULL AND c.client_id != '" . $_POST['update_id'] . "'
) OR b.broker_id IN (
    SELECT c.broker_id
    FROM ssi_trader.clients AS c
    WHERE c.client_id = '" . $_POST['update_id'] . "'
)
ORDER BY b.title ASC
";

$arr['field']['account'] = array(
    'tab' => '1',
    'type' => 'dropdown',
    'label' => 'Broker',
    'array_mysql' => $query_brokerlist,
    'text' => 'name',
    'class' => 'fluid search selection',
    'validate' => true
);

// Updating your JavaScript
$add_js .= "<script type=\"text/javascript\" src=\"js/form_after.js\"></script>"; // Ensure the file name is correct