<?php
class Promotion {
    public $makm;
    public $muckm;
    public $soluong;

    public function __construct($makm, $muckm, $soluong) {
        $this->makm = $makm;
        $this->muckm = $muckm;
        $this->soluong = $soluong;
    }
}
