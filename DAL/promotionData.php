<?php
require_once __DIR__ . '/connect_database.php';
require_once __DIR__ . '/../MODEL/promotion_model.php';

class promotionDAL {

    public function getAllpromotion() {
        $promos = [];
        $conn = getConnection();
        $query = "SELECT * FROM discounts"; // Cập nhật tên bảng cho đúng
        $data = $conn->query($query);
        
        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $promos[] = new Promotion($row['code'], $row['amount'], $row['usage_limit']);
            }
        }

        $conn->close();
        return $promos;
    }

    public function getonePromotion($code) {
        $promo = null; // Chỉ cần một đối tượng, không phải mảng
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM discounts WHERE code = ?");
        $stmt->bind_param('s', $code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $promo = new Promotion($row['code'], $row['amount'], $row['usage_limit']);
        }

        $stmt->close();
        $conn->close();
        return $promo;
    }

    public function AddPromotionData($makm, $muckm,$soluong) {
        $conn = getConnection();
        try {
            $query = "INSERT INTO discounts (code, amount,usage_limit) VALUES (?, ?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $makm, $muckm,$soluong);
            $result = $stmt->execute();
            $stmt->close();
            return true;
        } catch (Exception $e) {
        } 
        $conn->close();
    }

    public function UpdatePromotionData($code, $muckm, $soluong) {
        $conn = getConnection();
        $query = "UPDATE discounts SET amount = ?, usage_limit = ? WHERE code = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            throw new Exception('Invalid prepare statement: ' . $conn->error);
        }

        $stmt->bind_param('sis', $muckm, $soluong, $code);
        $result = $stmt->execute();

        $stmt->close();
        $conn->close();
        return $result;
    }

    public function Del($id) {
        $conn = getConnection();
        $query = "DELETE FROM discounts WHERE code = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Invalid prepare statement: ' . $conn->error);
        }

        $stmt->bind_param('s', $id);
        $result = $stmt->execute();

        $stmt->close();
        $conn->close();
        return $result;
    }
}


?>