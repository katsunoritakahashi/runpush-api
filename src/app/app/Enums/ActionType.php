<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Delete()
 * @method static static Complete()
 */
final class ActionType extends Enum
{
    const Delete = 0;
    const Complete = 1;
}
