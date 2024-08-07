<?php
// C:\xampp\htdocs\img

// C:\xampp\htdocs\Office Task\Task 5
//$dir =  dir(getcwd());
//echo $dir->path;


// opening a directory


$dir_handle = opendir("../Task 4/images");

;
// reading the contents of the directory
while (($file_name = readdir($dir_handle)) !== false) {
    echo("File Name: " . $file_name);
    echo "<br>";
}
closedir($dir_handle);

