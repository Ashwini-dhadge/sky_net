<?php init_header(); ?>

<style>
    /* .main-content {
        padding: 10px;
    } */

    .page-dashboard {
        background: #f5f7fb;
        padding-bottom: 30px;
    }

    .welcome-card {
        background: #fff;
        border-radius: 14px;
        padding: 16px 25px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .05);

        display: flex;
        align-items: center;
        gap: 20px;
    }

    .welcome-left h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #111827;
    }

    .welcome-left span {
        font-size: 13px;
        color: #de3f3f;
    }

    #liveTime {
        color: #de3f3f;
    }

    .welcome-center,
    .welcome-right {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #374151;
        font-weight: 500;
    }

    .welcome-right {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }

    .welcome-divider {
        width: 1px;
        height: 35px;
        background: #e5e7eb;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .stat-title {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .icon-blue {
        background: #eef2ff;
        color: #4f46e5;
    }

    .icon-green {
        background: #ecfdf5;
        color: #10b981;
    }

    .icon-orange {
        background: #fff7ed;
        color: #f97316;
    }

    .icon-red {
        background: #fef2f2;
        color: #ef4444;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .05);
        padding: 20px;
        margin-bottom: 24px;
    }

    .dashboard-card h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .card-subtitle {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 18px;
    }

    .mini-box {
        background: #f9fafb;
        border-radius: 14px;
        padding: 15px;
        border: 1px solid #eef0f4;
        margin-bottom: 14px;
    }

    .mini-box h4 {
        font-weight: 700;
        margin-bottom: 3px;
    }

    .mini-box span {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
    }

    .alert-stat {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .05);
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 100%;
    }

    .alert-stat h3 {
        font-weight: 700;
        margin-bottom: 2px;
    }

    .alert-stat span {
        font-size: 13px;
        color: #6b7280;
    }

    .filter-box {
        background: #f9fafb;
        border: 1px solid #eef0f4;
        padding: 16px;
        border-radius: 14px;
        margin-bottom: 16px;
    }

    .table thead th {
        background: #f9fafb;
        font-size: 12px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 700;
    }

    .table td {
        font-size: 13px;
        vertical-align: middle;
    }

    #enrollmentTypeChart,
    #courseStudentChart,
    #studentCourseTypeChart,
    #pie_chart {
        min-height: 310px;
    }
</style>

