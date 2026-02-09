<?php init_header(); ?>
<style>
    .so-question-box {
        background: #ffffff;
        border-radius: 10px;
        padding: 18px 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        margin-bottom: 20px;
    }

    .so-title {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
    }

    .so-desc {
        color: #555;
        line-height: 1.7;
        font-size: 14px;
        text-align: justify;
    }

    .so-tag {
        display: inline-block;
        background: #ffeeee;
        color: #d9403b;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-right: 6px;
        font-weight: 500;
    }

    .so-answer {
        background: #fff;
        border-radius: 8px;
        padding: 16px 18px;
        margin-bottom: 20px;
        border-left: 4px solid #CA151C;
        box-shadow: 0 1px 6px rgba(0, 0, 0, .3);
        text-align: justify;

    }

    .so-answer-meta {
        font-size: 12px;
        color: #ff4343;
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
    }

    .so-section-title {
        font-size: 18px;
        font-weight: 600;
        margin: 20px 0 12px 0;
        color: #2c3e50;
    }

    .so-empty {
        background: #fafafa;
        border-radius: 6px;
        padding: 20px;
        text-align: center;
        color: #999;
        font-size: 14px;
    }
</style>
<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <a href="<?= base_url(ADMIN . FORUM . 'listing'); ?>" class="btn btn-primary float-right mt-3 mb-3">Back</a>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4 mt-4">
                            <div class="card-body">
                                <div style="display:flex;justify-content:space-between;">
                                    <p class="card-title"><?= $title ?></p>
                                </div>
                                <div class="so-question-box">

                                    <div class="mb-2 text-muted">
                                        Asked by <b><?= $question['asked_by'] ?></b>
                                    </div>

                                    <div class="so-title mb-2">
                                        <?= $question['title'] ?>
                                    </div>

                                    <div class="so-desc mb-3">
                                        <?= $question['description'] ?>
                                    </div>

                                    <div>
                                        <?php
                                        $tags = !empty($question['tags']) ? explode(',', $question['tags']) : [];
                                        foreach ($tags as $tag):
                                        ?>
                                            <span class="so-tag"><?= trim($tag) ?></span>
                                        <?php endforeach; ?>
                                    </div>

                                </div>


                                <div class="so-section-title">
                                    Replies
                                </div>

                                <?php if (empty($answers)): ?>
                                    <div class="so-empty">
                                        No answers yet — Be the first to reply 🙂
                                    </div>
                                <?php endif; ?>

                                <?php foreach ($answers as $ans): ?>
                                    <div class="so-answer">

                                        <div class="so-answer-meta">
                                            <span>Answered by <b><?= $ans['answered_by'] ?></b></span>
                                            <span><?= date('d M Y', strtotime($ans['created_at'])) ?></span>
                                        </div>

                                        <div>
                                            <?= nl2br(htmlspecialchars($ans['answer'])) ?>
                                        </div>


                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mt-4">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title">Recent Questions</p>

                                <?php if (!empty($recentQuestions)): ?>
                                    <ul style="padding-left:15px;margin-bottom:0;">
                                        <?php foreach ($recentQuestions as $rq): ?>
                                            <li style="margin-bottom:8px;">
                                                <a href="<?= base_url(ADMIN . 'Forum/detail_view/' . $rq['id']) ?>">
                                                    <?= htmlspecialchars($rq['title']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <div class="text-muted small">No questions found</div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>
<script>
    $("#tags_input").select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: "Type and press Enter to add tag",
        width: '100%'
    });
</script>
<script src="<?= base_url(); ?>assets/js/custom-js/forum.js"></script>