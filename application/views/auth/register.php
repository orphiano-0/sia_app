<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - OneAtATime</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            background: #f0f0f0; 
        }
        .logo { 
            width: 150px; 
            height: 150px; 
            margin: 0 auto 30px; 
            display: block; /* Ensures the image itself is centered within its container */
        }
        h2 { 
            color: #333; 
            margin-bottom: 30px; 
            text-align: center; 
            font-size: 2rem; 
        }
        .form-group { 
            margin-bottom: 20px; 
            text-align: left; 
            max-width: 500px; 
            width: 100%; 
            margin-left: auto; 
            margin-right: auto; 
        }
        label { 
            font-size: 1.1rem; 
            color: #333; 
        }
        input { 
            width: 100%; 
            padding: 12px; 
            margin-top: 8px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            box-sizing: border-box; 
            font-size: 1rem; 
        }
        button { 
            width: 100%; 
            padding: 12px; 
            background: #8a9a5b; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            max-width: 500px; 
            margin-left: auto; 
            margin-right: auto; 
            display: block; 
            font-size: 1.1rem; 
        }
        button:hover { 
            background: #6f8050; 
        }
        .error { 
            color: red; 
            margin: 15px auto; 
            text-align: center; 
            max-width: 500px; 
            font-size: 1rem; 
        }
        .success { 
            color: green; 
            margin: 15px auto; 
            text-align: center; 
            max-width: 500px; 
            font-size: 1rem; 
        }
        .toggle-link { 
            margin-top: 20px; 
            color: #8a9a5b; 
            text-decoration: none; 
            display: block; 
            text-align: center; 
            max-width: 500px; 
            margin-left: auto; 
            margin-right: auto; 
            font-size: 1rem; 
        }
        .toggle-link:hover { 
            text-decoration: underline; 
        }

        /* Medium screens (tablets, 481px to 768px) */
        @media (max-width: 768px) and (min-width: 481px) {
            .logo { width: 120px; height: 120px; margin-bottom: 25px; }
            h2 { font-size: 1.8rem; margin-bottom: 25px; }
            .form-group, button, .error, .success, .toggle-link { max-width: 450px; }
            label { font-size: 1rem; }
            input { padding: 10px; font-size: 0.95rem; }
            button { padding: 10px; font-size: 1rem; }
            .error, .success, .toggle-link { font-size: 0.95rem; }
        }

        /* Small screens (mobile, 480px and below) */
        @media (max-width: 480px) {
            .logo { width: 100px; height: 100px; margin-bottom: 20px; }
            h2 { font-size: 1.5rem; margin-bottom: 20px; }
            .form-group, button, .error, .success, .toggle-link { max-width: 90%; }
            label { font-size: 0.9rem; }
            input { padding: 8px; font-size: 0.9rem; }
            button { padding: 8px; font-size: 0.9rem; }
            .error, .success, .toggle-link { font-size: 0.9rem; }
        }
    </style>
</head>
<body>
    <div>
        <img src="<?php echo base_url('images/logo.png'); ?>" alt="OneAtATime Logo" class="logo" onerror="this.style.display='none'; alert('Failed to load logo image. Please check the file path: images/logo.png');">
        <h2>Register</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/register') ?>">
            <div class="form-group">
                <label for="user_name">Username</label>
                <input type="text" id="user_name" name="user_name" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit">Register</button>
        </form>

        <a href="<?= site_url('auth/login') ?>" class="toggle-link">Already have an account? Login</a>
    </div>
</body>
</html>