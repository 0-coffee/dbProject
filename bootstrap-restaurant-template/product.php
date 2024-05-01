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
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>丹尼斯的貓薄荷</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                    <?php
                        // 检查用户角色并生成相应的链接
                        if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                            echo '<a href="manageProduct.php" class="nav-item nav-link">管理商品</a>';
                            echo '<a href="manageAccount.php" class="nav-item nav-link">管理帳號</a>';
                        }
                    ?>
                        <div class="navbar-nav ms-auto p-4 p-lg-0">
                            <a href="myAccount.php" class="nav-item nav-link active"><?php echo "歡迎，". $_SESSION['username'];?></a>
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

    <style>
       /* 基本重置和字體設置 */
        h1, h2, h3, p {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
        }

        /* 主容器設計，包含背景和陰影 */
        .container_list {
            width: 90%;
            margin: 20px auto;
            background-color: #f4f8ff; /* 淺藍色背景 */
            padding: 20px;
            border-radius: 8px; /* 圓角邊框 */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); /* 輕微的陰影 */
        }

        /* 排序條樣式 */
        .sort-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sort-bar select, .sort-bar input[type="text"], .sort-bar input[type="submit"] {
            padding: 10px 15px;
            margin-right: 10px;
            border: 1px solid #d1e3ff; /* 淺藍色邊框 */
            border-radius: 6px; /* 圓角邊框 */
            background-color: #ffffff; /* 白色背景 */
        }

        .sort-bar input[type="submit"] {
            cursor: pointer;
            background-color: #007bff; /* 較深的藍色背景 */
            color: white;
            border: none;
        }

        h3 {
            font-size: 1.5rem;
            color: #0056b3; /* 淺藍色文字 */
            margin-bottom: 20px;
        }

        /* 產品列表樣式 */
        .product-list {
            list-style: none;
            padding: 0;
        }

        .product-list .product {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e2e5ec; /* 更淺的藍色分隔線 */
            padding: 10px 0;
        }

        .product-list .product img {
            width: 100px; /* 保持圖片為方形 */
            height: 100px;
            object-fit: cover; /* 保證圖片充滿容器 */
            margin-right: 20px;
            border-radius: 5px; /* 圓角 */
        }

        .product-list .product-info {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-list .product-info .name,
        .product-list .product-info .price,
        .product-list .product-info .upload-date {
            margin: 0 10px;
        }

        /* 分頁樣式 */
        .pagination {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            display: block;
            padding: 8px 12px;
            background-color: #d1e3ff;
            color: #0056b3;
            border-radius: 4px;
            text-decoration: none;
        }

        .pagination .page-link:hover {
            background-color: #b9d1f8;
        }
        .add-to-cart {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background: linear-gradient(145deg, #006bff, #0056b3);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
        }

        .add-to-cart:hover {
            background: linear-gradient(145deg, #0056b3, #0041a8);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.24);
        }

        .add-to-cart:active {
            background: #0041a8;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12);
        }

        table {
            width: 100%; /* 表格寬度占滿容器 */
            border-collapse: collapse; /* 邊框合併 */
            background-color: #f0f8ff; /* 淺藍色背景 */
            font-family: Arial, sans-serif; /* 使用Arial或無襯線字體 */
        }

        /* 表頭樣式 */
        th {
            background-color: #e0efff; /* 表頭使用略深的藍色 */
            color: #333; /* 文字顏色為深灰 */
            padding: 10px; /* 內邊距 */
            font-size: 16px; /* 字體大小 */
            border-bottom: 2px solid #ccc; /* 底部有灰色邊框 */
        }

        /* 表格行樣式 */
        td {
            text-align: center; /* 文字居中顯示 */
            padding: 8px; /* 內邊距 */
            font-size: 14px; /* 字體大小 */
        }

        /* 表格行條紋效果 */
        tr:nth-child(odd) {
            background-color: #e6f1ff; /* 淺藍色條紋 */
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

        /* 產品圖片樣式 */
        img {
            width: 100px; /* 圖片寬度 */
            height: auto; /* 高度自動 */
        }

    </style>
    <?php
        if (!isset($_SESSION['username'])) {
            echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
            exit(); 
        }
    
        include "db_connection.php";

        
        $recordsPerPage = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $recordsPerPage;

        
        $sortTime = $_GET['sort-time'] ?? 'newest';
        $sortPrice = $_GET['sort-price'] ?? 'highest';
        $sortCategory = $_GET['sort-category'] ?? '';
        $searchTerm = $_GET['search'] ?? '';

        
        $sql = "SELECT * FROM product WHERE 1=1";

        
        if (!empty($searchTerm)) {
            $sql .= " AND product_name LIKE :searchTerm";
        }

        
        if (!empty($sortCategory)) {
            $sql .= " AND type = :sortCategory";
        }

        
        $orderClause = [];
        if ($sortTime == 'newest') {
            $orderClause[] = "uploadDate DESC";
        } elseif ($sortTime == 'oldest') {
            $orderClause[] = "uploadDate ASC";
        }
        if ($sortPrice == 'highest') {
            $orderClause[] = "price DESC";
        } elseif ($sortPrice == 'lowest') {
            $orderClause[] = "price ASC";
        }
        if (!empty($orderClause)) {
            $sql .= " ORDER BY " . implode(', ', $orderClause);
        }

        
        $sql .= " LIMIT :offset, :recordsPerPage";

        $stmt = $db->prepare($sql);
        if (!empty($searchTerm)) {
            $searchTerm = "%" . $searchTerm . "%";
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        }
        if (!empty($sortCategory)) {
            $stmt->bindParam(':sortCategory', $sortCategory, PDO::PARAM_STR);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
        $stmt->execute();

      
        $countSql = "SELECT COUNT(*) FROM product WHERE 1=1";
        
        $countStmt = $db->prepare($countSql);
 
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();
        $numPages = ceil($totalRecords / $recordsPerPage);
    ?>
    <?php
        if (($_SERVER['REQUEST_METHOD'] === "POST")&&($_POST['addToCart'])){
            $checkCartExists = $db->prepare("SELECT COUNT(*) FROM cart WHERE PID = :PID AND ID = :ID");
            $checkCartExists -> bindParam(':PID', $_POST['addToCartPID']);
            $checkCartExists -> bindParam(':ID', $_SESSION['ID']);
            $checkCartExists -> execute();
            if($checkCartExists->fetchColumn() > 0) {
                ob_end_flush();
                echo "<script>alert('該物品先前已加入我的購物車');</script>";
                echo '<script>window.location.href="product.php";</script>';
            } else {
                $stmt = $db->prepare("INSERT INTO `cart`(`ID`, `PID`) VALUES (:userID, :PID)");
                $stmt -> bindParam(':userID', $_SESSION['ID']);
                $stmt -> bindParam(':PID', $_POST['addToCartPID']);
                $stmt->execute();
                ob_end_flush();
                echo "<script>alert('已加入我的購物車');</script>";
                echo '<script>window.location.href="product.php";</script>';
            }
        }
    ?>
</head>

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