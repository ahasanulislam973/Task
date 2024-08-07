<?php
/*$directory="uploads/";
$flag= 1;
$file=$directory.basename($_FILES["fileToUpload"]["name"]);
$imagefiletype=strtolower(pathinfo($file, PATHINFO_EXTENSION));

//Check image or not
if(isset($_POST["submit"])){
    $check=getimagesize(($_FILES["fileToUpload"]["tmp_name"]));
    if($check!==false){
        echo "File is an image" .$check["mime"];
            $flag=1;
    }

    else{
        echo "File is not an image";

        $flag =0;
    }
}

// Check file is already exists or not

if(file_exists($file)){
    echo "Sorry this file is already exists";
    $flag =0;
}

//check file size
if($_FILES["fileToUpload"]["size"]>500000){
    echo "File size is large";
    $flag =0;
}

//Allow FIle Formats

if($imagefiletype!="jpg" && $imagefiletype!="png" && $imagefiletype!= "jpeg" && $imagefiletype!= "gif"){
    echo "only image is allowed";
    $flag =0;
}

//FIle move
if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$file)){
    echo "The file is submitted successfully";
    $flag =1;
}*/

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}