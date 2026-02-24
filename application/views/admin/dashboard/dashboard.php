<?php init_header(); ?>

<style>
    /* .page-content {
        background: #f4f6f9;
    } */

    .dashboard-title h4 {
        font-weight: 600;
        color: #333;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        padding: 18px 20px;
        transition: 0.3s ease;
        border-left: 4px solid;
    }

    .stat-card:hover {
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
    }

    .stat-value {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .stat-title {
        font-size: 13px;
        color: #888;
    }

    .stat-icon {
        font-size: 20px;
        opacity: 0.8;
    }

    .border-red {
        border-color: #e74c3c;
    }

    .border-cyan {
        border-color: #1abc9c;
    }

    .border-blue {
        border-color: #3498db;
    }

    .border-yellow {
        border-color: #f1c40f;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        padding: 20px;
        margin-bottom: 25px;
    }

    .dashboard-card h5 {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 15px;
    }

    .dashboard-table thead {
        background: #f8f9fb;
    }

    .dashboard-table th {
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        color: #666;
    }

    .dashboard-table td {
        font-size: 13px;
    }

    .dashboard-table tbody tr:hover {
        background: #f5f7fa;
    }

    .badge-pending {
        background: #ffc107;
        font-size: 11px;
        padding: 4px 8px;
    }

    .badge-unanswered {
        background: #17a2b8;
        font-size: 11px;
        padding: 4px 8px;
        color: #fff;
    }

    .section-space {
        margin-top: 30px;
    }

    .btn-group .btn {
        border-radius: 4px !important;
        margin-right: 3px;
    }

    .badge {
        font-size: 12px;
        letter-spacing: .4px;
    }

    .table-hover tbody tr:hover {
        background: #f7fbff;
    }
    
</style>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <div class="row mb-4 dashboard-title">
                    <div class="col-sm-6">
                        <h4>Dashboard</h4>
                        <p class="text-muted mb-0">Welcome to Dashboard</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card border-red d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value"><?= $total_users ?? 0 ?></div>
                                <div class="stat-title">Total Users</div>
                            </div>
                            <i class="fas fa-users stat-icon text-danger"></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card border-cyan d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value"><?= $total_students ?? 0 ?></div>
                                <div class="stat-title">Active Students</div>
                            </div>
                            <i class="fas fa-user-graduate stat-icon text-info"></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card border-blue d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value"><?= $total_instructors ?? 0 ?></div>
                                <div class="stat-title">Instructors</div>
                            </div>
                            <i class="fas fa-chalkboard-teacher stat-icon text-primary"></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card border-yellow d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value"><?= $total_courses ?? 0 ?></div>
                                <div class="stat-title">Active Courses</div>
                            </div>
                            <i class="fas fa-book-open stat-icon text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="row section-space">
                    <div class="col-lg-4">
                        <div class="dashboard-card" style="height: stretch;">
                            <h5>Online / Offline Summary</h5>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="stat-card border-blue d-flex justify-content-between align-items-center" style="padding:12px 14px;">
                                        <div>
                                            <div class="stat-value"><?= $online_students ?? 0 ?></div>
                                            <div class="stat-title">Online Students</div>
                                        </div>
                                        <i class="fas fa-wifi stat-icon text-primary"></i>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="stat-card border-yellow d-flex justify-content-between align-items-center" style="padding:12px 14px;">
                                        <div>
                                            <div class="stat-value"><?= $offline_students ?? 0 ?></div>
                                            <div class="stat-title">Offline Students</div>
                                        </div>
                                        <i class="fas fa-user stat-icon text-warning"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="stat-card border-cyan d-flex justify-content-between align-items-center" style="padding:12px 14px;">
                                        <div>
                                            <div class="stat-value"><?= $online_courses ?? 0 ?></div>
                                            <div class="stat-title">Online Courses</div>
                                        </div>
                                        <i class="fas fa-laptop stat-icon text-info"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="stat-card border-red d-flex justify-content-between align-items-center" style="padding:12px 14px;">
                                        <div>
                                            <div class="stat-value"><?= $offline_courses ?? 0 ?></div>
                                            <div class="stat-title">Offline Courses</div>
                                        </div>
                                        <i class="fas fa-building stat-icon text-danger"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="dashboard-card">
                            <h5>Enrollment by Student Type & Course Type</h5>
                            <div id="enrollmentTypeChart" style="height:320px;"></div>
                        </div>
                    </div>
                </div>

                <div class="row section-space">

                    <div class="col-lg-6">
                        <div class="dashboard-card">
                            <h5>Courses Wise Sale Count %</h5>
                            <div id="pie_chart" class="apex-charts"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-card">
                            <h5>Course vs Enrolled Students</h5>
                            <div id="courseStudentChart"></div>
                        </div>
                    </div>
                </div>



                <div class="row section-space">
                    <div class="col-lg-12">
                        <div class="dashboard-card">
                            <h5 class="text-warning">Forum Questions</h5>
                            <div class="row">
                                <div class="col-md-6 from-group">
                                    <select id="statusFilter" class="form-control w-50">
                                        <option value="0" selected>Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 text-muted small">
                                (Pending questions require Super Admin approval)
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
                                            <textarea id="reject_reason" class="form-control" rows="4" placeholder="Enter reason..." required></textarea>
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
                    </div>
                </div>

                <div class="row section-space">
                    <div class="col-lg-12">
                        <div class="dashboard-card">
                            <h5 class="text-info">Course QnA</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <select id="filter_course" class="form-control select2">
                                        <option value="">All Courses</option>
                                        <?php foreach ($courses as $c) { ?>
                                            <option value="<?= $c['id']; ?>">
                                                <?= $c['title']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="filter_unanswered">
                                        <label class="form-check-label" for="filter_unanswered">
                                            Unanswered First
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php $this->load->view(ADMIN . QUESTION . 'table-question'); ?>
                        </div>
                    </div>
                    <?php $this->load->view(ADMIN . QUESTION . 'qnamodal'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>
<script>
    function openRejectModal(id) {
        document.getElementById('rejectId').value = id;
        $('#rejectModal').modal('show');
    }
</script>
<script src="<?= base_url(); ?>assets/js/custom-js/forum.js"></script>
<script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/dashboard.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/question.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var enrollOO = <?= (int)($enroll_online_student_online_course ?? 0) ?>;
        var enrollFF = <?= (int)($enroll_offline_student_offline_course ?? 0) ?>; 
        var enrollOF = <?= (int)($enroll_online_student_offline_course ?? 0) ?>;
        var enrollFO = <?= (int)($enroll_offline_student_online_course ?? 0) ?>; 

        var optionsEnroll = {
            chart: {
                type: 'area',
                height: 320,
                stacked: true,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 900
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
                categories: ['Online Courses', 'Offline Courses']
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    columnWidth: '20%'
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.95,
                    opacityTo: 0.85,
                    stops: [0, 100]
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 600
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 4
            },
            legend: {
                position: 'top'
            }
        };

        var enrollChart = new ApexCharts(document.querySelector("#enrollmentTypeChart"), optionsEnroll);
        enrollChart.render();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var courseNames = [
            <?php foreach ($course_student_chart as $c) {
                echo "'" . addslashes($c->title) . "',";
            } ?>
        ];

        var studentCounts = [
            <?php foreach ($course_student_chart as $c) {
                echo (int)$c->total_students . ",";
            } ?>
        ];

        if (courseNames.length === 0) return;

        var options = {
            chart: {
                type: 'area',
                height: 315,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },

            series: [{
                name: 'Students',
                data: studentCounts
            }],

            xaxis: {
                categories: courseNames
            },

            dataLabels: {
                enabled: true
            },

            stroke: {
                curve: 'smooth'
                // curve: 'straight'
                // curve: 'stepline'
            },

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 100]
                }
            },

            colors: ['#db9834'],

            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 4
            }
        };

        var chart = new ApexCharts(
            document.querySelector("#courseStudentChart"),
            options
        );

        chart.render();

    });
</script>