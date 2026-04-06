<?php
require_once __DIR__ . '/../DAL/UtilitiesRepository.php';

class UtilitiesService {
    private $repo;

    public function __construct() {
        $this->repo = new UtilitiesRepository();
    }

    public function getInventory() {
        return $this->repo->getInventory();
    }

    public function updateQuantity($id, $quantity) {
        return $this->repo->updateQuantity($id, $quantity);
    }

    public function placeOrder($user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, $stringing_service, $stringing_details) {
        // Tính tổng
        $total = 0;
        $inventory = $this->getInventory();
        $prices = [];
        foreach ($inventory as $item) {
            $prices[$item['item_name']] = $item['price'];
        }

        if ($drink_quantity > 0 && isset($prices[$drink_type])) {
            $total += $prices[$drink_type] * $drink_quantity;
        }
        if ($racket_quantity > 0 && isset($prices[$racket_type])) {
            $total += $prices[$racket_type] * $racket_quantity;
        }
        if ($stringing_service && isset($prices['Dịch vụ quấn vợt'])) {
            $total += $prices['Dịch vụ quấn vợt'];
        }

        return $this->repo->placeOrder($user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, $stringing_service, $stringing_details, $total);
    }

    public function getOrders() {
        return $this->repo->getOrders();
    }

    public function updateOrderStatus($id, $status) {
        return $this->repo->updateOrderStatus($id, $status);
    }
}
?>