<div class="main-content page-dashboard">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <div>
                            <h4 class="my-3 px-3">Dashboard</h4>
                        </div>
                        <div>
                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent">
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
                                    <!-- <li class="breadcrumb-item active" aria-current="page">Library</li> -->
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 mb-3">
                        <div class="welcome-card">

                            <div class="welcome-left">
                                <h5>Welcome <?= $this->session->userdata('name') ?></h5>
                                <span>LMS Dashboard</span>
                            </div>

                            <div class="welcome-divider"></div>

                            <div class="welcome-center">
                                <i class="mdi mdi-calendar-month-outline"></i>
                                <span id="liveDate"></span>
                            </div>

                            <div class="welcome-divider"></div>

                            <!-- <div class="welcome-right">
                                <i class="mdi mdi-clock-outline"></i>
                                <span id="liveTime"></span>
                            </div> -->

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div>
                                <div class="stat-value"><?= $total_users ?? 0 ?></div>
                                <div class="stat-title">Total Users</div>
                            </div>
                            <div class="stat-icon icon-blue">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div>
                                <div class="stat-value"><?= $total_students ?? 0 ?></div>
                                <div class="stat-title">Active Students</div>
                            </div>
                            <div class="stat-icon icon-green">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div>
                                <div class="stat-value"><?= $total_instructors ?? 0 ?></div>
                                <div class="stat-title">Instructors</div>
                            </div>
                            <div class="stat-icon icon-orange">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card">
                            <div>
                                <div class="stat-value"><?= $total_courses ?? 0 ?></div>
                                <div class="stat-title">Active Courses</div>
                            </div>
                            <div class="stat-icon icon-red">
                                <i class="fas fa-book-open"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mt-2">

                    <div class="col-lg-4">
                        <div class="dashboard-card" style="height: 436px;">
                            <h5 class="text-danger py-1">Online / Offline Summary</h5>
                            <div class="card-subtitle">Student and course mode overview</div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mini-box">
                                        <h4 class="text-primary"><?= $online_students ?? 0 ?></h4>
                                        <span>Online Students</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mini-box">
                                        <h4 class="text-warning"><?= $offline_students ?? 0 ?></h4>
                                        <span>Offline Students</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mini-box">
                                        <h4 class="text-info"><?= $online_courses ?? 0 ?></h4>
                                        <span>Online Courses</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mini-box">
                                        <h4 class="text-danger"><?= $offline_courses ?? 0 ?></h4>
                                        <span>Offline Courses</span>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="dashboard-card">
                            <h5 class="text-danger py-1">Enrollment Type Analytics</h5>
                            <div class="card-subtitle">
                                Online/offline students enrolled in online/offline courses
                            </div>
                            <div id="enrollmentTypeChart"></div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="dashboard-card">
                            <h5 class="text-danger py-1">Courses Wise Sale Count %</h5>
                            <div class="card-subtitle">Course sale distribution</div>
                            <div id="studentCourseTypeChart"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="dashboard-card">
                            <h5 class="text-danger py-1">Course vs Enrolled Students</h5>
                            <div class="card-subtitle">Top enrolled courses</div>
                            <div id="courseStudentChart"></div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <div class="alert-stat">
                            <div>
                                <h3 class="text-warning">
                                    <?= !empty($pending_forum) ? count($pending_forum) : 0 ?>
                                </h3>
                                <span>Pending Forum</span>
                            </div>
                            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="alert-stat">
                            <div>
                                <h3 class="text-danger">
                                    <?= !empty($rejected_forum) ? count($rejected_forum) : 0 ?>
                                </h3>
                                <span>Rejected Forum</span>
                            </div>
                            <i class="fas fa-ban fa-2x text-danger"></i>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="alert-stat">
                            <div>
                                <h3 class="text-info">
                                    <?= !empty($unanswered_qna) ? count($unanswered_qna) : 0 ?>
                                </h3>
                                <span>Unanswered QnA</span>
                            </div>
                            <i class="fas fa-question-circle fa-2x text-info"></i>
                        </div>
                    </div>

                </div>

                <div class="dashboard-card">
                    <h5 class="text-danger py-1">Forum Questions</h5>
                    <div class="card-subtitle">Review pending, approved and rejected forum questions</div>

                    <div class="filter-box">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="font-weight-bold mb-1">Status</label>
                                <select id="statusFilter" class="form-control">
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="pendingTable"
                            class="table table-hover table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                        </table>
                    </div>

                    <div class="modal fade" id="rejectModal" tabindex="-1">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Reject Question</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" id="reject_forum_id">

                                    <label>Reason for rejection</label>
                                    <textarea id="reject_reason" class="form-control" rows="4"
                                        placeholder="Enter reason..." required></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button class="btn btn-danger" id="confirmReject">
                                        Reject
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <h5 class="text-danger py-1">Course QnA</h5>
                    <div class="card-subtitle">Filter course questions and unanswered queries</div>

                    <div class="filter-box">
                        <div class="row align-items-end">

                            <div class="col-md-4 mb-2">
                                <label class="font-weight-bold mb-1">Course</label>
                                <select id="filter_course" class="form-control select2">
                                    <option value="">All Courses</option>
                                    <?php foreach ($courses as $c) { ?>
                                        <option value="<?= $c['id']; ?>">
                                            <?= $c['title']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="filter_unanswered">
                                    <label class="form-check-label" for="filter_unanswered">
                                        Unanswered First
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php $this->load->view(ADMIN . QUESTION . 'table-question'); ?>
                </div>

                <?php $this->load->view(ADMIN . QUESTION . 'qnamodal'); ?>

            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>
<script>
    function updateDashboardClock() {

        const now = new Date();

        document.getElementById('liveDate').innerHTML =
            now.toLocaleDateString('en-IN', {
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

        document.getElementById('liveTime').innerHTML =
            now.toLocaleTimeString('en-IN', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
    }

    updateDashboardClock();

    setInterval(updateDashboardClock, 1000);
</script>

<script>
    function openRejectModal(id) {
        $('#reject_forum_id').val(id);
        $('#rejectModal').modal('show');
    }
</script>

<script src="<?= base_url(); ?>assets/js/custom-js/forum.js"></script>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/dashboard.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/question.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        var onlineStudents = <?= (int) ($online_students ?? 0) ?>;
        var offlineStudents = <?= (int) ($offline_students ?? 0) ?>;
        var onlineCourses = <?= (int) ($online_courses ?? 0) ?>;
        var offlineCourses = <?= (int) ($offline_courses ?? 0) ?>;

        var enrollOO = <?= (int) ($enroll_online_student_online_course ?? 0) ?>;
        var enrollFF = <?= (int) ($enroll_offline_student_offline_course ?? 0) ?>;
        var enrollOF = <?= (int) ($enroll_online_student_offline_course ?? 0) ?>;
        var enrollFO = <?= (int) ($enroll_offline_student_online_course ?? 0) ?>;

        var courseNames = [
            <?php foreach ($course_student_chart as $c) {
                echo "'" . addslashes($c->title) . "',";
            } ?>
        ];

        var studentCounts = [
            <?php foreach ($course_student_chart as $c) {
                echo (int) $c->total_students . ",";
            } ?>
        ];

        if (document.querySelector("#studentCourseTypeChart")) {
            new ApexCharts(document.querySelector("#studentCourseTypeChart"), {
                chart: {
                    type: 'pie',
                    height: 370,
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    onlineStudents,
                    offlineStudents,
                    onlineCourses,
                    offlineCourses
                ],
                labels: [
                    'Online Students',
                    'Offline Students',
                    'Online Courses',
                    'Offline Courses'
                ],
                colors: [
                    '#4f46e5',
                    '#f59e0b',
                    '#06b6d4',
                    '#ef4444'
                ],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '68%'
                        }
                    }
                }
            }).render();
        }

        if (document.querySelector("#enrollmentTypeChart")) {
            new ApexCharts(document.querySelector("#enrollmentTypeChart"), {
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                        name: 'Online Students',
                        data: [enrollOO, enrollOF]
                    },
                    {
                        name: 'Offline Students',
                        data: [enrollFO, enrollFF]
                    }
                ],
                xaxis: {
                    categories: [
                        'Online Courses',
                        'Offline Courses'
                    ]
                },
                colors: [
                    '#e54646',
                    '#f59e0b'
                ],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '42%'
                    }
                },
                dataLabels: {
                    enabled: true
                },
                grid: {
                    borderColor: '#eef0f4',
                    strokeDashArray: 4
                },
                legend: {
                    position: 'top'
                }
            }).render();
        }

        if (document.querySelector("#courseStudentChart") && courseNames.length > 0) {
            new ApexCharts(document.querySelector("#courseStudentChart"), {
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Students',
                    data: studentCounts
                }],
                xaxis: {
                    categories: courseNames
                },
                colors: [
                    '#e54a4a'
                ],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 8
                    }
                },
                dataLabels: {
                    enabled: true
                },
                grid: {
                    borderColor: '#eef0f4',
                    strokeDashArray: 4
                }
            }).render();
        }

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        var saleLabels = [
            <?php
            if (!empty($course_wise_sale)) {
                foreach ($course_wise_sale as $row) {
                    echo "'" . addslashes($row['title']) . "',";
                }
            }
            ?>
        ];

        var saleData = [
            <?php
            if (!empty($course_wise_sale)) {
                foreach ($course_wise_sale as $row) {
                    echo (int) $row['total'] . ",";
                }
            }
            ?>
        ];

        if (
            document.querySelector("#pie_chart") &&
            saleData.length > 0
        ) {

            var pieChart = new ApexCharts(
                document.querySelector("#pie_chart"), {

                    chart: {
                        type: 'donut',
                        height: 320
                    },

                    series: saleData,

                    labels: saleLabels,

                    legend: {
                        position: 'bottom'
                    },

                    dataLabels: {
                        enabled: true
                    },

                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%'
                            }
                        }
                    },

                    colors: [
                        '#4f46e5',
                        '#06b6d4',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#14b8a6'
                    ]
                }
            );

            pieChart.render();
        }

    });
</script>