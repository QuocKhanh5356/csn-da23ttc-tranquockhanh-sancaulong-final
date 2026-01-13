<?php
require_once __DIR__ . '/../DAL/connect_database.php';
require_once __DIR__ . '/../DAL/EmployeeRepository.php';

class EmployeeService
{
    private $conn;
    private $employeeRepository;

    public function __construct()
    {
        $this->conn = getConnection();
        $this->employeeRepository = new EmployeeRepository($this->conn);
    }

    public function login($email, $hashedPassword)
    {
        $employee = $this->employeeRepository->findEmployeeByEmail($email);
        if (!$employee) {
            return false;
        }
        if ($employee['password'] !== $hashedPassword) {
            return false;
        }
        return $employee;
    }

    public function getEmployeeById($id) {
        return $this->employeeRepository->findEmployeeById($id);
    }

    public function getEmployeeByEmail($email) {
        return $this->employeeRepository->findEmployeeByEmail($email);
    }

    public function updateEmployee($id, $name, $password, $phone, $email, $address) {
        return $this->employeeRepository->updateEmployee($id, $name, $password, $phone, $email, $address);
    }

    public function getAllEmployees() {
        return $this->employeeRepository->findAllEmployees();
    }

    public function deleteEmployee($id) {
        return $this->employeeRepository->deleteEmployee($id);
    }

    public function addEmployee($name, $email, $password, $phone, $address) {
        return $this->employeeRepository->addEmployee($name, $email, $password, $phone, $address);
    }

    public function isEmailExist($email) {
        return $this->employeeRepository->isEmailExist($email);
    }

    public function updatePassword($email, $newPassword) {
        $hashedPassword = md5($newPassword);
        return $this->employeeRepository->updatePassword($email, $hashedPassword);
    }

    public function toggleEmployeeActive($id) {
        $employee = $this->getEmployeeById($id);
        if ($employee) {
            $newActive = $employee['active'] ? 0 : 1;
            return $this->employeeRepository->updateEmployeeActive($id, $newActive);
        }
        return false;
    }

    public function validatePhoneNumber($phone) {
        $pattern = '/^[0-9]{10}$/';
        if (preg_match($pattern, $phone)) {
            return true;
        } else {
            return false;
        }
    }
}
?>