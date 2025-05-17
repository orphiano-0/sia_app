<!-- Sidebar Partial: views/admin/_sidebar.php -->
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background-color: #1e1e2f;
        color: white;
        transition: width 0.3s ease;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
    }

    .logo {
        font-size: 24px;
    }

    .admin-text {
        margin-left: 10px;
        font-weight: bold;
    }

    .toggle-btn {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }

    .sidebar.collapsed .admin-text,
    .sidebar.collapsed .toggle-btn,
    .sidebar.collapsed .link-text {
        display: none;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        transition: background 0.2s;
    }

    .sidebar a:hover {
        background-color: #29293d;
    }

    .sidebar i {
        margin-right: 10px;
        font-style: normal;
    }

    .main-content {
        flex: 1;
        padding: 20px;
    }
</style>

<div class="sidebar collapsed" id="sidebar" onclick="handleSidebarClick(event)">
    <div class="sidebar-header">
        <span class="logo">🧭</span>
        <span class="admin-text">Admin</span>
        <button class="toggle-btn" id="toggleBtn" onclick="toggleSidebar(event)">☰</button>
    </div>

    <a href="<?= site_url('admin/dashboard') ?>">
        <i>📌</i><span class="link-text">Dashboard</span>
    </a>
    <a href="<?= site_url('admin/posts') ?>">
        <i>📄</i><span class="link-text">Post Management</span>
    </a>
    <a href="<?= site_url('admin/users') ?>">
        <i>👥</i><span class="link-text">User Management</span>
    </a>
    <a href="<?= site_url('admin/logout') ?>">
        <i>🚪</i><span class="link-text">Logout</span>
    </a>
</div>

<script>
    function toggleSidebar(event) {
        event.stopPropagation();
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('collapsed');
        document.cookie = `sidebar_collapsed=${sidebar.classList.contains('collapsed')}; path=/`;
    }

    function handleSidebarClick(event) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar.classList.contains('collapsed')) {
            sidebar.classList.remove('collapsed');
            document.cookie = "sidebar_collapsed=false; path=/";
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const collapsed = document.cookie.includes('sidebar_collapsed=true');
        if (collapsed) sidebar.classList.add('collapsed');
        else sidebar.classList.remove('collapsed');
    });
</script>
