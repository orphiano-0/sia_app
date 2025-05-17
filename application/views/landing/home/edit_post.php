<div class="edit-post-container">
    <h2>Edit Post</h2>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo site_url('post/update'); ?>" method="post">
        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">

        <div class="form-group">
            <label for="content">Post Content</label>
            <textarea name="content" id="content" class="form-control post-textarea" rows="4"
                required><?php echo set_value('content', $post['content']); ?></textarea>
            <div class="char-counter">180 characters remaining</div>
        </div>

        <div class="form-group">
            <label>Tags (max 3)</label>
            <select id="tag-dropdown" class="tag-dropdown">
                <option value="">Select tags...</option>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['category']; ?></option>
                <?php endforeach; ?>
            </select>
            <div id="selected-tags" class="selected-tags">
                <?php foreach ($post_tags as $tag): ?>
                    <span class="tag-pill" data-tag-id="<?php echo $tag['tag_id']; ?>">
                        <?php echo $tag['category']; ?>
                        <span class="remove-tag">×</span>
                    </span>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="tags" id="tags-input"
                value="<?php echo implode(',', array_column($post_tags, 'tag_id')); ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Post</button>
            <a href="<?php echo site_url('home'); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Character counter
        const textarea = document.querySelector('.post-textarea');
        const counter = document.querySelector('.char-counter');

        if (textarea && counter) {
            textarea.addEventListener('input', function () {
                const remaining = 180 - this.value.length;
                counter.textContent = remaining + ' characters remaining';
                counter.style.color = remaining < 20 ? '#ff0000' : '#666';
            });
            // Trigger initial count
            textarea.dispatchEvent(new Event('input'));
        }

        // Tag selection
        const dropdown = document.getElementById('tag-dropdown');
        const selectedTagsContainer = document.getElementById('selected-tags');
        const tagsInput = document.getElementById('tags-input');
        let selectedTags = tagsInput.value ? tagsInput.value.split(',') : [];

        dropdown.addEventListener('change', function () {
            if (this.value && selectedTags.length < 3) {
                const tagId = this.value;
                const tagName = this.options[this.selectedIndex].text;

                if (!selectedTags.includes(tagId)) {
                    selectedTags.push(tagId);
                    updateSelectedTags();
                    this.value = '';
                }
            }
        });

        function updateSelectedTags() {
            selectedTagsContainer.innerHTML = '';
            tagsInput.value = selectedTags.join(',');

            selectedTags.forEach(tagId => {
                const tagName = Array.from(dropdown.options)
                    .find(opt => opt.value === tagId).text;

                const tagPill = document.createElement('span');
                tagPill.className = 'tag-pill';
                tagPill.dataset.tagId = tagId;
                tagPill.innerHTML = `${tagName} <span class="remove-tag">×</span>`;
                selectedTagsContainer.appendChild(tagPill);
            });

            dropdown.disabled = selectedTags.length >= 3;
        }

        selectedTagsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-tag')) {
                const tagId = e.target.closest('.tag-pill').dataset.tagId;
                selectedTags = selectedTags.filter(id => id !== tagId);
                updateSelectedTags();
            }
        });

        // Initialize if there are existing tags
        if (selectedTags.length > 0) {
            updateSelectedTags();
        }
    });
</script>

<style>
    .edit-post-container {
        max-width: 600px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .edit-post-container h2 {
        margin-bottom: 20px;
        color: #333;
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 14px;
    }

    .post-textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 4px;
        min-height: 120px;
        resize: vertical;
        line-height: 1.5;
        font-size: 14px;
    }

    .char-counter {
        font-size: 12px;
        color: #666;
        text-align: right;
        margin-top: 5px;
    }

    .tag-dropdown {
        width: 100%;
        padding: 8px;
        border: 1px solid #eee;
        border-radius: 4px;
        font-size: 14px;
    }

    .selected-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
        margin-bottom: 15px;
    }

    .tag-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
        text-transform: lowercase;
        transition: all 0.2s ease;
    }

    /* Tag pill colors matching the home page */
    .tag-pill:nth-child(1n) {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .tag-pill:nth-child(2n) {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .tag-pill:nth-child(3n) {
        background-color: #f3e5f5;
        color: #8e24aa;
    }

    .tag-pill:nth-child(4n) {
        background-color: #fff3e0;
        color: #f57c00;
    }

    .tag-pill:nth-child(5n) {
        background-color: #ffebee;
        color: #d32f2f;
    }

    .tag-pill:nth-child(6n) {
        background-color: #e0f7fa;
        color: #00acc1;
    }

    .tag-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Specific tag colors (matching home page) */
    .tag-pill[data-tag="travel"] {
        background-color: #bbdefb;
        color: #0d47a1;
    }

    .tag-pill[data-tag="food"] {
        background-color: #c8e6c9;
        color: #2e7d32;
    }

    .tag-pill[data-tag="technology"] {
        background-color: #d1c4e9;
        color: #4527a0;
    }

    .tag-pill[data-tag="books"] {
        background-color: #ffccbc;
        color: #bf360c;
    }

    .tag-pill[data-tag="fitness"] {
        background-color: #b2ebf2;
        color: #006064;
    }

    .tag-pill[data-tag="life"] {
        background-color: #f8bbd0;
        color: #880e4f;
    }

    .tag-pill[data-tag="inspiration"] {
        background-color: #d7ccc8;
        color: #3e2723;
    }

    .tag-pill[data-tag="humor"] {
        background-color: #f0f4c3;
        color: #827717;
    }

    .remove-tag {
        margin-left: 6px;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .remove-tag:hover {
        opacity: 1;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #1d9bf0;
        color: white;
    }

    .btn-primary:hover {
        background: #0c7abf;
    }

    .btn-secondary {
        background: #f0f2f5;
        color: #666;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 14px;
        line-height: 1.5;
    }

    .alert-danger {
        background: #ffebee;
        color: #d32f2f;
        border: 1px solid #ef9a9a;
    }

    /* For dark mode compatibility */
    @media (prefers-color-scheme: dark) {
        .tag-pill {
            opacity: 0.9;
        }
    }
</style>