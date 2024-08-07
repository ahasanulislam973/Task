<?php

/*
 * return Global INSERT (create)
 */
if (!function_exists('doInsert')) {
    function doInsert($table, $data = array())
    {
        global $conn;
        $fields = array_keys($data); // get key of data array
        $values = array_values($data); // get value of data array
        $query = "INSERT INTO $table ( " . implode(',', $fields) . ") VALUES('" . implode("','", $values) . "')";

        $result = mysqli_query($conn, $query);
        if ($result > 0) {
            return true;
        }

        return false;

    }
}

/*
 * return Global SELECT (get)
 */
if (!function_exists('doSelect')) {
    function doSelect($tableName, $organizationId, $columns = '*')
    {
        global $conn;
        $queryOpts = $resultArray = array();
        if (empty($columns)) {
            $columns = '*';
        }
        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $column = is_array($columns) ? implode(', ', $columns) : $columns;
        if ($organizationId == '' || $organizationId == 0)
            $query = 'SELECT ' . implode(' ', $queryOpts) . $column . " FROM " . $tableName;
        else
            $query = 'SELECT ' . implode(' ', $queryOpts) . $column . " FROM " . $tableName . " WHERE organization_id=" . $organizationId;
        // echo $query;
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_object($result)) {
                $resultArray[] = $row;
            }
            return $resultArray;
        }

        return false;
    }
}
if (!function_exists('getOrganization')) {

    function getOrganization($tableName = 'organization')
    {
        global $conn;
        $sql = "SELECT `organization_id`,`organization_name` FROM $tableName";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        $response = array('' => 'Choose Organization - Any');
        while ($row = mysqli_fetch_object($result)) {
            $response[$row->organization_id] = $row->organization_name;
        }
        return $response;
    }
}

if (!function_exists('getOrganization')) {

    function getOrganization($tableName = 'organization')
    {
        global $conn;
        $sql = "SELECT `organization_id`,`organization_name` FROM $tableName";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        $response = array('' => 'Choose Organization - Any');
        while ($row = mysqli_fetch_object($result)) {
            $response[$row->organization_id] = $row->organization_name;
        }
        return $response;
    }
}

if (!function_exists('getMenuPermission')) {
    function getMenuPermission($role_id, $organizationId)
    {
        global $conn;
        $sql = "SELECT `module`,`action` FROM `permissions` WHERE  `role_id` = '$role_id' AND `value`=1 AND `organization_id` = '$organizationId'";
        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $data = array();
            $module = '';
            while ($row = mysqli_fetch_object($result)) {
                set_time_limit(0);
                /*     if($row->module==$module)*/
                $data[$row->module][] = $row->action;
            }

            //$row = mysqli_fetch_object($result);

            /*   $fp = fopen('aaa.txt', 'a+');
                fwrite($fp, $sql.PHP_EOL.json_encode($data).PHP_EOL);
                fclose($fp);*/

            return $data;
        }
        return false;
    }
}

if (!function_exists('doUpdate')) {

    /*
     * where : array
     * data : array
     */
    function doUpdate($tableName, $data, $where)
    {
        global $conn;
        $cols = $whereArr = array();
        $whereField = '';
        if (!empty($where)) {
            foreach ($where as $key => $val) {
                $whereArr[] = "$key = '$val'";
            }
            $whereField .= " WHERE " . implode(' AND ', $whereArr);
        }
        foreach ($data as $key => $val) {
            $cols[] = "$key = '$val'";
        }

        $sql = 'UPDATE ' . $tableName . ' SET ' . implode(', ', $cols) . $whereField;
        $fp = fopen('aa.txt', 'a+');
        fwrite($fp, $sql . PHP_EOL);
        fclose($fp);

        $result = mysqli_query($conn, $sql);
        if ($result > 0) {
            return true;
        }
        return false;
    }

}

if (!function_exists('getAdminRoleInfo')) {
    function getAdminRoleInfo($roleId)
    {
        global $conn;
        $sql = "SELECT role_name, created_by FROM `admin_roles` WHERE role_id = '" . $roleId . "'";
        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_object($result);
            return $row;
        } else {
            return false;
        }
    }
}


