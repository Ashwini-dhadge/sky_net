<?php init_header(); ?>
<style>
    .student-name-wrap {
        white-space: normal !important;
        word-break: break-word;
        display: block;
        line-height: 18px;
    }
</style>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Students</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/Student/') ?>">Students</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm" style="border-radius:18px;">
                            <div class="card-body p-4">
                                <input type="hidden" name="action" id="action" value="2">
                                <?php $img = (!empty($user['image'])) ? $user['image'] : 'no-image.png'; ?>

                                <div class="mb-4">
                                    <div class="mr-3">
                                        <?php

                                        $image = trim($user['image'] ?? '');

                                        $uploadPath = FCPATH . 'assets/uploads/user_image/' . $image;

                                        if ($image != '' && $image != 'null' && is_file($uploadPath)) {

                                            $imagePath = base_url('assets/uploads/user_image/' . $image);
                                        } else {

                                            $imagePath = base_url('assets/images/user.png');
                                        }

                                        ?>

                                        <img src="<?= $imagePath ?>"
                                            style="width:85px;height:85px;object-fit:cover;border-radius:15px;">
                                    </div>
                                    <div>
                                        <h5 class="mb-3 mt-3 font-weight-bold student-name-wrap">
                                            <?= $user['first_name']; ?> <?= $user['last_name']; ?>
                                        </h5>

                                        <span
                                            class="badge <?= ($user['status']) ? 'badge-success' : 'badge-secondary' ?>"
                                            style="padding:6px 14px;border-radius:30px;font-size:12px;">
                                            <?= ($user['status']) ? "Active Account" : "Inactive Account"; ?>
                                        </span>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="profile-info ">
                                    <div class="mr-5">
                                        <small class="text-muted d-block">Email Address</small>
                                        <span class="font-weight-medium"><?= $user['email']; ?></span>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Mobile Number</small>
                                        <span class="font-weight-medium"><?= $user['mobile_no']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm" style="border-radius:18px;">
                            <div class="card-body p-4">
                                <ul class="nav nav-pills mb-4" role="tablist" style="gap:10px;">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-info-circle mr-1"></i> Basic Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-book mr-1"></i> My Courses
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#disscussion"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-comments mr-1"></i> My Discussion Forum
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#qna"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-question mr-1"></i> My QNA
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#certification"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-award mr-1"></i> My Certification
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="home1">
                                        <div class="bg-light p-4" style="border-radius:15px;">
                                            <form method="post" id="imeno_form">
                                                <input type="hidden" name="id" id="id" value="<?= $user['id']; ?>">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label font-weight-semibold">
                                                        IMEI No
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="text" id="imei_no"
                                                            name="imei_no" value="<?= $user['imei_no']; ?>">
                                                    </div>
                                                </div>
                                                <?php if ($user['role'] != 3) { ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label font-weight-semibold">
                                                            Commission %
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text" id="commsion_percentage"
                                                                name="commsion_percentage"
                                                                value="<?= $user['commsion_percentage']; ?>">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="mt-3">
                                                    <button type="button" class="btn btn-sm btn-success mr-2"
                                                        onclick="actionUsers(1)">
                                                        <i class="fas fa-check mr-1"></i> Update
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="actionUsers(2)">
                                                        <i class="fas fa-trash mr-1"></i> Delete IMEI
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile1">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="font-weight-bold mb-0">Assigned Courses</h6>
                                            <?php if ($user['user_type'] == 0) { ?>
                                                <a href="javascript:void(0);" title="Assign Course"
                                                    class="btn btn-primary btn-sm openAssignModal"
                                                    data-id="<?= $user['id'] ?>"
                                                    style="border-radius:20px;padding:6px 16px;">
                                                    <i class="fas fa-plus mr-1"></i> Assign Course
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="modal fade" id="assignCourseModal" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content" style="border-radius:15px;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Assign Course</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body" id="assignCourseModalBody">
                                                        <div class="text-center py-4">
                                                            <i class="fas fa-spinner fa-spin"></i> Loading...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-white p-3 rounded shadow-sm">
                                            <?php $this->load->view(ADMIN . USER . 'table-mycourse'); ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="disscussion">
                                        <div class="bg-white p-4 rounded shadow-sm"
                                            style="max-height: 500px; overflow-y: scroll;">
                                            <?php if (!empty($forum_questions)) { ?>
                                                <?php foreach ($forum_questions as $row) { ?>
                                                    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>
                                                                    <h6 class="mb-0 font-weight-semibold"><?= $row['title']; ?>
                                                                    </h6>
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-sm mb-2 p-0 openReplyModal"
                                                                        data-id="<?= $row['id']; ?>">
                                                                        <i class="fas fa-reply mr-1"></i> Replies
                                                                        (<?= $row['total_answers']; ?>)
                                                                    </button> <br>
                                                                    <?php
                                                                    if ($row['is_approved'] == 1) {
                                                                        echo '<span class="badge badge-success">Approved</span>';
                                                                    } elseif ($row['is_approved'] == 2) {
                                                                        echo '<span class="badge badge-danger">Rejected</span>';
                                                                    } else {
                                                                        echo '<span class="badge badge-warning text-dark">Pending</span>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted mb-2" style="font-size:13px;">
                                                                <?= substr(strip_tags($row['description']), 0, 120); ?>...
                                                            </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <small class="text-muted">
                                                                    <i class="far fa-calendar mr-1"></i>
                                                                    <?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?>
                                                                </small>
                                                                <small class="text-primary">
                                                                    <i class="far fa-comment-dots mr-1"></i>
                                                                    <?= $row['total_answers']; ?> Answers
                                                                </small>
                                                            </div>
                                                            <?php if (!empty($row['tags'])) { ?>
                                                                <div class="mt-2">
                                                                    <?php
                                                                    $tags = explode(',', $row['tags']);
                                                                    foreach ($tags as $tag) {
                                                                        echo '<span class="badge badge-light mr-1">' . trim($tag) . '</span>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                            <?php } else { ?>

                                                <div class="text-center py-5">
                                                    <i class="far fa-comments fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">No discussions posted yet.</p>
                                                </div>

                                            <?php } ?>

                                        </div>
                                        <div class="modal fade" id="replyModal" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content" style="border-radius:14px;">

                                                    <div class="modal-header border-bottom">
                                                        <div>
                                                            <h5 class="modal-title mb-1" id="replyModalTitle">
                                                                Discussion
                                                            </h5>
                                                            <small class="text-muted" id="replyModalCount">
                                                                0 Replies
                                                            </small>
                                                        </div>

                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <div class="modal-body" id="replyModalBody"
                                                        style="max-height:500px; overflow-y:auto;">

                                                        <div class="text-center py-4">
                                                            <i class="fas fa-spinner fa-spin"></i> Loading...
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="qna" style="max-height: 500px; overflow-y: scroll;">
                                        <div class="p-4 rounded ">

                                            <h5 class="mb-4 font-weight-bold">
                                                <i class="fas fa-question-circle text-primary mr-2"></i>
                                                Course Q&A
                                            </h5>

                                            <?php if (!empty($qna_list)): ?>
                                                <?php foreach ($qna_list as $row):
                                                    $created_at = !empty($row['created_at'])
                                                        ? date('d M Y H:i', strtotime($row['created_at']))
                                                        : '-';

                                                    $isAnswered = !empty($row['answer']);
                                                ?>
                                                    <div class="card mb-3 border-0 shadow-sm">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <div>
                                                                    <span class="badge badge-light">
                                                                        <?= $row['course_title']; ?>
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <?php if ($isAnswered): ?>
                                                                        <span class="badge badge-success">Answered</span>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-warning text-dark">Pending</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>

                                                            <div class="mb-2">
                                                                <strong class="text-dark">
                                                                    <i class="fas fa-question text-primary mr-1"></i>
                                                                    <?= $row['question']; ?>
                                                                </strong>
                                                            </div>
                                                            <?php if ($isAnswered): ?>
                                                                <div class="mt-3 p-3 bg-light rounded">
                                                                    <strong class="text-success">
                                                                        <i class="fas fa-reply mr-1"></i>
                                                                        Instructor Reply
                                                                    </strong>
                                                                    <div class="mt-2" style="font-size:14px;">
                                                                        <?= nl2br($row['answer']); ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="mt-3 text-muted small">
                                                                Asked on: <?= $created_at; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="text-center py-5">
                                                    <i class="far fa-comment-dots fa-2x text-muted mb-2"></i>
                                                    <p class="text-muted">No Q&A found for this user.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="certification">
                                        <div class="bg-white p-3 rounded shadow-sm">
                                            <?php $this->load->view(ADMIN . USER . 'table-certificates'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#lesson" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Lesson Video MCQ Solved</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="lesson" role="tabpanel">

                                        <style>
                                            /* .learning-dashboard-wrapper {
                                                background: #f4f7fb;
                                                padding: 20px;
                                                border-radius: 16px;
                                            }

                                            .learning-hero {
                                                background: linear-gradient(135deg, #3657ff, #7b2ff7);
                                                color: #fff;
                                                border-radius: 18px;
                                                padding: 28px;
                                                margin-bottom: 24px;
                                                box-shadow: 0 10px 30px rgba(54, 87, 255, .25);
                                            }

                                            .learning-hero h3 {
                                                font-weight: 700;
                                                margin-bottom: 6px;
                                            } */

                                            .stat-card {
                                                border: 0;
                                                border-radius: 18px;
                                                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                                                transition: .2s;
                                            }

                                            .stat-card:hover {
                                                transform: translateY(-3px);
                                            }

                                            .stat-icon {
                                                width: 50px;
                                                height: 50px;
                                                border-radius: 15px;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                font-size: 22px;
                                            }

                                            .icon-primary {
                                                background: rgba(54, 87, 255, .12);
                                                color: #3657ff;
                                            }

                                            .icon-success {
                                                background: rgba(40, 167, 69, .12);
                                                color: #28a745;
                                            }

                                            .icon-danger {
                                                background: rgba(220, 53, 69, .12);
                                                color: #dc3545;
                                            }

                                            .icon-warning {
                                                background: rgba(255, 193, 7, .18);
                                                color: #d39e00;
                                            }

                                            .chart-card {
                                                border: 0;
                                                border-radius: 18px;
                                                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                                                margin-bottom: 24px;
                                            }

                                            .lesson-card {
                                                border: 0;
                                                border-radius: 18px;
                                                overflow: hidden;
                                                box-shadow: 0 8px 25px rgba(0, 0, 0, .07);
                                                margin-bottom: 22px;
                                            }

                                            .lesson-top {
                                                background: #fff;
                                                padding: 20px;
                                                border-bottom: 1px solid #eef0f5;
                                            }

                                            .course-title {
                                                font-weight: 700;
                                                font-size: 18px;
                                                color: #222;
                                                margin-bottom: 5px;
                                            }

                                            .lesson-meta {
                                                color: #6c757d;
                                                font-size: 13px;
                                            }

                                            .mini-stat {
                                                background: #f8f9fc;
                                                border-radius: 14px;
                                                padding: 14px;
                                                text-align: center;
                                                height: 100%;
                                            }

                                            .mini-stat h5 {
                                                font-weight: 700;
                                                margin-bottom: 3px;
                                            }

                                            .score-circle {
                                                width: 82px;
                                                height: 82px;
                                                border-radius: 50%;
                                                background: conic-gradient(#28a745 var(--score), #e9ecef 0);
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                margin-left: auto;
                                                position: relative;
                                            }

                                            .score-circle::before {
                                                content: "";
                                                width: 62px;
                                                height: 62px;
                                                border-radius: 50%;
                                                background: #fff;
                                                position: absolute;
                                            }

                                            .score-circle span {
                                                position: relative;
                                                font-weight: 700;
                                                color: #222;
                                            }

                                            .answer-option {
                                                padding: 10px 12px;
                                                border-radius: 10px;
                                                margin-bottom: 8px;
                                                background: #f8f9fa;
                                                border: 1px solid #e9ecef;
                                            }

                                            .answer-correct {
                                                background: #eaf8ef;
                                                border-color: #28a745;
                                                color: #155724;
                                                font-weight: 600;
                                            }

                                            .answer-wrong {
                                                background: #fdecee;
                                                border-color: #dc3545;
                                                color: #721c24;
                                                font-weight: 600;
                                            }

                                            .question-box {
                                                background: #fff;
                                                border-radius: 14px;
                                                border: 1px solid #eef0f5;
                                                padding: 16px;
                                                margin-bottom: 15px;
                                            }

                                            .empty-state {
                                                background: #fff;
                                                border-radius: 18px;
                                                padding: 60px 20px;
                                                text-align: center;
                                                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                                            }
                                        </style>

                                        <?php

                                        $totalLessons = !empty($lesson_progress) ? count($lesson_progress) : 0;
                                        $totalCorrect = 0;
                                        $totalWrong = 0;
                                        $totalQuestions = 0;
                                        $totalMarks = 0;
                                        $totalScorePercentage = 0;
                                        $completedVideos = 0;
                                        $passCount = 0;
                                        $failCount = 0;

                                        $chartLabels = [];
                                        $chartScores = [];

                                        if (!empty($lesson_progress)) {
                                            foreach ($lesson_progress as $lp) {

                                                $resultData = [];

                                                if (!empty($lp['result'])) {
                                                    $decoded = json_decode($lp['result'], true);
                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                        $resultData = $decoded;
                                                    }
                                                }

                                                $correct = $resultData['correct_question'] ?? 0;
                                                $wrong = $resultData['wrong_question'] ?? 0;
                                                $totalQ = $resultData['total_question'] ?? ($lp['total_questions_db'] ?? 0);

                                                $percentage = $totalQ > 0 ? round(($correct / $totalQ) * 100) : 0;

                                                $totalCorrect += $correct;
                                                $totalWrong += $wrong;
                                                $totalQuestions += $totalQ;
                                                $totalMarks += (int) ($lp['total_marks'] ?? 0);
                                                $totalScorePercentage += $percentage;

                                                if ($lp['view_video'] == 1) {
                                                    $completedVideos++;
                                                }

                                                if ($percentage >= 60) {
                                                    $passCount++;
                                                } else {
                                                    $failCount++;
                                                }

                                                $chartLabels[] = $lp['lesson_title'] ?? 'Lesson';
                                                $chartScores[] = $percentage;
                                            }
                                        }

                                        $avgScore = $totalLessons > 0 ? round($totalScorePercentage / $totalLessons) : 0;

                                        ?>

                                        <div class="learning-dashboard-wrapper">
                                            <!-- 
                                            <div class="learning-hero">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <h3>
                                                            <i class="fas fa-graduation-cap mr-2"></i>
                                                            Student Learning Dashboard
                                                        </h3>
                                                        <p class="mb-0">
                                                            Complete lesson video progress, MCQ performance, score
                                                            analytics and question review.
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                                        <h1 class="mb-0"><?= $avgScore ?>%</h1>
                                                        <small>Average Score</small>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <?php if (!empty($lesson_progress)): ?>

                                                <div class="row mb-4">

                                                    <div class="col-md-3 mb-3">
                                                        <div class="card stat-card">
                                                            <div class="card-body d-flex align-items-center">
                                                                <div class="stat-icon icon-primary mr-3">
                                                                    <i class="fas fa-play-circle"></i>
                                                                </div>
                                                                <div>
                                                                    <h4 class="mb-0"><?= $totalLessons ?></h4>
                                                                    <small class="text-muted">Lesson Attempts</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <div class="card stat-card">
                                                            <div class="card-body d-flex align-items-center">
                                                                <div class="stat-icon icon-success mr-3">
                                                                    <i class="fas fa-check-circle"></i>
                                                                </div>
                                                                <div>
                                                                    <h4 class="mb-0"><?= $totalCorrect ?></h4>
                                                                    <small class="text-muted">Correct Answers</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <div class="card stat-card">
                                                            <div class="card-body d-flex align-items-center">
                                                                <div class="stat-icon icon-danger mr-3">
                                                                    <i class="fas fa-times-circle"></i>
                                                                </div>
                                                                <div>
                                                                    <h4 class="mb-0"><?= $totalWrong ?></h4>
                                                                    <small class="text-muted">Wrong Answers</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <div class="card stat-card">
                                                            <div class="card-body d-flex align-items-center">
                                                                <div class="stat-icon icon-warning mr-3">
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                                <div>
                                                                    <h4 class="mb-0"><?= $totalMarks ?></h4>
                                                                    <small class="text-muted">Total Marks</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="card chart-card" style="height: 400px;">
                                                            <div class="card-header bg-white border-0 pt-4 px-4">
                                                                <h5 class="mb-0 font-weight-bold">
                                                                    <i class="fas fa-chart-pie text-danger mr-2"></i>
                                                                    Answer Accuracy
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="answerAccuracyChart"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="card chart-card" style="height: 400px;">
                                                            <div class="card-header bg-white border-0 pt-4 px-4">
                                                                <h5 class="mb-0 font-weight-bold">
                                                                    <i class="fas fa-chart-bar text-danger mr-2"></i>
                                                                    Lesson Wise Score
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="lessonScoreChart"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="card chart-card" style="height: 400px;">
                                                            <div class="card-header bg-white border-0 pt-4 px-4">
                                                                <h5 class="mb-0 font-weight-bold">
                                                                    <i class="fas fa-award text-danger mr-2"></i>
                                                                    Pass vs Fail Analysis
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="studentRadarChart"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card chart-card">
                                                    <div class="card-header bg-white border-0 pt-4 px-4">
                                                        <h5 class="mb-0 font-weight-bold">
                                                            <i class="fas fa-tasks text-info mr-2"></i>
                                                            Learning Summary
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row text-center">

                                                            <div class="col-md-3 mb-3">
                                                                <div class="mini-stat">
                                                                    <h5 class="text-success"><?= $completedVideos ?></h5>
                                                                    <small>Videos Completed</small>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 mb-3">
                                                                <div class="mini-stat">
                                                                    <h5 class="text-primary"><?= $totalQuestions ?></h5>
                                                                    <small>Total Questions</small>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 mb-3">
                                                                <div class="mini-stat">
                                                                    <h5 class="text-success"><?= $passCount ?></h5>
                                                                    <small>Passed Lessons</small>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 mb-3">
                                                                <div class="mini-stat">
                                                                    <h5 class="text-danger"><?= $failCount ?></h5>
                                                                    <small>Failed Lessons</small>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <?php foreach ($lesson_progress as $row): ?>

                                                    <?php

                                                    $resultData = [];

                                                    if (!empty($row['result'])) {
                                                        $decoded = json_decode($row['result'], true);
                                                        if (json_last_error() === JSON_ERROR_NONE) {
                                                            $resultData = $decoded;
                                                        }
                                                    }

                                                    $correct = $resultData['correct_question'] ?? 0;
                                                    $wrong = $resultData['wrong_question'] ?? 0;
                                                    $total_q = $resultData['total_question'] ?? ($row['total_questions_db'] ?? 0);

                                                    $percentage = $total_q > 0 ? round(($correct / $total_q) * 100) : 0;

                                                    $examStatus = $percentage >= 60 ? 'PASS' : 'FAIL';
                                                    $examBadge = $percentage >= 60 ? 'badge-success' : 'badge-danger';

                                                    $videoStatus = $row['view_video'] == 1 ? 'Completed' : 'In Progress';
                                                    $videoBadge = $row['view_video'] == 1 ? 'badge-success' : 'badge-warning';

                                                    $solvedData = [];

                                                    if (!empty($row['solved_mcq'])) {
                                                        $decodedSolved = json_decode($row['solved_mcq'], true);
                                                        if (json_last_error() === JSON_ERROR_NONE) {
                                                            $solvedData = $decodedSolved;
                                                        }
                                                    }

                                                    ?>

                                                    <div class="lesson-card">

                                                        <div class="lesson-top">

                                                            <div class="row align-items-center">

                                                                <div class="col-md-8">

                                                                    <div class="course-title">
                                                                        <i class="fas fa-book-open text-primary mr-2"></i>
                                                                        <?= !empty($row['course_title']) ? $row['course_title'] : 'Course Not Found' ?>
                                                                    </div>

                                                                    <div class="lesson-meta">
                                                                        <i class="fas fa-layer-group mr-1"></i>
                                                                        <?= !empty($row['section_title']) ? $row['section_title'] : 'Section Not Found' ?>

                                                                        <span class="mx-2">/</span>

                                                                        <i class="fas fa-video mr-1"></i>
                                                                        <?= !empty($row['lesson_title']) ? $row['lesson_title'] : 'Lesson Not Found' ?>
                                                                    </div>

                                                                    <div class="mt-3">
                                                                        <span class="badge <?= $videoBadge ?> px-3 py-2">
                                                                            Video: <?= $videoStatus ?>
                                                                        </span>

                                                                        <span class="badge <?= $examBadge ?> px-3 py-2 ml-2">
                                                                            Exam: <?= $examStatus ?>
                                                                        </span>

                                                                        <span class="badge badge-light px-3 py-2 ml-2">
                                                                            Attempted:
                                                                            <?= !empty($row['created_at']) ? date('d M Y h:i A', strtotime($row['created_at'])) : '-' ?>
                                                                        </span>
                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                                                    <div class="score-circle"
                                                                        style="--score: <?= $percentage ?>%;">
                                                                        <span><?= $percentage ?>%</span>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="card-body bg-white">

                                                            <div class="row mb-4">

                                                                <div class="col-md-2 col-6 mb-3">
                                                                    <div class="mini-stat">
                                                                        <h5 class="text-primary"><?= $total_q ?></h5>
                                                                        <small>Total Questions</small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 col-6 mb-3">
                                                                    <div class="mini-stat">
                                                                        <h5 class="text-success"><?= $correct ?></h5>
                                                                        <small>Correct</small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 col-6 mb-3">
                                                                    <div class="mini-stat">
                                                                        <h5 class="text-danger"><?= $wrong ?></h5>
                                                                        <small>Wrong</small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 col-6 mb-3">
                                                                    <div class="mini-stat">
                                                                        <h5 class="text-warning"><?= $row['total_marks'] ?? 0 ?>
                                                                        </h5>
                                                                        <small>Marks</small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 col-6 mb-3">
                                                                    <div class="mini-stat">
                                                                        <h5 class="text-info"><?= $row['no_of_question'] ?? 0 ?>
                                                                        </h5>
                                                                        <small>Attempted</small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 col-6 mb-3">
                                                                    <div class="mini-stat">
                                                                        <h5 class="text-dark">
                                                                            <?= !empty($row['solved_duration']) ? $row['solved_duration'] : '-' ?>
                                                                        </h5>
                                                                        <small>Duration</small>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="progress mb-4"
                                                                style="height: 12px; border-radius: 20px;">
                                                                <div class="progress-bar <?= $percentage >= 60 ? 'bg-success' : 'bg-danger' ?>"
                                                                    role="progressbar"
                                                                    style="width: <?= $percentage ?>%; border-radius: 20px;"
                                                                    aria-valuenow="<?= $percentage ?>" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>

                                                            <button class="btn btn-primary btn-sm" type="button"
                                                                data-toggle="collapse" data-target="#mcqReview<?= $row['id'] ?>"
                                                                aria-expanded="false"
                                                                aria-controls="mcqReview<?= $row['id'] ?>">
                                                                <i class="fas fa-eye mr-1"></i>
                                                                View MCQ Review
                                                            </button>

                                                            <div class="collapse mt-4" id="mcqReview<?= $row['id'] ?>">

                                                                <?php if (!empty($row['questions'])): ?>

                                                                    <?php $qNo = 1; ?>

                                                                    <?php foreach ($row['questions'] as $q): ?>

                                                                        <?php

                                                                        $correctOption = strtoupper($q['correct_option'] ?? '');
                                                                        $userAnswer = '';

                                                                        if (!empty($solvedData)) {
                                                                            foreach ($solvedData as $s) {
                                                                                if ($s['q_id'] == $q['id']) {
                                                                                    $correctOption = strtoupper($s['actual_ans'] ?? $correctOption);
                                                                                    $userAnswer = strtoupper($s['user_ans'] ?? '');
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }

                                                                        $options = [
                                                                            'A' => $q['option_a'],
                                                                            'B' => $q['option_b'],
                                                                            'C' => $q['option_c'],
                                                                            'D' => $q['option_d']
                                                                        ];

                                                                        ?>

                                                                        <div class="question-box">

                                                                            <h6 class="font-weight-bold mb-3">
                                                                                Q<?= $qNo ?>. <?= $q['question'] ?>
                                                                            </h6>

                                                                            <?php foreach ($options as $opt => $txt): ?>

                                                                                <?php

                                                                                $optionClass = 'answer-option';
                                                                                $icon = '';

                                                                                if ($opt == $correctOption) {
                                                                                    $optionClass .= ' answer-correct';
                                                                                    $icon = '<i class="fas fa-check-circle mr-1"></i>';
                                                                                }

                                                                                if ($opt == $userAnswer && $userAnswer != $correctOption) {
                                                                                    $optionClass .= ' answer-wrong';
                                                                                    $icon = '<i class="fas fa-times-circle mr-1"></i>';
                                                                                }

                                                                                ?>

                                                                                <div class="<?= $optionClass ?>">
                                                                                    <?= $icon ?>
                                                                                    <strong><?= $opt ?>.</strong>
                                                                                    <?= $txt ?>
                                                                                </div>

                                                                            <?php endforeach; ?>

                                                                            <div class="mt-2 small text-muted">
                                                                                Correct Answer:
                                                                                <strong><?= $correctOption ?: '-' ?></strong>

                                                                                <span class="mx-2">|</span>

                                                                                Student Answer:
                                                                                <strong><?= $userAnswer ?: 'Not Attempted' ?></strong>
                                                                            </div>

                                                                        </div>

                                                                        <?php $qNo++; ?>

                                                                    <?php endforeach; ?>

                                                                <?php else: ?>

                                                                    <div class="text-center text-muted py-4">
                                                                        <i class="fas fa-question-circle fa-2x mb-2"></i>
                                                                        <p>No questions found for this lesson.</p>
                                                                    </div>

                                                                <?php endif; ?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                <?php endforeach; ?>

                                            <?php else: ?>

                                                <div class="empty-state">
                                                    <i class="fas fa-user-graduate fa-4x text-muted mb-3"></i>
                                                    <h4>No Lesson Activity Found</h4>
                                                    <p class="text-muted mb-0">
                                                        Student has not watched lessons or attempted MCQs yet.
                                                    </p>
                                                </div>

                                            <?php endif; ?>

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



<!-- content -->
<?php init_footer(); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/user.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/certificate.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/student.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/question.js"></script>

<script>
    <?php if (!empty($lesson_progress)): ?>

        var radarCtx = document.getElementById('studentRadarChart');

        new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: [
                    'Score',
                    'Pass Rate',
                    'Video Completion',
                    'Accuracy',
                    'Lessons'
                ],

                datasets: [{
                    label: 'Student Performance',
                    data: [
                        <?= $avgScore ?>,
                        <?= round(($passCount / $totalLessons) * 100) ?>,
                        <?= round(($completedVideos / $totalLessons) * 100) ?>,
                        <?= round(($totalCorrect / ($totalCorrect + $totalWrong)) * 100) ?>,
                        100
                    ]
                }]
            }
        });

        var answerAccuracyCtx = document.getElementById('answerAccuracyChart');

        if (answerAccuracyCtx) {
            new Chart(answerAccuracyCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Correct Answers', 'Wrong Answers'],
                    datasets: [{
                        data: [
                            <?= $totalCorrect ?>,
                            <?= $totalWrong ?>
                        ],
                        backgroundColor: [
                            '#28a745',
                            '#dc3545'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        var lessonScoreCtx = document.getElementById('lessonScoreChart');

        if (lessonScoreCtx) {
            new Chart(lessonScoreCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($chartLabels) ?>,
                    datasets: [{
                        label: 'Score %',
                        data: <?= json_encode($chartScores) ?>,
                        backgroundColor: '#ff3636',
                        borderRadius: 2,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        },
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

    <?php endif; ?>
</script>