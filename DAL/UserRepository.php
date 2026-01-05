<?php
require_once __DIR__ . '/connect_database.php';

class UserRepository {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function findUserByEmail($email) {
        $sql = "SELECT id, password, type FROM users WHERE email=?";
        
        // Sử dụng prepared statement để tránh SQL Injection
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Lấy thông tin người dùng
        $user = $result->fetch_assoc();
        
        // Đóng statement và trả về kết quả
        $stmt->close();
        return $user;
    }

    public function findUserById($id) {
        $sql = "SELECT * FROM users WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function updateUser($id, $name, $password, $phone, $email, $address) {
        $sql = "UPDATE users SET name=?, password=?, phone=?, email=?, address=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $password, $phone, $email, $address, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function findAllUsers() {
    $sql = "SELECT * FROM users";
    $result = $this->conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

public function deleteUser($id) {
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

public function findNameTypebyId($id){
    $sql = "SELECT name FROM user_types WHERE id = $id" ;
    $typeName = $this->conn->query($sql);
    if($typeName->num_rows>0){
        $result = $typeName->fetch_assoc();
        return $result['name'];
    }
    return null;
}

public function addUser($name, $email, $password, $phone, $address, $type) {
    try {
        $query = "INSERT INTO users (name, email, password, phone, address, type) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", $name, $email, $password, $phone, $address, $type);
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (Exception $e) {
        error_log("Error adding user: " . $e->getMessage());
        return false; 
    }
}



    public function isEmailExist($email) {
        $query = "SELECT COUNT(*) as count FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email); // Sử dụng bind_param để tránh lỗi
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] > 0;
    }
    public function updatePassword($email, $password) {
        $sql = "UPDATE users SET password=? WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $password, $email); // "ss" tương ứng với string và string
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}