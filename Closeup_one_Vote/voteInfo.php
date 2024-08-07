<?php

$url="http://localhost/Closeup_one_Vote/voteDetails.php";

$response = file_get_contents($url);
$json = json_decode($response, true);
?>


<html>
<body>
<table border='1'>
    <tr>
        <th>A Participate</th>
        <th>B Participate</th>
        <th>C Participate</th>
        <th>D Participate</th>
        <th>E Participate</th>
        <th>F Participate</th>
        <th>G Participate</th>
        <th>H Participate</th>
        <th>I Participate</th>
        <th>J Participate</th>

    </tr>

    <?php
    foreach ($json as $item) {
        ?>
        <html>
        <body>

        <tr>
            <td> <?php echo $item['A'] ?> </td>
            <td> <?php echo $item['B'] ?> </td>
            <td> <?php echo $item['C'] ?> </td>
            <td> <?php echo $item['D'] ?> </td>
            <td> <?php echo $item['E'] ?> </td>
            <td> <?php echo $item['F'] ?> </td>
            <td> <?php echo $item['G'] ?> </td>
            <td> <?php echo $item['H'] ?> </td>
            <td> <?php echo $item['I'] ?> </td>
            <td> <?php echo $item['J'] ?> </td>

        </tr>
        </body>
        </html>
        <?php
    }

    ?>
</table>
</body>
</html>
