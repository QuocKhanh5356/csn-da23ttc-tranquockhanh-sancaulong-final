<?php
session_start();
require_once __DIR__ . '/../BLL/pitchService.php';
require_once __DIR__ . '/../BLL/orderService.php';
require_once __DIR__ . '/../BLL/utils.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $namee = trim(htmlspecialchars($_POST['name']));
        $namee = formatStandard($namee);
        $sdt = htmlspecialchars(trim($_POST['phone']));
        $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
        $code = isset($_POST['code']) ? htmlspecialchars(trim($_POST['code'])) : null;
        $pitch_details_id = trim($_POST['pitch_details_id']);
        $price_perhour = trim($_POST['price_perhour']);
        $price_perpeak = trim($_POST['price_perpeak']);
        $time_open = new DateTime(formatDateTime($date, $_POST['time_open']), $timezone);
        $time_close = new DateTime(formatDateTime($date, $_POST['time_close']), $timezone);
        
        $start = new DateTime(formatDateTime($date, $start_time), $timezone);
        $end = new DateTime(formatDateTime($date, $end_time), $timezone);
        $current_time = new DateTime('now', $timezone);
        $current_time->setTimezone($timezone);
        
        $current_time->modify('+1 hours');
        
     if ($start <= $current_time) {
    echo "<style>
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .custom-modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            animation: fadeIn 0.3s ease-out;
        }
        .custom-modal-content h3 {
            color: #d9534f;
            font-size: 1.5em;
            margin-bottom: 15px;
        }
        .custom-modal-content p {
            color: #555;
            font-size: 1em;
            margin-bottom: 25px;
        }
        .custom-modal-content button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .custom-modal-content button:hover {
            background-color: #218838;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>";

    echo "<div class='custom-modal-overlay'>
        <div class='custom-modal-content'>
            <h3>Thông báo</h3>
            <p>Vui lòng đặt sân trước ít nhất 1 ngày.</p>
            <button onclick=\"window.location.replace('pitchDetail.php');\">Đóng</button>
        </div>
    </div>";

    exit();
}
        if ($start < $time_open || $end > $time_close) {
            echo "<script type='text/javascript'>alert('Thời gian cần nằm trong thời gian mở cửa'); window.location.replace('pitchDetail.php');</script>";
            exit();
        }
        if (!$namee) {
            echo "<script type='text/javascript'>alert('Tên không được chứa ký tự đặc biệt');window.location.replace('pitchDetail.php');</script>";
            exit;
        }
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            echo "<script type='text/javascript'>alert('Không có thông tin người đặt');window.location.replace('pitchDetail.php');</script>";
        }

        
        try {
            $re = createNewOrder($pitch_details_id, $user_id, $date, $start_time, $end_time, $namee, $sdt, $email, $price_perhour, $price_perpeak, $code);
            if ($re) {
                $_SESSION["order_id"] = $re;
                $_SESSION["pitch_id"] = $pitch_details_id;
                $_SESSION["name_pitch"] = $_POST['name_pitch'];
                $_SESSION["quantity_pitch"] = $_POST['volume'];
                $_SESSION["name_user"] = $namee;
                $_SESSION["phone"] = $sdt;
                $_SESSION["email"] = $email;
                $_SESSION["start_time"] = $start->format('Y-m-d H:i:s');
                $_SESSION["end_time"] = $end->format('Y-m-d H:i:s');
                header("Location: order.php");
                unset($_SESSION['selectedPitch']);
                exit();
            } else {
                echo "<script type='text/javascript'>alert('Đặt không thành công'); window.location.replace('pitchDetail.php');</script>";
            }
        } catch (Exception $e) {
            echo "<script type='text/javascript'>alert('Message: " . $e->getMessage() . "'); window.location.replace('pitchDetail.php');</script>";
        }
    } else {
        
    }
}