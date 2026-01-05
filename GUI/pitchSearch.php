<?php
require_once __DIR__ . '/../BLL/pitchSearchService.php';
$service = new PitchSearchService();

$value = isset( $_SESSION['something'])? $_SESSION['something']:"";
$mess = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['pitchId'])){
        $pitchId = $_POST['pitchId'];
        $_SESSION['selectedPitch'] = $pitchId;
        header('Location: pitchDetail.php');
        exit();
    }
}
?>
<?php
    if($_SERVER['REQUEST_METHOD']== 'POST'){
    if(isset($_POST['search'])){
        $name = trim($_POST['search-bar']);
        if(!empty($name)){
            $_SESSION['something'] = $name;
            $emptyPitches = $service-> getPitchByName($name);
            $value = $name;
        }else{
            $mess = "Vui lòng nhập tên sân bóng!";
            unset($_SESSION['something']);
            $value = "";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Kiếm Sân Cầu Lông</title>
    <link rel="stylesheet" href="css/pitchSearch.css?v=<?php echo time(); ?>">
</head>

<body>
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
            margin: 0;
            padding: 0;
        }

        .search-banner {
            background-image: url('https://media.vov.vn/sites/default/files/styles/large/public/2022-08/nguyen_tien_minh.jpg');
            background-size: cover;
            background-position: center;
            padding: 140px 20px;
            color: white;
            text-align: center;
            position: relative;
        }

        .search-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Lớp phủ mờ */
            z-index: 1;
        }

        .search-content {
            position: relative;
            z-index: 2;
        }

        .search-content h1 {
            font-size: 2.5em;
            font-weight: bold;
            margin: 0 0 10px;
        }

        .search-content p {
            font-size: 1.0em;
            font-weight: 300;
            margin: 0 0 30px;
        }

        .search-form {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .search-form input,
        .search-form select {
            border: none;
            padding: 15px;
            font-size: 1em;
            outline: none;
            flex: 1;
        }

        .search-form button {
            background-color: #ffc107;
            border: none;
            padding: 15px 30px;
            color: #333;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-form button:hover {
            background-color: #e0a800;
        }

        .rating {
            color: #ffc107ff;
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .star {
            margin: 0 2px;
        }
        .search-box {
    max-width: 520px;      /* ⭐ chỉnh ngắn tại đây (420–560 tùy thích) */
    margin: 30px auto 0;   /* căn giữa */
}

        .search-box form {
    width: 100%;
    height: 52px;
    display: flex;
    border-radius: 40px;
    overflow: hidden;
}


.search-box input {
    flex: 1;
    height: 100%;
    padding: 0 22px;
    border: none;
    outline: none;
}

.search-box button {
    width: 64px;
    height: 100%;
    background: #ffc107;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0 40px 40px 0;
}

.search-box button:hover {
    background: #e0a800;
}

.search-box button:active {
    transform: scale(0.95);
}
.search-box form:focus-within {
    box-shadow:
        0 0 0 3px rgba(255, 193, 7, 0.6),
        0 12px 30px rgba(0, 0, 0, 0.4);
}

/* Ba dòng Chú thích dưới tìm kím */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }

        .features-section {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 50px 20px;
            text-align: center;
            background-color: #ffffff;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
        }

        .feature-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 300px;
            padding: 0 30px;
        }

        .feature-item .icon {
            font-size: 50px;
            color: #000000;
            margin-bottom: 20px;
        }

        .feature-item h3 {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .feature-item p {
            font-size: 1em;
            color: #666;
            line-height: 1.5;
        }

        .feature-divider {
            width: 1px;
            height: 150px;
            background-color: #e0e0e0;
            margin: 0 40px;
        }

        @media (max-width: 768px) {
            .features-section {
                flex-direction: column;
                align-items: center;
            }
            .feature-divider {
                width: 80%;
                height: 1px;
                margin: 40px 0;
            }
        }
/* Ba dòng Chú thích dưới tìm kím */    
    </style>
</head>

<body>
    <div class="search-banner">
        <div class="search-content">
            <div class="rating">
                <i class="fas fa-star star"></i>
                <i class="fas fa-star star"></i>
                <i class="fas fa-star star"></i>
            </div>
            <h1>HỆ THỐNG HỖ TRỢ TÌM KIẾM SÂN CẦU LÔNG NHANH</h1>
            <p>Dữ liệu được Badminton AYA cập nhật thường xuyên giúp cho người dùng tìm được sân một cách nhanh nhất</p>
            
            <div class="search-box">
    <form action="" method="post">
        <input 
            type="text"
            id="search-bar"
            name="search-bar"
            placeholder="🔍 Nhập tên sân cầu lông..."
            value="<?php echo $value; ?>"
        >
        <button type="submit" name="search">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>
        </div>
    </div>
</body>
</html>
    <section class="features-section">
    <div class="feature-item">
        <div class="icon">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <h3>Tìm kiếm vị trí sân</h3>
        <p>Dữ liệu sân đấu dồi dào, liên tục cập nhật, giúp bạn dễ dàng tìm kiếm theo khu vực mong muốn</p>
    </div>
    <div class="feature-divider"></div>
    <div class="feature-item">
        <div class="icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <h3>Đặt lịch online</h3>
        <p>Không cần đến trực tiếp, không cần gọi điện đặt lịch, bạn hoàn toàn có thể đặt sân ở bất kì đâu có internet</p>
    </div>
    <div class="feature-divider"></div>
    <div class="feature-item">
        <div class="icon">
            <i class="fas fa-running"></i>
        </div>
        <h3>Thanh toán trực tuyến</h3>
        <p>Thanh toán dễ dàng, nhanh chóng và an toàn qua các phương thức thanh toán điện tử.</p>
    </div>
</section>
    
        <?php if (!empty($emptyPitches)) : ?>
        <div class="container">
        <?php foreach ($emptyPitches as $pitch) : ?>
        <div class="info_pitch">
            <img src="<?php echo $service->getImg($pitch->id); ?>" alt="hình anh">
            <div class="info_show">
                <p class="title_name">Tên sân cầu lông: </p>
                <p><?php echo $pitch->name; ?></p>
                <p class="title_name">Thời gian mở: </p>
                <p><?php echo $pitch->start_time .' - '.$pitch->end_time; ?></p>
                <p class="title_name">Giá 1 giờ: </p>
                <p><?php echo $pitch->price_per_hour . " VND"; ?></p>
                <p class="title_name">Giá giờ cao điểm:</p>
                <p><?php echo $pitch->price_per_peak_hour . " VND"; ?></p>
                <div class="button-container">
                    <form method="post">
                        <input type="hidden" name="pitchId" value="<?php echo $pitch->id ?>">
                        <button type="submit">Đặt sân</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
        <?php else : ?>
        <?php endif; ?>
   
</body>

</html>