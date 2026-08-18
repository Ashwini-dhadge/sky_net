<style>
    .vertical-menu {
        background: #1f2937;
        width: 270px;
    }

    .menu-title {
        color: #9ca3af !important;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 18px 20px 8px;
    }

    #side-menu li a {
        color: #565656 !important;
        font-size: 12.5px;
        font-weight: 500;
        padding: 12px 20px;
        margin: 4px 10px;
        border-radius: 10px;
        transition: all .3s ease;
    }

    #side-menu li a i {
        width: 22px;
        text-align: center;
        color: #f3f3f3;
    }

    #side-menu li a:hover {
        background: #ff000044;
        color: #fff !important;
    }

    #side-menu .mm-active>a {
        background: #eb2525b0 !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, .3);
    }

    #side-menu .mm-active>a i {
        color: #fff !important;
    }

    .sub-menu {
        background: #ff616112;
        margin: 0 10px;
        border-radius: 8px;
        font-size: 12.5px;
    }
</style>
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- DASHBOARD -->
                <li class="menu-title">
                    <i class="fas fa-home mr-1"></i> Dashboard
                </li>

                <li>
                    <a href="<?= base_url('admin'); ?>" class="waves-effect">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard Overview</span>
                    </a>
                </li>

                <?php if ($this->session->userdata('role') == 1) { ?>
                    <!-- USER MANAGEMENT -->
                    <li class="menu-title">
                        <i class="fas fa-users-cog mr-1"></i> User Management
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-users"></i>
                            <span>Manage Users</span>
                        </a>

                        <ul class="sub-menu">
                            <li>
                                <a href="<?= base_url('admin/User/') ?>">
                                    <i class="fas fa-user"></i> All Users
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('admin/Student') ?>">
                                    <i class="fas fa-user-graduate"></i> Students
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('admin/User/index1') ?>">
                                    <i class="fas fa-chalkboard-teacher"></i> Instructors
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- LMS -->
                <li class="menu-title">
                    <i class="fas fa-graduation-cap mr-1"></i> Learning Management
                </li>

                <li>
                    <a href="<?= base_url('admin/Course/') ?>" class="waves-effect">
                        <i class="fas fa-book-open"></i>
                        <span>Courses</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/Certificate/') ?>" class="waves-effect">
                        <i class="fas fa-award"></i>
                        <span>Certificates</span>
                    </a>
                </li>

                <!-- COMMUNITY -->
                <li class="menu-title">
                    <i class="fas fa-comments mr-1"></i> Community
                </li>

                <li>
                    <a href="<?= base_url('admin/Forum/pending') ?>" class="waves-effect">
                        <i class="fas fa-clock"></i>
                        <span>Pending Topics</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/Forum/listing') ?>" class="waves-effect">
                        <i class="fas fa-comment-dots"></i>
                        <span>Forum Discussions</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/QuestionAnswer') ?>" class="waves-effect">
                        <i class="fas fa-question-circle"></i>
                        <span>Q & A Board</span>
                    </a>
                </li>

                <!-- REPORTS -->
                <li class="menu-title">
                    <i class="fas fa-chart-bar mr-1"></i> Analytics & Reports
                </li>

                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-file-alt"></i>
                        <span>Reports</span>
                    </a>

                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('admin/SaleReport') ?>">
                                Course Sales Report
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/UserCourseProgressReport') ?>">
                                Course Performance
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/LearnerProgressReport') ?>">
                                Learner Progress
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/UserResultReport') ?>">
                                User Results
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/FinalExamReport') ?>">
                                Final Exam Results
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if ($this->session->userdata('role') == 1) { ?>

                    <!-- SETTINGS -->
                    <li class="menu-title">
                        <i class="fas fa-cogs mr-1"></i> Settings
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-tools"></i>
                            <span>Master Data</span>
                        </a>

                        <ul class="sub-menu">
                            <li>
                                <a href="<?= base_url('admin/Category/') ?>">
                                    <i class="fas fa-tags"></i>
                                    Categories
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/Batch/') ?>">
                                    <i class="fas fa-layer-group"></i>
                                    Batch Master
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php } ?>

            </ul>
        </div>
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