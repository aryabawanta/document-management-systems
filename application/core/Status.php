<?php

class Status {

    const ACTIVE = 'A';
    const INACTIVE = 'I';
    const DRAFT = 'D';
    const VOID = 'V';
    
    public static function getArray() {
        return array(
            self::ACTIVE => 'Aktif',
            self::INACTIVE => 'Tidak Aktif',
            self::DRAFT => 'Draft',
            self::VOID => 'Dihapus'
        );
    }

}
