<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 11/7/2018
 * Time: 7:40 PM
 */

include_once('lib/dbconfig.php');

$action = isset($_POST['action']) ? $_POST['action'] : '';

$RESPONSE_ARRAY = array();
$RESPONSE_ARRAY['code'] = '999';

$query = "
	SELECT * FROM `project` WHERE project_status = 'active' ORDER BY project_name ASC;
	";

$output = '';
$sql_result = Sql_exec($con, $query);

while ($row = Sql_fetch_assoc($sql_result)) {

    if ($action == 'DATALIST') {
        $output .= '<option value="' . $row["project_name"] . '">';

    } else if ($action == 'SELECTOPTION') {
        $output .= '<option value="' . $row["project_id"] . '">' . $row["project_name"] . '[' . $row["project_code"] . ']' . '</option>';
    }
}

$RESPONSE_ARRAY['data'] = $output;

echo json_encode($RESPONSE_ARRAY);