<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Kanekescom\Simgtk\Filament\Traits\HasHistoryBezettingRelationManager;

class BezettingSmpRelationManager extends RelationManager
{
    use HasHistoryBezettingRelationManager;

    protected static string $relationship = 'bezettingSmp';

    protected static ?string $title = 'SMP';

    protected static array $jenjangMapelHeaders = [
        'smp' => [
            'pai' => 'PAI',
            'pjok' => 'PJOK',
            'b_indonesia' => 'B. INDONESIA',
            'b_inggris' => 'B. INGGRIS',
            'bk' => 'BK',
            'ipa' => 'IPA',
            'ips' => 'IPS',
            'matematika' => 'MATEMATIKA',
            'ppkn' => 'PPKN',
            'prakarya' => 'PRAKARYA',
            'seni_budaya' => 'SENI BUDAYA',
            'b_sunda' => 'B. SUNDA',
            'tik' => 'TIK',
        ],
    ];

    protected static array $jenjangMapels = [
        'smp' => [
            'pai',
            'pjok',
            'b_indonesia',
            'b_inggris',
            'bk',
            'ipa',
            'ips',
            'matematika',
            'ppkn',
            'prakarya',
            'seni_budaya',
            'b_sunda',
            'tik',
        ],
    ];
}
