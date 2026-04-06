<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiện ích</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/home.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Đặt Tiện ích Bổ sung</h2>
        <form action="" method="POST" class="row g-3">
            <div class="col-md-6">
                <h4>Nước uống</h4>
                <div class="mb-3">
                    <label for="drink_type" class="form-label">Loại nước</label>
                    <select class="form-select" id="drink_type" name="drink_type">
                        <option value="">Chọn loại</option>
                        <option value="Nước khoáng">Nước khoáng</option>
                        <option value="Nước ngọt">Nước ngọt</option>
                        <option value="Nước ép">Nước ép</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="drink_quantity" class="form-label">Số lượng</label>
                    <input type="number" class="form-control" id="drink_quantity" name="drink_quantity" min="0" value="0">
                </div>
            </div>
            <div class="col-md-6">
                <h4>Vợt cầu lông</h4>
                <div class="mb-3">
                    <label for="racket_type" class="form-label">Loại vợt</label>
                    <select class="form-select" id="racket_type" name="racket_type">
                        <option value="">Chọn loại</option>
                        <option value="Vợt cơ bản">Vợt cơ bản</option>
                        <option value="Vợt trung cấp">Vợt trung cấp</option>
                        <option value="Vợt cao cấp">Vợt cao cấp</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="racket_quantity" class="form-label">Số lượng</label>
                    <input type="number" class="form-control" id="racket_quantity" name="racket_quantity" min="0" value="0">
                </div>
            </div>
            <div class="col-12">
                <h4>Dịch vụ quấn vợt</h4>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="stringing_service" name="stringing_service" value="1">
                    <label class="form-check-label" for="stringing_service">
                        Đặt dịch vụ quấn vợt
                    </label>
                </div>
                <div class="mb-3" id="stringing_details" style="display: none;">
                    <label for="stringing_details_input" class="form-label">Chi tiết quấn vợt</label>
                    <textarea class="form-control" id="stringing_details_input" name="stringing_details" rows="3" placeholder="Mô tả chi tiết về dịch vụ quấn vợt..."></textarea>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Đặt tiện ích</button>
            </div>
        </form>
        <?php
        require_once __DIR__ . '/../BLL/UtilitiesService.php';
        $utilitiesService = new UtilitiesService();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $drink_type = $_POST['drink_type'] ?? '';
            $drink_quantity = (int)($_POST['drink_quantity'] ?? 0);
            $racket_type = $_POST['racket_type'] ?? '';
            $racket_quantity = (int)($_POST['racket_quantity'] ?? 0);
            $stringing_service = isset($_POST['stringing_service']);
            $stringing_details = $_POST['stringing_details'] ?? '';

            $user_id = $_SESSION['user_id'] ?? 1; // Giả sử user_id từ session

            $result = $utilitiesService->placeOrder($user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, $stringing_service, $stringing_details);
            if ($result) {
                echo '<div class="alert alert-success mt-3">Đặt tiện ích thành công! Chúng tôi sẽ liên hệ với bạn sớm.</div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Có lỗi xảy ra khi đặt hàng.</div>';
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('stringing_service').addEventListener('change', function() {
            var details = document.getElementById('stringing_details');
            details.style.display = this.checked ? 'block' : 'none';
        });
    </script>
</body>
</html>