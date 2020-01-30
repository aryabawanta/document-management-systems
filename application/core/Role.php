<?php

class Role {

    const ADMINISTRATOR = 'A';
    const USER = 'U';

    public static function name($role = NULL) {
        $names = array(
            self::ADMINISTRATOR => 'Administrator',
            self::USER => 'User',
        );
        return empty($role) ? '-' : $names[$role];
    }

    public static function getRoles(){
        $roles = array(
            self::ADMINISTRATOR => 'Administrator',
            self::USER => 'User',
        );
        return $roles;
    }

    static function getStyle($role) {
    }

    public static function permission() {
        // $permissions = array(
        //     //POST
        //     'post/public' => '*',
        //     'post/group' => array(self::STAFF, self::EMPLOYEE),
        //     'post/private' => array(self::STAFF, self::EMPLOYEE),
        //     'post/me' => '*',
        //     'post/create_public' => array(self::ADMINISTRATOR, self::STAFF),
        //     'post/create_group' => array(self::STAFF, self::EMPLOYEE),
        //     'post/create_private' => array(self::STAFF, self::EMPLOYEE),
        //     //COMMENT
        //     'comment/create' => '*',
        //     //GROUP
        //     'group/create' => self::LEADER,
        //     //USER
        //     'user/update' => '*',
        //     'user/change_password' => '*',
        //     //AGENDA
        //     'agenda/me' => '*',
        //     'agenda/create' => '*',
        //     //DEVICE
        //     'device/register' => '*',
        // );
        return $permissions;
    }

    public static function getPermissions($role = NULL) {
        $permissions = array();
        foreach (self::permission() as $key => $val) {
            if ((is_string($val) && ($role == $val || $val == '*')) || (is_array($val) && in_array($role, $val))) {
                $permissions[] = $key;
            }
        }
        return $permissions;
    }

}
