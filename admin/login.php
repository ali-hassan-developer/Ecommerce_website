<?php
session_start();
include '../includes/db.php';

$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if(password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "Incorrect password";
        }
    } else {
        $msg = "Email not found";
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $resetEmail = mysqli_real_escape_string($conn, $_POST['reset_email']);
    $msg = "Password reset link sent to $resetEmail (demo)";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Background animation */
body {
    background: linear-gradient(-45deg,#1e3c72,#2a5298,#1e3c72,#2a5298);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    height:50vh;
    margin:0;
    display:flex;
    justify-content:center;
    align-items:center;
}

@keyframes gradientBG {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}

/* Centered card */
.card-container {
    perspective: 1200px;
    width: 400px;
    max-width: 90%;
}
.card-flip {
    width: 100%;
    transition: transform 1s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* smooth spring-like effect */
    transform-style: preserve-3d;
    position: relative;
}
.card-flip.flip {
    transform: rotateY(180deg);
}
.card {
    width: 100%;
    border-radius: 15px;
    background-color: rgba(255,255,255,0.95);
    box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    padding: 2rem;
    position: absolute;
    backface-visibility: hidden;
    top:0;
    left:0;
}
.card h3 {
    color: #0d6efd;
    font-weight: bold;
    margin-bottom: 1.5rem;
}
.card input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 12px rgba(13,110,253,0.5);
    transition:0.3s;
}
.card .btn-primary {
    transition: all 0.3s ease;
}
.card .btn-primary:hover {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 12px 25px rgba(0,0,0,0.35);
}
.card-back {
    transform: rotateY(180deg);
}

/* Responsive */
@media(max-width:450px){
    .card-container { width: 90%; }
}
</style>
</head>
<body>
<div class="card-container">
    <div class="card-flip" id="cardFlip">
        <!-- Login Card -->
        <div class="card card-front">
            <h3 class="text-center">Admin Login</h3>
            <?php if($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="invalid-feedback">Password is required.</div>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                <p class="text-center mt-3"><a href="#" id="forgotLink">Forgot Password?</a></p>
            </form>
        </div>

        <!-- Forgot Password Card -->
        <div class="card card-back">
            <h3 class="text-center">Reset Password</h3>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <input type="email" name="reset_email" class="form-control" placeholder="Enter your email" required>
                    <div class="invalid-feedback">Email is required.</div>
                </div>
                <button type="submit" name="reset" class="btn btn-primary w-100">Send Reset Link</button>
                <p class="text-center mt-3"><a href="#" id="backLink">Back to Login</a></p>
            </form>
        </div>
    </div>
</div>

<script>
// Flip card
const cardFlip = document.getElementById('cardFlip');
document.getElementById('forgotLink').addEventListener('click', e => {
    e.preventDefault();
    cardFlip.classList.add('flip');
});
document.getElementById('backLink').addEventListener('click', e => {
    e.preventDefault();
    cardFlip.classList.remove('flip');
});

// Bootstrap validation
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
