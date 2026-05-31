<?php
session_start();
require_once __DIR__ . '/../BLL/UtilitiesService.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 1;
$utilitiesService = new UtilitiesService();

try {
    $orders = $utilitiesService->getOrdersByUserId($user_id);
    foreach ($orders as &$order) {
        $description = $order['stringing_details'];
        $decoded = json_decode($order['stringing_details'], true);
        if (is_array($decoded) && isset($decoded['description'])) {
            $description = $decoded['description'];
        } else {
            $pieces = [];
            if (!empty($order['drink_type']) && intval($order['drink_quantity']) > 0) {
                $pieces[] = $order['drink_quantity'] . ' x ' . $order['drink_type'];
            }
            if (!empty($order['racket_type']) && intval($order['racket_quantity']) > 0) {
                $pieces[] = $order['racket_quantity'] . ' x ' . $order['racket_type'];
            }
            if (empty($pieces)) {
                $description = $order['stringing_details'];
            } else {
                $description = implode(', ', $pieces);
            }
        }
        $order['description'] = $description;
    }
    unset($order);
    echo json_encode($orders);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Không thể tải dữ liệu']);
}
?>
