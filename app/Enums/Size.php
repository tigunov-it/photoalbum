<?php

namespace App\Enums;

use App\Traits\EnumFromName;

enum Size: int
{
    use EnumFromName;

    case S = 400;
    case M = 800;
    case L = 2048;

    public function title(): string
    {
        return match ($this) {
            Size::S => 'small',
            Size::M => 'medium',
            Size::L => 'large',
        };
    }
}
