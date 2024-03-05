<?php

return [

    'table_prefix' => 'simgtk_',

    'jenjang_sekolah' => [
        'sd' => 'SD',
        'smp' => 'SMP',
    ],

    'filament' => [
        'id' => 'simgtk',

        'path' => 'simgtk',

        'topbar' => true,

        'brandLogo' => null,

        'favicon' => null,

        'colors' => [
            'primary' => \Filament\Support\Colors\Color::Amber,
        ],

        'navigationGroups' => [
            'Pegawai',
            'Pensiun',
            'Sekolah',
            'Bezetting',
            'Mutasi',
            'Referensi Bezetting',
            'Referensi Kependidikan',
            'Referensi Wilayah',
            'Tools',
        ],
    ],

];
