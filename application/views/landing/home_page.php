<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f0f0f0;
    }

    .posts-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    .post-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        padding: 20px;
        width: 100%;
    }

    .post-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.9rem;
        color: #777;
    }

    .post-username {
        font-weight: bold;
        color: #333;
    }

    .post-time {
        font-style: italic;
    }

    .post-content {
        font-size: 1rem;
        color: #444;
        margin-bottom: 10px;
    }

    .post-tags {
        margin-top: 10px;
    }

    .tag {
        display: inline-block;
        background: #e0e0e0;
        color: #333;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        margin: 3px;
    }
</style>

<div class="posts-container">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-card" data-post-id="<?php echo $post['post_id']; ?>">
                <div class="post-header">
                    <span class="post-username"><?php echo $username; ?></span>
                    <span class="post-time"><?php echo date('M j, Y g:i A', strtotime($post['created_At'])); ?></span>
                </div>

                <div class="post-content">
                    <?php echo htmlspecialchars($post['content']); ?>
                </div>

                <?php
                $post_tags = $this->Post_model->get_post_tags($post['post_id']);
                if (!empty($post_tags)): ?>
                    <div class="post-tags">
                        <?php foreach ($post_tags as $tag): ?>
                            <span class="tag" data-tag="<?= strtolower(htmlspecialchars($tag['category'])) ?>">
                                <?= htmlspecialchars($tag['category']) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="post-footer">
                    <span class="reaction-count"><?php echo $post['reaction_count']; ?> likes</span>

                    <div class="post-actions">
                        <?php if ($post['user_id'] == $this->session->userdata('user_id')): ?>
                            <a href="<?php echo site_url('post/edit/' . $post['post_id']); ?>" class="edit-post-btn">Edit</a>
                            <button class="delete-post-btn" onclick="confirmDelete(<?php echo $post['post_id']; ?>)">
                                Delete
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-posts">
            <p>No posts found.</p>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmDelete(postId) {
        if (confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
            // User confirmed, proceed with deletion
            deletePost(postId);
        }
    }

    function deletePost(postId) {
        // AJAX request to delete the post
        fetch('<?php echo site_url("post/delete"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'post_id=' + postId
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the post from the DOM
                    document.querySelector(`.post-card[data-post-id="${postId}"]`).remove();

                    // Optional: Show success message
                    alert('Post deleted successfully');
                } else {
                    alert('Error deleting post: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error.message);
                alert('An error occurred while deleting the post');
            });
    }

    const maxTags = 3;
    if (selectedTags.length >= maxTags) {
        document.getElementById('tag-dropdown').disabled = true;
        document.getElementById('tag-limit-message').style.display = 'block';
    } else {
        document.getElementById('tag-dropdown').disabled = false;
        document.getElementById('tag-limit-message').style.display = 'none';
    }
</script>

<style>
    .posts-container {
        max-width: 600px;
        margin: 20px auto;
    }

    .post-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        /* Increased padding */
        margin-bottom: 20px;
        /* Increased margin */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        min-height: 180px;
        /* Minimum height for each post */
        display: flex;
        flex-direction: column;
    }

    .post-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .post-username {
        font-weight: bold;
    }

    .post-time {
        color: #666;
    }

    .post-content {
        margin-bottom: 15px;
        /* Increased margin */
        line-height: 1.5;
        /* Improved line height */
        flex-grow: 1;
        /* Takes available space */
        word-wrap: break-word;
        /* Ensures long words break */
        overflow-wrap: break-word;
        /* Alternative for better support */
    }

    .post-actions {
        display: flex;
        gap: 10px;
    }

    .edit-post-btn {
        background: #e0f7fa;
        color: #00acc1;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .edit-post-btn:hover {
        background: #b2ebf2;
    }

    .tag-bubble {
        display: inline-block;
        background: #f0f2f5;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
        color: #1d9bf0;
    }

    .post-footer {
        border-top: 1px solid #eee;
        padding-top: 8px;
        font-size: 13px;
        color: #666;
    }

    .no-posts {
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .delete-post-btn {
        background: #ff4444;
        color: white;
        border: none;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        margin-left: 10px;
    }

    .delete-post-btn:hover {
        background: #cc0000;
    }

    .post-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #eee;
        padding-top: 8px;
        font-size: 13px;
        color: #666;
    }

    .post-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }

    .tag {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
        text-transform: lowercase;
        transition: all 0.2s ease;
    }

    /* Color variations for different tags */
    .tag:nth-child(1n) {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    /* Blue */
    .tag:nth-child(2n) {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    /* Green */
    .tag:nth-child(3n) {
        background-color: #f3e5f5;
        color: #8e24aa;
    }

    /* Purple */
    .tag:nth-child(4n) {
        background-color: #fff3e0;
        color: #f57c00;
    }

    /* Orange */
    .tag:nth-child(5n) {
        background-color: #ffebee;
        color: #d32f2f;
    }

    /* Red */
    .tag:nth-child(6n) {
        background-color: #e0f7fa;
        color: #00acc1;
    }

    /* Cyan */

    /* Hover effects */
    .tag:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Specific tag colors (optional - if you know your tag categories) */
    .tag[data-tag="travel"] {
        background-color: #bbdefb;
        color: #0d47a1;
    }

    .tag[data-tag="food"] {
        background-color: #c8e6c9;
        color: #2e7d32;
    }

    .tag[data-tag="technology"] {
        background-color: #d1c4e9;
        color: #4527a0;
    }

    .tag[data-tag="books"] {
        background-color: #ffccbc;
        color: #bf360c;
    }

    .tag[data-tag="fitness"] {
        background-color: #b2ebf2;
        color: #006064;
    }

    .tag[data-tag="life"] {
        background-color: #f8bbd0;
        color: #880e4f;
    }

    .tag[data-tag="inspiration"] {
        background-color: #d7ccc8;
        color: #3e2723;
    }

    .tag[data-tag="humor"] {
        background-color: #f0f4c3;
        color: #827717;
    }

    /* If you want the first tag to stand out */
    .post-tags .tag:first-child {
        font-weight: bold;
        padding: 4px 14px;
    }

    /* For dark mode compatibility */
    @media (prefers-color-scheme: dark) {
        .tag {
            opacity: 0.9;
        }
    }
</style>