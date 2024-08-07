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
            $permissionArray = getMenuPermission($roleId, $organizationId);
            //   print_r($permissionArray);
            //   exit();

            foreach ($permissionArray as $menu => $subMenu) { ?>

                <li class="sub-menu">
                    <a href="javascript:void(0)" <?php echo (isset($tabActive) && $tabActive == $menu) ? 'class="active"' : ''; ?>>
                        <i class="fa fa-ambulance"></i>
                        <span><?php
                            $msgMenu = str_replace('_', ' ', $menu);
                            $msgMenu = str_replace('newspaper', '', $msgMenu);
                            $msgMenu = str_replace('reckitt', '', $msgMenu);
                            $msgMenu = str_replace('benckiser', '', $msgMenu);
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

            <!-- <?php /*if ($roleId == 1) { */ ?>

                <li class="sub-menu">

                    <a href="javascript:void(0)" <?php /*echo (isset($tabActive) && $tabActive == 'modules') ? 'class="active"' : ''; */ ?>>
                        <i class="fa fa-bars"></i>
                        <span>Modules</span>
                    </a>

                    <ul class="sub">

                        <li <?php /*echo isset($subTabActive) && $subTabActive == 'module_manage' ? 'class="active"' : ''; */ ?>>
                            <a href="<?php /*echo baseUrl('modules/manage_module.php'); */ ?>">Manage Module</a>
                        </li>

                        <li <?php /*echo isset($subTabActive) && $subTabActive == 'module_add' ? 'class="active"' : ''; */ ?>>
                            <a href="<?php /*echo baseUrl('modules/add_module.php'); */ ?>">Module Add</a>
                        </li>

                        <li <?php /*echo isset($subTabActive) && $subTabActive == 'module_action_manage' ? 'class="active"' : ''; */ ?>>
                            <a href="<?php /*echo baseUrl('modules/manage_module_action.php'); */ ?>">Manage Module
                                Action</a>
                        </li>

                        <li <?php /*echo isset($subTabActive) && $subTabActive == 'add_module_action' ? 'class="active"' : ''; */ ?>>
                            <a href="<?php /*echo baseUrl('modules/add_module_action.php'); */ ?>">Module Action Add</a>
                        </li>

                    </ul>
                </li>
            --><?php /*} */ ?>

            <!-- <li class="sub-menu">
                <a href="javascript:void(0)" <?php /*echo (isset($tabActive) && $tabActive == 'quiz_reporting') ? 'class="active"' : ''; */ ?>>
                    <i class="fa fa-sitemap "></i>
                    <span>Telenor EL Reports</span>
                </a>
                <ul class="sub">
                    <li <?php /*echo isset($subTabActive) && $subTabActive == 'quiz_charging_log' ? 'class="active"' : ''; */ ?>>
                        <a href="<?php /*echo baseUrl('quiz_reporting/quiz_charging_log.php'); */ ?>">Charging Log</a>
                    </li>

                    <li <?php /*echo isset($subTabActive) && $subTabActive == 'quiz_completion_status' ? 'class="active"' : ''; */ ?>>
                        <a href="<?php /*echo baseUrl('quiz_reporting/quiz_completion_status.php'); */ ?>">Chapter Completion
                            Status</a>
                    </li>

                    <li <?php /*echo isset($subTabActive) && $subTabActive == 'quiz_log' ? 'class="active"' : ''; */ ?>>
                        <a href="<?php /*echo baseUrl('quiz_reporting/quiz_log.php'); */ ?>">Question Log</a>
                    </li>
                </ul>
            </li>-->
            <!--multi level menu start-->
            <!--            <li class="sub-menu">
                            <a href="javascript:;" >
                                <i class="fa fa-sitemap"></i>
                                <span>Multi level Menu</span>
                            </a>
                            <ul class="sub">
                                <li><a  href="javascript:;">Menu Item 1</a></li>
                                <li class="sub-menu">
                                    <a  href="boxed_page.html">Menu Item 2</a>
                                    <ul class="sub">
                                        <li><a  href="javascript:;">Menu Item 2.1</a></li>
                                        <li class="sub-menu">
                                            <a  href="javascript:;">Menu Item 3</a>
                                            <ul class="sub">
                                                <li><a  href="javascript:;">Menu Item 3.1</a></li>
                                                <li><a  href="javascript:;">Menu Item 3.2</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
            <!--multi level menu end-->
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>