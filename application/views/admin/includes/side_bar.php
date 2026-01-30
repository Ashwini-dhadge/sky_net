<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="<?= base_url(); ?>" class="waves-effect ">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">User Management</li>
                <li>
                    <a href="<?= base_url('admin/User/'); ?>" class=" waves-effect">
                        <i class="fas fa-user"></i>
                        <span>User</span>
                    </a>

                </li>
                <!-- <li><a href="<?= base_url(ADMIN . 'Order/'); ?>" class="waves-effect"><i
                            class="fas fa-file-invoice"></i><span>Orders</span></a></li> -->
                <li class="menu-title">Instructor Management</li>
                <li>
                    <a href="<?= base_url('admin/User/index1'); ?>" class=" waves-effect">
                        <i class="fas fa-user"></i>
                        <span>Instructor</span>
                    </a>
                </li>
                <li class="menu-title">Course Management</li>
                <li>
                    <a href="<?= base_url('admin/Course/'); ?>" class=" waves-effect">
                        <i class="fas fa-hotel"></i>
                        <span>Course List</span>
                    </a>
                </li>
                <li class="menu-title">Section Management</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-notepad"></i>
                        <span>Section</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('admin/Lesson/') ?>">Section List</a></li>
                        <li><a href="<?= base_url('admin/LessonVideoMcq/') ?>">Lesson Mcq List</a></li>
                    </ul>
                </li>
                <li class="menu-title">Video Management</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-notepad"></i>
                        <span>Video</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('admin/Video/') ?>">Video List</a></li>
                        <!-- <li><a href="<?= base_url('admin/LessonVideoMcq/') ?>">Lesson Mcq List</a></li> -->
                    </ul>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button><?= $msg ?>
    </div>
<?php endif ?>
<?php if ($msg = $this->session->flashdata('error')): ?>
    <div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert"
            aria-label="Close"><span aria-hidden="true">&times;</span></button><?= $msg ?></div>
<?php endif ?>