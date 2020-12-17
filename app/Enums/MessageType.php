<?php

namespace App\Enums;

class MessageType extends BaseEnum
{
    const FILE = 'FILE';
    const TEXT = 'TEXT';
    const ADMIN = 'ADMIN';

    public static function all() : array
    {
        return [
            self::FILE,
            self::TEXT,
            self::ADMIN,
        ];
    }
}
