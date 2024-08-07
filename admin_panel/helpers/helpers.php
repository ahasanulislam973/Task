<?php

if (!function_exists('checkAuthenticLogin')) {

    function checkAuthenticLogin()
    {
        // check the user data from session
        if (isset($_SESSION['admin_login_info']['user_logged_in']) && ($_SESSION['admin_login_info']['user_logged_in'] == TRUE)) {
            return TRUE;
        }

        return FALSE;
    }

}

if (!function_exists('limit_word')) {

    function limit_word($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

}
if (!function_exists('hasPermission')) {

    function hasPermission($action, $module, $roleId = 0)
    {
        global $conn;

        if ($roleId == 0) {
            $roleId = $_SESSION['admin_login_info']['role_id'];
        }
        $organizationId = $_SESSION['admin_login_info']['organization_id'];
        // generate the params
        $params = array(
            'role_id' => $roleId,
            'module' => $module,
            'organization_id' => $organizationId,
            'action' => $action
        );

        $rolePermission = getUserPermission($params);
        // print_r($rolePermission);
        if ($rolePermission) {
            if ($rolePermission->value == 1)
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }

    }

}

if (!function_exists('hasActionPermission')) {

    function hasActionPermission($action, $organizationId, $module, $roleId)
    {
        global $conn;

        if ($roleId == 0) {
            $roleId = $_SESSION['admin_login_info']['role_id'];
        }
        // $organizationId = $_SESSION['admin_login_info']['organization_id'];
        // generate the params
        $params = array(
            'role_id' => $roleId,
            'module' => $module,
            'organization_id' => $organizationId,
            'action' => $action
        );

        $rolePermission = getUserPermission($params);
        //print_r($rolePermission);
        if ($rolePermission) {
            if ($rolePermission->value == 1)
                return TRUE;
            else
                return FALSE;
        } else {
            return FALSE;
        }

    }

}

// get the module list
if (!function_exists('getPageModules')) {

    function getPageModules()
    {
        $modules = doSelect('modules', '*');
    }

}

/*
 * Show access denied pages
 */

if (!function_exists('showAccessDenied')) {
    function showAccessDenied()
    {
        ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel-body">
                        <h3 class="page-header text-warning">Access Denied !!!</h3>
                        <div class="col-lg-12">
                            <div class="alert alert-danger alert-dismissable" role="alert">
                                <h4 class="alert-heading">Opss!</h4>
                                <hr>
                                <p>You do not have permission to access the menu or action that you requested.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php
    }
}

/**
 * function to generate random string.
 */

if (!function_exists('randomString')) {
    function randomString($n)
    {
        $generated_string = "";
        $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $len = strlen($domain);

        // Loop to create random string
        for ($i = 0; $i < $n; $i++) {
            // Generate a random index to pick characters
            $index = rand(0, $len - 1);

            // Concatenating the character
            // in resultant string
            $generated_string = $generated_string . $domain[$index];
        }
        return $generated_string;
    }
}

/**
 * return secure random token
 */
if (!function_exists('getSecureRandomToken')) {
    function getSecureRandomToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        return $token;
    }
}

/**
 * Clear Auth Cookie
 */
if (!function_exists('clearAuthCookie')) {
    function clearAuthCookie()
    {
        unset($_COOKIE['series_id']);
        unset($_COOKIE['remember_token']);
        setcookie('series_id', null, -1, '/');
        setcookie('remember_token', null, -1, '/');
    }
}

/**
 * return clean input values
 */
if (!function_exists('cleanInput')) {
    function cleanInput($data)
    {
        global $conn;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = mysqli_real_escape_string($conn, $data);
        return $data;
    }
}

/**
 * return base path of url
 */
if (!function_exists('baseUrl')) {

    function baseUrl($uri = '')
    {
        return PROJECT_BASE_PATH . '/' . $uri;
    }
}

/**
 * return status check html
 */
if (!function_exists('statusCheck')) {

    function statusCheck($status)
    {
        if ($status == 1) {
            return '<span class="label label-success">Active</span>';
        } else {
            return '<span class="action label label-danger">Inactive</span>';
        }
    }

}

/**
 * return common messages html
 */
