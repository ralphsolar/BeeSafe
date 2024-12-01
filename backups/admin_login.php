<?php
session_start(); 

$servername = "localhost";
$dbusername = "u475920781_bee_db";
$dbpassword = "bee.4321A";
$dbname = "u475920781_bee_db";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

$loginError = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE BINARY username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();
        if ($password === $stored_password) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id; 
            header("Location: dashboard.php");
            exit;
        } else {
            $loginError = "Invalid password!";
        }
    } else {
        $loginError = "No user found with that username!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS for modal support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body class="hold-transition login-page" style="background-image: url('media/beesafe-background.png'); background-size: cover; background-position: center; padding: 20px; border-radius: 10px;">

<div class="login-box" > 
    
    <div class="card">
        <div class="login-logo">
        <img src="media/BEESAFE-LOGO.png" alt="Logo" style="width: 350px; display: block; margin: 0 auto;">
        <b style="font-size: 20px; font-family: Verdana, Geneva, sans-serif;  display: block; text-align: center;">ADMIN LOG-IN</b>
        </div>
        <div class="card-body login-card-body">
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" style="color:#ff8a1d;">
                        <button type="submit" class="btn btn-primary btn-block" style="background-color: #ff8a1d; border-color: #ff8a1d; color: white;">
                        Log-in
                        </button>
                    </div>
                </div>
            </form>
            <p class="mb-1 mt-3" style="font-size: 13px;">
                Use your credentials to log in to your account.
            </p>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                <h5 class="modal-title" id="errorModalLabel">Login Failed</h5>
                <p><?php echo htmlspecialchars($loginError); ?></p>
                <button type="button" class="btn btn-secondary mt-3" data-dismiss="modal">Try Again</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if ($loginError): ?>
<script>
    $(document).ready(function(){
        $('#errorModal').modal('show');
    });
</script>
<?php endif; ?>

</body>
</html>
