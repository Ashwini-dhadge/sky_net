<?php init_header(); ?>

<div class="main-content">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card  mb-4 mt-4">
                            <div class="card-body">

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="custom-validation"
                                                action="<?= base_url() . 'admin/UserWiseCoursesReport/downloadUserWiseCoursesReport/' ?>"
                                                method="post">
                                                <div class="row">

                                                    <div class="form-group col-md-3 ">
                                                        <select id="user_id" name="user_id" class="form-control select2"
                                                            onchange="filter_report()">
                                                            <option value="">Select users</option>
                                                            <?php foreach ($users as $key => $user): ?>
                                                            <option value="<?= $user['id']; ?>">
                                                                <?= $user['first_name'] . " " . $user['last_name']; ?>
                                                            </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3 ">
                                                        <div>
                                                            <input type="submit"
                                                                class="btn btn-success waves-effect waves-light"
                                                                id="submit" name="submit" value="Export">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <h4 class="mt-0 header-title">User Wise Courses package list
                                                    </h4>
                                                </div>
                                            </form>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <table id="report_users_courses"
                                                        class="table table-striped dt-responsive"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php init_footer(); ?>
    <script src="<?= base_url(); ?>assets/js/custom-js/report_user_courses.js?v=1.0.7"></script>
    <!-- Plugins js -->