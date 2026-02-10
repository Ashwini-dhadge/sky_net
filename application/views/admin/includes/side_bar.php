<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- DASHBOARD -->
                <li class="menu-title">Overview</li>
                <li>
                    <a href="<?= base_url(); ?>" class="waves-effect">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- MASTER -->
                <li class="menu-title">Configuration</li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cogs"></i>
                        <span>Masters</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('admin/Category/') ?>">
                                <i class="fas fa-tags"></i> Categories
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/DurationMaster') ?>">
                                <i class="fas fa-hourglass-half"></i> Durations
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- USERS -->
                <li class="menu-title">User Management</li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users"></i>
                        <span>User Directory</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('admin/User/') ?>">
                                <i class="fas fa-user"></i> Users
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

                <!-- COURSES -->
                <li class="menu-title">Learning Management</li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-book-open"></i>
                        <span>Courses</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('admin/Course/') ?>">
                                <i class="fas fa-book"></i> Course List
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/Section') ?>">
                                <i class="fas fa-layer-group"></i> Sections
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/Lesson/') ?>">
                                <i class="fas fa-play-circle"></i> Lessons
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- FORUM -->
                <li class="menu-title">Community</li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-comments"></i>
                        <span>Forum & Q&A</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('admin/QuestionAnswer/') ?>">
                                <i class="fas fa-question-circle"></i> Q & A Board
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/Forum/pending') ?>">
                                <i class="fas fa-clock"></i> Pending Questions
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/Forum/listing/') ?>">
                                <i class="fas fa-list"></i> Forum Threads
                            </a>
                        </li>
                    </ul>
                </li>

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