<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <li>
                <a class="<?php echo (isset($tabActive) && $tabActive == 'dashboard') ? 'active' : ''; ?>"
                   href="<?php echo baseUrl('index.php'); ?>">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php
            $roleId = $_SESSION['admin_login_info']['role_id']; // super admin user id from session
            $organizationId = $_SESSION['admin_login_info']['organization_id']; // organization_id from session

            $currentFileName = basename(__FILE__);
            //$permissionArray = getMenuPermission($roleId, $organizationId);


             if($roleId = '21' && $organizationId = '9')
            {
                $permissionArray = [
                    'Service Reporting' => [
                        'content_delivery_report.php',
                    ]
                ];
            }


            /*       print "<pre>";
                   print_r($permissionArray);
                   print "</pre>";
                   exit;*/
            if (!empty($permissionArray)) {

                foreach ($permissionArray as $menu => $subMenu) { ?>

                    <li class="sub-menu">
                        <a href="javascript:void(0)" <?php echo (isset($tabActive) && $tabActive == $menu) ? 'class="active"' : ''; ?>>
                            <i class="fa fa-ambulance"></i>
                            <span><?php
                                $msgMenu = str_replace('_', ' ', $menu);
                                $msgMenu = str_replace('newspaper', '', $msgMenu);
                                $msgMenu = str_replace('nestle bd', '', $msgMenu);
                                $msgMenu = ucwords($msgMenu);
                                echo $msgMenu; ?></span>
                        </a>
                        <ul class="sub">
                            <?php foreach ($subMenu as $subMenuField) {
                                if (strpos($subMenuField, 'delete') !== false)
                                    continue;
                                elseif (strpos($subMenuField, 'update') !== false)
                                    continue;
                                elseif (strpos($subMenuField, 'edit') !== false)
                                    continue;
                                elseif (strpos($subMenuField, 'permission') !== false)
                                    continue;
                                elseif (strpos($subMenuField, 'push') !== false)
                                    continue;
                                else {
                                    $msgSubMenu = str_replace('_', ' ', str_replace('.php', '', $subMenuField));
                                    $msgSubMenu = ucwords(str_replace('admin', '', $msgSubMenu));
                                    ?>

                                    <li <?php echo isset($subTabActive) && $subTabActive == str_replace('.php', '', $subMenuField) ? 'class="active"' : ''; ?>>
                                        <a href="<?php echo baseUrl($menu . '/' . $subMenuField); ?>"><i
                                                    class="fa fa-eye"></i><?php echo $msgSubMenu; ?></a>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>