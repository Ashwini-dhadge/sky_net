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
        background: #007bff;
        color: #fff;
        border-color: #007bff;
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



<form id="certificateForm" enctype="multipart/form-data">

    <input type="hidden" name="user_id" value="<?= $user_details['id'] ?>">

    <div class="cert-wrapper">

        <!-- LEFT SIDE FORM -->
        <div class="cert-form">


            <div class="cert-block">

                <label class="cert-label">
                    <i class="fas fa-certificate text-primary mr-1"></i>
                    Certificate Title
                </label>

                <input type="text"
                    name="certificate_title"
                    class="form-control"
                    placeholder="Example: Web Development Certificate"
                    required>

            </div>



            <div class="cert-block">

                <label class="cert-label">
                    <i class="fas fa-book text-primary mr-1"></i>
                    Course Type
                </label>

                <div class="toggle-group">

                    <label class="toggle-btn active">
                        <input type="radio" name="course_type" value="internal" checked>
                        Internal
                    </label>

                    <label class="toggle-btn">
                        <input type="radio" name="course_type" value="external">
                        External
                    </label>

                </div>


                <div class="mt-3" id="internalCourseDiv">

                    <select name="course_id" class="form-control">

                        <option value="">Select Course</option>

                        <?php foreach ($courses as $course) { ?>

                            <option value="<?= $course['id'] ?>">
                                <?= $course['title'] ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div class="mt-3 d-none" id="externalCourseDiv">

                    <input type="text"
                        name="external_course"
                        class="form-control"
                        placeholder="Enter external course name">

                </div>

            </div>



            <div class="cert-block">

                <label class="cert-label">
                    <i class="fas fa-chart-bar text-primary mr-1"></i>
                    Result Type
                </label>

                <select id="resultType" class="form-control">

                    <option value="none">No Result</option>
                    <option value="score">Score</option>
                    <option value="grade">Grade</option>
                    <option value="both">Score + Grade</option>

                </select>

                <div class="row mt-3">

                    <div class="col-md-6 d-none" id="scoreDiv">

                        <input type="number"
                            name="score"
                            class="form-control"
                            placeholder="Enter Score">

                    </div>


                    <div class="col-md-6 d-none" id="gradeDiv">

                        <select name="grade" class="form-control">

                            <option value="">Select Grade</option>
                            <option>A+</option>
                            <option>A</option>
                            <option>B+</option>
                            <option>B</option>
                            <option>C</option>

                        </select>

                    </div>

                </div>

            </div>



            <div class="cert-block">

                <label class="cert-label">
                    <i class="fas fa-calendar-alt text-primary mr-1"></i>
                    Issue Date
                </label>

                <input type="date"
                    name="issued_date"
                    class="form-control">

            </div>



            <div class="cert-block">

                <label class="cert-label">
                    <i class="fas fa-upload text-primary mr-1"></i>
                    Upload Certificate
                </label>

                <div class="upload-box">

                    <input type="file"
                        name="certificate_file"
                        accept=".pdf,.jpg,.jpeg,.png">

                    <div class="small-note">
                        Allowed: PDF, JPG, PNG
                    </div>

                </div>

            </div>


            <div class="text-left">

                <button type="submit" class="cert-btn">

                    <i class="fas fa-check mr-1"></i>
                    Generate Certificate

                </button>

            </div>


        </div>



        <!-- RIGHT SIDE INFO -->
        <div class="cert-info">

            <div class="student-box">

                <img src="<?= base_url(USER_PROFILE . $user_details['image']) ?>"
                    class="student-img">

                <div>
                    <div class="student-name">
                        <?= $user_details['first_name'] ?>
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

                • Select internal course if certificate is for LMS course
                • Use external option for outside programs
                • Score or grade is optional
                • Upload certificate if already generated

            </div>


        </div>

    </div>

</form>



<script>
    $(document).on("change", "input[name='course_type']", function() {

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


    $("#resultType").change(function() {

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