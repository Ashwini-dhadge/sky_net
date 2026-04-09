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
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <div>
                                                            <label for="">Select Course Type</label>
                                                            <select id="course_type" name="course_type"
                                                                class="form-control select2" onchange="filter_order()">
                                                                <option value=""></option>
                                                                <option value="0">Offile</option>
                                                                <option value="1">Online</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div>
                                                            <label for="">Select Course</label>
                                                            <select id="course_id" name="course_id"
                                                                class="form-control select2" onchange="filter_order()">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div>
                                                            <label for="">Select Student</label>
                                                            <select id="user_id" name="user_id"
                                                                class="form-control select2" onchange="filter_order()">

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-3 ">
                                                        <div class="mt-4">
                                                            <button class="btn btn-info mt-1" onclick="resetFilter()">
                                                                Rest
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Final Exam Report
                                            </h4>
                                            <br>
                                            <table id="report_sales" class="table table-striped dt-responsive"
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
        <?php init_footer(); ?>
        <script src="<?= base_url(); ?>assets/js/custom-js/final_exam_report.js?v=1.0.7"></script>
        <!-- Plugins js -->