<form action="<?php echo site_url('post/create'); ?>" method="post">
    <div class="main-content-container">
        <!-- Left Container (70%) -->
        <div class="left-container">
            <!-- Post Text Area -->
            <div class="post-text-container">
                <textarea name="content" class="post-textarea" placeholder="Write your day..." rows="4"
                    maxlength="180"><?php echo set_value('content'); ?></textarea>
                <div class="char-counter">180 characters remaining</div>
                <?php echo form_error('content'); ?>
            </div>

            <div class="post-controls">
                <!-- Tag Selection -->
                <div class="tag-selection">
                    <select id="tag-dropdown" class="tag-dropdown">
                        <option value="">Select tags (max 3)...</option>
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['category']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="selected-tags" class="selected-tags"></div>
                    <input type="hidden" name="tags" id="tags-input">
                </div>

                <button type="submit" class="post-button">Post</button>
            </div>
        </div>

        <!-- Right Container (30%) -->
        <div class="right-container">
            <div class="date-greeting">
                <?php date_default_timezone_set('Asia/Manila'); ?>
                <h3><?php echo date('g:i A · M j, Y'); ?></h3>
                <p>Hello, <?php echo $username ?? 'User'; ?>!</p>
            </div>
        </div>
    </div>
</form>

<!-- Add this to your existing CSS -->
<style>
    .tag-input {
        border: 1px solid #ddd;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 13px;
        margin-right: 10px;
    }

    .tag-input:focus {
        outline: none;
        border-color: #1d9bf0;
    }

    .error {
        color: #ff0000;
        font-size: 13px;
        margin-top: 5px;
    }

    .tag-input {
        border: 1px solid #ddd;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 13px;
        margin-right: 10px;
    }

    .tag-input:focus {
        outline: none;
        border-color: #1d9bf0;
    }

    .error {
        color: #ff0000;
        font-size: 13px;
        margin-top: 5px;
    }

    .tag-selection {
        flex-grow: 1;
        margin-right: 10px;
    }

    .tag-dropdown {
        width: 100%;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .selected-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }

    .tag-pill {
        background: #e0f0ff;
        padding: 3px 8px;
        border-radius: 15px;
        font-size: 12px;
        display: flex;
        align-items: center;
    }

    .tag-pill .remove-tag {
        margin-left: 5px;
        cursor: pointer;
        color: #666;
    }

    .tag-pill .remove-tag:hover {
        color: #ff0000;
    }

    .main-content-container {
        display: flex;
        max-width: 650px;
        margin: 8px auto;
        margin-bottom: 100px;
        gap: 12px;
    }

    .left-container {
        flex: 30;
        background: #fff;
        border-radius: 12px;
        padding: 10px;
        border: 1px solid #e0e0e0;
    }

    .right-container {
        flex: 10;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 10px;
        font-size: 0.9em;
    }

    .post-textarea {
        width: 100%;
        min-height: 60px;
        border: none;
        font-size: 14px;
        resize: none;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        /* Remove outline completely */
        outline: none;
        /* Optional: Add custom focus style if desired */
        /* border: 1px solid #1d9bf0; */
    }

    .post-controls {
        display: flex;
        justify-content: space-between;
        padding-top: 6px;
        margin-top: 4px;
        border-top: 1px solid #eee;
    }

    .tags-button {
        background: transparent;
        border: 1px solid #ddd;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 12px;
    }

    .post-button {
        background: #1d9bf0;
        color: white;
        border: none;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 13px;
    }

    .date-greeting h3 {
        color: #536471;
        font-size: 13px;
        margin-bottom: 3px;
    }

    .date-greeting p {
        color: #0f1419;
        font-size: 13px;
        margin: 2px 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('tag-dropdown');
        const selectedTagsContainer = document.getElementById('selected-tags');
        const tagsInput = document.getElementById('tags-input');
        let selectedTags = [];

        dropdown.addEventListener('change', function () {
            if (this.value && selectedTags.length < 3) {
                const tagId = this.value;
                const tagName = this.options[this.selectedIndex].text;

                // Add to selected tags if not already selected
                if (!selectedTags.some(tag => tag.id === tagId)) {
                    selectedTags.push({ id: tagId, name: tagName });
                    updateSelectedTags();
                    this.value = ''; // Reset dropdown
                }
            }
        });

        function updateSelectedTags() {
            selectedTagsContainer.innerHTML = '';
            const tagIds = [];

            selectedTags.forEach(tag => {
                const tagPill = document.createElement('div');
                tagPill.className = 'tag-pill';
                tagPill.innerHTML = `
                ${tag.name}
                <span class="remove-tag" data-id="${tag.id}">×</span>
            `;
                selectedTagsContainer.appendChild(tagPill);
                tagIds.push(tag.id);
            });

            // Update hidden input with comma-separated tag IDs
            tagsInput.value = tagIds.join(',');

            // Disable dropdown if max tags reached
            dropdown.disabled = selectedTags.length >= 3;
        }

        // Remove tag when clicked
        selectedTagsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-tag')) {
                const tagId = e.target.getAttribute('data-id');
                selectedTags = selectedTags.filter(tag => tag.id !== tagId);
                updateSelectedTags();
            }
        });
    });
</script>