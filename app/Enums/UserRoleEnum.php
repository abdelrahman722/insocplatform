<?php

namespace App\Enums;
enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Manager = 'manager';
    case Teacher = 'teacher';
    case Student = 'student';
    case Employee = 'employee';
    case Guardian = 'guardian';

    public static function getValuesExcept(self ...$except): array
    {
        return array_values(array_filter(
            array_column(self::cases(), 'value'),
            fn ($value) => ! in_array(self::tryFrom($value), $except, true)
        ));
    }
}