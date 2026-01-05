<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
</head>

<body style="background-image: url('https://images.pexels.com/photos/3660204/pexels-photo-3660204.jpeg?cs=srgb&dl=pexels-eric-anada-280222-3660204.jpg&fm=jpg');background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; min-height: 100vh;">
    <form action="config.php" method="post">
        <div class="container">
            <img src="https://images2.thanhnien.vn/zoom/686_429/Uploaded/taban/2019_10_21/matkhau_UKNN.jpg"
                alt="hình ảnh">
            <div class="ui_login">
                <p class="heading">Quên mật khẩu</p>
                <input type="email" name="email" placeholder="Email" class="form-group" required>
                <input type="password" name="new_password" placeholder="Mật khẩu" class="form-group" required>
                <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" class="form-group"
                    required>
                <input type="submit" value="Quên mật khẩu" class="btn" name="forgotPassword">
                <p class="signup-link">Bạn chưa có tài khoản? <a href="signin.php">Đăng ký</a></p>
                <p class="signup-link">Quay lại trang đăng nhập <a href="login.php">Đăng nhập</a></p>

            </div>
        </div>
    </form>
</body>

</html>