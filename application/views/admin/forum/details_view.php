<?php init_header(); ?>

<style>
    .main-content {
        background: #f6f8fa;
    }

    .question-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 30px;
        border: 1px solid #e6e8eb;
        margin-bottom: 35px;
        transition: 0.2s ease;
    }

    .question-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .question-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .question-meta {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .question-desc {
        font-size: 15px;
        line-height: 1.75;
        margin-bottom: 18px;
    }

    .question-tags span {
        background: #eef2ff;
        color: #4c6ef5;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        margin-right: 6px;
    }

    .discussion-header {
        font-size: 18px;
        font-weight: 600;
        margin: 35px 0 20px;
    }

    .thread {
        display: flex;
        gap: 15px;
        margin-bottom: 28px;
    }

    .thread.level-1 {
        margin-left: 35px;
    }

    .thread.level-2 {
        margin-left: 70px;
    }

    .vote-box {
        width: 42px;
        text-align: center;
        font-size: 18px;
        color: #6c757d;
    }

    .vote-box div {
        cursor: pointer;
        transition: 0.2s ease;
    }

    .vote-box div:hover {
        color: #4c6ef5;
        transform: scale(1.2);
    }

    .vote-count {
        font-size: 14px;
        margin: 4px 0;
    }

    .thread-content {
        flex: 1;
        background: #ffffff;
        border: 1px solid #e6e8eb;
        border-radius: 14px;
        padding: 20px;
        transition: 0.2s ease;
    }

    .thread-content:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .thread-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .thread-user {
        font-weight: 600;
        font-size: 14px;
    }

    .thread-date {
        font-size: 12px;
        color: #888;
    }

    .badge-owner {
        background: #e7f5ff;
        color: #1971c2;
        font-size: 11px;
        padding: 3px 7px;
        border-radius: 20px;
    }

    .accepted-badge {
        display: inline-block;
        background: #e6fcf5;
        color: #087f5b;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .op-highlight .thread-content {
        border-left: 4px solid #1971c2;
    }

    .thread-text {
        font-size: 14px;
        line-height: 1.7;
        margin-top: 6px;
        max-height: 130px;
        overflow: hidden;
        transition: 0.3s ease;
        text-align: justify;
    }

    .thread-text.expanded {
        max-height: 1000px;
        text-align: justify;

    }

    .reaction-bar {
        margin-top: 12px;
    }

    .reaction {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f1f3f5;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-right: 6px;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .reaction:hover {
        background: #dee2e6;
        transform: scale(1.05);
    }

    .toggle-replies {
        margin-top: 10px;
        font-size: 13px;
        color: #1971c2;
        cursor: pointer;
        font-weight: 500;
    }

    .toggle-replies:hover {
        text-decoration: underline;
    }

    .side-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px;
        border: 1px solid #e6e8eb;
        transition: 0.2s ease;
    }

    .side-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .side-title {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .empty-thread {
        padding: 22px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e6e8eb;
        color: #999;

    }
</style>

<div class="main-content mb-5">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- Back Button -->
                    <div class="col-12 text-right p-3">
                        <a href="<?= base_url(ADMIN . FORUM . 'listing'); ?>"
                            class="btn btn-outline-primary back-btn">
                            ← Back to Listing
                        </a>
                    </div>

                    <!-- LEFT SIDE -->
                    <div class="col-lg-8 mt-3">

                        <!-- Question -->
                        <div class="question-card">

                            <div class="question-meta">
                                Asked by <strong><?= $question['asked_by'] ?></strong>
                            </div>

                            <div class="question-title">
                                <?= $question['title'] ?>
                            </div>

                            <div class="question-desc">
                                <?= $question['description'] ?>
                            </div>

                            <div class="question-tags">
                                <?php
                                $tags = !empty($question['tags']) ? explode(',', $question['tags']) : [];
                                foreach ($tags as $tag):
                                ?>
                                    <span><?= trim($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <!-- Discussion -->
                        <div class="discussion-header">
                            Discussion
                        </div>

                        <?php if (empty($answers)): ?>
                            <div class="empty-thread">
                                No replies yet — start the discussion 🙂
                            </div>
                        <?php else: ?>

                            <?php
                            function renderThread($comments, $level = 0, $questionUser = '')
                            {
                                foreach ($comments as $comment):
                                    $isOwner = ($comment['answered_by'] === $questionUser);
                            ?>
                                    <div class="thread level-<?= $level ?> <?= $isOwner ? 'op-highlight' : '' ?>">
                                        <div class="thread-content">
                                            <div class="thread-header">
                                                <span class="thread-user">
                                                    <?= $comment['answered_by'] ?>
                                                </span>
                                                <?php if ($isOwner): ?>
                                                    <span class="badge-owner">Author</span>
                                                <?php endif; ?>
                                                <span class="thread-date">
                                                    <?= date('d M Y H:i', strtotime($comment['created_at'])) ?>
                                                </span>
                                            </div>

                                            <?php if ($level == 0 && $comment === reset($comments)): ?>
                                                <span class="accepted-badge">✔ Accepted</span>
                                            <?php endif; ?>

                                            <div class="thread-text collapsible">
                                                <?= $comment['answer'] ?>
                                            </div>
                                            <?php if (!empty($comment['replies'])): ?>
                                                <div class="toggle-replies" onclick="toggleReplies(this)">
                                                    View <?= count($comment['replies']) ?> replies
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($comment['replies'])): ?>
                                        <div class="reply-container" style="display:none;">
                                            <?php renderThread($comment['replies'], $level + 1, $questionUser); ?>
                                        </div>
                                    <?php endif; ?>
                            <?php
                                endforeach;
                            }
                            renderThread($answers, 0, $question['asked_by']);
                            ?>
                        <?php endif; ?>

                    </div>

                    <!-- RIGHT SIDEBAR -->
                    <div class="col-lg-4 mt-3">

                        <div class="side-card">
                            <div class="side-title">Recent Questions</div>

                            <?php if (!empty($recentQuestions)): ?>
                                <?php foreach ($recentQuestions as $rq): ?>
                                    <div style="margin-bottom:10px;">
                                        <a href="<?= base_url(ADMIN . 'Forum/detail_view/' . $rq['id']) ?>">
                                            <?= htmlspecialchars($rq['title']) ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-muted small">
                                    No questions found
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>
<script>
    document.querySelectorAll('.collapsible').forEach(el => {
        if (el.scrollHeight > 130) {
            let more = document.createElement('div');
            more.innerText = "Read more";
            more.style.color = "#1971c2";
            more.style.cursor = "pointer";
            more.style.marginTop = "6px";
            more.onclick = function() {
                el.classList.toggle('expanded');
                this.innerText = el.classList.contains('expanded') ?
                    "Show less" :
                    "Read more";
            };

            el.after(more);
        }
    });

    function toggleReplies(btn) {
        let container = btn.parentElement.parentElement.nextElementSibling;
        if (container.style.display === "none") {
            container.style.display = "block";
            btn.innerText = "Hide replies";
        } else {
            container.style.display = "none";
            btn.innerText = btn.innerText.replace("Hide", "View");
        }
    }
</script>