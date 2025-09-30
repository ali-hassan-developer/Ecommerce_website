<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #43cea2, #185a9d);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }
    .card {
      width: 420px;
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      background: #fff;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      animation: fadeIn 1s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .profile-pic {
      width: 100px;
      height: 100px;
      background: linear-gradient(135deg, #43cea2, #185a9d);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 40px;
      font-weight: bold;
      margin: 0 auto 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      animation: popIn 0.8s ease;
    }
    @keyframes popIn {
      from { transform: scale(0.5); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
    h2 {
      font-weight: 600;
      margin-bottom: 5px;
    }
    p.role {
      font-size: 14px;
      color: #666;
      margin-bottom: 20px;
    }
    .btn-custom {
      background: #185a9d;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 500;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: #43cea2;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="profile-pic">
      <?= strtoupper(substr($_SESSION['name'], 0, 1)); ?>
    </div>
    <h2>Welcome, <?= $_SESSION['name']; ?> 👋</h2>
    <p class="role">You are logged in as <b><?= ucfirst($_SESSION['role']); ?></b></p>
    <a href="logout.php" class="btn btn-custom">Logout</a>
  </div>
</body>
</html>
