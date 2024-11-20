<?php require_once ('../mysql.inc'); ?>
$('#add_group').empty();
$('.group_toggle').remove();
<?php 
$contact_id = $_POST['contact_id'];
//echo $_POST['test'];
$array = explode(",",$_POST['values']);
if (!is_array($array)) return;
foreach ($array as $id)  {
	if ($id) {
		$query = $GLOBALS['mysqli']->query ("SELECT title, (SELECT `activate` FROM contact2tag WHERE tag_id = '$id' AND contact_id = '$contact_id') activate FROM tag WHERE tag_id = '$id' ")or die (mysqli_error());
		$fetch = mysqli_fetch_array($query);
		$title = $fetch['title'];
		$tag_activate = $fetch['activate'];
		
		if ($tag_activate OR !isset($tag_activate)) {
			$checked  = "checked='checked'";
		}
		else
			$checked = '';
		?>
		
		$('#add_group').append("<div id='row_tag<?=$id?>' class='field row_field inline'><div class='ui toggle checkbox'><input id='tag<?=$id?>' class='form_edit hidden' value='1' name='tag<?=$id?>' tabindex='0' type='checkbox' <?=$checked?>><label id='label_tag<?=$id?>' class='label'><?=$title?></label></div></div>");
		$('.ui.checkbox').checkbox();
		<?
	}
}