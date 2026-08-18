<?php init_header(); ?>
<style>
    /* card wrapper */
    .progress-card {
        width: 180px;
        font-family: "Segoe UI", Arial, sans-serif;
    }

    /* top label row */
    .progress-head {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 6px;
        color: #6c757d;
    }

    /* main progress container */
    .enterprise-progress {
        height: 12px;
        background: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }

    /* progress base */
    .enterprise-progress .progress-bar {
        height: 100%;
        border-radius: 4px;
    }

    /* corporate colors */
    .p-excellent {
        background: #28a745;
    }

    /* green */
    .p-good {
        background: #17a2b8;
    }

    /* blue */
    .p-average {
        background: #ffc107;
    }

    /* yellow */
    .p-zero {
        background: #dc3545;
    }

    /* red */
</style>


<style>
    .exam-card {
        width: 420px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
        overflow: hidden;
        font-family: Segoe UI;
    }

    /* top gold header */
    .exam-header {
        background: linear-gradient(135deg, #48bc97, #2f9e85);
        color: #fff;
        padding: 18px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .student-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .exam-title {
        font-weight: 600;
        font-size: 16px;
    }

    .exam-sub {
        font-size: 13px;
        opacity: .9;
    }

    .score-box {
        text-align: right;
    }

    .score-box span {
        font-size: 13px;
    }

    .score-big {
        font-size: 26px;
        font-weight: 700;
    }

    /* body */
    .exam-body {
        padding: 22px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: #555;
        font-size: 14px;
    }

    /* stat boxes */
    .exam-stats {
        display: flex;
        gap: 15px;
        margin: 18px 0;
    }

    .stat {
        flex: 1;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }

    .stat-blue {
        background: #eaf1ff;
        color: #2b63ff;
    }

    .stat-green {
        background: #eaf7ee;
        color: #1e9b4f;
    }

    .stat-red {
        background: #fdecec;
        color: #e03131;
    }

    .stat-number {
        font-size: 20px;
        font-weight: 700;
    }

    .progress-label {
        text-align: center;
        margin-top: 10px;
        color: #666;
    }

    .progress-bar-custom {
        height: 8px;
        background: #e9ecef;
        border-radius: 20px;
        overflow: hidden;
        margin-top: 10px;
    }

    .progress-fill-custom {
        height: 100%;
        background: #e03131;
    }

    .view-qa {
        text-align: center;
        margin-top: 18px;
        color: #c79a2b;
        font-weight: 600;
        cursor: pointer;
    }
</style>


<style>

</style>
<div class="main-content">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Learning Progress Report</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/LearnerProgressReport') ?>">Learning Progress Report</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Listing</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="custom-validation"
                                    action="<?= base_url() . 'admin/SaleReport/downloadSaleReport' ?>"
                                    method="post">
                                    <div class="row">
                                        <div class="form-group col-md-2 col-sm-6">
                                            <div>
                                                <label for="">Select Batch</label>
                                                <select id="batch_id" name="batch_id"
                                                    class="form-control select2" onchange="filter_order()">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 col-sm-6">
                                            <div>
                                                <label for="">Select Course</label>
                                                <select id="course_id" name="course_id"
                                                    class="form-control select2"
                                                    onchange="filter_order()">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 col-sm-6">
                                            <div>
                                                <label for="">Select Section</label>
                                                <select id="section_id" name="section_id"
                                                    class="form-control select2"
                                                    onchange="filter_order()">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 col-sm-6">
                                            <div>
                                                <label for="">Select Lesson</label>
                                                <select id="lesson_id" name="lesson_id"
                                                    class="form-control select2"
                                                    onchange="filter_order()">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 col-sm-6">
                                            <div>
                                                <label for="">Select Student</label>
                                                <select id="user_id" name="user_id"
                                                    class="form-control select2"
                                                    onchange="filter_order()">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2 col-sm-6">
                                            <div class="mt-4">
                                                <button type="button" class="btn btn-danger btn-block"
                                                    onclick="resetFilters()">
                                                    Reset
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </form>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Learner Progress Report
                                            </h4>
                                            <br>
                                            <table id="report_sales" class="table table-striped dt-responsive"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            </table>
                                            <div id="resultDashboard" style="display:none;margin-top:20px;">
                                                <div id="resultCardContainer"></div>
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
        <script src="<?= base_url(); ?>assets/js/custom-js/learner_progress_report.js?v=1.0.7"></script>
        <!-- Plugins js -->