<?php init_header(); ?>
<style>
    .student-name-wrap{
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
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"><?= $title ?> Profile</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <button type="button" class="btn btn-secondary waves-effect waves-light mb-0" onclick="window.history.back()">Back</button>
                            </div>
                        </div>
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
                                
                                <img src="<?= $imagePath ?>" style="width:85px;height:85px;object-fit:cover;border-radius:15px;">
                                    </div>
                                    <div>
                                        <h5 class="mb-3 mt-3 font-weight-bold student-name-wrap">
                                            <?= $user['first_name']; ?> <?= $user['last_name']; ?>
                                        </h5>   

                                        <span class="badge <?= ($user['status']) ? 'badge-success' : 'badge-secondary' ?>"
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
                                        <a class="nav-link active"
                                            data-toggle="tab"
                                            href="#home1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-info-circle mr-1"></i> Basic Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            data-toggle="tab"
                                            href="#profile1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-book mr-1"></i> My Courses
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            data-toggle="tab"
                                            href="#disscussion"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-comments mr-1"></i> My Discussion Forum
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            data-toggle="tab"
                                            href="#qna"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-question mr-1"></i> My QNA
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            data-toggle="tab"
                                            href="#certification"
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
                                                        <input class="form-control"
                                                            type="text"
                                                            id="imei_no"
                                                            name="imei_no"
                                                            value="<?= $user['imei_no']; ?>">
                                                    </div>
                                                </div>
                                                <?php if ($user['role'] != 3) { ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label font-weight-semibold">
                                                            Commission %
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control"
                                                                type="text"
                                                                id="commsion_percentage"
                                                                name="commsion_percentage"
                                                                value="<?= $user['commsion_percentage']; ?>">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="mt-3">
                                                    <button type="button"
                                                        class="btn btn-sm btn-success mr-2"
                                                        onclick="actionUsers(1)">
                                                        <i class="fas fa-check mr-1"></i> Update
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
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
                                                <a href="javascript:void(0);"
                                                    title="Assign Course"
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
                                                        <button type="button"
                                                            class="close"
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
                                        <div class="bg-white p-4 rounded shadow-sm" style="max-height: 500px; overflow-y: scroll;">
                                            <?php if (!empty($forum_questions)) { ?>
                                                <?php foreach ($forum_questions as $row) { ?>
                                                    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>
                                                                    <h6 class="mb-0 font-weight-semibold"><?= $row['title']; ?></h6>
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-sm mb-2 p-0 openReplyModal"
                                                                        data-id="<?= $row['id']; ?>">
                                                                        <i class="fas fa-reply mr-1"></i> Replies (<?= $row['total_answers']; ?>)
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
                                                                    <?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?> </small>
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

                                                        <button type="button"
                                                            class="close"
                                                            data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <div class="modal-body"
                                                        id="replyModalBody"
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

                                            <?php if (!empty($qna_list)) : ?>
                                                <?php foreach ($qna_list as $row) :
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
                                                                    <?php if ($isAnswered) : ?>
                                                                        <span class="badge badge-success">Answered</span>
                                                                    <?php else : ?>
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
                                                            <?php if ($isAnswered) : ?>
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
                                            <?php else : ?>
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
                                        <div class="bg-white p-4 rounded shadow-sm">

                                            <h5 class="mb-4 font-weight-bold">
                                                <i class="fas fa-play-circle text-primary mr-2"></i>
                                                Lesson Video MCQ Solved
                                            </h5>

                                            <?php if (!empty($lesson_progress)) : ?>

                                                <?php foreach ($lesson_progress as $row) : ?>

                                                    <?php
                                                    $resultData = [];
                                                    if (!empty($row['result']) && is_string($row['result'])) {
                                                        $decoded = json_decode($row['result'], true);
                                                        if (json_last_error() === JSON_ERROR_NONE) {
                                                            $resultData = $decoded;
                                                        }
                                                    }

                                                    $total_q = $row['total_questions_db'] ?? 0;
                                                    $correct = $resultData['correct_question'] ?? 0;
                                                    $wrong   = $resultData['wrong_question'] ?? 0;

                                                    $percentage = $total_q > 0
                                                        ? round(($correct / $total_q) * 100)
                                                        : 0;

                                                    $solvedData = [];
                                                    if (!empty($row['solved_mcq']) && is_string($row['solved_mcq'])) {
                                                        $decodedSolved = json_decode($row['solved_mcq'], true);
                                                        if (json_last_error() === JSON_ERROR_NONE) {
                                                            $solvedData = $decodedSolved;
                                                        }
                                                    }
                                                    ?>

                                                    <div class="row text-center mb-4">
                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3">
                                                                <h4 class="text-primary"><?= $total_q ?></h4>
                                                                <small>Total Questions</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3">
                                                                <h4 class="text-success"><?= $correct ?></h4>
                                                                <small>Correct</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3">
                                                                <h4 class="text-danger"><?= $wrong ?></h4>
                                                                <small>Wrong</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="border rounded p-3">
                                                                <h4><?= $row['total_marks'] ?></h4>
                                                                <small>Total Marks</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- QUESTION REVIEW -->
                                                    <div class="card border-0 shadow-sm">
                                                        <div class="card-body">

                                                            <h6 class="mb-3 font-weight-bold">
                                                                <i class="fas fa-list mr-2 text-info"></i>
                                                                Question Review
                                                            </h6>

                                                            <?php if (!empty($row['questions'])) : ?>

                                                                <?php foreach ($row['questions'] as $q) :

                                                                    $userAnswer = '';
                                                                    foreach ($solvedData as $s) {
                                                                        if ($s['q_id'] == $q['id']) {
                                                                            $userAnswer = $s['user_ans'];
                                                                            break;
                                                                        }
                                                                    }

                                                                    $correctOption = '';
                                                                    $userAnswer = '';

                                                                    foreach ($solvedData as $s) {
                                                                        if ($s['q_id'] == $q['id']) {
                                                                            $correctOption = strtoupper($s['actual_ans']);
                                                                            $userAnswer    = strtoupper($s['user_ans']);
                                                                            break;
                                                                        }
                                                                    }                                                                ?>

                                                                    <div class="mb-4 p-3 border rounded bg-light">

                                                                        <p class="font-weight-semibold mb-2">
                                                                            <?= $q['question']; ?>
                                                                        </p>

                                                                        <?php
                                                                        $options = [
                                                                            'A' => $q['option_a'],
                                                                            'B' => $q['option_b'],
                                                                            'C' => $q['option_c'],
                                                                            'D' => $q['option_d']
                                                                        ];

                                                                        foreach ($options as $keyOpt => $optText) :

                                                                            $keyOpt = strtoupper($keyOpt);

                                                                            $class = '';
                                                                            $icon  = '';

                                                                            if ($keyOpt == $correctOption) {
                                                                                $class = 'text-success font-weight-bold';
                                                                                $icon = '<i class="fas fa-check-circle mr-1 text-success"></i>';
                                                                            }

                                                                            if ($keyOpt == $userAnswer && $userAnswer != $correctOption) {
                                                                                $class = 'text-danger font-weight-bold';
                                                                                $icon = '<i class="fas fa-times-circle mr-1 text-danger"></i>';
                                                                            }
                                                                        ?>

                                                                            <div class="<?= $class ?>">
                                                                                <?= $icon ?>
                                                                                <?= $keyOpt ?>. <?= $optText ?>
                                                                            </div>

                                                                        <?php endforeach; ?>

                                                                    </div>

                                                                <?php endforeach; ?>

                                                            <?php else : ?>

                                                                <div class="text-muted text-center py-3">
                                                                    No questions found.
                                                                </div>

                                                            <?php endif; ?>

                                                            <div class="text-muted small mt-3">
                                                                Duration: <?= $row['solved_duration'] ?? '-' ?> |
                                                                Questions Attempted: <?= $row['no_of_question'] ?> |
                                                                Date: <?= !empty($row['created_at']) ? date('d M Y H:i', strtotime($row['created_at'])) : '-' ?>
                                                            </div>

                                                        </div>
                                                    </div>

                                                <?php endforeach; ?>

                                            <?php else : ?>

                                                <div class="text-center py-5">
                                                    <i class="fas fa-video fa-2x text-muted mb-2"></i>
                                                    <p class="text-muted">No lesson activity found.</p>
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
<script src="<?= base_url(); ?>assets/js/custom-js/user.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/certificate.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/student.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/question.js"></script>