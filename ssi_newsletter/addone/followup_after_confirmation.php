<?php
$contact_id = '99';
$show_test_output = true;
include ('../inc_followup/generate_new_session.php');
// Testuser
//prüft Tags des Users und sucht in Followup nach Übereinstimmung
echo "<a href='index.php'>Zur&uuml;ck</a><hr>";
echo "Session f&uuml;r contact_id=$contact_id wurde erzeugt";