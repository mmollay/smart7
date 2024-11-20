<?php
/*
 * mm@ssi.at am 13.02.2019
 * Diese Funktion wandelt Arrays in einem Text um
 */
$array['vorname'] = 'Martin';
$array['nachname'] = 'Mollay';

$text = "Hallo %vorname% Ich bin froh, dass du %nachname% als deinen Nachnamen hast :) ";

echo preg_replace_callback('/%(\w+)%/', function($matches){ global $array; return $array[$matches[1]]; }, $text);