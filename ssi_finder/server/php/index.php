<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
session_start();
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
//$upload_handler = new UploadHandler();

$upload_handler = new UploadHandler(array(
'upload_dir' => $_SESSION['HTTP_SERVER_FOLDER'],
'upload_url' => $_SESSION['HTTP_HOST_FOLDER'],
'inline_file_types' => '/\.(gif|jpe?g|png|pdf|mp3|zip|ico|mp4|ico)$/i',
'accept_file_types' => '/\.(gif|jpe?g|png|pdf|mp3|zip|ico|mp4|ico)$/i',
));
