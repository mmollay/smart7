<?
include ("mysql_faktura.inc.php");

// Filter zurücksetzen
$mysql_list_filter = '';

if ($_POST['SetYear'])
	$_SESSION['SetYear'] = $_POST['SetYear'];
	// SET YEAR for FAKTURA mm@ssi.at 19.05.2012
$SetYear = $_SESSION['SetYear'];

// SET Month mm@ssi.at 10.01.2014
$SetMonth = $_SESSION['SetMonth'];

if ($SetYear == 'all')
	$add_mysql_filter_year = '';
else
	$add_mysql_filter_year = "AND DATE_FORMAT(date_create,'%Y') = '{$_SESSION['SetYear']}'";

if ($SetMonth == 'all')
	$add_mysql_filter_year .= '';
else
	$add_mysql_filter_year .= "AND DATE_FORMAT(date_create,'%m') = '{$_SESSION['SetMonth']}'";

/**
 * ********************************************
 * BILLS
 * ********************************************
 */
if ($_SESSION['filter_table'] == 'bills') {
	
	if (! $_SESSION['list_filter'])
		$_SESSION['list_filter'] = 1;
	
	if ($_SESSION['list_filter'] == 1) {
		$mysql_list_filter = "";
		$mysql_list_filter_bill = "and date_storno = '0000-00-00' ";
	}  // Alle Rechnungen auch Stornorechnungen
else if ($_SESSION['list_filter'] == 8) {
		$mysql_list_filter = "";
		$mysql_list_filter_bill = "";
	} else if ($_SESSION['list_filter'] == 2) {
		$mysql_list_filter = "and date_booking = '0000-00-00' ";
		$mysql_list_filter_bill = "and date_storno = '0000-00-00' ";
	} else if ($_SESSION['list_filter'] == 3) {
		$mysql_list_filter = "and date_booking != '0000-00-00' ";
		$mysql_list_filter_bill = "and date_storno = '0000-00-00' ";
	} else if ($_SESSION['list_filter'] == 4) {
		$mysql_list_filter = "and date_remind < NOW() and date_booking = '0000-00-00' and remind_level != 0 ";
		$mysql_list_filter_bill = "and date_storno = '0000-00-00' ";
	}  // Noch nicht versendete Rechungen
else if ($_SESSION['list_filter'] == 5) {
		$mysql_list_filter = "and remind_level = 0 and date_booking = '0000-00-00' ";
		$mysql_list_filter_bill = "and date_storno = '0000-00-00' ";
	}  // Inkassofälle
else if ($_SESSION['list_filter'] == 6) {
		$mysql_list_filter = "and remind_level = 4 and date_remind < NOW() and date_booking = '0000-00-00' ";
		$mysql_list_filter_bill = "and date_storno = '0000-00-00' ";
	}  // Stornierte Rechnungen
else if ($_SESSION['list_filter'] == 7) {
		$mysql_list_filter_bill = "and date_storno != '0000-00-00' ";
	}  // Rechnungen mit Nettosumme 0
else if ($_SESSION['list_filter'] == 9) {
		$mysql_list_filter_bill = "and netto = '0.000' ";
	}  // Rechnungen ohne Mailadresse
else if ($_SESSION['list_filter'] == 10) {
		$mysql_list_filter_bill = "and email = '' ";
	}  // Rechnungen mit Mailadresse
else if ($_SESSION['list_filter'] == 11) {
		$mysql_list_filter_bill = "and email != '' ";
	}  // Teilverbuchte Rechnungen
else if ($_SESSION['list_filter'] == 12) {
		$mysql_list_filter_bill = "and (ROUND(booking_total,2) != ROUND(brutto,2)) and date_booking != '0000-00-00'";
	}  // verbuchte Rechnung des aktuellen Jahres anzeigen aus der Vergangenheit
else if ($_SESSION['list_filter'] == 13) {
		$mysql_list_filter_bill = "and DATE_FORMAT(date_booking,'%Y') = '" . date ( Y ) . "' ";
	}  // Rechungen ohne Kundennummer
else if ($_SESSION['list_filter'] == 20) {
		$mysql_list_filter_bill = "and client_id = 0 ";
	}
} /*
   * CLIENTS
   */
