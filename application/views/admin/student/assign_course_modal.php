<style>
    .course-wrapper {
        max-height: 420px;
        overflow-y: auto;
        padding-right: 6px;
    }

    .course-card {
        border-radius: 10px;
        border: 1px solid #eef1f4;
        transition: all 0.2s ease;
        padding: 12px 15px;
        background: #ffffff;
    }

    .course-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .course-title {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
    }

    .course-meta {
        font-size: 12px;
        color: #6c757d;
    }

    .expired-course {
        border-left: 4px solid #dc3545;
        background: #fff6f6;
    }

    .active-course {
        border-left: 4px solid #198754;
        background: #f4fbf6;
    }

    .status-badge {
        font-size: 11px;
        padding: 5px 8px;
        margin-right: 5px;
    }

    .modal-header-custom {
        border-bottom: 1px solid #eef1f4;
        padding-bottom: 12px;
        margin-bottom: 15px;
    }
</style>

<form id="assignCourseForm">
    <input type="hidden" name="user_id" value="<?= $user_id ?>">

    <!-- Header -->
    <div class="modal-header-custom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0">
                <i class="fas fa-graduation-cap text-primary me-2"></i>
                Course Subscription Management
            </h5>
            <small class="text-muted">Assign or manage user course access</small>
        </div>

        <input type="text"
            id="courseSearch"
            class="form-control form-control-sm"
            placeholder="Search course..."
            style="width:220px;">
    </div>

    <!-- Select All -->
    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" id="selectAllCourses" class="form-check-input">
            <label class="form-check-label fw-semibold">
                Select All Courses
            </label>
        </div>
    </div>

    <!-- Course List -->
    <div class="course-wrapper">

        <?php foreach ($courses as $course):

            $sub = isset($sub_map[$course['id']]) ? $sub_map[$course['id']] : null;
            $isSubscribed = $sub ? true : false;
            $isExpired = ($sub && strtotime($sub['end_date']) < time());
        ?>

            <div class="course-item mb-2">

                <div class="course-card d-flex justify-content-between align-items-center 
                    <?= $isExpired ? 'expired-course' : ($isSubscribed ? 'active-course' : '') ?>">

                    <!-- Left Section -->
                    <div class="d-flex align-items-start">

                        <div class="form-check me-3 mt-1">
                            <input type="checkbox"
                                name="course_ids[]"
                                value="<?= $course['id'] ?>"
                                class="form-check-input course-checkbox"
                                <?= $isSubscribed && !$isExpired ? 'checked' : '' ?>>
                        </div>

                        <div>
                            <div class="course-title">
                                <?= $course['title'] ?>
                            </div>

                            <?php if ($isSubscribed): ?>
                                <div class="course-meta mt-1">
                                    Order: <strong><?= $sub['order_no'] ?></strong> |
                                    Start: <?= date('d M Y', strtotime($sub['start_date'])) ?> |
                                    Expiry: <?= date('d M Y', strtotime($sub['end_date'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <!-- Right Section -->
                    <div class="text-end">
                        <div class="d-flex align-items-center">
                            <?php if ($isSubscribed): ?>
                                <?php if ($isExpired): ?>
                                    <span class="badge  status-badge" style="border:1px solid #dc3545">Expired</span>
                                <?php else: ?>
                                    <span class="badge status-badge" style="border:1px solid #198754">Active</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge  status-badge" style="border:1px solid #919191; background-color: #ededed">Not Assigned</span>
                            <?php endif; ?>

                            <!-- <?php if ($isSubscribed): ?>
                                <?php
                                switch ($sub['payment_type']) {
                                    case 1:
                                        echo '<span class="badge  text-dark status-badge" style="border:1px solid #f0cc47">COD</span>';
                                        break;
                                    case 2:
                                        echo '<span class="badge  status-badge" style="border:1px solid #39b0f9">Online</span>';
                                        break;
                                    case 3:
                                        echo '<span class="badge  status-badge" style="border:1px solid #198754">Free</span>';
                                        break;
                                    case 4:
                                        echo '<span class="badge  status-badge" style="border:1px solid #919191">Offline</span>';
                                        break;
                                }
                                ?>
                            <?php endif; ?> -->
                        </div>
                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- Footer -->
    <div class="mt-4 pt-3 border-top text-right">
        <button class="btn btn-secondary"
            data-dismiss="modal">
            Close
        </button>

        <button type="button"
            class="btn btn-primary px-4 saveAssignCourse">
            <i class="fas fa-save me-1"></i>
            Save Changes
        </button>
    </div>
</form>

<script>
    // Select All
    $(document).on("change", "#selectAllCourses", function() {
        $(".course-checkbox").prop("checked", $(this).prop("checked"));
    });

    // Search Filter
    $("#courseSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".course-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
</script>