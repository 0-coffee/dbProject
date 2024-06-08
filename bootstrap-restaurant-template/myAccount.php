<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
?>

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
                    <h1 class="text-primary m-0"><picture>
                    <source srcset="https://fonts.gstatic.com/s/e/notoemoji/latest/1f4b8/512.webp" type="image/webp">
                    <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f4b8/512.gif" alt="💸" width="32" height="32">
                    </picture>
                    丹尼斯的貓薄荷</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                    <?php
                        if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                            echo '<a href="manageProduct.php" class="nav-item nav-link">管理商品</a>';
                            echo '<a href="manageAccount.php" class="nav-item nav-link">管理帳號</a>';
                            echo '<a href="manageOrder.php" class="nav-item nav-link">管理訂單</a>';
                        }
                    ?>
                        <div class="navbar-nav ms-auto p-4 p-lg-0">
                            <a href="myAccount.php" class="nav-item nav-link active"><?php echo "歡迎，". $_SESSION['username'];?></a>
                            <?php
                            if(isset($_SESSION['role']) && $_SESSION['role'] == "user") {
                            echo '<a href="cart.php" class="nav-item nav-link">購物車</a>';
                        }
                            ?>
                            <a href="logout.php" class="nav-item nav-link active"><?php echo "登出";?> </a>
                        </div>
                    </div>
                    <?php
                        // 检查用户角色并生成相应的链接
                        if(isset($_SESSION['role']) && $_SESSION['role'] == "user") {
                            echo '<a href="product.php" class="btn btn-primary py-2 px-4">開始下單</a>';
                        }
                    ?>

                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft">個人資料</h1>
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
    

    if (!isset($_SESSION['username'])) {
        echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
        exit(); 
    }

    include "db_connection.php";
    
    try {
        $stmt = $db->prepare("SELECT * FROM member WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $role = $user['role'];
            $realname = $user['realname'];
            $email = $user['email'];
            $tel = $user['tel'];
            $username = $user['username'];

        } else {
            //echo "No user found with that username.";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    ?>
    <?php
    if (($_SERVER['REQUEST_METHOD'] === "POST")&&(isset($_POST['update']))){ //update stands for the field name
        include "db_connection.php";
        $fieldToUpdate = $_POST['update'];
        $updateValue = $_POST[$fieldToUpdate]?? '';
        // echo "<script>alert('".$fieldToUpdate.$updateValue."');</script>";

        if ($fieldToUpdate === 'password') { //處理更改密碼需要加密的部分
            if (($_POST['password'] === $_POST['confirmPassword']) && (strlen($_POST['password']) >= 4 && strlen($_POST['password']) <= 50)) {
                $updateValue = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } else {
                echo "<script>alert('密碼與確認密碼不相同或是密碼長度低於4個字元或高於50個字元'); window.history.back();</script>";
                exit();
            }
        }

        try { //更新資料庫
            $stmt = $db->prepare("UPDATE member SET `$fieldToUpdate` = :updateValue WHERE id = :id");
            $stmt->bindParam(':updateValue', $updateValue);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                echo "<script>alert('更新成功'); window.location.href = 'myAccount.php';</script>";
                if($fieldToUpdate == "realname") $_SESSION['realname'] = $updateValue; 
            } else {
                echo "<script>alert('無變更導致的未更新'); window.history.back();</script>";
            }
        } catch (PDOException $e) {
            die("Database error during update: " . $e->getMessage());
        }
    }

    ?>
</head>

<div class="bg-light rounded h-100 d-flex align-items-center p-5">
        <table>
            <tr>
                <th>身分組</th>
                <td><input type="text" class="form-control border-0" value="<?php echo $role;?>" readonly></td>
                <td></td>
            </tr>
            <tr>
                <form action="myAccount.php" method="post" autocomplete="off">
                    <th>使用者姓名</th>
                    <td><input type="text" name="realname" class="form-control border-0" value="<?php echo $realname;?>" ></td>
                    <td><button type="submit" name="update" value="realname">更改姓名</button></td>
                </form>
            </tr>
            <tr>
                <form action="myAccount.php" method="post" autocomplete="off">
                    <th>Email</th>
                    <td><input type="email" name="email"  class="form-control border-0" value="<?php echo $email;?>" ></td>
                    <td><button type="submit" name="update" value="email">更改Email</button></td>
                </form>
            </tr>
            <tr>
                <form action="myAccount.php" method="post" autocomplete="off">
                    <th>手機號碼</th>
                    <td><input type="tel" name="tel" class="form-control border-0" value="<?php echo $tel;?>" ></td>
                    <td><button type="submit" name="update" value="tel">更改手機號碼</button></td>
                </form>
            </tr>
            <tr>
                <form action="myAccount.php" method="post" autocomplete="off">
                    <th>使用者名稱</th>
                    <td><input type="text" name="username" class="form-control border-0" value="<?php echo $username;?>" ></td>
                    <td><button type="submit" name="update" value="username">更改</button></td>
                </form>
            </tr>
            <form action="myAccount.php" method="post" autocomplete="off">
            <tr>
                <th>密碼</th>
                <td><input type="password" name="password" class="form-control border-0"></td>
                <td rowspan="2" ><button type="submit" name="update" value="password">更改</button></td>
            </tr>
            <tr>
                <th>再次確認密碼</th>
                <td><input type="password" name="confirmPassword" class="form-control border-0"></td>
            </tr>
            </form>
        </table>
    </div>


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