
<?php
session_start();

require_once('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM admin WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location:../dashboard/admin_dashboard.php");
            exit();
        } else {
            echo "Incorrect Username or Password";
        }
    } else {
        echo "All fields should be filled.";
    }
}
?>

<!doctype html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      
    <?php include_once'../includes/title.php';?>
      <!-- Favicon -->
      <link rel="stylesheet" href="../assets/css/libs.min.css">
      <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">  </head>
  <body class="" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body"></div>
      </div>    </div>
    <!-- loader END -->
      <div style="background-image: url('../assets/images/auth/01.png')" >  
        <div class="wrapper">
<section class="vh-100 bg-image">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="auth-form">
                                <h2 class="text-center mb-4">Sign In</h2>
                                <form action="" method="POST">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="username" class="form-control" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Username</label>
                                    </div>
                                     <div class="form-floating mb-2">
                                        <input type="password" name="password" class="form-control" id="Password" placeholder="Password">
                                        <label for="Password">Password</label>
                                    </div>
                                    <div class="d-flex justify-content-between  align-items-center flex-wrap">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"  id="Remember">
                                                <label class="form-check-label" for="Remember">Remember me?</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <a href="#page-forgot-password.html">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                    </div>
                                    <div class="text-center mt-3">
                                        <p>or sign in with others account?</p>
                                    </div>
                                     <div class="d-flex justify-content-center ">
                                        <ul class="list-group list-group-horizontal   list-group-flush">
                                            <li class="list-group-item bg-transparent border-0">
                                            <a href="#"><img src="../assets/images/brands/01.png" class="img-fluid avatar avatar-30 avatar-rounded" alt="img60"></a>
                                            </li>
                                            <li class="list-group-item bg-transparent border-0">
                                            <a href="#"><img src="../assets/images/brands/02.png" class="img-fluid avatar avatar-30 avatar-rounded" alt="gm"></a>
                                            </li>
                                            <li class="list-group-item bg-transparent border-0">
                                            <a href="#"><img src="../assets/images/brands/03.png" class="img-fluid avatar avatar-30 avatar-rounded" alt="im"></a>
                                            </li>
                                            <li class="list-group-item bg-transparent border-0">
                                            <a href="#"><img src="../assets/images/brands/04.png" class="img-fluid avatar avatar-30 avatar-rounded" alt="li"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </form>
                                <div class="new-account mt-3 text-center">
                                    <p>Don't have an account? <a class="" href="../dashboard/auth/sign-up.html">Click
                                            here to sign up</a></p>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        </div>
      </div>
      
    
    <!-- Backend Bundle JavaScript -->
    <script src="../assets/js/libs.min.js"></script>
    <!-- widgetchart JavaScript -->
    <script src="../assets/js/charts/widgetcharts.js"></script>
    <!-- fslightbox JavaScript -->
    <script src="../assets/js/fslightbox.js"></script>
    <!-- app JavaScript -->
    <script src="../assets/js/app.js"></script>
    <!-- apexchart JavaScript -->
    <script src="../assets/js/charts/apexcharts.js"></script>
  </body>
</html>