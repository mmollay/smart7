<?php
$id = $_POST['id'];
$src_image_thumb_path = $_SESSION['HTTP_HOST_FOLDER']."thumbnail/$name"."?".Date('U').rand(1,32000);
$src_image_path = $_SESSION['HTTP_HOST_FOLDER']."$name"."?".Date('U').rand(1,32000);
echo "$('#img_thumb{$id}').attr('src','$src_image_thumb_path');";
echo "$('#img_link{$id}').attr('href','$src_image_path');";
echo "window.parent.reload_element (gadget_id); ";