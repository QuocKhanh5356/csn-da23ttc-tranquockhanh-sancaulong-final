<?php
    function formatDateTime($date, $time) {
        $datetime = new DateTime("$date $time");
        return $datetime->format('Y-m-d H:i:s');
    }

    function getTime($startTime){
        $oj = new DateTime($startTime);
        return $oj->format('H:i:s');
    }
    function formatStandard($str) {
        $patern = '/^[\p{L}\s]+$/u';
            if (!preg_match($patern, (string)$str)) {
                return false;
            }
            else {
                $str = ucwords(mb_strtolower(trim($str), 'UTF-8'));
                return $str;
            }
    }

    function timeToMinutes($time) {
        list($hours, $minutes) = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    function calculatePrice($price_normal, $price_peakhour, $peak_hours, $start_at, $end_at) {
        $startMinutes = timeToMinutes($start_at);
        $endMinutes = timeToMinutes($end_at);

        if ($endMinutes <= $startMinutes) {
            echo "<script type='text/javascript'>alert('Thời gian kết thúc phải sau thời gian bắt đầu.');window.location.replace('dashboard.php?pg=home');</script>";

            exit();
        }

        $totalPrice = 0;

        for ($currentMinutes = $startMinutes; $currentMinutes < $endMinutes; $currentMinutes += 60) {
            // Kiểm tra nếu giờ hiện tại là giờ cao điểm
            $isPeakHour = false;
            foreach ($peak_hours as $peak) {
                $peakStartMinutes = timeToMinutes($peak['start_at']);
                $peakEndMinutes = timeToMinutes($peak['end_at']);

                if ($currentMinutes >= $peakStartMinutes && $currentMinutes < $peakEndMinutes) {
                    $isPeakHour = true;
                    break;
                }
            }

            if ($isPeakHour) {
                $totalPrice += $price_peakhour;
            } else {
                $totalPrice += $price_normal;
            }
        }

        return $totalPrice;
    }

    function calculatePrice1($price_normal, $price_peakhour, $peak_hours, $start_at, $end_at) {
        $startMinutes = timeToMinutes($start_at);
        $endMinutes = timeToMinutes($end_at);

        if ($endMinutes <= $startMinutes) {
            echo "<script type='text/javascript'>alert('Thời gian kết thúc phải sau thời gian bắt đầu.');window.location.replace('./GUI/dashboard_admin.php?pg=summary');</script>";
            exit();
        }

        $totalPrice = 0;

        for ($currentMinutes = $startMinutes; $currentMinutes < $endMinutes; $currentMinutes += 60) {
            // Kiểm tra nếu giờ hiện tại là giờ cao điểm
            $isPeakHour = false;
            foreach ($peak_hours as $peak) {
                $peakStartMinutes = timeToMinutes($peak['start_at']);
                $peakEndMinutes = timeToMinutes($peak['end_at']);

                if ($currentMinutes >= $peakStartMinutes && $currentMinutes < $peakEndMinutes) {
                    $isPeakHour = true;
                    break;
                }
            }

            if ($isPeakHour) {
                $totalPrice += $price_peakhour;
            } else {
                $totalPrice += $price_normal;
            }
        }

        return $totalPrice;
    }