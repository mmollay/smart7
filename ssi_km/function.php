<?php
/**
 * date_german2mysql
 * wandelt ein traditionelles deutsches Datum
 * nach MySQL (ISO-Date).
 */
function date_german2mysql($datum) {
	list($tag, $monat, $jahr) = explode(".", $datum);

	return sprintf("%04d-%02d-%02d", $jahr, $monat, $tag);
}

/**
 * date_mysql2german
 * wandelt ein MySQL-DATE (ISO-Date)
 * in ein traditionelles deutsches Datum um.
 */
function date_mysql2german($datum) {
	list($jahr, $monat, $tag) = explode("-", $datum);

	return sprintf("%02d.%02d.%04d", $tag, $monat, $jahr);
}

function nr_format($wert){
	if ($wert) {
		$wert = number_format($wert, 2, '.', '');
		return preg_replace("/\./",',',$wert);
	}
}