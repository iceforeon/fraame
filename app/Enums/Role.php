<?php

namespace App\Enums;

enum Role: string
{
    case Developer = 'developer';
    case Editor = 'editor';
    case Guest = 'guest';
}
