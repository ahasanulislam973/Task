<?php
require_once './lib/Common.php';
$responseArray = array();
$con=connectDB();

$A = $B = $C = $D = $E = $F = $G = $H = $I = $J = 0;
$query = "select message from votinginfo";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result)) {
    while ($rows = mysqli_fetch_assoc($result)) {

        $message = $rows['message'];

        $msg = explode(" ", $message);

        $show = $msg['1'];
        $l = strlen($show);
        for ($j = 0; $j <= $l; $j++) {

            $search = substr($show, $j, 1);

            if ($search == 'A') {
                $A++;
            }

            if ($search == 'B') {
                $B++;
            }
            if ($search == 'C') {
                $C++;
            }
            if ($search == 'D') {
                $D++;
            }
            if ($search == 'E') {
                $E++;
            }
            if ($search == 'F') {
                $F++;
            }
            if ($search == 'G') {
                $G++;
            }
            if ($search == 'H') {
                $H++;
            }
            if ($search == 'I') {
                $I++;
            }
            if ($search == 'J') {
                $J++;
            }
        }

    }
    $responseArray[] = [
        'A' => $A,
        'B' => $B,
        'C' => $C,
        'D' => $D,
        'E' => $E,
        'F' => $F,
        'G' => $G,
        'H' => $H,
        'I' => $I,
        'J' => $J,
    ];
    echo json_encode($responseArray);
    ClosedDBConnection($con);
}