<?php
    require_once '../DAL/connect_database.php';

    function getPitchById($pitch_id) {
        $conn = getConnection();
        $query = "SELECT p.*, COALESCE(t.quantity, 0) as quantity, COALESCE(t.description, '') as type_note FROM badminton_pitches p LEFT JOIN pitch_types t ON p.pitch_type_id = t.id WHERE p.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $pitch_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pitch = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $pitch;
    }

    function getDiscountByCode($code) {
    $conn = getConnection();
    $sql = $conn->prepare("SELECT * FROM discounts WHERE code = ?");
    $sql->bind_param("s", $code);
    $sql->execute();
    $result = $sql->get_result();

    $discount = $result->fetch_assoc();
    $conn->close();

    return $discount;
}