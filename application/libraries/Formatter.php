<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formatter {

    private static $months = array(
        1 => 'Januari',
        2 => 'February',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
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

    public static function getMonth($default = NULL) {
        return !empty($default) ? self::$months[$default] : self::$months;
    }

    public static function getDay($default = NULL) {
        return !empty($default) ? self::$days[$default] : self::$days;
    }    

    public static function toIndoDate($date) {
        return implode(' ', array(date('d', strtotime($date)), date('n', strtotime($date)), date('Y', strtotime($date))));
    }

    public static function toIndoDateTime($datetime) {
        return self::toIndoDate($datetime) . ' ' . date('H:i:s', strtotime($datetime));
    }

    public static function toIndoNumber($number, $decimal = 2) {
        return number_format($number, $decimal, ',', '.');
    }

}
