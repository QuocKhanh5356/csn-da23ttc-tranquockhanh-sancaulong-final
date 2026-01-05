<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time() ?>">
</head>

<body style="background-image: url('https://images.pexels.com/photos/3660204/pexels-photo-3660204.jpeg?cs=srgb&dl=pexels-eric-anada-280222-3660204.jpg&fm=jpg');background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; min-height: 100vh;">
    <form action="config.php" method="post">
        <div class="container">
            <img src="https://hvshop.vn/wp-content/uploads/2024/09/tuyen-thu-cau-long-viet-nam.webp"
                alt="hình ảnh">
            <div class="ui_login">
                <p class="heading">Đăng nhập</p>
                <input type="email" name="email" placeholder="Email" class="form-group" required>
                <input type="password" name="password" placeholder="Mật khẩu" class="form-group" required>
                <input type="submit" value="Đăng nhập" class="btn" name="login">
                <p class="signup-link">Bạn chưa có tài khoản? <a href="signin.php">Đăng ký</a></p>
                <p class="signup-link"><a href="forgotPassword.php">Quên mật khẩu? </a></p>
            </div>
        </div>
    </form>
</body>

</html>