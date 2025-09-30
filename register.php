<?php
include 'includes/db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role  = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $pass, $role);

    if ($stmt->execute()) {
        $msg = "<div class='alert alert-success text-center'>✅ Registration successful. <a href='login.php' class='alert-link'>Login</a></div>";
    } else {
        $msg = "<div class='alert alert-danger text-center'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
            animation: fadeInUp 1s ease;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            border-color: #667eea;
            box-shadow: 0 0 6px rgba(102, 126, 234, 0.5);
        }

        .btn-custom {
            background: #667eea;
            border: none;
            border-radius: 10px;
            font-weight: 500;
            transition: 0.3s;
            padding: 12px;
        }

        .btn-custom:hover {
            background: #764ba2;
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
            color: #764ba2;
        }
    </style>
</head>

<body>
    <div class="card" style="width:420px;">
        <h2 class="text-center mb-4">Create Account</h2>
        <?= $msg ?>
        <form method="POST">
            <div class="mb-3">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter a strong password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Register as</label>
                <select name="role" class="form-select" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom w-100 text-white">Register</button>
        </form>
        <p class="text-center">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>

</html>