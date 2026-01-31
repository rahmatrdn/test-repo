<?php

namespace App\Constants;

class UserConst
{
    const SUPER_ADMIN = 1;

    const ADMIN_SEKOLAH = 2;

    const GURU = 3;

    const SISWA = 4;

    public static function getAccessTypes()
    {
        return [
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN_SEKOLAH => 'Admin Sekolah',
            self::GURU => 'Guru',
            self::SISWA => 'Siswa',
        ];
    }
}
