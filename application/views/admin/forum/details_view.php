<?php init_header(); ?>
<style>
    .q-header {
        background: linear-gradient(145deg, #ffffff, #fbfbfb);
        border-radius: 16px;
        padding: 26px;
        box-shadow:
            0 10px 30px rgba(0, 0, 0, .04),
            0 2px 6px rgba(0, 0, 0, .03);
        margin-bottom: 24px;
        border: 1px solid rgba(0, 0, 0, .04);
    }

    .q-title {
        font-size: 24px;
        font-weight: 700;
        letter-spacing: .2px;
        margin-bottom: 12px;
    }

    .q-desc {
        color: #555;
        line-height: 1.75;
        font-size: 15px;
        margin-bottom: 12px; 
    }

    .q-tags span {
        background: #eef2ff;
        color: #3b5bdb;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 12px;
        margin-right: 5px;
        font-weight: 600;
    }

    .reply-item {
        position: relative;
        display: flex;
        margin-bottom: 26px;
    }

    .reply-item::before {
        content: '';
        position: absolute;
        left: 17px;
        top: 40px;
        bottom: -26px;
        width: 2px;
        background: #e6e9f2;
    }

    .reply-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ca151c, #ff4b2b);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 16px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .15);
        z-index: 1;
    }

    .reply-body {
        flex: 1;
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow:
            0 6px 18px rgba(0, 0, 0, .05),
            0 1px 3px rgba(0, 0, 0, .04);
        border: 1px solid rgba(0, 0, 0, .05);
        transition: .18s ease;
    }

    .reply-body:hover {
        transform: translateY(-2px);
        box-shadow:
            0 14px 28px rgba(0, 0, 0, .08),
            0 2px 6px rgba(0, 0, 0, .05);
    }

    .reply-title {
        font-size: 15px;
        margin-bottom: 10px;
        font-weight: 600;

    }

    .reply-meta {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #888;
        margin-bottom: 8px;
    }

    .reply-text {
        font-size: 14px;
        color: #444;
        line-height: 1.7;
    }

    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(0, 0, 0, .05);
    }

    .empty-thread {
        background: #ffffff;
        border-radius: 12px;
        padding: 26px;
        text-align: center;
        color: #999;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .05);
    }
</style>
<div class="main-content mb-5">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <a href="<?= base_url(ADMIN . FORUM . 'listing'); ?>" class="btn btn-primary float-right mt-3 mb-3">Back</a>
                    </div>
                    <div class="col-lg-8  mt-4">

                        <div class="q-header">

                            <div class="q-user">
                                <!-- <div class="avatar">
                                    <?= strtoupper(substr($question['asked_by'], 0, 1)) ?>
                                </div> -->
                                <div>
                                    <div class="q-asked"></div>
                                    <div class="q-date"><b><?= $question['asked_by'] ?></b> Asked Question</div>
                                </div>
                            </div>

                            <div class="q-title">
                                <?= $question['title'] ?>
                            </div>

                            <div class="q-desc">
                                <?= $question['description'] ?>
                            </div>

                            <div class="q-tags">
                                <?php
                                $tags = !empty($question['tags']) ? explode(',', $question['tags']) : [];
                                foreach ($tags as $tag):
                                ?>
                                    <span><?= trim($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                        </div>


                        <div class="reply-title">
                            Discussion
                        </div>

                        <?php if (empty($answers)): ?>
                            <div class="empty-thread">
                                No replies yet — start the discussion 🙂
                            </div>
                        <?php endif; ?>


                        <?php foreach ($answers as $ans): ?>
                            <div class="reply-item">

                                <div class="reply-avatar">
                                    <?= strtoupper(substr($ans['answered_by'], 0, 1)) ?>
                                </div>

                                <div class="reply-body">

                                    <div class="reply-meta">
                                        <b><?= $ans['answered_by'] ?></b>
                                        <span><?= date('d M Y', strtotime($ans['created_at'])) ?></span>
                                    </div>

                                    <div class="reply-text">
                                        <?= nl2br(htmlspecialchars($ans['answer'])) ?>
                                    </div>

                                </div>

                            </div>
                        <?php endforeach; ?>

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