<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Daily()
 * @method static static Weekly()
 * @method static static Monthly()
 */
final class RepeatRule extends Enum
{
    const Daily = 0;
    const Weekly = 1;
    const Monthly = 2;
}