elseif ($_SESSION['list_filter'] and $_SESSION['filter_table'] == 'client') {
	
	if ($_SESSION['list_filter'] == 1)
		$mysql_list_filter = "";
	else if ($_SESSION['list_filter'] == 2)
		// $mysql_list_filter = "and activ = 1 ";
		$mysql_list_filter = "AND (DATE_FORMAT(date_membership_start,'%Y') <= $year AND (DATE_FORMAT(date_membership_stop,'%Y-%m-%d') >= NOW() OR date_membership_stop = 0000-00-00))";
	else if ($_SESSION['list_filter'] == 3) {
		$mysql_list_filter = "AND !(DATE_FORMAT(date_membership_start,'%Y') <= $year AND (DATE_FORMAT(date_membership_stop,'%Y-%m-%d') >= NOW() OR date_membership_stop = 0000-00-00))";
	} else if ($_SESSION['list_filter'] == 4)
		$mysql_list_filter = "and brutto > '' ";
	else if ($_SESSION['list_filter'] == 5) {
		$mysql_list_filter = "and ROUND(brutto,2) != ROUND(booking_total,2) ";
	}  // $mysql_list_orderby =" ORDER BY amound_open DESC"; }
	else if ($_SESSION['list_filter'] == 6) {
		$mysql_list_filter = "AND (DATE_FORMAT(date_membership_start,'%Y') <= $year AND (DATE_FORMAT(date_membership_stop,'%Y-%m-%d') >= NOW() OR date_membership_stop = 0000-00-00))";
		$mysql_list_filter .= "and newsletter=1 ";
	}
	else if ($_SESSION['list_filter'] == 7) {
                $mysql_list_filter = "AND (DATE_FORMAT(date_membership_start,'%Y') <= $year AND  date_membership_stop = 0000-00-00 )";
                //$mysql_list_filter = "AND (DATE_FORMAT(date_membership_start,'%Y') <= $year+1 AND (DATE_FORMAT(date_membership_stop,'%Y-%m-%d') >= NOW()) )";
        }

}

/*
 * Article GROUP
 */
elseif ($_SESSION['list_filter'] and $_SESSION['filter_table'] == 'article_group') {
	if ($_SESSION['list_filter'] == 'all') {
		$mysql_list_filter = '';
	} else {
		$mysql_list_filter = "and article2group.group_id= {$_SESSION['list_filter']}";
		$mysql_list_filter2 = "INNER JOIN article2group ON article_temp.temp_id = article2group.article_id";
	}
} 


/*
 * ACHTUNG
 * BOOLEAN MODE GEHT NICHT bei INT
 */
if ($_SESSION['list_search']) {
	// deactivate Case sensitiv
	$_SESSION['list_search'] = strtolower ( $_SESSION['list_search'] );
	
	if ($_SESSION['filter_table'] == 'bills') {
		
		if (ereg ( '^[0-9,]+$', $_SESSION['list_search'] )) {
			$_SESSION['list_search'] = preg_replace ( "/,/", ".", $_SESSION['list_search'] );
		}
		
		// $mysql_list_filter .= "and MATCH(company_1,firstname,secondname,zip,city,bill_number,client_number,netto,brutto) AGAINST ('*{$_SESSION['list_search']}*' IN BOOLEAN MODE)";
		$mysql_list_filter .= "
		and (
		company_1 Like '%{$_SESSION['list_search']}%'
		or firstname Like '%{$_SESSION['list_search']}%'
		or secondname Like '%{$_SESSION['list_search']}%'
		or bill_number Like '{$_SESSION['list_search']}'
		or client_number Like '{$_SESSION['list_search']}'
		or netto Like '{$_SESSION['list_search']}%'
		or brutto Like '{$_SESSION['list_search']}%'
		or city Like '{$_SESSION['list_search']}%'
		or street Like '{$_SESSION['list_search']}%'
		or zip Like '{$_SESSION['list_search']}%'
		or email Like '{$_SESSION['list_search']}%'

		)";
		// or netto Like '{$_SESSION['list_search']}'
		// or brutto Like '{$_SESSION['list_search']}'
	} elseif ($_SESSION['filter_table'] == 'issues') {
		$mysql_list_filter .= "
		and (MATCH(description,company_1) AGAINST ('{$_SESSION['list_search']}*' IN BOOLEAN MODE)
		or bill_number Like '{$_SESSION['list_search']}'
		)";
	} elseif ($_SESSION['filter_table'] == 'client') {
		$mysql_list_filter .= "and ( " . // MATCH(client.company_1,client.company_2,client.firstname,client.secondname,client.city,client.email) AGAINST ('{$_SESSION['list_search']}*' IN BOOLEAN MODE)
" client.client_number Like '{$_SESSION['list_search']}'
				or client.firstname Like '%{$_SESSION['list_search']}%'
				or client.company_1 Like '%{$_SESSION['list_search']}%'
				or client.company_2 Like '%{$_SESSION['list_search']}%'
				or client.secondname Like '%{$_SESSION['list_search']}%'
				or client.city Like '{$_SESSION['list_search']}%'
				or client.street Like '{$_SESSION['list_search']}%'
				or client.zip Like '{$_SESSION['list_search']}%'
				or client.email Like '{$_SESSION['list_search']}%'
				or client.delivery_company1 Like '%{$_SESSION['list_search']}%'
				or client.delivery_company2 Like '%{$_SESSION['list_search']}%'
				or client.delivery_secondname Like '%{$_SESSION['list_search']}%'
				or client.delivery_city Like '{$_SESSION['list_search']}%'
				or client.delivery_street Like '{$_SESSION['list_search']}%'
				or client.delivery_zip Like '{$_SESSION['list_search']}%'
				)";
	} elseif ($_SESSION['filter_table'] == 'article_group') {
		$mysql_list_filter .= "and MATCH(art_title, accounts.title , format) AGAINST ('{$_SESSION['list_search']}*' IN BOOLEAN MODE)";
	} elseif ($_SESSION['filter_table'] == 'accounts') {
		$mysql_list_filter .= "and MATCH(title) AGAINST ('{$_SESSION['list_search']}*' IN BOOLEAN MODE)";
	}
}

