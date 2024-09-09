<?php

namespace App\Enums\OptionReference;

use ArchTech\Enums\From;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

/**
 * @method static ENDPOINT()
 * @method static FAT()
 * @method static JB()
 * @method static ODF()
 */
enum EndpointType: string
{
    use Names;
    use Values;
    use Options;
    use From;
    use InvokableCases;

    case ODF = 'odf';
    case OLT = 'olt';
    case BEST_TRAY = 'best_tray';
    case FAT = 'fat';
    case JB = 'jb';
}
