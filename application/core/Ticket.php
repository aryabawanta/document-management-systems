<?php

class Ticket {

    const BUKA = 'B';
    const PROSES = 'P';
    const SELESAI = 'S';

    static function status($status = NULL) {
        $list = self::listStatus();
        return empty($status) ? 'No Status' : $list[$status];
    }

    static function listStatus() {
        $status = array(
            self::BUKA => 'Terbuka',
            self::PROSES => 'Diproses',
            self::SELESAI => 'Selesai',
        );
        return $status;
    }


}
