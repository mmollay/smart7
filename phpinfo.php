<?php
echo "eval";
$string = 'Bierglas';
$name = 'Binding-Lager';
$str = 'Das ist mein $string, voll mit $name.';
echo $str . "\n";
eval ("\$str = \"$str\";");
echo $str . "\n";


echo "<br>";
echo "base64 deaktiviert";
$str = 'RGllcyBpc3QgZWluIHp1IGtvZGllcmVuZGVyIFN0cmluZw==';
echo base64_decode($str);

phpinfo();