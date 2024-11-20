###Smart-Form v2.x


## Basic Usage - Form

```php
<?php

  #### Configs
  $arr ['smartFormRootPath'] = '/smart_form';   //To use the 'Export' function, please specify the path to the 'smart_form' folder or run it by default from the root: 'localhost/smart_form'.

  #### LIST - Settings
  $arr['list']['id'] = 'contact_list' (used for refresh the list)
  $arr['list']['width'] = 600px (%)
  $arr['list']['align'] = [left|center|right]
  $arr['list']['size'] = [small|large]
  $arr['list']['class'] = 'compact celled striped definition' (http://semantic-ui.com/collections/table.html (more config-parameter)
  $arr['list']['class'] = 'selectable' (hover effect for mouse over)
  $arr['list']['style'] = 'border:1px solid red;'
  $arr['list']['header'] = false //Default => true
  $arr['list']['footer'] = false //Default => true
  $arr['list']['loading_time'] = true; //Anzeige Ladezeit
  $arr['list']['serial'] = false //Fortlaufender Nummerkreislauf wird ausgeblendet
  $arr['list']['hide'] = true | default => false //Blendet eine Liste aus (Bsp.: Wenn eine bestimmte Gruppe gewählt werden soll
  $arr['list']['auto_reload'] = true  // OR array 
  $arr['list']['auto_reload']['checkbox'] = true | false (Default = true)
  $arr['list']['auto_reload']['ckecked'] = true | false (Default = true)
  $arr['list']['auto_reload']['label'] = 'Live Aktualisierung' (Default-Text = 'Auto-Reload' )
  $arr['list']['auto_reload']['loader'] = true | false (Default = true) (Zeigt keinen Loader)
  
  #### SEARCH
  $arr['search']['show_empty'] = true; //Zeigt eine leere Liste an und nur wenn nach etwas gesucht wird
  $arr['search']['hightlight'] = true; //Der Suchtext wird in der Auflistung hervorgehoben
  $arr['search']['class'] = 'fluid'; //Das Inputfeld wird auf die ganze Seite ausgedehnt
  $arr['search']['default_text'] = 'Nach gewünschten Begriff suchen'; //Textanzeige wenn noch kein Suchbegriff eingegeben wurd
  $arr['search']['default_text_notfound'] = 'Es wurden keine Inhalte für den Begriff <b>{data}</b> gefunden.'; //Textanzeige wenn kein Text gefunden wurde
  $arr['search']['strip_tags'] = true; //Textausgabe wird ohne HTML ausgegeben

  #### MYSQL
  $arr['mysql']['query'] = 'SELECT id,field1,field2 FROM table WHERE x = 1'; //(alte Version - wird nicht mehr verwendet)
  $arr['mysql']['table'] = 't1 LEFT JOIN t2 ON t1.id = t2.id
  $arr['mysql']['table_total'] = 't1'; //or whate ever -> important for total-values //Default: '#table'
  $arr['mysql']['field'] = 'id,name,date'; // id should be always first !!!
  $arr['mysql']['export'] = 'id,name;
  $arr['mysql']['charset'] = 'utf8'; // or true
  $arr['mysql']['debug'] = true; //zeigt mysql-string an
  $arr['mysql']['order'] = 'id desc';
  $arr['mysql']['limit'] = 10;
  $arr['mysql']['like'] = 'field1,field2';
  $arr['mysql']['match'] = 'field1,field2';
  $arr['mysql']['group'] => 'id';
  
  ##### DATA instat of mysql 
  $arr['data'] = array('1' => array('first'=>'Martin','second'=>'Mollay')); 
  :
  #### Dropdown - Order BY
  $arr['order']['array'] = array ('article_id desc'=>'Veröffentlicht','price'=>'Peis aufsteigend','price desc'=>'Peis absteigend');
  $arr['order']['class'] = ''; //nur die minimal Darstellung wird angezeigt | search,.....
  $arr['order']['default'] = 'price desc'
  
  #### Flyout - Window
  $arr['flyout']['MODEL_NAME']['title'] = 'Edit contact';
  $arr['flyout']['MODEL_NAME']['url'] = 'form_path.php?id={id}'; //{id}=Platzhalter für die ID
  $arr['flyout']['MODEL_NAME']['class'] = 'small'; // [small|basic|standard|large|fullscreen|overlay fullscreen];
  $arr['flyout']['MODEL_NAME']['class'] = 'scrolling'; // for long "content" scrolling-effect on the bottom with buttos for actions
  $arr['flyout']['MODEL_NAME']['class'] = 'left'; // top|bottom|right
  $arr['flyout']['MODEL_NAME']['hide_close'] = true; //don't show hide button on the top 'X'
  $arr['flyout']['MODEL_NAME']['focus'] = true; //Autofocus einschalten - erstes Feld wird automatisch gewählt (Default = false)
  $arr['flyout']['MODEL_NAME']['button']['cancel'] = array('title'=>'Schließen','color'=>'green', 'icon' => 'eye');
  $arr['flyout']['MODEL_NAME']['button']['more'] = array('title'=>'More', 'onclick' => "alert('test'); );
  $arr['flyout']['MODEL_NAME']['button']['reload'] = array('title'=>'Reload' );
  $arr['flyout']['MODEL_NAME']['button']['submit'] = array('title'=>'Save','form_id' => '[id der form zum auslösen des Submit]' );
  
  
  #### Modal - Window (call Modal for Forms)
  $arr['modal']['MODEL_NAME']['title'] = 'Edit contact';
  $arr['modal']['MODEL_NAME']['url'] = 'form_path.php?id={id}'; //{id}=Platzhalter für die ID
  $arr['modal']['MODEL_NAME']['class'] = 'very wide'; // [thin|very thin|wide|very wide|fullscreen|overlay fullscreen|one-twelve wide];
  $arr['modal']['MODEL_NAME']['class'] = 'scrolling'; // for long "content" scrolling-effect on the bottom with buttos for actions
  $arr['modal']['MODEL_NAME']['hide_close'] = true; //don't show hide button on the top 'X'
  $arr['modal']['MODEL_NAME']['focus'] = true; //Autofocus einschalten - erstes Feld wird automatisch gewählt (Default = false)
  $arr['modal']['MODEL_NAME']['button']['cancel'] = array('title'=>'Schließen','color'=>'green', 'icon' => 'eye');
  $arr['modal']['MODEL_NAME']['button']['more'] = array('title'=>'More', 'onclick' => "alert('test');" );
  $arr['modal']['MODEL_NAME']['button']['submit'] = array('title'=>'Save' );
  $arr['modal']['MODEL_NAME']['button']['reload'] = array('title'=>'Reload'" );
  :
  :
  #### Buttons on the TOP
  $arr['top']['buttons']['class'] = 'tiny, red'; //(Use that, if you want to have a cluster for all buttons)
  $arr['top']['buttons']['group] = true; //set buttons inner Group
  $arr['top']['button']['MODEL_NAME']['id'] = 'ID';
  $arr['top']['button']['MODEL_NAME']['title'] = 'title';
  $arr['top']['button']['MODEL_NAME']['icon'] = 'edit';
  $arr['top']['button']['MODEL_NAME']['class'] = 'mini';
  $arr['top']['button']['MODEL_NAME']['hide'] = true; | default false //Wenn button sporadisch ausgeblendet werden soll
  $arr['top']['button']['MODEL_NAME']['popup'] = 'Click to edit'; 
  $arr['top']['button']['MODEL_NAME']['href']= '{pdf}';  //change site
  $arr['top']['button']['MODEL_NAME']['target']= 'new'; //New Tab
  $arr['top']['button']['MODEL_NAME']['download']= '{art_title}.pdf'; //download ist der Title des downloads (ohne "download" wird seite in einem neuen Fenster geöffnet)
  $arr['top']['button']['MODEL_NAME']['single'] = true; //Button wird entkoppelt
  $arr['top']['button']['MODEL_NAME']['onclick'] = "alert('test');"
  $arr['top']['button']['MODEL_NAME']['onclick'] = "alert('test'+{ID});";
  //tab setzen, content laden
  $arr['top']['button']['MODEL_NAME']['onclick'] = "$('.menu_structure .item').tab('change tab', 'import'); load_content_semantic('newsletter','import');";
  $arr['top']['button']['MODEL_NAME']['filter'] = "SELECT  FROM logfile WHERE error=1"; //(Bsp.)
  
  #### TH_TOP  
  $arr ['tr_top'] = array ('style' => "background-color:red;", 'align'=>'center');
  $arr ['th_top'] [] = array ('title' => "Endwert",'colspan' => '1','align'=>'center'); //oberhalb vom Main TH
  
  #### BUTTON LEFT AND RIGHT
  $arr ['tr_bottom'] = array ('style' => "background-color:red;", 'align'=>'center');
  $arr ['th_bottom'] [] = array ('title' => "Endwert",'colspan' => '1','align'=>'center'); //unterhalb vom Main TH

  #### TH -> MAIN - TH
  $arr['th'][$name]['title'] = 'FieldName';
  $arr['th'][$name]['tooltip'] = 'Beschreibung des Feldes';
  $arr['th'][$name]['info'] = 'Infotext für das Feld';
  $arr['th'][$name]['align'] = [left|center|right]
  $arr['th'][$name]['class'] = [right aligned red] selec'table' => Feld ist klickbar (Vor Text <a href=''>text</a>
  $arr['th'][$name]['class'] = [one|two|.... wide] Column wide
  $arr['th'][$name]['style'] = 'background-color:red;';
  $arr['th'][$name]['nowrap'] = true; //Zeilenumbruch verhindern
  $arr['th'][$name]['href'] = '';
  $arr['th'][$name]['replace'] = array('default'=>'','1'=>"<i class='icon green check'>{value}</i>",'0'=>"<i class='icon grey check'></i>")"
  $arr['th'][$name]['replace'] = array('>1'=>"<i class='icon green check'>{value}</i>",'<5'=>"<i class='icon grey check'></i>")" //bigger and smaller
  $arr['th'][$name]['gallery'] = "path/folder/;
  $arr['th'][$name]['colspan'] = array ( [ 'field' => 'status' , 'value' => 3, 'operator' => '==' ], col => 2 )
  $arr['th'][$name]['format'] = 'euro'; (oder andere Formatierungen wied (|,%,Liter,..)
  $arr['th'][$name]['format'] = 'euro_color'; //euro_color (- Werte werden rot angezeigt)
  $arr['th'][$name]['total'] = true; //Get total from the field depend from filter
  $arr['th'][$name]['modal'] = array ('id' => 'edit','popup' => 'Open {title}','onclick' => "alert('test')" ); //open Modal, popup with template
  :
  :
  #### TR -> BUTTON LEFT AND RIGHT
  $arr ['tr'] = array ('style' => 'background-color:#EEE;',"align" => 'center' ); //Betrifft den gesamten Header
  :
  :
  #### TR -> BUTTON LEFT AND RIGHT
  $arr ['tr'][buttons]['right|left'] (Use that, if you want to have a cluster for all buttons)
  $arr ['tr'][buttons]['class'] => 'tiny, red';
  :
  :
  #### TR -> BUTTON LEFT AND RIGHT
  $arr ['tr']['button']['right|left']['MODEL_NAME'] =
  $arr ['tr']['button']['right|left']['MODEL_NAME']['title'] = 'Edit';
  $arr ['tr']['button']['right|left']['MODEL_NAME']['icons'] = 'huge';
  $arr ['tr']['button']['right|left']['MODEL_NAME']['icon'] = 'edit';
  $arr ['tr']['button']['right|left']['MODEL_NAME']['icon_corner'] = 'add'; //Zusatz icon zusatz
  $arr ['tr']['button']['right|left']['MODEL_NAME']['class'] = 'mini';
  $arr ['tr']['button']['right|left']['MODEL_NAME']['popup'] = 'Click to edit';
  $arr ['tr']['button']['right|left']['MODEL_NAME']['onclick'] = alert({id}); //id kann als Platzhalter übergeben werden
  $arr ['tr']['button']['right|left']['MODEL_NAME']['onclick'] = alert({name}); //also alle in der Datenbank befindlichen Werten
  $arr ['tr']['button']['right|left']['MODEL_NAME']['onclick'] = "$('#modal_form_detail>.header').html('{title}'); //changes headertext
  $arr ['tr']['button']['right|left']['MODEL_NAME']['single'] = true; //Button wird entkoppelt
  $arr ['tr']['button']['right|left']['MODEL_NAME']['filter'] = array(['field' => 'user_id', 'operator' => '==' , 'value' => 10 (NOW == aktuelles Datum Bsp. 2020-02-20 , 'operator' => '==' ]) (!=, >, <, <=, >=,) //Bsp.: Es werden nur Button angezeigt wenn der user_id = 10 ist
  : -> 'field' => 'name'
  : -> 'value' => 'Martin'
  : -> 'operator' => '==' | (!=, >, <, <=, >=,)
  : -> 'link' => 'and' | 'or' (bei mehreren Verkettungen Bsp.: array([parameter],[...parameter],[link=>'and',...parameter])
  : Bsp.: $arr['tr']['button']['left']['pdf'] = array (popup=>'PDF herunterladen frei', href=>'{pdf}', download=>'{art_title}.pdf', 'icon' => 'file pdf outline', 'class' => 'tiny red', 'filter' => array(['field' => 'pdf', 'value' => true ,'operator' => '==' ],[link=>'and','field' => 'free', 'value' => '1' ,'operator' => '==' ]) , single=>true );
  :
  :
  #### FILTER
  $arr['filter'][$field_id]['array'] = array('1'=>'wert1', '2'=>'wert2');
  $arr['filter'][$field_id]['id'] = field; // Alte Version kann in kombi mit "table" verwendet werden
  $arr['filter'][$field_id]['type'] = 'select | button';
  $arr['filter'][$field_id]['default_value'] = '1'; //Wenn kein Filter gesetzt ist, kann ein Default-Wert geladen werden
  $arr['filter'][$field_id]['placeholder'] = '--bitte wählen--';
  $arr['filter'][$field_id]['table'] = 'table'; //Bsp. Bei LEFT JOIN Gleichheit von Feldern
  $arr['filter'][$field_id]['settings'] = 'maxSelections: 3'; //http://semantic-ui.com/modules/dropdown.html#/examples
  $arr['filter'][$field_id]['query'] = feld LIKE '{value}%' // komplexe Abfragen bsp.: DATE_FORMAT(date_create,'%Y')
  $arr['filter'][$field_id]['query'] = "{value}", 'array' => array('pdf>" "'=>'vorhanden','pdf=""' =>'nicht vorhanden'); (ganz spezifisch)!!!
  $arr['filter'][$field_id]['query'] = "{value}", 'array' => array('(value1 = true or value2 = true)" "'=>'vorhanden','velue3 = true' =>'nicht vorhanden');
  $arr['filter'][$field_id]['query'] = "{value}", 'array' => array('having field > 1" "'=>'Havingwert'); //Bsp.: SUM(sales_amount) AS total_sales //Where ist in dem Fall nicht möglich daher wird beim Filter "having" angewendet
  :
  :
  #### JS
  $arr['js']['js1']['src'] = 'js/list_newsletter.js';
  $arr['js']['js1']['text'] = "alert('alert')";
  :
  :
  #### CONTENT
  $arr['content']['bottom'] = 'Content on the top';
  $arr['content']['top'] = 'Content on the bottom';
  
  
  
  #### SESSION-Parameters
  $_SESSION['page_link'][list_id];  //for submit Link url
  
  