<?php
require_once __DIR__ . '/connect_database.php';

class EmployeeRepository {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function findEmployeeByEmail($email) {
        $sql = "SELECT * FROM employees WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();
        $stmt->close();
        return $employee;
    }

    public function findEmployeeById($id) {
        $sql = "SELECT * FROM employees WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();
        $stmt->close();
        return $employee;
    }

    public function findAllEmployees() {
        $sql = "SELECT * FROM employees";
        $result = $this->conn->query($sql);
        $employees = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
        }
        return $employees;
    }

    public function updateEmployee($id, $name, $password, $phone, $email, $address) {
        $sql = "UPDATE employees SET name=?, password=?, phone=?, email=?, address=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $password, $phone, $email, $address, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteEmployee($id) {
        $sql = "DELETE FROM employees WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function addEmployee($name, $email, $password, $phone, $address) {
        try {
            $query = "INSERT INTO employees (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log("Error adding employee: " . $e->getMessage());
            return false;
        }
    }

    public function isEmailExist($email) {
        $query = "SELECT COUNT(*) as count FROM employees WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] > 0;
    }

    public function updatePassword($email, $password) {
        $sql = "UPDATE employees SET password=? WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $password, $email);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateEmployeeActive($id, $active) {
        $sql = "UPDATE employees SET active=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $active, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>