<?php
$string=$_GET['input']

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        canvas {
            border: 1px solid red;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</head>
<body>

<div id="the_text"><?php echo $string; ?></div>
<button id="show_img_btn">Convert to Image</button>
<div id="show_img_here"></div>


<script>

    window.onload = function () {
        $("#show_img_btn").on("click", function () {
            var canvas = document.createElement("canvas");
            canvas.width = 620;
            canvas.height = 80;
            var ctx = canvas.getContext('2d');
            ctx.font = "30px Arial";
            var text = $("#the_text").text();
            ctx.fillText(text, 10, 50);
            var img = document.createElement("img");
            img.src = canvas.toDataURL();
            $("#show_img_here").append(img);
            //$("body").append(canvas);
        });
    };
</script>

</body>
</html>