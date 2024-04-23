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
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
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

		if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

		include "db_connection.php";

		if ($_SERVER['REQUEST_METHOD'] === "POST"){

			if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) { //檢查cfrs令牌
				die("CSRF token validation failed");
			}

			$realname = $_POST['realname']?? '';
            $email = $_POST['email'] ?? '';
            $tel = $_POST['tel']?? '';
            $username = $_POST['username']?? '';
			$password = $_POST['password'] ?? '';
			$confirmPassword = $_POST['confirmPassword'] ?? '';
			
			$errors = '';
            if (empty($realname)) {
				$errors .= "使用者姓名不得為空\\n";
			} else if (strlen($realname) < 2 || strlen($realname) > 20) {
				$errors .= "使用者姓名的長度必須至少2個字元且少於20個字元\\n";
			}
			
			if (empty($email)) {
				$errors .= "電子郵箱不得為空\\n";
			} else if (strlen($email) < 4 || strlen($email) > 50) {
				$errors .= "電子郵箱的長度必須至少4個字元且少於50個字元\\n";
			}

            if (empty($tel)) {
				$errors .= "手機號碼不得為空\\n";
			} else if (strlen($tel) != 10) {
				$errors .= "手機號碼的長度必須等於10個字元\\n";
			}

            if (empty($username)) {
				$errors .= "使用者名稱不得為空\\n";
			} else if (strlen($username) < 4 || strlen($username) > 20) {
				$errors .= "使用者ID的長度必須至少4個字元且少於20個字元\\n";
			}
			
			if (empty($password)) {
				$errors .= "你的密碼不得為空\\n";
			} else if (strlen($password) < 4 || strlen($password) > 50) {
				$errors .= "密碼的長度必須至少4個字元且少於50個字元\\n";
			}
			
			if (empty($confirmPassword)) {
				$errors .= "再次輸入密碼不得為空\\n";
			} else if ($password != $confirmPassword) {
				$errors .= "你的密碼與再次確認密碼不同，請確保他們是相同的\\n";
			} else if (strlen($confirmPassword) < 4 || strlen($confirmPassword) > 50) {
				$errors .= "確認密碼的長度必須至少4個字元且少於50個字元\\n";
			}

			if(empty($errors)){
				$checkUser = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
				$checkUser -> bindParam(':username', $username);
				$checkUser -> execute();

				if($checkUser->fetchColumn() > 0) $errors.= "使用者名稱已經被註冊\\n";

				$checkEmail = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
				$checkEmail -> bindParam(':email', $email);
				$checkEmail -> execute();

				if($checkEmail->fetchColumn() > 0) $errors.= "電子郵箱已經被註冊\\n";
			}
			
			if (!empty($errors)) echo "<script>alert('$errors');</script>";
			else {
				if (!empty($password)&&(strlen($password)>=4)&&(strlen($password)<=50)) {
					$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				}

				try {
					$stmt = $db->prepare("INSERT INTO users (role, realname, email, tel, username, password) VALUES (:role, :realname, :email, :tel, :username, :password)");
					$role = 'user';
					$stmt->bindParam(':role', $role);
                    $stmt->bindParam(':realname', $realname);
                    $stmt->bindParam(':email', $email);
					$stmt->bindParam(':tel', $tel);
                    $stmt->bindParam(':username', $username);
					$stmt->bindParam(':password', $hashedPassword);
					$stmt->execute();
				
					echo "<script>
							alert('使用者註冊成功');
							setTimeout(function() {
								window.location.href = 'login.php';
							}, 0);
						</script>";

				} catch (PDOException $e) {
					echo "資料庫錯誤: " . $e->getMessage();
				}
			}
		}
	?>
</head>

<body>
    <div>
    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
        <form action="register.php" method="post" autocomplete="off">
            <div class="row g-3">
                <h1 class="mb-4">註冊新帳號</h1>
                <div class="col-12 col-sm-6">
                    <input type="text" name="realname" class="form-control border-0" placeholder="你的姓名" style="height: 55px;">
                </div>
                <div class="col-12 col-sm-6">
                    <input type="email" name="email" class="form-control border-0" placeholder="你的 Email" style="height: 55px;">
                </div>
                <div class="col-12 col-sm-6">
                    <input type="text" name="tel" class="form-control border-0" placeholder="你的手機" style="height: 55px;">
                </div>
                <div class="col-12 col-sm-6">
                    <input type="text" name="username" class="form-control border-0" placeholder="使用者名稱" style="height: 55px;">
                </div>
                <div class="col-12 col-sm-6">
                    <input type="password" name="password" class="form-control border-0" placeholder="請輸入密碼" style="height: 55px;">
                </div>
                <div class="col-12 col-sm-6">
                    <input type="password" name="confirmPassword" class="form-control border-0" placeholder="再次確認密碼" style="height: 55px;">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100 py-3" type="submit">註冊帳號</button>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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