-###Smart-Form v2.x

Configs

## Basic Usage - List

```php
<?php

//LINE - get line with text between
$arr ['field'] [] = array ('type' => 'line', 'text' => 'AND');


//CONTENT
$arr ['field'] [] = array ('type' => 'content','text' => 'infotext', 'color'=> 'blue', 'size'=>'large' );

//smart_password
$arr2['field'][] = array('label' => 'Passwort', 'label_repeat' => 'Passwort wiederholen','type' => 'smart_password','placeholder'=>'passwort', 'placeholder_repeat'=>'passwort wiederholen');


//DATE
$arr ['field'] [] = array ('label' => 'Date','type' => 'calendar', 'setting' =>"'type':'date', minDate: new Date()" ); //Example: Zeigt die vergangen Tage nicht an (https://fomantic-ui.com/modules/calendar.html#/usage)

