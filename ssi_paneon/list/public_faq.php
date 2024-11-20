<?php


// Aufruf aller TAGS
function call_array_faq_tags() {
    $mysql_query = $GLOBALS ['mysqli']->query ( "
	SELECT tag.tag_id tag_id, tag.title, tag.color, COUNT(IF(faq.faq_id,1,null)) count FROM ssi_paneon.tag
		LEFT JOIN (ssi_paneon.faq2tag, ssi_paneon.faq) ON (faq.faq_id = faq2tag.faq_id AND faq2tag.tag_id = tag.tag_id)
		GROUP BY tag.tag_id
			ORDER BY tag.title
	" ) or die ( mysqli_error ( $GLOBALS ['mysqli'] ) );
    
    while ( $mysql_fetch = mysqli_fetch_array ( $mysql_query ) ) {
        $tag_id = $mysql_fetch ['tag_id'];
        
        $tag_name = "";
        if ($mysql_fetch ['color'])
            $tag_name .= "<a class='ui " . $mysql_fetch ['color'] . " empty circular label'>d</a>";
            
            $tag_name .= $mysql_fetch ['title'] . " (" . $mysql_fetch ['count'] . ")";
            $tag_array [$tag_id] = "$tag_name";
    }
    return $tag_array;
}


$arr ['mysql'] = array ('table' => 'ssi_paneon.faq 
        LEFT JOIN ssi_paneon.faq2tag ON faq.faq_id = faq2tag.faq_id
        LEFT JOIN ssi_paneon.faq2category ON faq.faq_id = faq2category.faq_id',
		'field' => "faq.faq_id faq_id, title, question, DATE(timestamp) timestamp, tag_id,
		if (image > '', CONCAT ('<div align=\"center\"><img style=\"object-fit: cover;  max-width:150px; height:150px;\" class=\"ui image medium bordered rounded image\" src=\" ',image,'\"></div>'),'Kein Bild') image,
        CONCAT ('<span class=\'ui header\'>',question,'</span><br>',SUBSTRING_INDEX(`answer`, ' ', 10)) question	
		",'order' => '','limit' => 50,'group' => 'faq.faq_id','like' => 'title,question,answer' );


$arr ['list'] = array ('id' => 'faq_list','width' => '1200px','size' => '','class' => 'very basic selectable','header' => false ); //selectable
$arr ['list'] ['serial'] = false;
//$arr ['list'] ['template'] = '{title}<br>{problem}';

//$arr ['top'] ['button'] ['share_link'] = array ('title' => 'Seite Teilen','icon' => 'share alternate','href' => '','target' => 'new','popup' => 'Link','class' => 'blue' );

$arr ['filter'] ['category_id'] = array ('type' => 'dropdown','array' => $array_category,'placeholder' => '-- Alle Kategorien --' );
//$arr ['filter'] ['category'] = array ('type' => 'dropdown','array' => call_array_report_catogary(),'placeholder' => '-- Alle Kategorien --' );
$arr ['filter'] ['tag_id'] = array ('type' => 'dropdown','array' => call_array_faq_tags(),'placeholder' => '--Alle Tags --','class' => '' );

$arr ['order'] = array ("array" => array ('timestamp desc' => 'Neueste Beiträge zuerst','title ' => 'Nach ABC sortiert','age ' => 'Nach Alter sortiert' ),'default' => 'timestamp desc' );

$arr ['th'] ['image'] = array ('title' => "",'align'=>'center' );
//$arr ['th'] ['title'] = array ('title' => "Titel", );
$arr ['th'] ['question'] = array ('title' => "Frage", );


//$arr ['tr'] ['buttons'] ['right'] = array ('class' => 'tiny' );
//$arr ['tr'] ['button'] ['right'] ['share_link'] = array ('title' => '','icon' => 'share alternate','class' => 'blue','popup' => 'Teilen' );
//$arr ['tr'] ['button'] ['right'] ['page'] = array ('href'=>'page.php?id={report_id}','title' => '','icon' => 'file','popup' => 'Page', 'align'=>'center', 'target' =>'new' );
$arr ['flyout'] ['modal_form_detail'] = array ('title' => 'Erfahrungsbericht {title}','url' => 'form_detail.php','class' => 'fullscreen' ); //overlay
$arr ['modal'] ['modal_form_detail'] = array ('title' => 'Erfahrungsbericht {title}','url' => 'form_detail.php','class' => 'fullscreen' ); //overlay
//$arr ['modal'] ['share_link'] = array ('title' => 'Share Link','url' => 'share_link.php?share_id={id}','class' => 'small','focus' => true );
$arr ['modal'] ['modal_form_detail'] ['button'] ['cancel'] = array ('title' => 'Schließen','color' => 'green','icon' => 'close' );