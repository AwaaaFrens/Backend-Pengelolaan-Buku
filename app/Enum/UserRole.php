<?php

namespace App\Enum;

enum UserRole: string
{
    case Admin = 'admin';
    case Member = 'member';
}
