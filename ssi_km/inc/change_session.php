<?php
session_start ();
if ($_POST ['year'])
	$_SESSION ['SetYear'] = $_POST ['year'];

if ($_POST ['car_id'])
	$_SESSION ['car_id'] = $_POST ['car_id'];