<!DOCTYPE html>
<html lang="en">
<?php include(APPPATH . 'views/admin/partial_header.php'); ?>
<body>
    <div class="container">
        <?php include(APPPATH . 'views/admin/partial_sidebar.php'); ?>
        <div class="main collapsed" id="main">
            <h2><i class="fas fa-tachometer-alt"></i> Welcome to Dashboard</h2>
            <p>Welcome to your Admin Dashboard! Here you can manage One At A Time's posts and users</p>
        </div>
    </div>
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

    .main p {
        font-size: 18px;
        color: #555;
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
    }
</style>