if ($_SESSION['filter_section']) {
	$mysql_list_filter .= "AND sections.section_id = '" . $_SESSION['filter_section'] . "' AND ( sections.date_sections_stop > NOW() or sections.date_sections_stop = '0000-00-00') ";
	//$mysql_list_filter .= "AND sections.section_id = '" . $_SESSION['filter_section'] . "'";
	//echo "test";
}

if ($_SESSION['filter_membership']) {
	//$mysql_list_filter .= "AND membership_id = '" . $_SESSION['filter_membership'] . "' AND (date_membership_stop > NOW() or date_membership_stop = '0000-00-00')";
	$mysql_list_filter .= "AND membership_id = '" . $_SESSION['filter_membership'] . "'";
}

// CLIENT
// NOCH einbauen and date_storno != '0000-00-00'
// echo $mysql_list_filter;
$array_client = array ( table => "client
		LEFT JOIN bills ON client.client_id = bills.client_id
		LEFT JOIN membership ON client.client_id = membership.client_id
		LEFT JOIN sections ON client.client_id = sections.client_id" , 
		table_main => 'client' , 
		where => "client.company_id = '{$_SESSION['company_id']}' $mysql_list_filter" , 
		group => 'client.client_id' , 
		indexColumn => 'client.client_id' , 
		indexFieldId => 'client_id' , 
		
		fields => "
		client.client_number client_number, 
		abo, client.company_1 company_1,client.firstname firstname,client.secondname secondname,
		IF ((SELECT COUNT(*) FROM membership WHERE DATE_FORMAT(date_membership_start,'%Y') <= $year AND (DATE_FORMAT(date_membership_stop,'%Y-%m-%d') >= NOW()  OR date_membership_stop = 0000-00-00) AND client_id = client.client_id),'<div class=icon_hakerl>&#10004;</div>','') activ2,
		client.email email, newsletter,
		client.zip zip, client.city city, client.birth birth, send_date, client.post post,
		if (delivery_city != '', CONCAT (client.city,' <div class=set_tooltip title=\'',delivery_company1,'<br>',delivery_zip,' ',delivery_city,'\'>[Liefer]</div>'),client.city) city,
		client.company_1, client.client_id, client.company_id,
		ROUND((SELECT SUM(brutto) FROM bills WHERE bills.client_id = client.client_id AND date_storno = '0000-00-00'),2) brutto,
		ROUND((SELECT SUM(booking_total) FROM bills WHERE bills.client_id = client.client_id AND date_storno = '0000-00-00'),2) booking_total,
		ROUND((SELECT SUM(brutto ) - SUM( booking_total ) FROM bills WHERE bills.client_id = client.client_id AND date_storno = '0000-00-00'),2) amound_open,
		if (client.tel, CONCAT('<button class=client_info title=\"Tel:',client.tel,'\">Info</button>'),'') info
		" );


		//IF ((SELECT COUNT(*) FROM membership WHERE DATE_FORMAT(date_membership_start,'%Y') <= $year AND (DATE_FORMAT(date_membership_stop,'%Y') >= date('%Y') OR date_membership_stop = 0000-00-00) AND client_id = client.client_id),'<div class=icon_hakerl>&#10004;</div>','') activ2,


$array_mysql_group = array ( table => 'article_group' , where => "company_id = '{$_SESSION['company_id']}' " , indexColumn => 'group_id' );

/*
 * todoliste 
 */
$array_mysql_todo = array ( table => 'todo' , 
		// where => "company_id = '{$_SESSION['company_id']}' ",
		indexColumn => 'todo_id' , 
		order_by => 'finished_date, todo_date, todo_id' , 
		fields => "
		finished_date, todo_date todo_date_blank,
		(CASE
		WHEN finished_date != '0000-00-00 00:00:00' then CONCAT('<div class=todo_text_finished>',todo_date,'</div>')
		WHEN todo_date < NOW() then CONCAT('<div class=todo_actuel>',todo_date,'</div>')
		ELSE CONCAT('<div class=todo_before>',todo_date,'</div>')
		END) as todo_date,
		if (finished_date = '0000-00-00 00:00:00', text, CONCAT ('<div class=todo_text_finished>',text,'</div>')) text" );

if ($_SESSION['company_all'] == false)
	$add_mysql_set_company = "issues.company_id = '{$_SESSION['company_id']}' ";
else
	$add_mysql_set_company = '1';

$array_issues = array ( // Anzeige aller Inhalte der Konten (fuer Auflistung Steuerberatung)
table => "issues LEFT JOIN accounts ON account = account_id " , 
		table_main => "issues" , 
		where => "$add_mysql_set_company $add_mysql_filter_year $mysql_list_filter " , 
		// where => "1 $add_mysql_filter_year $mysql_list_filter ",
		fields => "
		IF(LENGTH(description) >= 40, CONCAT(substring(description, 1,40), CONCAT('<span class=\'km_info\' title=\'',description,'\'>[...]</span>')), description) description,
		bill_number,company_1,date_create,date_booking,accounts.title title,netto,brutto,issues.tax tax
		" , 
		indexColumn => "bill_id" );

/**
 * ***********************************************
 * ACCOUNT
 * ************************************************
 */

$array_account_in = array ( 
		fields => "accounts.title as title, accounts.tax as tax, netto del_status, account_id,code, accountgroup.title accountgroup,
		(SELECT SUM((bill_details.netto*count)) FROM bill_details INNER JOIN bills ON bill_details.bill_id = bills.bill_id WHERE 1 $add_mysql_filter_year AND account = account_id ) as netto" , 
		table => "accounts LEFT JOIN bill_details ON account = account_id LEFT JOIN accountgroup ON accountgroup.accountgroup_id = accounts.accountgroup_id " , 
		table_main => "accounts" , 
		where => "accounts.company_id = '{$_SESSION['company_id']}' AND accounts.option = 'in' $mysql_list_filter" , 
		indexColumn => "account_id" , 
		group => "account_id" );

$array_account_out = array ( 
		fields => "accounts.title title, accounts.tax,account_id,code, accountgroup.title accountgroup,
		(SELECT SUM(netto) FROM issues WHERE 1 $add_mysql_filter_year and account = account_id) netto,
		(SELECT SUM(brutto) FROM issues WHERE 1 $add_mysql_filter_year and account = account_id) brutto,
		code, netto del_status, afa_400 " , 
		table_main => "accounts" , 
		field_sum => "(SELECT SUM(netto) FROM issues WHERE 1 $add_mysql_filter_year and account = account_id) netto,
		(SELECT SUM(brutto) FROM issues WHERE 1 $add_mysql_filter_year and account = account_id) brutto" , 
		table => "accounts LEFT JOIN issues ON account = account_id LEFT JOIN accountgroup ON accountgroup.accountgroup_id = accounts.accountgroup_id	" , 
		where => "accounts.company_id = '{$_SESSION['company_id']}'  AND accounts.option = 'out' " , 
		indexColumn => "account_id" , 
		group => "account_id" );

/**
 * ***********************************************
 * ACCOUNTGROUP (IN)
 * ************************************************
 */
$array_accountgroup_in = array ( 
		fields => "
		title, accountgroup_id id,
		(SELECT SUM((bill_details.netto * count)) FROM bill_details INNER JOIN bills ON bill_details.bill_id = bills.bill_id INNER JOIN accounts ON account_id = account WHERE 1 $add_mysql_filter_year	 AND accounts.accountgroup_id = id) netto_sum
		" , 
		table => "accountgroup" , 
		table_main => "accountgroup" , 
		where => "user_id = '{$_SESSION['user_id']}' AND `option` = 'in' " , 
		indexColumn => "accountgroup_id" , 
		group => "accountgroup_id" , 
		sum => "
		SELECT SUM((bill_details.netto * count)) netto_sum
		FROM bill_details
		INNER JOIN bills ON bill_details.bill_id = bills.bill_id
		INNER JOIN accounts ON account_id = account WHERE 1 $add_mysql_filter_year" );

/**
 * ***********************************************
 * ACCOUNTGROUP (OUT)
 * ************************************************
 */
$array_accountgroup_out = array ( table => "accountgroup" , table_main => "accountgroup" , where => "user_id = '{$_SESSION['user_id']}' AND `option` = 'out' " , indexColumn => "accountgroup_id" , group => "accountgroup_id" );

/**
 * ***********************************************
 * Bills
 * ************************************************
 */
function mysql_remind_level($level) {
	$button_book = "<button class=button_book onclick=call_booking(',bill_id,')>Verbuchen</button>";
	
	if ($level == 1)
		$button_color = 'yellow';
	if ($level == 2)
		$button_color = 'orange';
	if ($level == 3)
		$button_color = 'red';
	
	if ($level == 4) {
		return "
		WHEN (remind_level > 3 and date_remind > NOW()) then CONCAT('$button_book <span style=color:gray  class=info_text>Inkasso in ',DATEDIFF(date_remind,NOW()) ,' Tagen</span>')
		WHEN remind_level > 3 then CONCAT('$button_book <button class=\'button ui mini red\' onclick=send_pdf(',bill_id,'\,\'\'\,true)>Inkasso seit ',DATEDIFF(NOW(),date_remind) ,' Tagen</button>')
		";
	} else {
		return "
		WHEN (remind_level = $level and date_remind > NOW()) then CONCAT('$button_book <span class=info_text style=color:gray>Mahnstufe ', remind_level,' in ',DATEDIFF(date_remind,NOW()) ,' Tagen </span>')	
		WHEN remind_level = $level then 
			CONCAT('
			$button_book 
			<div class=\'buttons ui mini\'>
			<button class=\'button ui $button_color\' onclick=send_pdf(',bill_id,'\,true) title=\'seit ',DATEDIFF(NOW(),date_remind) ,' Tagen\'>Mahnung ', remind_level,'</button>
			<button class=\'button icon ui tooltip\' onclick=remind_back(',bill_id,') title=\'Mahnung zurücksetzen\' ><i class=\'icon level down\'></i></button>
			</div>
			')
		";
	}
}

// if (!$mysql_list_filter_bill)$mysql_list_filter_bill = "and date_storno = '0000-00-00'";
$array_bills = array ( table => "bills" , 
		where => "company_id = '{$_SESSION['company_id']}' $add_mysql_filter_year $mysql_list_filter $mysql_list_filter_bill" , 
		fields => "bill_number,client_number,date_create,date_booking,date_send,date_remind,remind_level,netto,post,date_booking,firstname,secondname,zip,city,
ROUND(brutto,2) brutto,date_storno,
if (email = '', '',CONCAT('<i class=\'icon mail tooltip\' title=',email,'></i>')) email,	
if (ROUND(booking_total) != ROUND(brutto), ROUND(brutto-booking_total,2),CONCAT('<div style=color:green>0,00</div>')) booking_total,

(CASE
WHEN date_storno != '0000-00-00' then CONCAT('<div class=info_text style=color:red>',date_storno,' (Storno)</div>')
WHEN date_booking != '0000-00-00' then CONCAT('<div class=info_text style=color:green>',date_booking,' (Verbucht)</div>')
WHEN date_send = '0000-00-00' then CONCAT('<button class=\'ui button blue mini\' onclick=send_pdf(',bill_id,') ><i class=\"icon send\"></i> Versenden</button>')
" . mysql_remind_level ( 1 ) . mysql_remind_level ( 2 ) . mysql_remind_level ( 3 ) . mysql_remind_level ( 4 ) . "
END) as send_status,
if (tel, CONCAT('<button class=client_info title=\"Tel:',tel,'\">Info</button>'),'') tel,
(CASE
WHEN LENGTH(company_1) >= 40 then CONCAT(substring(company_1, 1,40), CONCAT('<span class=\'km_info\' title=\'',company_1,'\'>[...]</span>'))
WHEN company_1 = '' then CONCAT (firstname,' ',secondname)
ELSE company_1
END) as company_1
" , 
		indexColumn => "bill_id" );

$_SESSION['mysql_list_filter'] = "$mysql_list_filter $add_mysql_filter_year $mysql_list_filter2 $mysql_list_filter_bill";

/*
 * verbindet sich mit der Datenbank und schliesst die Session wieder
 */
function runSQL($rsql) {
	$result = mysql_query ( $rsql ) or die ( $rsql );
	return $result;
	mysql_close ( $connect );
}

include_once ('functions.inc');

// echo $mysql_list_filter;

?>
