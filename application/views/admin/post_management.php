<!DOCTYPE html>
<html lang="en">
<?php include(APPPATH . 'views/admin/partial_header.php'); ?>
<body>
    <div class="container">
        <?php include(APPPATH . 'views/admin/partial_sidebar.php'); ?>
        <div class="main collapsed" id="main">
            <h2><i class="fas fa-file-alt"></i> Post Management</h2>

            <!-- Tag Filter Form -->
            <form method="get" action="<?= site_url('admin/posts') ?>" style="margin-bottom: 20px;">
                <label for="tag_filter">Filter by Tag:</label>
                <select id="tag_filter" name="tag" onchange="this.form.submit()">
                    <option value="">All Tags</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?= $tag['tag_id'] ?>" <?= isset($_GET['tag']) && $_GET['tag'] == $tag['tag_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tag['category']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>


            <?php if (!empty($posts)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Content</th>
                            <th>Tags</th>
                            <th>Created</th>
                            <th class="reactions-column">Reactions</th>
                            <th class="actions-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?= htmlspecialchars($post['id']) ?></td>
                                <td><?= htmlspecialchars($post['username']) ?></td>
                                <td><?= htmlspecialchars($post['content']) ?></td>
                                <td><?= htmlspecialchars($post['tag_name'] ?? 'None') ?></td>
                                <td><?= date('M j, Y', strtotime($post['created_At'])) ?></td>
                                <td class="reactions-column"><?= htmlspecialchars($post['reaction_count']) ?> <i class="fas fa-thumbs-up"></i></td>
                                <td class="actions-column">
                                    <form method="POST" action="<?= site_url('admin/delete_post/' . $post['id']) ?>" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No posts available.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <script>
            showToast("<?= $this->session->flashdata('success') ?>");
        </script>
    <?php elseif ($this->session->flashdata('error')): ?>
        <script>
            showToast("<?= $this->session->flashdata('error') ?>", true);
        </script>
    <?php endif; ?>
</body>
</html>

<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: #f5f6fa;
        color: #333;
        display: flex;
        min-height: 100vh;
    }

    .container {
        display: flex;
        width: 100%;
    }

    .main {
        flex: 1;
        padding: 30px;
        transition: margin-left 0.3s ease;
        margin-left: 250px;
        min-height: 100vh;
    }

    .main.collapsed {
        margin-left: 70px;
    }

    .main h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-table {
        width: 100%;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        border-collapse: collapse;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .admin-table thead {
        background-color: #f0f2f5;
    }

    .admin-table th, .admin-table td {
        padding: 15px;
        text-align: left;
        font-size: 14px;
    }

    .admin-table th {
        font-weight: 600;
        color: #555;
    }

    .admin-table tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    .admin-table tbody tr:hover {
        background-color: #f1f9ff;
        transition: background-color 0.2s ease;
    }

    .admin-table th.reactions-column,
    .admin-table td.reactions-column {
        text-align: center;
    }

    .admin-table th.actions-column,
    .admin-table td.actions-column {
        text-align: center;
    }

    .delete-btn {
        background-color: #ef4444;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.2s ease;
    }

    .delete-btn:hover {
        background-color: #dc2626;
    }

    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #10b981;
        color: #fff;
        padding: 12px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2000;
    }

    .toast.show {
        opacity: 1;
    }

    .toast.error {
        background-color: #ef4444;
    }

    @media (max-width: 768px) {
        .main {
            margin-left: 70px;
        }

        .admin-table, .admin-table thead, .admin-table tbody, .admin-table th, .admin-table td, .admin-table tr {
            display: block;
        }

        .admin-table thead tr {
            display: none;
        }

        .admin-table td {
            position: relative;
            padding: 15px 15px 15px 50%;
            border-bottom: 1px solid #eee;
            min-height: 50px;
        }

        .admin-table td::before {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 40%;
            font-weight: 600;
            color: #666;
            white-space: nowrap;
        }

        .admin-table td:nth-of-type(1)::before { content: "ID"; }
        .admin-table td:nth-of-type(2)::before { content: "User"; }
        .admin-table td:nth-of-type(3)::before { content: "Content"; }
        .admin-table td:nth-of-type(4)::before { content: "Tags"; }
        .admin-table td:nth-of-type(5)::before { content: "Created"; }
        .admin-table td:nth-of-type(6)::before { content: "Reactions"; }
        .admin-table td:nth-of-type(7)::before { content: "Action"; }
    }
</style>
```