if (!function_exists('isDataExists')) {
    function isDataExists($tableName, $fieldName, $fieldVal)
    {
        global $conn;
        $sql = "SELECT `" . $fieldName . "` FROM `" . $tableName . "` WHERE `" . $fieldName . "` = '" . $fieldVal . "'";
        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        }

        return false;
    }
}

if (!function_exists('makeDynamicModulesOrder')) {
    function makeDynamicModulesOrder($table = 'modules', $id = 'module_id')
    {
        global $conn;
        $sql = "SELECT view_order FROM $table ORDER BY $id DESC LIMIT 1";
        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_object($result);
            return $row;
        }

        return false;
    }
}

if (!function_exists('getUserPermission')) {
    function getUserPermission($params = array())
    {
        global $conn;
        $sql = "SELECT role_id,action,value FROM `permissions` WHERE  
          `role_id` = '" . $params['role_id'] . "' AND
          `action` = '" . $params['action'] . "' AND `organization_id` = '" . $params['organization_id'] . "' AND `module` = '" . $params['module'] . "'";

        //  echo $sql . PHP_EOL;
        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_object($result);
            return $row;
        }
        return false;
    }
}

// get action based on module
if (!function_exists('getModuleActions')) {

    function getModuleActions($params = array())
    {
        if (!empty($params)) {
            global $conn;
            if ($params['organization_id'] == 0)
                $sql = "SELECT `action_name`,`display_name` FROM `module_actions` WHERE `module_id` ='$params[module_id]' GROUP BY `action_name`,`display_name`";
            else
                $sql = "SELECT * FROM `module_actions` WHERE  
                   `module_id` = '" . $params['module_id'] . "'" . " AND `organization_id` = '" . $params['organization_id'] . "'";

            mysqli_query($conn, 'SET CHARACTER SET utf8');
            mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_object($result)) {
                    $resultArray[] = $row;
                }

                return $resultArray;
            }
            return false;
        }

    }

}

// get permission
if (!function_exists('getPermission')) {

    function getPermission($params = array())
    {
        if (!empty($params)) {
            global $conn;

            $sql = "SELECT * FROM `permissions` WHERE  
            `role_id` = '" . $params['role_id'] . "' AND `action` = '" . $params['action'] . "'
            AND `module` = '" . $params['module'] . "'" . " AND `organization_id` = '" . $params['organization_id'] . "'";

            mysqli_query($conn, 'SET CHARACTER SET utf8');
            mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_object($result);
                return $row;
            }

            return false;
        }

    }

}

if (!function_exists('updatePermission')) {

    function updatePermission($where = array())
    {
        if (!empty($params)) {
            global $conn;

            $sql = "SELECT * FROM `permissions` WHERE  
            `role_id` = '" . $params['role_id'] . "' AND `action` = '" . $params['action'] . "'
            AND `module` = '" . $params['module'] . "'";

            mysqli_query($conn, 'SET CHARACTER SET utf8');
            mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_object($result);
                return $row;
            }

            return false;
        }

    }

}

if (!function_exists('getUserInfoByUserName')) {
    function getUserInfoByUserName($userName)
    {
        global $conn;
        $sql = "SELECT * FROM `admin_users` WHERE (username = '" . $userName . "' OR email = '" . $userName . "')";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_object($result);
            return $row;
        }

        return false;
    }
}

if (!function_exists('saveAdminUser')) {
    function saveAdminUser($data)
    {
        global $conn;
        $fields = array_keys($data);
        $values = array_values($data);
        $query = "INSERT INTO admin_users ( " . implode(',', $fields) . ") VALUES('" . implode("','", $values) . "')";

        $result = mysqli_query($conn, $query);
        if ($result > 0) {
            return true;
        } else {
            return false;
        }

    }
}

if (!function_exists('updateAdminUser')) {

    function updateAdminUser($table = 'admin_users', $data, $userId)
    {
        global $conn;
        $cols = array();
        foreach ($data as $key => $val) {
            $cols[] = "$key = '$val'";
        }
        $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE user_id = $userId";
        $result = mysqli_query($conn, $sql);
        if ($result > 0) {
            return true;
        }
        return false;
    }

}

