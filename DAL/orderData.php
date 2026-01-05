<?php
    require_once '../DAL/connect_database.php';

    function getTimeOrderById($id_user, $id_pitch) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) as order_count FROM orders WHERE user_id = ? AND badminton_pitch_id = ?");
        $stmt->bind_param('ii', $id_user, $id_pitch);
        $row = null;
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        }
        $stmt->close();
        $conn->close();
        return $row;
    }

    function checkTimeOrderById($pitch_id, $start_time, $end_time) {
    $conn = getConnection();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM orders WHERE badminton_pitch_id = ? AND (start_at < ? AND end_at > ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('iss', $pitch_id, $end_time, $start_time);
    if ($stmt->execute() === false) {
        die("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        die("Get result failed: " . $stmt->error);
    }

    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    // Debug output
    echo "checkTimeOrderById - pitch_id: $pitch_id, start_time: $start_time, end_time: $end_time, count: " . $row['count'] . "<br>";

    return $row['count'];
}


    function createNewOrderData($pitch_id, $user_id, $name, $phone, $deposit, $code, $start_time, $end_time, $total, $status, $email = null, $note = null, $created_at = null) {
        $conn = getConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Gỡ lỗi: hiển thị các giá trị biến trước khi thực thi
        echo "createNewOrderData - pitch_id: $pitch_id, user_id: $user_id, name: $name, phone: $phone, deposit: $deposit, code: $code, start_time: $start_time, end_time: $end_time, total: $total, status: $status, email: $email, note: $note, created_at: $created_at<br>";

        $id = null;
        $stmt = null;

        if ($code) {
            $stmt = $conn->prepare("INSERT INTO orders (id, name, phone, email, deposit, code, start_at, end_at, total, status, note, user_id, badminton_pitch_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('isssdsssdisiis', $id, $name, $phone, $email, $deposit, $code, $start_time, $end_time, $total, $status, $note, $user_id, $pitch_id, $created_at);
        } else {
            $stmt = $conn->prepare("INSERT INTO orders (id, name, phone, email, deposit, start_at, end_at, total, status, note, user_id, badminton_pitch_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('isssdsssdissi', $id, $name, $phone, $email, $deposit, $start_time, $end_time, $total, $status, $note, $user_id, $pitch_id, $created_at);
        }

        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        // Gỡ lỗi: kiểm tra xem bản ghi mới có được thêm thành công không
        $checkStmt = $conn->prepare("SELECT id FROM orders WHERE start_at = ? AND end_at = ? AND user_id = ? AND badminton_pitch_id = ?");
        if ($checkStmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $checkStmt->bind_param("ssii", $start_time, $end_time, $user_id, $pitch_id);
        if ($checkStmt->execute() === false) {
            die("Execute failed: " . $checkStmt->error);
        }

        $re = $checkStmt->get_result();
        if ($re === false) {
            die("Get result failed: " . $checkStmt->error);
        }

        if ($re->num_rows == 0) {
            return 0;
        } else {
            $r = $re->fetch_assoc();
            $id = $r["id"];
        }

        $checkStmt->close();
        $conn->close();
        return $id;
    }


    function getStatusOrderById($order_id) {
        $conn = getConnection();
        $result = $conn->query("SELECT status FROM orders WHERE order_id = $order_id");
        $row = $result->fetch_assoc();
        $conn->close();
        return $row["status"];
    }

    function getOrderById($order_id) {
        $conn = getConnection();
        $re = $conn->query("SELECT * FROM orders WHERE id = $order_id");
        $r = $re->fetch_assoc();
        $conn->close();
        return $r;
    }


    function getUnpaidOrders() {
        $conn = getConnection();
        $sql = "SELECT id, name, start_at, end_at, deposit, total, code, status, phone, email FROM orders WHERE status = 'unpaid'";
        $result = $conn->query($sql);
        $orders = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        $conn->close();
        return $orders;
    }

    function getAllOrders() {
        $conn = getConnection();
        $sql = "SELECT id, name, start_at, end_at, deposit, total, code, status, phone, email, badminton_pitch_id FROM orders";
        $result = $conn->query($sql);
        $orders = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        $conn->close();
        return $orders;
    }

    function updateOrderData($id,$name,$phone,$email,$start_at,$end_at,$deposit,$status, $total){
        $conn = getConnection();
        $sql = "UPDATE orders SET name = '$name',phone = '$phone', email = '$email', deposit = '$deposit', start_at = '$start_at', end_at = '$end_at', total = '$total', status = '$status' WHERE id = '$id'" ;
        $data = $conn->query($sql);
        if($data){
            return true;
        } else {
            echo "Error: " . $conn->error;
        }
        $conn->close();
        return false;
    }

    function removeOrderData($id){
        $conn = getConnection();
        $sql = "DELETE FROM orders WHERE id = '$id'";
        $data = $conn->query($sql);
        if($data){
            return true;
        }else {
            echo "Error: " . $conn->error;
        }
        $conn->close();
        return false;
    }

    function getOrdersByUserIdnn($userId)
    {
        $conn = getConnection();
        $sql = "SELECT id, name, start_at, end_at, deposit, total, code, status, phone, email, badminton_pitch_id 
                FROM orders 
                WHERE user_id = $userId";
        $result = $conn->query($sql);
        $orders = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        $conn->close();
        return $orders;
    }
    // Trong tệp DAL

    function getOrdersByPitchIdData($pitchId)
    {
        $conn = getConnection();
        $sql = "SELECT id, name, start_at, end_at, deposit, total, code, status, phone, email, badminton_pitch_id, user_id
                FROM orders
                WHERE badminton_pitch_id = $pitchId AND status != 'cancelled'
                ORDER BY start_at ASC";
        $result = $conn->query($sql);
        $orders = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        $conn->close();
        return $orders;
    }
 