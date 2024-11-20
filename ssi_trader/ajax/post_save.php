<?php
include(__DIR__ . '/../config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Konvertiere 'qty' zu einem Float, falls es gesetzt ist
    if (isset($_POST['qty'])) {
        $_POST['qty'] = floatval($_POST['qty']);
    }

    if (isset($_POST['price'])) {
        $_POST['price'] = floatval($_POST['price']);
    }

    // Setze 'qty' auf 0.1, falls der Wert kleiner als 0 ist
    if ($_POST['qty'] < 0) {
        $_POST['qty'] = 0.1;
    }

    // Die Url wird aus der Db gelesen
    $url = getSingleServerIpByUserId($mysqli, $_SESSION['user_id']);

    //$url = 'http://85.215.176.20:8080';

    // Überprüfung, welche Aktion ausgeführt werden soll
    switch (true) {
        case ($_POST['ema_print'] == 'emaPrint'):
            $url .= '/emaPrint';
            break;
        case ($_POST['strategy_value'] == 'startEmaHedge'):
            $url .= '/startEmaHedge';
            $data = json_encode(array('interval' => $_POST['interval']));
            break;
        case ($_POST['strategy_value'] == 'stopEmaHedge'):
            $url .= '/stopEmaHedge';
            break;
        case ($_POST['strategy_value'] == 'startReverseEmaHedge'):
            $url .= '/startReverseEmaHedge';
            break;
        case ($_POST['strategy_value'] == 'stopReverseEmaHedge'):
            $url .= '/stopReverseEmaHedge';
            break;
        case ($_POST['strategy_value'] == 'startManualHedge'):
            $url .= '/startManualHedge';
            break;
        case ($_POST['strategy_value'] == 'stopManualHedge'):
            $url .= '/stopManualHedge';
            break;
        case ($_POST['strategy_value'] == 'startManualHedgeReverse'):
            $url .= '/startManualHedgeReverse';
            break;
        case ($_POST['strategy_value'] == 'stopManualHedgeReverse'):
            $url .= '/stopManualHedgeReverse';
            break;
        case ($_POST['cancel_close_all'] == 'cancelAll'):
            $url .= '/cancelAll';
            break;
        case ($_POST['cancel_close_all'] == 'closeAll'):
            $url .= '/closeAll';
            $data = '';
            break;
        case ($_POST['kill_all'] == 1):
            $url .= '/panic';
            break;
        case ($_POST['buy_sell'] == 'sell'):
            $url .= '/sellMarket';
            $data = json_encode(array('qty' => $_POST['qty']));
            break;
        case ($_POST['buy_sell'] == 'buy'):
            $url .= '/buyMarket';
            $data = json_encode(array('qty' => $_POST['qty']));
            break;
        case ($_POST['buy_sell_stop'] == 'buyStop'):
            $url .= '/buyStop';
            $data = json_encode(array('qty' => $_POST['qty'], 'price' => $_POST['price']));
            break;
        case ($_POST['buy_sell_stop'] == 'sellStop'):
            $url .= '/sellStop';
            $data = json_encode(array('qty' => $_POST['qty'], 'price' =>  $_POST['price']));
            break;
        case ($_POST['buy_sell_limit'] == 'buyLimit'):
            $url .= '/buyLimit';
            $data = json_encode(array('qty' => $_POST['qty'], 'price' =>  $_POST['price']));
            break;
        case ($_POST['buy_sell_limit'] == 'sellLimit'):
            $url .= '/sellLimit';
            $data = json_encode(array('qty' => $_POST['qty'], 'price' =>  $_POST['price']));
            break;
            //send strategy value to the server
        case ($_POST['strategy_value'] == ' '):
            $url .= '/startEmaHedge';
            $data = json_encode(array('qty' => $_POST['qty'], 'price' =>  $_POST['price']));
            break;
    }

    // Sende den ersten Request
    $jsonString = sendCurlRequest($url, $data);

    echo $jsonString;
}
// r.POST("/startEmaHedge", controller.StartEmaHedge)
// r.GET("/stopEmaHedge", controller.StopEmaHedge)
// r.GET("/startReverseEmaHedge", controller.StartReverseEmaHedge)
// r.GET("/stopReverseEmaHedge", controller.StopReverseEmaHedge)
// r.GET("/startManualHedge", controller.StartManualHedge)
// r.GET("/stopManualHedge", controller.StopManualHedge)
// r.GET("/startManualHedgeReverse", controller.StartManualHedgeReverse)
// r.GET("/stopManualHedgeReverse", controller.StopManualHedgeReverse)
// r.GET("/emaPrint", controller.EmaPrint)
// r.GET("/panic", controller.Panic)
// r.GET("/cancelAll", controller.CancelAll)
// r.GET("/closeAll", controller.CloseAll)
// r.POST("/buyMarket", controller.MarketBuy)
// r.POST("/sellMarket", controller.MarketSell)
// r.POST("/buyLimit", controller.LimitBuy)
// r.POST("/sellLimit", controller.LimitSell)
// r.POST("/buyStop", controller.BuyStopLoss)
// r.POST("/sellStop", controller.SellStopLoss)
// r.GET("/startEmaHedgeInfo", controller.GetEmaHedgeStatus)
// r.GET("/getActiveStrategies", controller.GetActiveStrategy)
