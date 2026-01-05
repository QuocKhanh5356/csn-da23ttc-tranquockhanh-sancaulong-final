<?php
require_once __DIR__ . '/../DAL/promotionData.php';

class PromotionService {
    private $dal;

    public function __construct() {
        $this->dal = new promotionDAL();
    }

    public function getAll() {
        return $this->dal->getAllpromotion();
    }

    public function getOne($id) {
        return $this->dal->getonePromotion($id);
    }

    public function add($makm, $muckm,$soluong) {
        return $this->dal->AddPromotionData($makm, $muckm,$soluong);
    }

    public function update($code, $muckm, $soluong) {
        return $this->dal->UpdatePromotionData($code, $muckm, $soluong);
    }

    public function delete($id) {
        return $this->dal->Del($id);
    }
}
