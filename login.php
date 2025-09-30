<?php
session_start();
include 'includes/db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['name']    = $user['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "<div class='alert alert-danger text-center'>❌ Invalid Password</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger text-center'>❌ No user found with this email</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
      animation: zoomIn 0.9s ease;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      padding: 30px;
    }
    @keyframes zoomIn {
      from { opacity: 0; transform: scale(0.8); }
      to { opacity: 1; transform: scale(1); }
    }
    h2 {
      font-weight: 600;
      color: #333;
    }
    label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #444;
    }
    .form-control {
      border-radius: 10px;
      padding: 12px;
      transition: all 0.3s;
    }
    .form-control:focus {
      border-color: #ff4b5c;
      box-shadow: 0 0 6px rgba(255,75,92,0.5);
    }
    .btn-custom {
      background: #764ba2;
      border: none;
      border-radius: 10px;
      font-weight: 500;
      transition: 0.3s;
      padding: 12px;
    }
    .btn-custom:hover {
      background: #667eea;
      transform: translateY(-2px);
    }
    .card p {
      margin-top: 15px;
      color: #555;
    }
    .card a {
      text-decoration: none;
      color: #667eea;
      font-weight: 500;
    }
    .card a:hover {
      text-decoration: underline;
      color: #ff2e63;
    }
  </style>
</head>
<body>
  <div class="card" style="width:420px;">
    <h2 class="text-center mb-4">Login</h2>
    <?= $msg ?>
    <form method="POST">
      <div class="mb-3">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com" required>
      </div>
      <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="btn btn-custom w-100 text-white">Login</button>
    </form>
    <p class="text-center">Don’t have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>
