<?
$setMenu .= "<div style='position:relative; left:6px;' class='ui vertical fluid tabular menu'>";

if ($_SESSION['company'] == 'ssi') {
	$setMenu .= "<a class='item' id=companylist> <i class='icon building'></i>Unternehmen</a>";
} 

else if ($_SESSION['company'] == 'uni') {
	$setMenu .= "<a class='item' id=companylist> <i class='icon building'></i>Unternehmen</a>";
	$setMenu .= "<a class='item' id=constructor><i class='browser icon'></i>Constructor</a>";
}

$setMenu .= "<a class='item' id=userlist><i class='users icon'></i>User</a>";
$setMenu .= "<a class='item' id=domain><i class='world icon'></i>Domains</a>";

if ($_SESSION['company'] == 'ssi') {
	$setMenu .= "<a class='item' id=ftp><i class='plug icon'></i>Ftp</a>";
}

//$setMenu .= "<a class='item' id=smart><i class='world icon'></i>SmartKit</a>";

$setMenu .= "<a class='item' id=templates><i class='block layout icon'></i>Vorlagen</a>";
$setMenu .= "<a class='item' id=profiles><i class='privacy icon'></i>Rechte</a>";

if ($_SESSION['company'] == 'ssi') {
	$setMenu .= "<hr>";
	$setMenu .= "<a class='item' id=organigramm><i class='sitemap icon'></i>Organigramm</a>";
	$setMenu .= "<a class='item' id=constructor><i class='browser icon'></i>Constructor</a>";
	
}


$setMenu .= "</div>";


?>