<?php

// $main_menu .= '<div class="ui attached segment">';
// $title = preg_replace ( "/SSI-/", '', $this->title );
$title = $this->title;

$main_menu = '';
$main_menu .= "<div class='center_top ui top icon borderless fixed menu' style='background-color:#EEE'>";

$main_menu .= "<a class='item white tooltip-right' href='../ssi_dashboard'  title='Zum Dashboard'><i class='icon blue large dashboard'></i></a>";

$main_menu .= "<a href='' class='item tooltip-right' style='background-color:white; text-transform: uppercase;'><b>$title</b></a>";
// $main_menu .= "<a class='item icon toggle_sidemap'><i id='map_filter_icon' class='icon grey ui content'></i></a>";

$main_menu .= $this->menu_top_left ?? '';
$main_menu .= "<div class='center_top right icon menu'>";
$main_menu .= $this->menu_top_right ?? '';

$main_menu .= "<div class='item'>" . call_verification_content ( $_SESSION ['user_id'] ) . "</div>";
$main_menu .= "<a class='item tooltip' href='../login/logout.php' title='Ausloggen aus dem System'><i class='red sign large out icon'></i></a>";
// $main_menu .= "<a href='../ssi_dashboard/index.php'><div class='ui blue small icon button tooltip' title='Zum Dashboard (Hauptseite)'><i class='dashboard icon'></i></div></a>";
// $main_menu .= "<a href='../login/logout.php'><div class='ui blue small icon button tooltip' title='Ausloggen aus dem System'><i class='sign out icon'></i></div></a>";
$main_menu .= "</div>";
$main_menu .= '</div>';

// $main_menu .= '</div>';

return;
/*
 * Menueleiste oben, zum navigieren (anzeigen der Module,Domain zu ein-und ausloggen
 * mm@ssi.at am 02.03.2014
 */
// include ('../login/config_main.inc.php');

// Call verfication -> for Userlogin
// include ('../information/include.php');
// $main_menu .= "<div class=register_head>";
// $main_menu .= "<span class=register_head_right style ='display:block'>";
// $main_menu .= call_verification_content ( $_SESSION['user_id'] );
// $main_menu .= "<span ><a href='../ssi_dashboard/index.php'><div class='ui blue small icon button tooltip' title='Zum Dashboard (Hauptseite)'><i class='dashboard icon'></i></div></a></span>";
// $main_menu .= "<span ><a href='../login/logout.php'><div class='ui blue small icon button tooltip' title='Ausloggen aus dem System'><i class='sign out icon'></i></div></a></span>";
// $main_menu .= "</span>";
// $main_menu .= "</div>";

?>

