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
.result-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 24px;
    margin-top: 15px;
}

.exam-card {
    width: 100%;
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

.empty-result {
    height: 260px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 10px;
}

.empty-title {
    font-size: 20px;
    font-weight: 600;
    color: #444;
}

.empty-sub {
    font-size: 13px;
    color: #888;
}
</style>


<style>
.skeleton-card {
    animation: pulse 1.5s infinite;
}

.skeleton-line {
    height: 12px;
    background: #eee;
    border-radius: 6px;
    margin-bottom: 12px;
}

.skeleton-box {
    height: 60px;
    background: #eee;
    border-radius: 10px;
    margin-top: 15px;
}

@keyframes pulse {
    0% {
        opacity: .6
    }

    50% {
        opacity: 1
    }

    100% {
        opacity: .6
    }
}
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
                                                            <label for="">Select Course</label>
                                                            <select id="course_id" name="course_id"
                                                                class="form-control select2">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div>
                                                            <label for="">Select Student</label>
                                                            <select id="user_id" name="user_id"
                                                                class="form-control select2">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div>
                                                            <label for="">Select Section</label>
                                                            <select id="section_id" name="section_id"
                                                                class="form-control select2">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div>
                                                            <label for="">Select Lesson</label>
                                                            <select id="lesson_id" name="lesson_id"
                                                                class="form-control select2">

                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group col-md-3 ">
                                                        <div>
                                                            <button class="btn btn-info" onclick="applyResult()">
                                                                Apply
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
                                            <h4 class="mt-0 header-title">Learner Result
                                            </h4>

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
        <!-- <script src="<?= base_url(); ?>assets/js/custom-js/user_result_report.js?v=1.0.7"></script> -->
        <!-- Plugins js -->
        <script>
        $(document).ready(function() {
            renderSectionResultCard([]); // show default empty card
        });
        $("#course_id").select2({
            placeholder: "Search Course...",
            allowClear: true,
            width: "100%",
            ajax: {
                url: base_url + "admin/UserCourseProgressReport/list_course",
                type: "get",
                dataType: "json",
                delay: 250,

                data: function(params) {
                    return {
                        searchTerm: params.term, // user typing text
                    };
                },

                processResults: function(response) {
                    return {
                        results: response,
                    };
                },

                cache: true,
            },
        });
        $("#course_id").on("change", function() {
            $("#section_id").val(null).trigger("change");
        });
        $("#section_id").select2({
            placeholder: "Select section first choose course",
            allowClear: true,
            width: "100%",
            ajax: {
                url: base_url + "admin/UserCourseProgressReport/list_section",
                type: "get",
                dataType: "json",
                delay: 250,

                data: function(params) {
                    return {
                        searchTerm: params.term,
                        course_id: $("#course_id").val(),
                    };
                },

                processResults: function(response) {
                    return {
                        results: response,
                    };
                },

                cache: true,
            },
        });
        $("#section_id").on("change", function() {
            $("#lesson_id").val(null).trigger("change");
        });
        $("#lesson_id").select2({
            placeholder: "Select lesson first choose section",
            allowClear: true,
            width: "100%",
            ajax: {
                url: base_url + "admin/UserCourseProgressReport/list_lesson",
                type: "get",
                dataType: "json",
                delay: 250,

                data: function(params) {
                    return {
                        searchTerm: params.term,
                        course_id: $("#course_id").val(),
                        section_id: $("#section_id").val(),
                    };
                },

                processResults: function(response) {
                    return {
                        results: response,
                    };
                },

                cache: true,
            },
        });

        $("#user_id").select2({
            placeholder: "Search User",
            allowClear: true,
            width: "100%",
            ajax: {
                url: base_url + "admin/UserCourseProgressReport/list_user",
                type: "get",
                dataType: "json",
                delay: 250,

                data: function(params) {
                    return {
                        searchTerm: params.term,
                    };
                },

                processResults: function(response) {
                    return {
                        results: response,
                    };
                },

                cache: true,
            },
        });

        function applyResult() {

            if (!$("#course_id").val() || !$("#user_id").val()) {
                alert("Please select course and user to view result");
                return;
            }
            viewSectionResult($("#course_id").val(), $("#section_id").val(), $("#lesson_id")
                .val(), $("#user_id").val());
        }

        function showResultLoading() {

            let loadingHTML = `
    <div class="result-grid">
        <div class="exam-card skeleton-card">
            <div class="exam-header"></div>
            <div class="exam-body">
                <div class="skeleton-line"></div>
                <div class="skeleton-line"></div>
                <div class="skeleton-box"></div>
            </div>
        </div>

        <div class="exam-card skeleton-card">
            <div class="exam-header"></div>
            <div class="exam-body">
                <div class="skeleton-line"></div>
                <div class="skeleton-line"></div>
                <div class="skeleton-box"></div>
            </div>
        </div>

        <div class="exam-card skeleton-card">
            <div class="exam-header"></div>
            <div class="exam-body">
                <div class="skeleton-line"></div>
                <div class="skeleton-line"></div>
                <div class="skeleton-box"></div>
            </div>
        </div>
    </div>
`;

            $("#resultDashboard").show();
            $("#resultCardContainer").html(loadingHTML);
        }

        function viewSectionResult(courseId, sectionId, lessonId, userId) {

            $.ajax({
                url: base_url + "admin/LearnerProgressReport/getSectionResult",
                type: "POST",
                data: {
                    course_id: courseId,
                    section_id: sectionId,
                    lesson_id: lessonId,
                    user_id: userId,
                },
                beforeSend: function() {
                    showResultLoading();

                    // optional → disable buttons to avoid spam click
                    $(".view-result-btn").prop("disabled", true);
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    renderSectionResultCard(data);

                    // scroll smoothly to result section
                    $("html, body").animate({
                            scrollTop: $("#resultDashboard").offset().top - 80,
                        },
                        600
                    );
                },
            });
        }

        function renderSectionResultCard(apiData) {


            if (!apiData || apiData.length === 0) {
                let emptyHTML = `
                    <div class="empty-result">
                        <div class="empty-icon">📄</div>
                        <div class="empty-title">No Result Found</div>
                        <div class="empty-sub">This student has not attempted this exam yet</div>
                    </div>`;

                $("#resultDashboard").show();
                $("#resultCardContainer").html(emptyHTML);
                return;
            }

            let allCards = '<div class="result-grid">';

            // 🔁 LOOP ALL LESSON RESULTS
            apiData.forEach(item => {

                let result = JSON.parse(item.result);

                let totalQ = parseInt(item.no_of_question) || 0;
                let correct = parseInt(result.correct_question) || 0;
                let wrong = parseInt(result.wrong_question) || 0;

                let score = 0;
                let marksText = "0/0 marks";

                if (totalQ > 0) {
                    score = Math.round((correct / totalQ) * 100);
                    marksText = correct + "/" + totalQ + " marks";
                }
                let initial = item.student_name.charAt(0);

                allCards += `
                <div class="exam-card">

                    <div class="exam-header">
                        <div class="student-box">
                            <div class="student-avatar">${initial}</div>
                            <div>
                                <div class="exam-title">${item.student_name}</div>
                                <div class="exam-sub">${item.section_name}</div>
                            </div>
                        </div>

                        <div class="score-box">
                            <span>Score</span>
                            <div class="score-big">${score}%</div>
                        </div>
                    </div>

                    <div class="exam-body">
                        <div class="info-row">
                            <span>Exam:</span>
                            <span>${item.lesson_name}</span>
                        </div>

                        <div class="exam-stats">
                            <div class="stat stat-blue">
                                <div class="stat-number">${totalQ}</div>
                                <div>Total</div>
                            </div>

                            <div class="stat stat-green">
                                <div class="stat-number">${correct}</div>
                                <div>Correct</div>
                            </div>

                            <div class="stat stat-red">
                                <div class="stat-number">${wrong}</div>
                                <div>Wrong</div>
                            </div>
                        </div>

                        <div class="progress-label">${marksText}</div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill-custom" style="width:${score}%"></div>
                        </div>
                    </div>
                </div>`;
            });

            allCards += '</div>';

            $("#resultDashboard").show();
            $("#resultCardContainer").html(allCards);
        }
        </script>