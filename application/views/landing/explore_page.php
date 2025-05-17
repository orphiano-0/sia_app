<div class="posts-container">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-card" data-post-id="<?= $post['post_id'] ?>">
                <!-- Profile section -->
                <div class="post-profile">
                    <img src="<?= base_url('images/profile-user.png') ?>" alt="Profile" class="profile-pic">
                    <div>
                        <span class="post-username"><?= htmlspecialchars($post['user_name']) ?></span>
                        <span class="post-time"><?= date('M j, Y g:i A', strtotime($post['created_At'])) ?></span>
                    </div>
                </div>

                <!-- Post content -->
                <div class="post-content">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>

                <!-- Tags section -->
                <?php $post_tags = $this->Post_model->get_post_tags($post['post_id']); ?>
                <?php if (!empty($post_tags)): ?>
                    <div class="post-tags">
                        <?php foreach ($post_tags as $tag): ?>
                            <span class="tag" data-tag="<?= strtolower(htmlspecialchars($tag['category'])) ?>">
                                <?= htmlspecialchars($tag['category']) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Post footer -->
                <div class="post-footer">
                    <div class="like-section">
                        <button class="like-button" data-post-id="<?= $post['post_id'] ?>">
                            <i class="far fa-heart"></i>
                            <span class="like-text">Like</span>
                        </button>
                        <span class="like-count"><?= (int) $post['reaction_count'] ?></span>
                    </div>

                    <?php if ($this->session->userdata('user_id') == $post['user_id']): ?>
                        <button class="delete-post-btn" onclick="confirmDelete(<?= $post['post_id'] ?>)">
                            Delete
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-posts">
            <p>No posts to display at the moment.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    body {
        background: #e0f7fa;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .posts-container {
        max-width: 650px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .post-card {
        background: #ffffff;
        border: 2px solid #b2ebf2;
        border-left: 6px solid #00acc1;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 24px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, background 0.3s ease;
    }

    .post-card:hover {
        transform: scale(1.01);
        background: #f1fcfc;
    }

    .post-profile {
        display: flex;
        align-items: center;
        margin-bottom: 14px;
    }

    .profile-pic {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 14px;
        border: 2px solid #b2ebf2;
    }

    .post-username {
        font-weight: bold;
        font-size: 16px;
        color: #006064;
        display: block;
    }

    .post-time {
        font-size: 13px;
        color: #607d8b;
    }

    .post-content {
        font-size: 15px;
        line-height: 1.6;
        color: #37474f;
        margin-bottom: 14px;
        word-wrap: break-word;
        /* Ensures long words break */
        overflow-wrap: break-word;
        /* Alternative for better support */
    }

    .post-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 14px;
    }

    .tag {
        background-color: #e0f2f1;
        color: #00796b;
        padding: 4px 10px;
        border-radius: 14px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .tag:hover {
        background-color: #b2dfdb;
        transform: scale(1.05);
    }

    .post-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #eeeeee;
        padding-top: 12px;
    }

    .like-section {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .like-button {
        background: none;
        border: none;
        color: #00796b;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 4px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .like-button:hover {
        background: #e0f2f1;
        color: #004d40;
    }

    .like-button.liked {
        color: #d81b60;
    }

    .like-count {
        font-size: 13px;
        color: #555;
    }

    .delete-post-btn {
        background: #ffe0e0;
        color: #b71c1c;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .delete-post-btn:hover {
        background: #ffcdd2;
    }

    .no-posts {
        text-align: center;
        padding: 40px;
        color: #666;
        font-size: 16px;
    }

    /* Unique tag color coding (kept from original for consistency) */
    .tag[data-tag="travel"] {
        background-color: #e1f5fe;
        color: #0277bd;
    }

    .tag[data-tag="food"] {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .tag[data-tag="technology"] {
        background-color: #ede7f6;
        color: #5e35b1;
    }

    .tag[data-tag="books"] {
        background-color: #fff3e0;
        color: #ef6c00;
    }

    .tag[data-tag="fitness"] {
        background-color: #e0f7fa;
        color: #00838f;
    }

    .tag[data-tag="life"] {
        background-color: #fce4ec;
        color: #ad1457;
    }

    .tag[data-tag="inspiration"] {
        background-color: #fff8e1;
        color: #f9a825;
    }

    .tag[data-tag="humor"] {
        background-color: #f1f8e9;
        color: #558b2f;
    }
</style>


<script>
    // Like button functionality
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', async function () {
            const postId = this.dataset.postId;
            const icon = this.querySelector('i');
            const likeText = this.querySelector('.like-text');
            const likeCount = this.closest('.like-section').querySelector('.like-count');

            try {
                const response = await fetch('<?= site_url("post/like") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `post_id=${postId}&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>`
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Unknown error');
                }

                if (data.success) {
                    likeCount.textContent = data.new_count;
                    this.classList.toggle('liked');
                    likeText.textContent = data.action === 'liked' ? 'Liked' : 'Like';
                    icon.className = data.action === 'liked' ? 'fas fa-heart' : 'far fa-heart';
                }
            } catch (error) {
                console.error('Like error:', error);
                alert('Error: ' + error.message);
            }
        });
    });
</script>