if (!function_exists('getAdminRoles')) {

    function getAdminRoles($organizationId, $tableName = 'admin_roles')
    {
        global $conn;
        if ($organizationId == 0)
            $sql = "SELECT role_id,role_name FROM $tableName ";
        else
            $sql = "SELECT role_id,role_name FROM $tableName WHERE `isCompanySuperAdmin`<>1 AND `organization_id`='$organizationId'";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        $response = array('' => 'Admin Roles - Any');
        while ($row = mysqli_fetch_object($result)) {
            $response[$row->role_id] = $row->role_name;
        }
        return $response;
    }
}

if (!function_exists('getModules')) {

    function getModules()
    {
        global $conn;
        $sql = "SELECT module_id,module_name,display_name FROM modules";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $result = mysqli_query($conn, $sql);
        $response = array('' => 'Modules - Any');
        while ($row = mysqli_fetch_object($result)) {
            $response[$row->module_id] = $row->display_name;
        }
        return $response;
    }
}

if (!function_exists('getUserInfo')) {
    function getUserInfo($userId)
    {
        global $conn;
        $sql = "SELECT * FROM `admin_users` WHERE user_id = '" . $userId . "'";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");

        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_object($result);
            return $row;
        } else {
            return false;
        }
    }
}

if (!function_exists('getAdminUserInfo')) {
    function getAdminUserInfo($organizationId)
    {
        global $conn;
        // $sql = "SELECT admin_users.*, admin_roles.role_name FROM admin_users INNER JOIN admin_roles ON admin_users.role_id=admin_roles.role_id WHERE admin_users.status = '1'";
        if ($organizationId == 0)
            $sql = "SELECT admin_users.*, admin_roles.role_name,organization.organization_name FROM admin_users INNER JOIN admin_roles INNER JOIN organization  ON admin_users.role_id=admin_roles.role_id and admin_users.organization_id=`organization`.`organization_id` WHERE admin_users.status = '1' ";
        else
            $sql = "SELECT admin_users.*, admin_roles.role_name,organization.organization_name FROM admin_users INNER JOIN admin_roles INNER JOIN organization  ON admin_users.role_id=admin_roles.role_id and admin_users.organization_id=`organization`.`organization_id` WHERE admin_users.status = '1' AND admin_users.organization_id='$organizationId'";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $resultArray = array();
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_object($result)) {
                $resultArray[] = $row;
            }
            if (!empty($resultArray)) {
                return $resultArray;
            }
        }
        return false;
    }
}


if (!function_exists('getModuleActionInfo')) {
    function getModuleActionInfo()
    {
        global $conn;
        $sql = "SELECT module_actions.*, modules.module_id,modules.module_name,
                (SELECT `organization_name` FROM `organization` WHERE `organization`.`organization_id`=module_actions.`organization_id`) AS `organization_name`
                FROM module_actions 
                INNER JOIN modules ON module_actions.module_id=modules.module_id";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $resultArray = array();
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_object($result)) {
                $resultArray[] = $row;
            }
            if (!empty($resultArray)) {
                return $resultArray;
            }
        }
        return false;
    }
}

if (!function_exists('loadModuleActionNameList')) {

    function loadModuleActionNameList()
    {
        global $conn;
        $sql = "SELECT DISTINCT `action_name` FROM `module_actions`";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $resultArray = array();
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_object($result)) {
                echo $row->action_name;
                $resultArray[] = $row->action_name;
            }
            if (!empty($resultArray)) {
                return $resultArray;
            }
        }
        return false;
    }

}
if (!function_exists('loadModuleActionDisplayNameList')) {

    function loadModuleActionDisplayNameList()
    {
        global $conn;
        $sql = "SELECT DISTINCT `display_name` FROM `module_actions`";

        mysqli_query($conn, 'SET CHARACTER SET utf8');
        mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
        $resultArray = array();
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_object($result)) {
                $resultArray[] = $row->display_name;
            }
            if (!empty($resultArray)) {
                return $resultArray;
            }
        }
        return false;
    }

}
