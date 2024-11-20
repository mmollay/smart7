<?php
include_once ('config.inc.php');

$array_menu['content_home.php'] = array('Home', 'home', 'active', 'id' => 'home');
$array_menu['content_orders.php'] = array('Orders', 'hand holding usd', '', 'id' => 'orders');
$array_menu['content_chart.php'] = array('Charts', 'chart bar', '', 'id' => 'chart');
// $array_menu['content_setting.php'] = array('Setting', 'setting', '', 'id' => 'setting');

$array_menu[] = 'hr';
$array_menu['content_servers.php'] = array('Servers', 'server', '', 'id' => 'server');
$array_menu['content_broker.php'] = array('Broker', 'university', '', 'id' => 'broker');
$array_menu['content_hedging.php'] = array('Strategy', 'list', '', 'id' => 'strategy');

$array_menu[] = 'hr';
$array_menu['content_clients.php'] = array('Clients', 'users', '', 'id' => 'client');
$array_menu['content_investments.php'] = array('Investments', 'money bill alternate', '', 'id' => 'investments');
//$array_menu['content_profit.php'] = array('Profit', 'money bill alternate', '', 'id' => 'profit');
//Investments

$array_menu[] = 'hr';
//$array_menu['content_import.php'] = array('Import', 'file import', '', 'id' => 'import');
//$array_menu['content_charts.php'] = array('Charts', 'chartline', '', 'id' => 'chart');
//$array_menu['content_home2.php'] = array('Home (develop)', 'home', '', 'id' => 'home2');
$array_menu['content_news.php'] = array('Version', 'code branch', 'active', 'id' => 'version');
//$array_menu['content_develop.php'] = array('Develop', 'flask', 'active', 'id' => 'develop');
//$array_menu['content_backtester.php'] = array('Backtester', 'flask', 'active', 'id' => 'backtester');
$array_menu[] = 'hr';

// $array_menu['content_stratey.php'] = array ( 'Strategy' , 'strategy' , '' , 'id' =>'strategy' );
// $array_menu['content_backtesting.php'] = array ( 'Backtesting' , 'strategy' , '' , 'id' =>'strategy' );

$array_menu_structure = call_menu_structure($array_menu);
$setContent = $array_menu_structure['content'];
$setMenu .= $array_menu_structure['menu'];
$setMenu .= "<div align=center><button onclick='fetchOrders();' class='ui fluid small button'>Fetch Orders</button></div><br>";
//Fetch token
//$setMenu .= "<div align=center><button onclick='generateToken();' class='ui fluid small button'>Generate new Tokens</button></div>";