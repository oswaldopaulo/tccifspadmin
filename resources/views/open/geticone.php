<?php
// open the file in a binary mode
$name = public_path('/icones/' . $image);
$fp = fopen($name, 'rb');

// send the right headers

$ext = pathinfo($name, PATHINFO_EXTENSION);
if($ext=="jpg"){
    header("Content-Type: image/jpg");
 
} else if($ext=="png"){
        header("Content-Type: image/png");
} else if($ext=="gif"){
    header("Content-Type: image/gif");
}

header("Content-Length: " . filesize($name));

// dump the picture and stop the script
fpassthru($fp);
exit;
?>