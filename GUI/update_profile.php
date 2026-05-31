<?php
session_start();
require_once __DIR__ . '/../BLL/UserService.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $name = $_POST['tenKhachHang'];
    $password = $_POST['matKhau'];
    $confirmPassword = $_POST['xacNhan'];
    $phone = $_POST['soDienThoai'];
    $email = $_POST['email'];
    $address = $_POST['diaChi'];

    $userService = new UserService();
    $currentUser = $userService->getUserById($userId);
    $type = $currentUser['type'];

    $hashedPassword = $currentUser['password'];
    $password = trim($password);
    $confirmPassword = trim($confirmPassword);

    $background = null;
    if (isset($_FILES['background'])) {
        $error = $_FILES['background']['error'];
        if ($error == UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $ext = strtolower(pathinfo($_FILES['background']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($ext, $allowed)) {
                $fileName = 'user_' . $userId . '_background.' . $ext;
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['background']['tmp_name'], $uploadFile)) {
                    $background = 'img/' . $fileName;
                } else {
                    echo '<script type="text/javascript">alert("Upload failed: Could not move file.");</script>';
                }
            } else {
                echo '<script type="text/javascript">alert("Upload failed: Invalid file type. Only JPG, PNG, GIF allowed.");</script>';
            }
        } else {
            $errorMsg = '';
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE: $errorMsg = 'File too large (INI)'; break;
                case UPLOAD_ERR_FORM_SIZE: $errorMsg = 'File too large (FORM)'; break;
                case UPLOAD_ERR_PARTIAL: $errorMsg = 'Partial upload'; break;
                case UPLOAD_ERR_NO_FILE: $errorMsg = 'No file selected'; break;
                default: $errorMsg = 'Unknown error: ' . $error;
            }
            if ($error !== UPLOAD_ERR_NO_FILE) {
                echo '<script type="text/javascript">alert("Upload error: ' . $errorMsg . '");</script>';
            }
        }
    }

    if ($password !== '' || $confirmPassword !== '') {
        if ($password === '' || $confirmPassword === '') {
            echo '<script type="text/javascript">alert("Vui lòng nhập cả mật khẩu và xác nhận mật khẩu hoặc để trống nếu không đổi."); location.replace("dashboard.php?pg=profile");</script>';
            exit();
        }
        if ($password !== $confirmPassword) {
            echo '<script type="text/javascript">alert("Passwords do not match."); location.replace("dashboard.php?pg=profile");</script>';
            exit();
        }
        if (strlen($password) < 8) {
            echo '<script type="text/javascript">alert("Password must have at least 8 characters."); location.replace("dashboard.php?pg=profile");</script>';
            exit();
        }
        $hashedPassword = md5($password);
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo '<script type="text/javascript">alert("Phone number must be 10 digits."); location.replace("dashboard.php?pg=profile");</script>';
        exit();
    }

    
    
    $updated = $userService->updateUser($userId, $name, $hashedPassword, $phone, $email, $address, $background);

    if ($updated) {
        if ($background) {
            // Optional: delete old background file if exists
            $oldBackground = $currentUser['background'] ?? null;
            if ($oldBackground && $oldBackground !== $background && file_exists(__DIR__ . '/' . $oldBackground)) {
                unlink(__DIR__ . '/' . $oldBackground);
            }
        }
        if ($type == 1) {
            echo '<script type="text/javascript">alert("Profile updated successfully."); location.replace("dashboard_admin.php");</script>';
        } elseif ($type == 2) {
            echo '<script type="text/javascript">alert("Profile updated successfully."); location.replace("dashboard.php?pg=profile");</script>';
        } else {
            echo '<script type="text/javascript">alert("Unknown user type."); location.replace("dashboard.php");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Failed to update profile."); location.replace("dashboard.php?pg=profile");</script>';
    }
}