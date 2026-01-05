<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-footer {
            background: linear-gradient(135deg, #007bff 0%, #00bcd4 100%);
            color: white;
            padding: 60px 20px 40px;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 15px 15px;
        }

        .main-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            opacity: 0.1;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
        }

        .footer-column h3 {
            font-size: 1.5em;
            font-weight: 700;
            margin-bottom: 20px;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-column h3::before {
            content: '';
            width: 30px;
            height: 3px;
            background: #ffffff;
            border-radius: 2px;
        }

        .footer-column p, .footer-column h4, .footer-column a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            margin: 0 0 10px 0;
            line-height: 1.6;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .footer-column h4 {
            font-size: 0.9em;
            font-weight: 500;
        }

        .footer-column p {
            font-size: 1em;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .alobo-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .alobo-logo img {
            height: 60px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .contact-button {
            background: none;
            border: none;
            color: #007bff;
            padding: 0;
            border-radius: 0;
            font-weight: bold;
            text-align: left;
            transition: color 0.3s ease;
            cursor: pointer;
            align-self: flex-start;
            box-shadow: none;
            text-decoration: underline;
        }

        .contact-button:hover {
            color: #0056b3;
            text-decoration: none;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.5em;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-icons a:hover {
            color: #ffffff;
            transform: scale(1.2);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.9em;
            color: rgba(255, 255, 255, 0.7);
        }

        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .footer-column {
                align-items: center;
                text-align: center;
            }
            .alobo-logo {
                align-items: center;
            }
            .contact-button {
                align-self: center;
            }
            .footer-column h3::before {
                display: none;
            }
        }
    </style>
</head>

<body>
    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3><i class="fas fa-volleyball-ball"></i> Badminton AYA</h3>
                <p>Đặt lịch và Quản lý sân cầu lông của bạn</p>
                <div class="alobo-logo">
                    <img src="./img/logomoi.png" alt="Badminton AYA Logo">
                    <p>Đặt sân AYA cung cấp các tiện ích thông minh giúp cho bạn đặt sân một cách hiệu quả nhất.</p>
                </div>
                <a href="#" class="contact-button">Liên hệ ngay</a>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3><i class="fas fa-phone"></i> Liên hệ với chúng tôi</h3>
                <h4>Meta: Badminton AYA</h4>
                <h4>Gmail: quockhanh715832@gmail.com</h4>
                <h4>Địa chỉ: Số 135 Đ.Kho Dầu, khóm 4, phường 5, TP.Trà Vinh, tỉnh Trà Vinh, Việt Nam.</h4>
                <h4>Hotline CSKH: 0869 734 188</h4>
                <h4>Hotline hỗ trợ kỹ thuật: 0869 734 188</h4>
            </div>
            <div class="footer-column">
                <h3><i class="fas fa-file-contract"></i> Quy định và chính sách</h3>
                <a href="#">Hướng dẫn sử dụng</a>
                <a href="#">Thông tin về thanh toán</a>
                <a href="#">Quy chế hoạt động ứng dụng</a>
                <a href="#">Thông tin chăm sóc khách hàng</a>
                <a href="#">Chính sách bảo mật thông tin cá nhân</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Badminton AYA. Tất cả quyền được bảo lưu. | Thiết kế bởi đội ngũ phát triển thể thao.</p>
        </div>
    </footer>
</body>
</html>