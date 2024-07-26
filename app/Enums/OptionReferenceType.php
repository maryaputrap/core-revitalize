<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;

/**
 * @method static ENDPOINT()
 */
enum OptionReferenceType: string
{
    use InvokableCases;

    case ENDPOINT = 'endpoint';
}
