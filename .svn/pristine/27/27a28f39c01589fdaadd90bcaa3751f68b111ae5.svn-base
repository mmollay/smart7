<?php
if ($_POST['update_id']) {

    // call groups for the User
    $mysql_tag_query = $GLOBALS['mysqli']->query("SELECT * FROM ssi_paneon.faq2tag where faq_id = '{$_POST['update_id']}' "); // and activate='1'
    while ($mysql_tag_fetch = mysqli_fetch_array($mysql_tag_query)) {
        $tag_id = $mysql_tag_fetch['tag_id'];
        $tag_name = $mysql_tag_fetch['title'];
        $tag_color = $mysql_tag_fetch['color'];
        $tag_selected_array[] = $tag_id;
    }

    // call groups for the User
    $mysql_category_query = $GLOBALS['mysqli']->query("SELECT * FROM ssi_paneon.faq2category where faq_id = '{$_POST['update_id']}' "); // and activate='1'
    while ($mysql_category_fetch = mysqli_fetch_array($mysql_category_query)) {
        $category_id = $mysql_category_fetch['category_id'];
        $category_name = $mysql_category['title'];
        $categoryg_color = $mysql_category_fetch['color'];
        $category_selected_array[] = $category_id;
    }
    
}

$arr['sql'] = array('query' => "SELECT * from ssi_paneon.faq WHERE faq_id = '{$_POST['update_id']}' ");

$arr['ajax'] = array('onLoad' => "call_add_tag('tag_id');",'success' => "if (data == 'ok') { $('.ui.modal').modal('hide'); table_reload(); } else  { alert('Error: f_faq.php'); }	",'dataType' => "html");
// $arr ['tab'] = array ('tabs' => array (1 => 'Default',2 => 'More' ),'active' => '1' );

$arr['field']['category'] = array('tab' => '1','type' => 'multiselect','label' => 'Kategorie','array' => $array_category ,'value' => $category_selected_array );
$arr['field']['image'] = array('tab' => '1','type' => 'finder','label' => 'Bild');

$arr['field'][] = array('tab' => '1','type' => 'div','class' => 'fields ui message'); // 'label'=>'test'
$arr['field']['tags'] = array('tab' => '1','label' => 'Ausgewählte Tags','class' => 'eleven wide search','type' => 'multiselect','array' => call_array_report_tags(),'value' => $tag_selected_array);
$arr['field']['new_tag'] = array('tab' => '1','type' => 'input','label' => 'Neuen Tag','class' => 'five wide','label_left' => "<i class='icon arrow left'></i> Anlegen",'label_left_class' => 'button orange ui');
$arr['field'][] = array('tab' => '1','type' => 'div_close');

//$arr['field'][] = array('type' => 'div','class' => 'fields');
//$arr['field']['title'] = array('class' => 'wide eleven','type' => 'input','label' => 'Bezeichnung','focus' => true);

// $arr['field']['color'] = array('class' => 'wide five','type' => 'dropdown','label' => 'Farbe','array' => 'color','set_color' => true);
//$arr['field'][] = array('type' => 'div_close');

$arr['field']['question'] = array('type' => 'ckeditor','label' => 'Frage');
$arr['field']['answer'] = array('type' => 'ckeditor','label' => 'Antwort');
