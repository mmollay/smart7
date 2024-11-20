<?
//Check ob Datenbanksatz bereits existiert
$exist_query = $GLOBALS['mysqli']->query ("SELECT * from tbl_user_paneon WHERE client_id = '{$_POST['ID']}'") or die(mysqli_error());
$exist_array       = mysqli_fetch_array($exist_query);
$check_client_id  = $exist_array['client_id'];
if ($check_client_id) {
	$_POST['client_id'] = $check_client_id;
	$msg =  'ok';
	$updated_user++;
}
else {
	$msg = 'ok new';
	$new_user++;
}

$name_array = explode(" ",$_POST['Name']);
$_POST['Nachname'] = $name_array[0];
$_POST['Vorname'] = $name_array[1];

//Umwandeln des "," auf "." für das speichern in der Datenbank
$array_change_komma = array(
		EiPunkte,
		KuPunkte,
		PlPunkte,
		SrPunkte,
		IpPunkte,
		Rabatt,
		DifProv,
		BalProv,
		InProv,
		Auszahlg,
		GuthabenNeu,
		GuthabenAlt,
		AuszahlgAb,
		EiUmsatz,
		KuUmsatz,
		PlUmsatz,
		SRumsatz,
		IPumsatz,
		IkUmsatz,
		IkPunkte);

foreach ($array_change_komma as $value ) {
	$_POST[$value] = preg_replace("/\,/",".",$_POST[$value] );
}

$sql = "REPLACE INTO tbl_user_paneon SET
client_id = '{$_POST['ID']}',
user_id   = '{$_SESSION['user_id']}',
TurnOverID = '{$_POST['TurnOverID']}',
BetreuerID = '{$_POST['BetreuerID']}',
BetrLevel = '{$_POST['BetrLevel']}',
BetrAst = '{$_POST['BetrAst']}',
InitiatorID = '{$_POST['InitiatorID']}',
InitLevel = '{$_POST['InitLevel']}',
ActiveVorgID = '{$_POST['ActiveVorgID']}',
ActiveVorgLevel = '{$_POST['ActiveVorgLevel']}',
InactVorgID = '{$_POST['InactVorgID']}',
InactVorgLevel = '{$_POST['InactVorgLevel']}',
VorgStatus = '{$_POST['VorgStatus']}',
FaPart = '{$_POST['FaPart']}',
Level = '{$_POST['Level']}',
Ast = '{$_POST['Ast']}',
Anrede = '{$_POST['Anrede']}',
Titel = '{$_POST['Titel']}',
Strasse= '{$_POST['Strasse']}',
PLZ= '{$_POST['PLZ']}',
Ort= '{$_POST['Ort']}',
Land= '{$_POST['Land']}',
Nachname  = '{$_POST['Nachname']}',
Vorname   = '{$_POST['Vorname']}',
IBAN= '{$_POST['IBAN']}',
BIC = '{$_POST['BIC']}',
BankdatenOK = '{$_POST['BankdatenOK']}',
Email = '{$_POST['Email']}',
Tel = '{$_POST['Tel']}',
VatNumber = '{$_POST['VatNumber']}',
EiUmsatz = '{$_POST['EiUmsatz']}',
KuUmsatz = '{$_POST['KuUmsatz']}',
PlUmsatz = '{$_POST['PlUmsatz']}',
SRumsatz = '{$_POST['SRumsatz']}',
IPumsatz = '{$_POST['IPumsatz']}',
IkUmsatz = '{$_POST['IkUmsatz']}'
";

$sql2 = "REPLACE INTO tbl_user_details SET
AbrechnNrID = '{$_POST['AbrechnNrID']}',
client_id   = '{$_POST['ID']}',
ProvPLan = '{$_POST['ProvPLan']}',
EiPunkte = '{$_POST['EiPunkte']}',
KuPunkte = '{$_POST['KuPunkte']}',
PlPunkte = '{$_POST['PlPunkte']}',
SrPunkte = '{$_POST['SrPunkte']}',
IpPunkte = '{$_POST['IpPunkte']}',
Rabatt = '{$_POST['Rabatt']}',
DifProv = '{$_POST['DifProv']}',
BalProv = '{$_POST['BalProv']}',
InProv = '{$_POST['InProv']}',
Auszahlg = '{$_POST['Auszahlg']}',
GuthabenNeu = '{$_POST['GuthabenNeu']}',
GuthabenAlt = '{$_POST['GuthabenAlt']}',
AuszahlgAb = '{$_POST['AuszahlgAb']}',
ProvisionInfo = '{$_POST['ProvisionInfo']}',
EiUmsatz = '{$_POST['EiUmsatz']}',
KuUmsatz = '{$_POST['KuUmsatz']}',
PlUmsatz = '{$_POST['PlUmsatz']}',
SRumsatz = '{$_POST['SRumsatz']}',
IPumsatz = '{$_POST['IPumsatz']}',
IkUmsatz = '{$_POST['IkUmsatz']}',
IkPunkte = '{$_POST['IkPunkte']}'
";

mysql_query($sql) or die(mysqli_error());
mysql_query($sql2) or die(mysqli_error());
?>