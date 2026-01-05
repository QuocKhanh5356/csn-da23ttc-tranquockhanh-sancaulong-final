<?php
class badminton_pitches {
    public $id;
    public $name;
    public $start_time;
    public $end_time;
    public $description;
    public $price_per_hour;
    public $price_per_peak_hour;
    public $is_maintenance;
    public $pitch_id;
    public $create_at;
    public $updated_at;

    public function __construct($id, $name, $start_time, $end_time, $description, $price_per_hour, $price_per_peak_hour, $is_maintenance, $pitch_id, $create_at, $updated_at) {
        $this->id = $id;
        $this->name = $name;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->description = $description;
        $this->price_per_hour = $price_per_hour;
        $this->price_per_peak_hour = $price_per_peak_hour;
        $this->is_maintenance = $is_maintenance;
        $this->pitch_id = $pitch_id;
        $this->create_at = $create_at;
        $this->updated_at = $updated_at;
    }
}