if (!function_exists('commonMessages')) {

    function commonMessages($message = '')
    {
        ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="alert alert-danger">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <h2>
                        <strong>
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            Oops !!
                        </strong>
                    </h2>
                    <h3><?php echo $message; ?></h3>
                </div>
            </div>
        </div>
        <?php
    }

}

/*
 * return human readable date time
 */
if (!function_exists('longDateHuman')) {

    function longDateHuman($dateTime, $format = 'datetime')
    {
        $intTime = (!ctype_digit($dateTime)) ? strtotime($dateTime) : $dateTime;
        if ($intTime) {
            switch ($format) {
                case 'datetime':
                    return date('jS M, Y \a\t h:i:s a', $intTime);
                case 'date_time':
                    return date('j M y, h:i A', $intTime);
                case 'date':
                    return date('jS F, Y', $intTime);
                case 'time':
                    return date('h:i', $intTime);
                case 'short':
                    return date('jS M, y', $intTime);
                case 'MY':
                    return date('F Y', $intTime);
                case 'Y':
                    return date('Y', $intTime);
                case 'M':
                    return date('F', $intTime);
                case 'full':
                    return date('j M Y, h:i A', $intTime);
                case 'md':
                    return date('j M, h:i A', $intTime);

                default:
                    break;
            }
        } else
            return "Not yet";
    }

}


if (!function_exists('getMenuItems')) {

    function getMenuItems($table)
    {
        // get the CI instance
        //$CI = &get_instance();

        $colorClassArr = ["home", "about", "service", "product", "contact"];

        $itemName = '';
        $link = '';
        if ($table == "product") {
            $itemName = "product_name";
            $link = "product/details";
        } else {
            $itemName = "category_name";
            $link = "service";
        }

        // get menu items
        //$getItems = $CI->global_model->getMenuData($table);
        if (!empty($getItems)):
            $i = 0;
            foreach ($getItems as $item) {
                $classIndex = $i % count($colorClassArr);
                $linkClass = $colorClassArr[$classIndex];
                $i++;
                ?>
                <!--<li><a class="<?php /*echo $linkClass; */ ?>" href="<?php /*echo!empty($item->id) ? site_url($link . '/' . $item->id) : ""; */ ?>"><?php /*echo!empty($item->$itemName) ? $item->$itemName : ""; */ ?></a></li>-->
                <?php
            }
        endif;
    }

}

