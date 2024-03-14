<?php

namespace Kanekescom\Simgtk\Filament\Resources\RencanaBezettingResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Kanekescom\Simgtk\Filament\Traits\HasHistoryBezettingRelationManager;

class BezettingSdRelationManager extends RelationManager
{
    use HasHistoryBezettingRelationManager;

    protected static string $relationship = 'bezettingSd';

    protected static ?string $title = 'SD';

    protected static array $jenjangMapelHeaders = [
        'sd' => [
            'kelas' => 'KELAS',
            'penjaskes' => 'PENJASKES',
            'agama' => 'AGAMA',
            'agama_noni' => 'AGAMA NONI',
        ],
    ];

    protected static array $jenjangMapels = [
        'sd' => [
            'kelas',
            'penjaskes',
            'agama',
            'agama_noni',
        ],
    ];
}
