<?php
require_once __DIR__ . '/../BLL/pitchSearchService.php';
$service = new PitchSearchService();
$emptyPitches = $service->getAllPitches();

$service = new PitchSearchService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pitchId = $_POST['pitchId'];
    $_SESSION['selectedPitch'] = $pitchId;
    header('Location: pitchDetail.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="css/home.css?v= <?php echo time(); ?>">
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* CSS cho banner */
.banner {
    position: relative;
    background: transparent;   /* hoặc #fff nếu muốn trắng */
    padding: 80px 20px;
    min-height: 400px;
}
.banner::before {
    background: none !important;
}


        .banner-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            gap: 50px;
        }

        .banner-left {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .banner-left img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .banner-left img:hover {
            transform: scale(1.05);
        }

        .banner-right {
            flex: 1;
            text-align: left;
        }

        .banner-right h1,
        .hero-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 16px 0;
            line-height: 1.15;
            color: #111;
        }

        .hero-title .brand {
            display: inline-block;
            color: #28a745;
            font-weight: 800;
            letter-spacing: 0.4px;
        }

        .banner-right p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 24px;
            color: #333;
        }

        .app-buttons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .app-buttons a {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .app-buttons a:hover {
            transform: translateY(-5px);
        }

        .app-buttons img {
            height: 44px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
        }

        @media (max-width: 992px) {
            .banner-content {
                flex-direction: column;
                text-align: center;
                gap: 30px;
            }
            .banner-left {
                order: 2;
            }
            .banner-right {
                order: 1;
                text-align: center;
            }
            .banner-right h1,
            .hero-title {
                font-size: 1.6rem;
            }
            .banner-right p {
                font-size: 0.95rem;
            }
            .app-buttons {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .banner {
                padding: 60px 20px;
                min-height: 300px;
            }
            .banner-right h1,
            .hero-title {
                font-size: 1.4rem;
            }
            .app-buttons img {
                height: 40px;
            }
        }
    </style>
</head>
<body>

<section class="banner">
    <div class="banner-content">
        <div class="banner-left">
            <img src="https://top1hanoi.com/StoreData/images/PageData/san-cau-long-o-ha-noi-3.jpg" alt="Hi5port App">
        </div>
        <div class="banner-right" style="color: black;">
<h1 class="hero-title">
  <span class="brand">Badminton AYA</span><br>
  Hệ thống đặt sân
  cầu lông
</h1>

            <p>Mang đến trải nghiệm đặt sân trực tuyến thuận tiện và linh hoạt cho người chơi.</p>
            <div class="app-buttons">
            <a href="#"><img src="https://st.download.com.vn/data/image/2022/08/02/Google-Play-Store-anh-lon.jpg" alt="Download on the App Store"></a>
            <a href="#"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtosYJJHPgUNF3i63UtU9h6jK2tKnnhx5ZgQ&s" alt="Get it on Google Play"></a>
            </div>
        </div>
    </div>
</section>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .header_pitchManage {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header_content h2 {
            margin: 0;
            font-size: 2.5em;
            font-weight: bold;
        }

        .services-section {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 20px;
            background-color: #f4f7f6;
            gap: 30px;
        }

        .service-item {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 350px;
            transition: transform 0.3s ease;
        }

        .service-item:hover {
            transform: translateY(-5px);
        }

        .service-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }

        .service-icon .fa-chart-line {
            color: #9b59b6; /* Màu tím */
        }

        .service-icon .fa-box-open {
            color: #f1c40f; /* Màu vàng cam */
        }

        .service-icon .fa-calendar-check {
            color: #3498db; /* Màu xanh dương */
        }

        .service-item h3 {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .service-item p {
            font-size: 1em;
            color: #666;
            line-height: 1.6;
        }

        @media (max-width: 992px) {
            .services-section {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <section class="services-section">
        <div class="service-item">
            <div class="service-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3>Nâng cao trình độ</h3>
            <p>Badminton AYA giúp bạn cải thiện khả năng đánh cầu vì là sân mở nên có thể xem các trận giao hữu khác. Cùng với giá thành phổ thông nên có thể giữ chân người chơi lâu vì chúng tôi luôn mong muốn các khách hàng quay trở lại.</p>
        </div>
        <div class="service-item">
            <div class="service-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <h3>Xem Tình Trạng Sân</h3>
            <p>Giúp chủ sân xem được sân nào giờ nào còn trống hay đã được đặt, sân còn dang hoạt động hay đã đưa vào bảo trì . Chủ sân có thể xem được đơn nào chưa thanh toán, đã thanh toán hay còn đang sử dụng dịch vụ ở sân. </p>
        </div>
        <div class="service-item">
            <div class="service-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h3>Quản Lý Lịch Đặt</h3>
            <p>Badminton AYA cung cấp đầy đủ tính năng quản lý và tạo lịch đặt theo ngày, linh hoạt, cố định theo tháng. Đồng thời bạn có thể theo dõi và duyệt đơn đặt lịch từ khách hàng, giúp bạn tổ chức công việc một cách thuận tiện.</p>
        </div>
    </section>

    </body>
</html>
</body>
</html>
<body>
   <style>
/* CSS cho phần danh sách sân cau long */
.container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.pitch-list {
    display: grid; /* Sử dụng Grid để các item nằm lưới */
    grid-template-columns: repeat(4, 1fr); /* 4 cột bằng nhau */
    gap: 30px; /* Tạo khoảng cách giữa các item */
}

.pitch-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.pitch-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.pitch-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.card-content {
    padding: 20px;
}

.card-content h3 {
    margin-top: 0;
    font-size: 1.5em;
    color: #333;
}

.card-content p {
    margin: 5px 0;
    color: #555;
    line-height: 1.5;
}

.card-content strong {
    color: #000;
}

.card-footer {
    padding: 0 20px 20px;
}

.pitch-card button {
    width: 100%;
    padding: 12px 0;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1em;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.pitch-card button:hover {
    background-color: #0056b3;
}

.no-pitch-message {
    text-align: center;
    font-size: 1.2em;
    color: #666;
    margin-top: 50px;
}

@media (max-width: 768px) {
    .pitch-list {
        grid-template-columns: repeat(1, 1fr);
    }
}

@media (min-width: 769px) and (max-width: 992px) {
    .pitch-list {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<div class="container">
    <div class="pitch-list">
        <?php if (!empty($emptyPitches)) : ?>
            <?php foreach ($emptyPitches as $pitch) : ?>
                <div class="pitch-card">
                    <img src="<?php echo $service->getImg($pitch->id); ?>" alt="Sân bóng">
                    <div class="card-content">
                        <h3><?php echo $pitch->name; ?></h3>
                        <p><strong>⏰Thời gian mở:</strong> <?php echo $pitch->start_time . ' - ' . $pitch->end_time; ?></p>
                        <p><strong>💰Giá 1 giờ:</strong> <?php echo number_format($pitch->price_per_hour, 0, ',', '.') . ' VND'; ?></p>
                        <p><strong>👉 Giá thống nhất cho mọi khung giờ:</strong> <?php echo number_format($pitch->price_per_peak_hour, 0, ',', '.') . ' VND'; ?></p>
                    </div>
                    <div class="card-footer">
                        <form method="post">
                            <input type="hidden" name="pitchId" value="<?php echo $pitch->id ?>">
                            <button type="submit">Đặt sân</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="no-pitch-message">Không có sân bóng nào được tìm thấy.</p>
        <?php endif; ?>
    </div>
</div>
</body>

</html>