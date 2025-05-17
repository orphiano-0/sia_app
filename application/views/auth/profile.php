<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Profile Widget</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 30px 20px;
      font-family: 'Segoe UI', sans-serif;
      background: #f2f9f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      width: 100%;
      max-width: 400px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    .header {
      text-align: center;
      background-color: #4a704a;
      color: white;
      padding: 10px 16px;
      border-radius: 12px;
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .header img {
      vertical-align: middle;
      margin-right: 8px;
    }

    .profile-info {
      background-color: #f6f6f6;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 16px;
      margin-bottom: 20px;
    }

    .profile-info h4 {
      margin: 0;
      color: #4a704a;
      font-size: 14px;
    }

    .profile-info p {
      margin: 4px 0 12px;
      font-size: 14px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-size: 13px;
      margin-bottom: 4px;
      font-weight: 600;
    }

    input {
      width: 100%;
      padding: 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #fafafa;
    }

    input:focus {
      outline: none;
      border-color: #4a704a;
      background: #fff;
    }

    button {
      width: 100%;
      padding: 10px;
      border: none;
      font-weight: bold;
      font-size: 14px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
    }

    #save-btn {
      background-color: #e0f0e0;
      color: #2f502f;
    }

    #save-btn:hover {
      background-color: #cce5cc;
    }

    #logout-btn {
      background-color: #4a704a;
      color: white;
      margin-top: 12px;
    }

    #logout-btn:hover {
      background-color: #3a5a3a;
    }

    .notification {
      display: none;
      text-align: center;
      padding: 8px 16px;
      background-color: #4a704a;
      color: white;
      border-radius: 8px;
      margin-bottom: 12px;
      font-size: 13px;
      animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @media (max-width: 420px) {
      .card {
        padding: 16px;
      }

      .profile-info p,
      input,
      button,
      label {
        font-size: 13px;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="notification" id="notification">Changes saved successfully!</div>

    <div class="header">
      <img src="<?php echo base_url('images/profile-user.png'); ?>" alt="User Icon" width="30" height="30" />
      <?= $user->user_name ?>
    </div>

    <div class="profile-info">
      <h4>Username</h4>
      <p><?= $user->user_name ?></p>

      <h4>Bio</h4>
      <p><?= $user->bio ?></p>
    </div>

    <form method="post" action="<?= site_url('auth/profile') ?>" onsubmit="return showNotification();">
      <div class="form-group">
        <label for="user_name">New Username</label>
        <input type="text" id="user_name" name="user_name" />
      </div>

      <div class="form-group">
        <label for="bio">New Bio</label>
        <input type="text" id="bio" name="bio" />
      </div>

      <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" />
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" />
      </div>

      <button type="submit" id="save-btn">Save</button>
    </form>

    <a href="<?= site_url('auth/logout') ?>">
      <button type="button" id="logout-btn">Logout</button>
    </a>
  </div>

  <script>
    function showNotification() {
      const note = document.getElementById("notification");
      note.style.display = "block";
      setTimeout(() => note.style.display = "none", 2500);
      return true;
    }
  </script>
</body>
</html>
