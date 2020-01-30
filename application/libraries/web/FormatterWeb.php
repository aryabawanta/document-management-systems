<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FormatterWeb {

    public static $months = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );
    public static $days = array(
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu'
    );

    /**
     * Membalik tanggal ymd jadi dmy dan sebaliknya
     * @param string $ymd
     * @return string
     */
    public static function formatDate($ymd) {
        list($ymd, $his) = explode(' ', $ymd);
        list($y, $m, $d) = explode('-', $ymd);

        return $d . '-' . $m . '-' . $y;
    }

    /**
     * Mengubah format tanggal lengkap Indonesia
     * @param string $ymd
     * @param bool $hari
     * @return string
     */
    public static function toIndoDate($ymd, $hari = false) {
        list($y, $m, $d) = explode('-', $ymd);

        $n = date('N', mktime(0, 0, 0, $m, $d, $y));

        return ($hari ? self::$days[$n] . ', ' : '') . (int) $d . ' ' . Formatter::getMonth((int) $m) . ' ' . $y;
    }

    /**
     * Mengubah format tanggal dan waktu lengkap Indonesia
     * @param string $ymd
     * @param bool $hari
     * @return string
     */
    public static function toIndoDateTime($ymd, $hari = false) {
        list($date, $time) = explode(' ', $ymd);

        return self::toIndoDate($date, $hari) . ' pukul ' . $time;
    }

    /**
     * Mendapatkan lama relatif dari date
     * @param string $ymd
     * @param bool $hari
     * @return string
     */
    public static function dateToDiff($ymd, $hari = true) {
        list($date, $time) = explode(' ', $ymd);
        list($y, $m, $d) = explode('-', $date);
        list($h, $i, $s) = explode(':', $time);

        $time = mktime($h, $i, $s, $m, $d, $y);
        $now = time();
        $diff = $now - $time;

        if ($diff < 60) {
            if (empty($diff))
                return 'baru saja';
            else
                return $diff . ' detik lalu';
        } else
            $diff = floor($diff / 60);

        if ($diff < 60)
            return $diff . ' menit lalu';
        else
            $diff = floor($diff / 60);

        if ($diff < 60)
            return $diff . ' jam lalu';
        else
            $diff = floor($diff / 24);

        // if ($diff < 7)
        //     return $diff . ' hari lalu';
        // else
        //     $diff = floor($diff / 7);

        // if ($diff < 4)
        //     return $diff . ' minggu lalu';
        // else
        //     return self::toIndoDate($ymd, $hari);

        return self::toIndoDateTime($ymd, $hari);
    }

    public static function toCountHourMinute($minute) {
        return floor($minute / 60) . ' Jam ' . ($minute % 60) . ' Mnt';
    }

}
