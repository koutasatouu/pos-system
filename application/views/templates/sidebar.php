<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php if ($this->session->userdata('role_id') == 1) : ?>
        <a href="<?= base_url('admin') ?>" class="brand-link">
            <img src="<?= base_url() ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">POS-System</span>
        </a>
    <?php else : ?>
        <a href="<?= base_url('user') ?>" class="brand-link">
            <img src="<?= base_url() ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">POS-System</span>
        </a>
    <?php endif; ?>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?php if ($this->session->userdata('role_id') == 1) : ?>
                    <a href="<?= base_url('user') ?>" class="d-block"><?= $user['name'] ?></a>
                <?php else : ?>
                    <a href="<?= base_url('user') ?>" class="d-block"><?= $user['name'] ?></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- dashboard -->

                <!-- query menu -->
                <?php
                $role_id = $this->session->userdata('role_id');
                $queryMenu = "SELECT `user_menu`.`id`, `menu`
                                    FROM `user_menu` JOIN `user_access_menu`
                                      ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                                   WHERE `user_access_menu`.`role_id` = $role_id
                                ORDER BY `user_access_menu`.`menu_id` ASC
                                ";
                $menu = $this->db->query($queryMenu)->result_array();
                // var_dump($menu);
                ?>

                <!-- looping menu -->
                <?php foreach ($menu as $m) : ?>
                    <li class="nav-header"><?= $m['menu']; ?></li>
                    <!-- sub-menu -->
                    <?php
                    $menu_id = $m['id'];
                    $querysubMenu = "SELECT *
                                        FROM `user_sub_menu` JOIN `user_menu`
                                          ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                                       WHERE `user_sub_menu`.`menu_id` = $menu_id
                                         AND `user_sub_menu`.`is_active` = 1
                                    ";
                    $subMenu = $this->db->query($querysubMenu)->result_array();
                    ?>

                    <?php foreach ($subMenu as $sm) : ?>
                        <li class="nav-item ">
                            <?php if ($title == $sm['title']) : ?>
                                <a href="<?= base_url($sm['url']) ?>" class="nav-link active">
                                    <i class="nav-icon <?= $sm['icon'] ?> nav-icon"></i>
                                    <p>
                                        <?= $sm['title'] ?>
                                    </p>
                                </a>
                            <?php else : ?>
                                <a href="<?= base_url($sm['url']) ?>" class="nav-link">
                                    <i class="nav-icon <?= $sm['icon'] ?> nav-icon"></i>
                                    <p>
                                        <?= $sm['title'] ?>
                                    </p>
                                </a>
                            <?php endif; ?>

                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <!-- examples -->
                <!-- menu -->

                <!-- <li class="nav-header">Menu</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Example
                        </p>
                    </a>
                </li> -->

                <!-- menu with notification-->

                <!-- <li class="nav-header">Menu + Notification</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Example
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li> -->

                <!-- menu with notification and active-->

                <!-- <li class="nav-header">Menu + Notification + Active</li>
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Example
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li> -->

                <!-- dropdown menu -->

                <!-- <li class="nav-header">Dropdown</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Example
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Example</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Example</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <!-- dropdown menu with notification -->

                <!-- <li class="nav-header">Dropdown + Notification</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Example
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">1</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Example</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <span class="badge badge-info right">1</span>
                                <p>Example</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <!-- dropdown menu with notification and active -->

                <!-- <li class="nav-header">Dropdown + Notification + Active</li>
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Example
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-danger right">1</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Example</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <span class="badge badge-danger right">1</span>
                                <p>Example</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>