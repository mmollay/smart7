<?php
if ($_POST['product_id']) {
	echo file_get_contents ( "https://www.amazon.de/dp/{$_POST['product_id']}" );
} else
	echo "error";
// echo file_get_contents("https://www.amazon.de/Lotuscrafts-Meditationsmatte-ZABUTON-Baumwolle-zertifiziert/dp/B005Q6S97E");
// echo file_get_contents("https://www.amazon.de/KlarGeist-Meditationskissen-Yogakissen-Ungelinkige-Zen-Kissen/dp/B00U7GC2NU/ref=pd_sim_200_7?_encoding=UTF8&psc=1&refRID=364WZ22JTHGRV5QBNVW7");
?>