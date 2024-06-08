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
    <?php
        session_start();
        // 處理越權查看以及錯誤登入
        if (!isset($_SESSION['username'])) {
            echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
            exit();
        } else if ($_SESSION['role'] != "admin") {
            echo "<script>alert('無權訪問'); window.location.href = 'logout.php';</script>";
            exit();
        }
        
        include "db_connection.php";
        $stmt = $db->prepare("SELECT * FROM `product`");
        $stmt->execute();
        
        $html = "<table><tr><th>ID</th><th>商品名稱</th><th>價格</th><th>商品描述</th></tr>";
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= "<tr>";
            $html .= "<td>" . htmlspecialchars($user['PID']) . "</td>";
            $html .= "<td>" . htmlspecialchars($user['product_name']) . "</td>";
            $html .= "<td>" . htmlspecialchars($user['price']) . "</td>";
            $html .= "<td>" . htmlspecialchars($user['product_info']) . "</td>";
            $html .= "<td><form action=\"manageProduct.php\" method=\"post\" onsubmit=\"return confirmDelete();\">". ((($user['role'] === "admin")||($user['role'] === "root")) ? "" : "<input type=\"hidden\" name=\"deleteID\" value=\"".$user['PID']."\"><button type=\"submit\" value=\"ture\" name=\"del\" style=\"background-color: #ff4d4d; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease;\">刪除商品</button></form></td>");
            $html .= "</tr>";
        }
        $html .= "</table>";
    ?>
    <?php
        if (($_SERVER['REQUEST_METHOD'] === "POST")&&(isset($_POST['deleteID']))){
            include "db_connection.php";
            $deleteUserID = $_POST['deleteID'];
            $stmt = $db -> prepare("DELETE FROM `product` WHERE PID = :deleteID");
            $stmt->bindParam(':deleteID', $deleteUserID);
            $stmt->execute();
            header("location: manageProduct.php");
        }
    ?>
    <!--------------------------------- 以上為刪除product ------------------------------------>





    <?php
		include "db_connection.php";

		if ($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['upload']){

			$product_name = $_POST['product_name']?? '';
            $price = $_POST['price']?? '';
            $product_info = $_POST['info']?? '';
                
            if (empty($product_name)) {
				$errors .= "商品名稱不得為空\\n";
			}
			
			if (empty($price)) {
				$errors .= "商品價格不得為空\\n";
			} elseif (!is_numeric($price) || $price <= 0) {
                $errors .= "商品價格必須為正數\\n";
            }
        

			if(empty($errors)){
				$checkProduct = $db->prepare("SELECT COUNT(*) FROM product WHERE product_name = :product_name");
				$checkProduct -> bindParam(':product_name', $product_name);
				$checkProduct -> execute();

				if($checkProduct->fetchColumn() > 0) $errors.= "商品名稱已經被註冊\\n";
			}
			
				try {
					$stmt = $db->prepare("INSERT INTO product (`product_name`, `price`, `product_info`) VALUES (:product_name, :price, :product_info)");
                    $stmt->bindParam(':product_name', $product_name);
                    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
                    $stmt->bindParam(':product_info', $product_info);
					$stmt->execute();
				
					echo "<script>
							alert('商品已成功上架');
							setTimeout(function() {
								window.location.href = 'manageProduct.php';
							}, 0);
						</script>";

				} catch (PDOException $e) {
					echo "資料庫錯誤: " . $e->getMessage();
				}
        }
    
	?>

    <!--------------------------------- 以下為刪除product ------------------------------------>
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

    </style>
</head>
    <!--------------------------------- 以上為刪除product ------------------------------------>

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
                    </i>丹尼斯的貓薄荷</h1>
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
                            <a href="logout.php" class="nav-item nav-link active"><?php echo "登出";?> </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft">管理商品</h1>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <img class="img-fluid" src="var/www/html/dbProject/bootstrap-restaurant-template/img/cannabis_leaves_logo.png.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
        <?php echo $html; ?>

    <!--------------------------------- 以下為上架product ------------------------------------>
        <body>
            <div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
            <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                <form action="manageProduct.php" method="post" autocomplete="off">
                    <div class="row g-3">
                        <h1 class="mb-4">上架新商品</h1>
                        <div class="col-12 col-sm-6">
                            <input type="text" name="product_name" class="form-control border-0" placeholder="商品名稱" style="height: 55px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="text" name="price" class="form-control border-0" placeholder="商品價格" style="height: 55px;">
                        </div>
                        <div class="col-12 w-100 col-sm-6">
                            <input type="text" name="info" class="form-control border-0" placeholder="商品描述/詳細資料" style="height: 55px;">
                        </div>
                        <!-- <div class="col-12">
                        <input type="file" name="image" class="form-control border-0" accept="image/*" style="height: 55px;">                        <div class="col-12 w-100 col-sm-6">                        -->
                            <button class="btn btn-primary w-100 py-3" type="submit" value="true" name="upload">上架商品</button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
            </div>
    <!--------------------------------- 以下為上架product ------------------------------------>


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