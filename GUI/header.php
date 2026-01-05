<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css?v = <?php echo time(); ?>">
</head>

<body>
    <div class="contranner">
        <div class="logo-wrap">
            <a href="dashboard.php?pg=home" aria-label="Trang chủ">
                <img class="site-logo" src="./img/logomoi.png" alt="Badminton AYA logo">
            </a>
        </div>
        <div class="wrapper">
            <ul class="menu">
                <li><a href="dashboard.php?pg=home">Trang chủ</a></li>
                <li><a href="dashboard.php?pg=pitchSearch">Tìm kiếm sân cầu lông</a></li>
                <li><a href="dashboard.php?pg=userEdit">Sửa thông tin cá nhân</a></li>
                <li><a href="dashboard.php?pg=summary">Lịch sử đặt sân</a></li>
                <li class="user-pill"><a href="dashboard.php?pg=logout">Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</body>

</html>