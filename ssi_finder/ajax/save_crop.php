<?
session_start ();
$name = time();
$image_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}" .$name.'.png';
$image_thumb_path = "{$_SESSION ['HTTP_SERVER_FOLDER']}thumbnail/" .$name.'.png';

if(isset($_POST['imagebase64'])){
	$data = $_POST['imagebase64'];
	
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	
	file_put_contents($image_path, $data);
	
}

echo "ok";

?>