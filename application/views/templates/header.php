<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title><?php echo isset($page_title) ? $page_title : 'One at a Time'; ?></title>
    <style>
        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 100;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .app-logo {
            height: 50px;
            width: auto;
            margin-right: 15px;
        }

        .app-name {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .profile-picture {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e0e0e0;
        }

        /* Navigation Tabs - Modified */
        .nav-tabs-container {
            display: flex;
            justify-content: center;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        .nav-tabs {
            display: flex;
            gap: 60px;
            /* Increased space between tabs */
            padding: 0 20px;
        }

        .nav-tabs a {
            padding: 12px 5px;
            /* Reduced side padding */
            text-decoration: none;
            color: #333;
            font-weight: 500;
            position: relative;
        }

        .nav-tabs a.active {
            color: #007bff;
        }

        .nav-tabs a.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: #007bff;
        }

        .nav-tabs a:hover {
            background: transparent;
            /* Remove background hover */
            color: #007bff;
        }

        .profile-picture {
            margin-right: 20px;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <header class="app-header">
        <div class="logo-container">
            <img src="<?php echo base_url('images/logo.png'); ?>" alt="App Logo" class="app-logo">
            <span class="app-name">One at a Time</span>
        </div>

        <div class="user-profile">
            <?php if ($this->session->userdata('user_id')): ?>
                <?php
                $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
                ?>
                <span class="username"><?php echo is_object($user) ? $user->user_name : $user['user_name']; ?></span>
                <img src="<?php echo base_url('images/profile-user.png'); ?>"
                    class="profile-picture">
                <a href="<?php echo site_url('auth/logout'); ?>" class="logout-btn">Logout</a>
            <?php else: ?>
                <a href="<?php echo site_url('auth/login'); ?>" class="login-btn">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Navigation Tabs - Wrapped in container -->
    <div class="nav-tabs-container">
        <nav class="nav-tabs">
            <a href="<?php echo base_url('home'); ?>"
                class="<?php echo ($active_tab == 'home') ? 'active' : ''; ?>">Home</a>
            <a href="<?php echo base_url('explore'); ?>"
                class="<?php echo ($active_tab == 'explore') ? 'active' : ''; ?>">Explore</a>
        </nav>
    </div>