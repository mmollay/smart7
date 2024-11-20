<?

//Schreige 100 Survivaltips in ein Array aus dem Internet und gib diese in einer Schleife aus

$handle = fopen("survivaltips.txt", "r");    
//Arufen eines Survivaltipps aus der txt Datei per Zufall
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $survivaltips[] = $line;
    }
    fclose($handle);
} else {
    // error opening the file.
}

//Ausgabe eines Survivaltipps
$output =  $survivaltips[array_rand($survivaltips)];

?>
<!--    Schöner dargestellt durch CSS, Schrift in Blau     -->
<style>

body {
    background-color: lavender;
    
    font-family: Arial, Helvetica, sans-serif;
    font-size: 1.5em;
    text-align: center;
}
</style>

<HTML>
<HEAD>Survivaltipps</HEAD>
<BODY>  
    <br><br>
<?php echo $output; ?>
</BODY>
</HTML>