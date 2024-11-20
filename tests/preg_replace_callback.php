<?php

$text = "das ist ein {firstname} test {plz} {} {secondname} ";
$array2['firstname'] = 'martin';
$array2['secondname'] = 'mollay';
$array2['plz'] = '';

//OLD PHP 5
//$text = preg_replace ( '!{(.*?)}!e', '$array[ \1 ]', $text );
//NEW > PHP 5.5
//$text = preg_replace_callback('!{(.*?)}!', function($matches){ global $array; return $array[$matches[1]]; }, $text);


function change ($text,$array) {
	return preg_replace_callback('!{(.*?)}!', function($matches){ global $array2; return $array2[$matches[1]]; }, $text);
}


//echo $text;
//echo "<hr>";
echo change ($text,$array);

echo "<hr>";

$string = "{1} and {2} have apples.";
$replacements = array(1=>'Mary',3=>'Jane');
echo preg_replace_callback('!{(.*?)}!', function($matches) use (&$replacements) {
	return array_shift($replacements);
}, $string);


exit;