<?php
    require_once '../DAL/pichesData.php';
    require_once '../DAL/pitchDetailsData.php';

    function getPitch($id) {
        $pitch = getPitchById($id);
        return $pitch;
    }

    function getPichesDetails($id) {
        $images = getPitchDetailsById($id);
        if ($images == null || empty($images)) {
            $images = array('../GUI/football_pitch/default_pitch.png');
        }
        return $images;
    }


    function checkTimeOrder($conn, $pitch_id, $date, $start_time, $end_time) {
    $query = "SELECT COUNT(*) as count FROM ORDERS WHERE pitch_id = ? AND date = ? AND (start_time < ? AND end_time > ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$pitch_id, $date, $end_time, $start_time]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['count'] == 0;
    }

    