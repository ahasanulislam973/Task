<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);
$phone = $user_data['mobile_number'];

if (isset($_REQUEST['mobile_number'])) {
    $mobile_number = $_REQUEST['mobile_number'];

    if ($phone == $mobile_number) {

        $url = "http://localhost/login/subscriber_info.php?mobile_number=$mobile_number";

        $response = file_get_contents($url);
        $json = json_decode($response, true);
        ?>

        <html>
        <body>
        <table border='1'>
            <tr>
                <th>Mobile_Number</th>
                <th>Status</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Registration_date</th>
                <th>Deregistration_date</th>
            </tr>

            <?php
            foreach ($json as $item) {
                ?>
                <html>
                <body>

                <tr>
                    <td> <?php echo $item['mobile_number'] ?> </td>
                    <td> <?php echo $item['status'] ?> </td>
                    <td> <?php echo $item['created_at'] ?> </td>
                    <td> <?php echo $item['updated_at'] ?> </td>
                    <td> <?php echo $item['registration_date'] ?> </td>
                    <td> <?php echo $item['deregistration_date'] ?> </td>

                </tr>
                </body>
                </html>
                <?php
            }

            ?>
            <a href="index.php?role=user&mobile_number=<?php echo $mobile_number ?>">Back</a>
        </table>
        </body>
        </html>

        <?php
    } else {
        echo "This number is not registered";
    }
} else {
    $url = "http://localhost/login/subscriber_info.php";

    $response = file_get_contents($url);
    $json = json_decode($response, true);
    ?>
    <html>
    <body>
    <table border='1'>
        <tr>
            <th>Mobile_Number</th>
            <th>Status</th>
            <th>Created_at</th>
            <th>Updated_at</th>
            <th>Registration_date</th>
            <th>Deregistration_date</th>
        </tr>

        <?php
        foreach ($json as $item) {
            ?>
            <html>
            <body>

            <tr>
                <td> <?php echo $item['mobile_number'] ?> </td>
                <td> <?php echo $item['status'] ?> </td>
                <td> <?php echo $item['created_at'] ?> </td>
                <td> <?php echo $item['updated_at'] ?> </td>
                <td> <?php echo $item['registration_date'] ?> </td>
                <td> <?php echo $item['deregistration_date'] ?> </td>

            </tr>
            </body>
            </html>
            <?php
        }

        ?>
        <a href="index.php?role=admin&mobile_number=<?php echo $phone ?>">Back</a>
    </table>
    </body>
    </html>

    <?php
}
?>

