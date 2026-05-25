<style>
    .cert-wrapper {
        display: flex;
        gap: 20px;
    }

    .cert-form {
        flex: 2;
    }

    .cert-info {
        flex: 1;
        background: #f7f9fc;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #e6ebf2;
    }

    .cert-block {
        background: #fff;
        border-radius: 8px;
        padding: 18px;
        border: 1px solid #e8edf3;
        margin-bottom: 15px;
    }

    .cert-label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }

    .toggle-group {
        display: flex;
        gap: 10px;
    }

    .toggle-btn {
        border: 1px solid #dcdcdc;
        padding: 7px 16px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
    }

    .toggle-btn input {
        display: none;
    }

    .toggle-btn.active {
        background: #ed2626;
        color: #fff;
        border-color: #ed2626;
    }

    .upload-box {
        border: 2px dashed #d6dbe5;
        padding: 25px;
        border-radius: 6px;
        text-align: center;
        background: #fafbfd;
    }

    .upload-box:hover {
        background: #eef5ff;
        border-color: #007bff;
    }

    .cert-btn {
        background: #16a085;
        border: none;
        padding: 12px 30px;
        border-radius: 6px;
        color: #fff;
        font-weight: 500;
    }

    .cert-btn:hover {
        background: #138d75;
    }

    .student-box {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .student-img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-name {
        font-weight: 600;
        font-size: 14px;
    }

    .small-note {
        font-size: 12px;
        color: #777;
        margin-top: 5px;
    }
</style>



<?php $certificate = $certificate ?? []; ?>

<form id="certificateForm" enctype="multipart/form-data">

    <input type="hidden" name="user_id" value="<?= $user_details['id'] ?>">
    <input type="hidden" name="id" value="<?= $certificate['id'] ?? '' ?>">

    <div class="cert-wrapper">
        <div class="cert-form">
            <div class="cert-block">
                <label class="cert-label">Certificate Title</label>
                <input type="text" name="certificate_title" class="form-control"
                    value="<?= $certificate['certificate_title'] ?? '' ?>" required>
            </div>
            <div class="cert-block">
                <label class="cert-label">Course Type</label>
                <div class="toggle-group">
                    <label class="toggle-btn <?= empty($certificate['external_course']) ? 'active' : '' ?>">
                        <input type="radio" name="course_type" value="internal"
                            <?= empty($certificate['external_course']) ? 'checked' : '' ?>>
                        Internal
                    </label>
                    <label class="toggle-btn <?= !empty($certificate['external_course']) ? 'active' : '' ?>">
                        <input type="radio" name="course_type" value="external"
                            <?= !empty($certificate['external_course']) ? 'checked' : '' ?>>
                        External
                    </label>
                </div>
                <div class="mt-3 <?= !empty($certificate['external_course']) ? 'd-none' : '' ?>" id="internalCourseDiv">
                    <select name="course_id" class="form-control">
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course) { ?>
                            <option value="<?= $course['id'] ?>" <?= ($certificate['course_id'] ?? '') == $course['id'] ? 'selected' : '' ?>>
                                <?= $course['title'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mt-3 <?= empty($certificate['external_course']) ? 'd-none' : '' ?>" id="externalCourseDiv">
                    <input type="text" name="external_course" class="form-control"
                        value="<?= $certificate['external_course'] ?? '' ?>" placeholder="Enter external course">
                </div>
            </div>
            <div class="cert-block">
                <label class="cert-label">Result Type</label>

                <?php
                $resultType = 'none';
                if (!empty($certificate['score']) && !empty($certificate['grade'])) {
                    $resultType = 'both';
                } elseif (!empty($certificate['score'])) {
                    $resultType = 'score';
                } elseif (!empty($certificate['grade'])) {
                    $resultType = 'grade';
                }
                ?>

                <select id="resultType" class="form-control">
                    <option value="none" <?= $resultType == 'none' ? 'selected' : '' ?>>No Result</option>
                    <option value="score" <?= $resultType == 'score' ? 'selected' : '' ?>>Score</option>
                    <option value="grade" <?= $resultType == 'grade' ? 'selected' : '' ?>>Grade</option>
                    <option value="both" <?= $resultType == 'both' ? 'selected' : '' ?>>Score + Grade</option>
                </select>
                <div class="row mt-3">
                    <div class="col-md-6 <?= ($resultType == 'score' || $resultType == 'both') ? '' : 'd-none' ?>"
                        id="scoreDiv">
                        <input type="number" name="score" class="form-control"
                            value="<?= $certificate['score'] ?? '' ?>" placeholder="Score">
                    </div>
                    <div class="col-md-6 <?= ($resultType == 'grade' || $resultType == 'both') ? '' : 'd-none' ?>"
                        id="gradeDiv">
                        <select name="grade" class="form-control">
                            <option value="">Select Grade</option>
                            <?php
                            $grades = ['A+', 'A', 'B+', 'B', 'C'];
                            foreach ($grades as $g) { ?>
                                <option value="<?= $g ?>" <?= ($certificate['grade'] ?? '') == $g ? 'selected' : '' ?>>
                                    <?= $g ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="cert-block">
                <label class="cert-label">Issue Date</label>
                <input type="date" name="issued_date" class="form-control"
                    value="<?= $certificate['issued_date'] ?? '' ?>">
            </div>
            <div class="cert-block">
                <label class="cert-label">Upload Certificate</label>
                <input type="file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                <?php if (!empty($certificate['certificate_file'])) { ?>
                    <div class="mt-2">
                        <a href="<?= base_url(CERTIFICATE_FILES . $certificate['certificate_file']) ?>" target="_blank">
                            View Uploaded File
                        </a>
                    </div>
                <?php } ?>
            </div>
            <button type="submit" class="cert-btn">
                <?= !empty($certificate['id']) ? 'Update Certificate' : 'Generate Certificate' ?>
            </button>
        </div>
        <div class="cert-info">
            <div class="student-box">
                <?php
                $imagePath = base_url('assets/images/user.png');

                if (
                    !empty($user_details['image']) &&
                    file_exists(FCPATH . USER_PROFILE . $user_details['image'])
                ) {
                    $imagePath = base_url(USER_PROFILE . $user_details['image']);
                }
                ?>

                <img src="<?= $imagePath ?>" class="student-img" >
                <div>
                    <div class="student-name">
                        <?= $user_details['first_name'] ?? '' ?>
                    </div>
                    <div class="small-note">
                        Student ID: <?= $user_details['id'] ?>
                    </div>
                </div>
            </div>
            <hr>
            <h6 class="font-weight-bold mb-2">
                Certificate Guide
            </h6>
            <div class="small-note">
                • Select internal course if certificate is for LMS course <br>
                • Use external option for outside programs<br>
                • Score or grade is optional<br>
                • Upload certificate if already generated<br>
            </div>
        </div>
    </div>
</form>


<script>
    $(document).on("change", "input[name='course_type']", function () {

        $(".toggle-btn").removeClass("active");
        $(this).parent().addClass("active");

        if ($(this).val() == "external") {
            $("#internalCourseDiv").addClass("d-none");
            $("#externalCourseDiv").removeClass("d-none");
        } else {
            $("#externalCourseDiv").addClass("d-none");
            $("#internalCourseDiv").removeClass("d-none");
        }

    });


    $("#resultType").change(function () {

        let type = $(this).val();

        $("#scoreDiv").addClass("d-none");
        $("#gradeDiv").addClass("d-none");

        if (type == "score") {
            $("#scoreDiv").removeClass("d-none");
        }

        if (type == "grade") {
            $("#gradeDiv").removeClass("d-none");
        }

        if (type == "both") {
            $("#scoreDiv").removeClass("d-none");
            $("#gradeDiv").removeClass("d-none");
        }

    });
</script>