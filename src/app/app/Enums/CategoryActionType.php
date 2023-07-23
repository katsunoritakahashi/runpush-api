<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Hidden()
 * @method static static SortBy()
 */
final class CategoryActionType extends Enum
{
    const Hidden = 0;
    const SortBy = 1;
}
