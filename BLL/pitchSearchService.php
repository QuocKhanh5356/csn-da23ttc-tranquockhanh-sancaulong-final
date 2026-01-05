<?php
require_once __DIR__ . '/../DAL/pitchSearchData.php'; 

class PitchSearchService {
    private $pitch_searchDAL;

    public function __construct() {
        $this->pitch_searchDAL = new PitchSearchDAL();
    }

    public function getImg($id){
        return $this->pitch_searchDAL->getImage($id);
    }
    public function getEmptyPitch() {
    $empty = [];

    $pitch = $this->pitch_searchDAL->getPitch();
    $order = $this->pitch_searchDAL->getOrder();

    foreach ($pitch as $badminton_pitches_model) {
        $is_empty = true;
        $current_pitch_id = $badminton_pitches_model->id;

        foreach ($order as $order_model) {
            if ($order_model->badminton_pitch_id == $current_pitch_id) {

                $order_start_time = strtotime($order_model->start_at);
                $order_end_time = strtotime($order_model->end_at);
                $current_start_time = strtotime('07:00:00');
                $current_end_time = strtotime('20:00:00');
                
                if (!($order_start_time >= $current_end_time || $order_end_time <= $current_start_time)) {
                    $is_empty = false;
                    break;
                }
            }
        }

        if ($is_empty) {
            $empty[] = $badminton_pitches_model;
        }
    }

    return $empty;
}

    public function getAllPitches() {
    return $this->pitch_searchDAL->getPitch();
}

    public function getPitchById($pitchId) {
        $pitch = $this->pitch_searchDAL->getPitchById($pitchId);
        return null;
    }

public function getBookedPitches() {
    $bookedPitches = [];

    $pitches = $this->pitch_searchDAL->getPitch();
    $orders = $this->pitch_searchDAL->getOrder();

    foreach ($pitches as $pitch) {
        foreach ($orders as $order) {
            if ($order->badminton_pitch_id == $pitch->id) {
                $bookedPitches[] = [
                    'pitch_name' => $pitch->name, 
                    'start_time' => $order->start_at,
                    'end_time' => $order->end_at, 
                    'customer_name' => $order->name, 
                    'phone' => $order->phone, 
                    'email' => $order->email, 
                ];
                break; 
            }
        }
    }
    return $bookedPitches;
}

    public function getPitchByName($name){
        return $this->pitch_searchDAL->getPitchByName($name);
    }

}