if (!function_exists('imgageResize')) {
    // image resize
    function imgageResize($initPath, $destPath, $params = array())
    {
        $width = !empty($params['width']) ? $params['width'] : null;
        $height = !empty($params['height']) ? $params['height'] : null;
        $constraint = !empty($params['constraint']) ? $params['constraint'] : FALSE;
        $rgb = !empty($params['rgb']) ? $params['rgb'] : 0xFFFFFF;
        $quality = !empty($params['quality']) ? $params['quality'] : 100;
        $aspectRatio = isset($params['aspect_ratio']) ? $params['aspect_ratio'] : TRUE;
        $crop = isset($params['crop']) ? $params['crop'] : TRUE;

        if (!file_exists($initPath)) {
            return FALSE;
        }

        if (!is_dir($dir = dirname($destPath))) {
            mkdir($dir);
        }

        $imgInfo = getimagesize($initPath);

        if ($imgInfo === FALSE) {
            return FALSE;
        }

        $ini_p = $imgInfo[0] / $imgInfo[1];
        if ($constraint) {
            $con_p = $constraint['width'] / $constraint['height'];
            $calc_p = $constraint['width'] / $imgInfo[0];

            if ($ini_p < $con_p) {
                $height = $constraint['height'];
                $width = $height * $ini_p;
            } else {
                $width = $constraint['width'];
                $height = $imgInfo[1] * $calc_p;
            }
        } else {
            if (!$width && $height) {
                $width = ($height * $imgInfo[0]) / $imgInfo[1];
            } else if (!$height && $width) {
                $height = ($width * $imgInfo[1]) / $imgInfo[0];
            } else if (!$height && !$width) {
                $width = $imgInfo[0];
                $height = $imgInfo[1];
            }
        }

        preg_match('/\.([^\.]+)$/i', basename($destPath), $match);
        $ext = strtolower($match[1]);
        $output_format = ($ext == 'jpg') ? 'jpeg' : $ext;

        $format = strtolower(substr($imgInfo['mime'], strpos($imgInfo['mime'], '/') + 1));
        $icfunc = "imagecreatefrom" . $format;

        $iresfunc = "image" . $output_format;

        if (!function_exists($icfunc)) {
            return FALSE;
        }

        $dst_x = $dst_y = 0;
        $src_x = $src_y = 0;
        $res_p = $width / $height;
        if ($crop && !$constraint) {
            $dst_w = $width;
            $dst_h = $height;
            if ($ini_p > $res_p) {
                $src_h = $imgInfo[1];
                $src_w = $imgInfo[1] * $res_p;
                $src_x = ($imgInfo[0] >= $src_w) ? floor(($imgInfo[0] - $src_w) / 2) : $src_w;
            } else {
                $src_w = $imgInfo[0];
                $src_h = $imgInfo[0] / $res_p;
                $src_y = ($imgInfo[1] >= $src_h) ? floor(($imgInfo[1] - $src_h) / 2) : $src_h;
            }
        } else {
            if ($ini_p > $res_p) {
                $dst_w = $width;
                $dst_h = $aspectRatio ? floor($dst_w / $imgInfo[0] * $imgInfo[1]) : $height;
                $dst_y = $aspectRatio ? floor(($height - $dst_h) / 2) : 0;
            } else {
                $dst_h = $height;
                $dst_w = $aspectRatio ? floor($dst_h / $imgInfo[1] * $imgInfo[0]) : $width;
                $dst_x = $aspectRatio ? floor(($width - $dst_w) / 2) : 0;
            }
            $src_w = $imgInfo[0];
            $src_h = $imgInfo[1];
        }

        $isrc = $icfunc($initPath);
        $idest = imagecreatetruecolor($width, $height);
        if (($format == 'png' || $format == 'gif') && $output_format == $format) {
            imagealphablending($idest, FALSE);
            imagesavealpha($idest, TRUE);
            imagefill($idest, 0, 0, IMG_COLOR_TRANSPARENT);
            imagealphablending($isrc, TRUE);
            $quality = 0;
        } else {
            imagefill($idest, 0, 0, $rgb);
        }

        imagecopyresampled($idest, $isrc, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        $res = $iresfunc($idest, $destPath, $quality);

        // imagedestroy($isrc);
        // imagedestroy($idest);
        return $res;
    }
}
if (!function_exists('sendEMail')) {

    function sendEMail($toEmail, $subject, $htmlContent, $senderEmail, $senderName)
    {
        $encoding = "utf-8";

        // Preferences for Subject field
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );

        // Mail header
        $header = "Content-type: text/html; charset=" . $encoding . " \r\n";
        $header .= "From: " . $senderName . " <" . $senderEmail . "> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: " . date("r (T)") . " \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

        // Send mail
        if (mail($toEmail, $subject, $htmlContent, $header)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

}


if (!function_exists('getRandomString')) {
    function getRandomString($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        $coupon = strtoupper($key);
        return $coupon;
    }
}


/*
 * Function Name : sendMailWithAttachment
 * Author : Raqibul Hasan
 * Return : TRUE or FALSE
 * Warning: Please think before change any params or functionality.
 */
function sendMailWithAttachment($toAddress, $subject = '', $messages = '', $attachment, $replyToMail, $replyToUser)
{
    // header for sender info
    $headers = "From: $replyToUser" . " <" . $replyToMail . ">";

    // boundary
    $semiRand = md5(uniqid(time()));
    $mimeBoundary = "==Multipart_Boundary_x{$semiRand}x";

    // headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mimeBoundary}\"";

    // multipart boundary
    $message = "--{$mimeBoundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $messages . "\n\n";

    // preparing attachment
    if (!empty($attachment) > 0) {
        if (is_file($attachment)) {
            $message .= "--{$mimeBoundary}\n";
            $fp = fopen($attachment, "rb");
            $data = fread($fp, filesize($attachment));

            fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($attachment) . "\"\n" .
                "Content-Description: " . basename($attachment) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename($attachment) . "\"; size=" . filesize($attachment) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }

    $message .= "--{$mimeBoundary}--";
    $toAddress = implode(',', array_filter($toAddress));

    // Send E-Mail
    if (mail($toAddress, $subject, $message, $headers)):
        return TRUE;
    else:
        return FALSE;
    endif;
}