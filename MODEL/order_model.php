<?php
class order_model {
    public $id;
    public $name;
    public $phone;
    public $email;
    public $deposit;
    public $code;
    public $start_at;
    public $end_at;
    public $total;
    public $status;
    public $note;
    public $user_id;
    public $badminton_pitch_id;
    public $created_at;
    public $updated_at;

    public function __construct($id, $name, $phone, $email, $deposit, $code, $start_at, $end_at, $total, $status, $note, $user_id, $badminton_pitch_id, $created_at, $updated_at) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->deposit = $deposit;
        $this->code = $code;
        $this->start_at = $start_at;
        $this->end_at = $end_at;
        $this->total = $total;
        $this->status = $status;
        $this->note = $note;
        $this->user_id = $user_id;
        $this->badminton_pitch_id = $badminton_pitch_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}