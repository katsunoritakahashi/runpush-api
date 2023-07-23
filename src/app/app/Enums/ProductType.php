<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Monthly()
 * @method static static Annually()
 */
final class ProductType extends Enum
{
    const Monthly = 0;
    const Annually = 1;
}
