<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

$uploaddir = '/var/www/html/contentfiles/userfiles/images/';
$uploadfile = $uploaddir . basename($_FILES['FileName']['name']);
$file = '/var/www/html/formlogs/laptops.tsv';
// The new person to add to the file
if(isset($_GET['status'])) {
echo "STLLaptop".$_GET['laptop'] . " " . $_GET['laptop'] . $_GET['status']  . " " . time();
$line = "STLLaptop".$_GET['laptop']."\t" . $_GET['laptop'] . "\t" . $_GET['status']  . "\t" . date("Y-m-d H:i:s") . "\n";
}
// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
move_uploaded_file($_FILES['FileName']['tmp_name'], $uploadfile);
//echo '<pre>';
if (move_uploaded_file($_FILES['FileName']['tmp_name'], $uploadfile)) {
    //echo "File is valid, and was successfully uploaded.\n";
} else {
    //echo "$uploadfile Possible file upload attack!\n";
}

//echo 'Here is some more debugging info:';
//print_r($_FILES);

//print "</pre>";

?>