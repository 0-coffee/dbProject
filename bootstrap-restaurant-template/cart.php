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
    <style>
        table {
            width: 100%;        /* 表格寬度佔滿父元素 */
            border-collapse: collapse; /* 邊框合併為單一邊框 */
            margin: 20px 0;     /* 上下邊距為 20px，左右為 0 */
            font-family: Arial, sans-serif; /* 使用 Arial 或無襯線字體 */
            color: #333;        /* 字體顏色 */
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); /* 輕微陰影效果 */
            background-color: #ffffff; /* 白色背景 */
        }

        /* 表格標頭 */
        th {
            background-color: #f2f2f2; /* 標頭背景顏色 */
            color: #333;        /* 標頭文字顏色 */
            font-weight: bold;  /* 粗體文字 */
            padding: 12px 15px; /* 內距 */
            text-align: left;   /* 文字對齊 */
        }

        /* 表格行與單元格 */
        tr {
            border-bottom: 1px solid #ddd; /* 行底部邊框 */
        }

        td {
            padding: 12px 15px; /* 單元格內距 */
            text-align: left;   /* 文字對齊 */
        }

        /* 滑過行變色效果 */
        tr:hover {
            background-color: #f5f5f5; /* 滑過時的背景顏色 */
        }

        /* 按鈕樣式 */
        button {
            background-color: #007bff; /* 按鈕背景色 */
            color: white; /* 按鈕文字顏色 */
            padding: 6px 12px; /* 內邊距 */
            border: none; /* 無邊框 */
            border-radius: 4px; /* 圓角邊框 */
            cursor: pointer; /* 鼠標樣式 */
            transition: background-color 0.3s; /* 過渡效果 */
        }

        /* 鼠標懸停在按鈕上時的效果 */
        button:hover {
            background-color: #0056b3; /* 按鈕深藍色 */
        }
    </style>
    <?php
        session_start();
        if (!isset($_SESSION['username'])) {
            echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
            exit(); 
        }

        include "db_connection.php";

        // 获取购物车内容
        $sql = "SELECT * FROM product t1
                JOIN cart t2 ON t1.PID = t2.PID
                WHERE t2.ID = :ID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':ID', $_SESSION['user_id']);
        $stmt->execute();

        // 移除购物车项目
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['removeFromCart'])) {
            $checkCartExists = $db->prepare("SELECT COUNT(*) FROM cart WHERE PID = :PID AND ID = :ID");
            $checkCartExists->bindParam(':PID', $_POST['removeFromCartPID']);
            $checkCartExists->bindParam(':ID', $_SESSION['user_id']);
            $checkCartExists->execute();

            if ($checkCartExists->fetchColumn() > 0) {
                $stmt = $db->prepare("DELETE FROM cart WHERE ID = :ID AND PID = :PID");
                $stmt->bindParam(':ID', $_SESSION['user_id']);
                $stmt->bindParam(':PID', $_POST['removeFromCartPID']);
                $stmt->execute();
                echo "<script>alert('已從購物車中移除該項目');</script>";
                echo '<script>window.location.href="cart.php";</script>';
            } else {
                echo "<script>alert('未找到可刪除的內容');</script>";
                echo '<script>window.location.href="cart.php";</script>';
            }
        }

        // 处理结账
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['checkout'])) {
            $paymentAmount = 0;
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cartItems as $item) {
                $paymentAmount += $item['price'];
            }

            $lastIdStmt = $db->prepare("SELECT orderID FROM checkout ORDER BY orderID DESC LIMIT 1");
            $lastIdStmt->execute();
            $lastId = $lastIdStmt->fetchColumn();

            $newId = $lastId + 1;
            $insertStmt = $db->prepare("INSERT INTO checkout (orderID, price) VALUES (:orderID, :price)");
            $insertStmt->bindParam(':orderID', $newId);
            $insertStmt->bindParam(':price', $paymentAmount);
            $insertStmt->execute();

            echo '<script>window.location.href="checkout.php";</script>';
        }
    ?>
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
                    <h1 class="text-primary m-0">
                        <picture>
                            <source srcset="https://fonts.gstatic.com/s/e/notoemoji/latest/1f4b8/512.webp" type="image/webp">
                            <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f4b8/512.gif" alt="💸" width="32" height="32">
                        </picture>
                        丹尼斯的貓薄荷
                    </h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <?php
                            // 检查用户角色并生成相应的链接
                            if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                                echo '<a href="manageProduct.php" class="nav-item nav-link">管理商品</a>';
                                echo '<a href="manageAccount.php" class="nav-item nav-link">管理帳號</a>';
                            }
                        ?>
                        <div class="navbar-nav ms-auto p-4 p-lg-0">
                            <a href="myAccount.php" class="nav-item nav-link active"><?php echo "歡迎，". $_SESSION['username']; ?></a>
                            <a href="cart.php" class="nav-item nav-link active">購物車</a>
                            <a href="logout.php" class="nav-item nav-link active">登出</a>
                        </div>
                    </div>
                    <?php
                        // 检查用户角色并生成相应的链接
                        if (isset($_SESSION['role']) && $_SESSION['role'] == "user") {
                            echo '<a href="product.php" class="btn btn-primary py-2 px-4">開始下單</a>';
                        }
                    ?>
                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark mb-5">
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

        <!-- Cart Content Start -->
        <div class="bg-light rounded h-100 d-flex align-items-center p-5">
            <div class="container_list">
                <h3>我的購物車</h3>
                <table class="product-list">
                    <tr><th>名稱</th><th>價格</th><th></th></tr>
                    <?php   
                        $paymentAmount = 0;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td><a href='product.php?pid=".$row['PID']."' class='product-link'><span class='name'>" . htmlspecialchars($row['product_name']) . "</span></a></td>";
                            echo "<td><span class='price'>$" . number_format($row['price'], 2) . "</span></td>";
                            $paymentAmount += $row['price'];
                            echo "<td><form action='cart.php' method='post'><input name='removeFromCartPID' value='".$row['PID']."' type='hidden'><button type='submit' name='removeFromCart' value='true' class='remove-from-cart'>從我的購物車移除</button></form></td>";
                            echo "</tr>";
                        }
                        echo "<tr><td colspan='4' class='total-line'>總金額: $" . number_format($paymentAmount, 2) . "</td></tr>";
                    ?>
                </table>
                <form action="cart.php" method="post">
                    <?php 
                        if ($stmt->rowCount() >= 1) {
                            echo "<button type='submit' name='checkout' class='checkout-button'>前往結帳</button>";
                        }
                    ?>
                </form>
            </div>
        </div>
        <!-- Cart Content End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-1">
                    <div class="col-lg-3">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                        <?php
                            function generateRandomString($length = 10) {
                                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                $randomString = '';
                                for ($i = 0; $i < $length; $i++) {
                                    $randomString .= $characters[rand(0, strlen($characters) - 1)];
                                }
                                return $randomString;
                            }
                        ?>

                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><?php echo generateRandomString(10); ?></p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><?php echo generateRandomString(10); ?></p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i><?php echo generateRandomString(10); ?>@<?php echo generateRandomString(5); ?>.com</p>
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
    </div>
</body>
</html>
