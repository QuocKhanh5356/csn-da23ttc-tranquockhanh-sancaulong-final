<?php
require_once __DIR__ . '/../DAL/connect_database.php';
require_once __DIR__ . '/../DAL/UserRepository.php';

class UserService
{
    private $conn;
    private $userRepository;

    public function __construct()
    {
        // 1️⃣ Lấy kết nối DB
        $this->conn = getConnection();

        // 2️⃣ Khởi tạo Repository
        $this->userRepository = new UserRepository($this->conn);
    }
    public function login($email, $hashedPassword)
{
    // Lấy user theo email
    $user = $this->userRepository->findUserByEmail($email);

    // Không tồn tại user
    if (!$user) {
        return false;
    }

    // So sánh mật khẩu (đang dùng md5)
    if ($user['password'] !== $hashedPassword) {
        return false;
    }

    // Đúng email + password
    return $user;
}


     public function getUserById($id) {
        return $this->userRepository->findUserById($id);
    }

    public function getUserByEmail($email) {
        return $this->userRepository->findUserByEmail($email);
    }
    public function updateUser($id, $name, $password, $phone, $email, $address) {
        return $this->userRepository->updateUser($id, $name, $password, $phone, $email, $address);
    }

    public function getAllUsers() {
    return $this->userRepository->findAllUsers();
}

    public function deleteUser($id) {
        return $this->userRepository->deleteUser($id);
    }

    public function findNameType($id){
        return $this->userRepository->findNameTypebyId($id);
    }

    public function addUser($name, $email, $password, $phone, $address, $type) {
        return $this->userRepository->addUser($name, $email, $password, $phone, $address, $type);
    }

    public function isEmailExist($email){
        return $this->userRepository->isEmailExist($email);
    }
    
    public function updatePassword($email, $newPassword) {
        $userRepository = new UserRepository();
        $hashedPassword = md5($newPassword); // hoặc sử dụng một phương pháp băm mật khẩu mạnh hơn
        return $userRepository->updatePassword($email, $hashedPassword);
    }
    
    function validatePhoneNumber($phone) {
        $pattern = '/^[0-9]{10}$/';

        if (preg_match($pattern, $phone)) {
            return true;
        } else {
            return false;
        }
    }

    public function getEmployees() {
        $typeId = $this->userRepository->getTypeIdByName('employee');
        if ($typeId) {
            return $this->userRepository->findUsersByType($typeId);
        }
        return [];
    }

    public function toggleUserActive($id) {
        $user = $this->getUserById($id);
        if ($user) {
            $newActive = $user['active'] ? 0 : 1;
            return $this->userRepository->updateUserActive($id, $newActive);
        }
        return false;
    }

    public function getEmployeeTypeId() {
        return $this->userRepository->getTypeIdByName('employee');
    }

    public function getCustomers() {
        $customerTypeId = $this->userRepository->getTypeIdByName('customer');
        if ($customerTypeId) {
            return $this->userRepository->findUsersByType($customerTypeId);
        }
        return [];
    }
}