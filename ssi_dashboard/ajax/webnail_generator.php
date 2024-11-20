<?php
// echo $path_template = '../../../templates/smart/ssi/';
// path register/include.php
if (! is_dir("$path_template"))
    exec("mkdir $path_template");
if (! is_dir("$path_template" . "private/"))
    exec("mkdir $path_template" . "private/");
if (! is_dir("$path_template" . "public/"))
    exec("mkdir $path_template" . "public/");

$sql_query = $GLOBALS['mysqli']->query("SELECT *
		FROM smart_templates
		where (set_public = 1 or user_id='{$_SESSION['user_id']}')
		ORDER by set_public desc") or die(mysqli_error($GLOBALS['mysqli']));
while ($fetch_array = mysqli_fetch_array($sql_query)) {
    $title = $fetch_array['title'];
    $text = $fetch_array['text'];

    if ($text)
        $title_text = "title='$text'";

    if ($fetch_array['set_public']) {
        // if ($_SESSION['user_id'])
        // $public_status = '<br>(&Ouml;ffentlich)';
        $path = 'public';
    } else {
        // $public_status = '(Privat)';
        $path = 'private';
    }
    if (! $first_template_id)
        $first_template_id = $fetch_array['template_id'];
    $template_id = $fetch_array['template_id'];
    $url = $fetch_array['url'];
    
    if (file_exists("$path_template$path/$template_id/mysql.txt")) {
            
        $imageUrl = "$path_template$path/$template_id/$url.jpg";

        // Erzeugt eine Thumbnail der gewünschten Seite und speichert sie ab
        if (! file_exists($imageUrl) and $url) {
            // $imageString = file_get_contents ( "http://server1.ssi.at/webcapt/cgi-bin/webcapt.fcgi?url=$url&app=ssi&format=jpg" );
            $imageString = file_get_contents("http://webthumb.ssi.at/cgi-bin/webcapt.fcgi?url=$url&app=ssi&format=jpg&width=300");
            file_put_contents("$path_template$path/$template_id/$url.jpg", $imageString);
        }

        // Webthumbnail ausgeben
        if (file_exists($imageUrl)) {
            $thumb_img = "<img alt='$url' class='templates_pic'  src='$imageUrl'>";
            $thumb_button = "<a class='button ui mini compact icon tooltip' data-fancybox='group' data-caption='$template_name' href='$imageUrl' title='$template_name' alt='$template_name' ><i class='external icon'></i>Vorschau</a>";
        } else {
            $thumb_img = "<div class='ui image'><img src='square-image.png'></div>";
            $thumb_button = "<br>";
        }

        $radio_field = "$title
		<span class='templates_pic_empty tooltip' $title_text>$thumb_img</span>
		<div align=center>$thumb_button</div>$public_status
		";

        $template_array[$template_id] = "$radio_field";
        
    }
}

?>