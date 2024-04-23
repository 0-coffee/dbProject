<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>丹尼斯的貓薄荷</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>丹尼斯的貓薄荷</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="index.php" class="nav-item nav-link active">主頁</a>
                        <a href="about.php" class="nav-item nav-link">關於</a>
                        <a href="login.php" class="nav-item nav-link">login</a>
                    </div>
                    <a href="product.php" class="btn btn-primary py-2 px-4">開始下單</a>

                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft">享用我們的<br>神奇小植物</h1>
                            <p class="text-white animated slideInLeft mb-4 pb-2">神奇的小G8話</p>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <img class="img-fluid" src="var/www/html/dbProject/bootstrap-restaurant-template/img/cannabis_leaves_logo.png.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
    
    <?php
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === "POST"){
            include "db_connection.php";
            $username = $_POST['username']?? '';
            $password = $_POST['password']?? '';

            $stmt = $db->prepare("SELECT * FROM member WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['ID']; 
                $_SESSION['username'] = $user['username']; 
                $_SESSION['realname'] = $user['realname']; 
                $_SESSION['role'] = $user['role'];

                if($_SESSION['role'] == "admin"){
                    header('Location: manageAccount.php');
                } else {
                    header('Location: myAccount.php'); 
                }
                //login後頁面

                exit;
            } else {
                // 登入失敗以及錯誤訊息
                echo "<script>alert('使用者名稱或密碼錯誤');</script>";
            }
        }
    ?>
</head>

<body>
    <div>
    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
        <form action="login.php" method="post" autocomplete="off">
            <h1 class="mb-4">使用者登入</h1>
            <div class="row g-3">
                <div class="col-12">
                    <input name="username" class="form-control border-0" rows="5" placeholder="請輸入使用者名稱"></input>
                </div>
                <div class="col-12">
                    <input type="password" name="password" class="form-control border-0" rows="5" placeholder="請輸入密碼"></input>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100 py-3" type="submit">登入</button> 
                    <a href="register.php" class="mb-4">沒有帳號號？註冊一個吧</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="forgotPassword.php" class="mb-4">忘記密碼？召回你的密碼吧</a>
                </div>
            </div>
        </form>
        </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-1">
                    <div class="col-lg-3">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>