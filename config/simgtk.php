<?php

return [

    'table_prefix' => 'simgtk_',

    'jenjang_sekolah' => [

        'sd' => 'SD',

        'smp' => 'SMP',

    ],

    'filament' => [

        'path' => 'simgtk',

        'domain' => null,

        'brandName' => null,

        'brandLogo' => null,

        'brandLogoHeight' => null,

        'favicon' => null,

        'colors' => [
            'primary' => \Filament\Support\Colors\Color::Amber,
        ],

        'darkMode' => [
            'enabled' => true,
        ],

        'topbar' => [
            'enabled' => true,
        ],

        'topNavigation' => [
            'enabled' => false,
        ],

        'breadcrumbs' => [
            'enabled' => false,
        ],

        'databaseNotifications' => [
            'enabled' => false,
            'polling' => '30s',
        ],

        'spa' => [
            'enabled' => true,
        ],

        'unsavedChangesAlerts' => [
            'enabled' => false,
        ],

        'databaseTransactions' => [
            'enabled' => true,
        ],

        'sidebarCollapsibleOnDesktop' => [
            'enabled' => true,
        ],

        'sidebarFullyCollapsibleOnDesktop' => [
            'enabled' => true,
        ],

        'navigation' => [
            'enabled' => true,
        ],

        'collapsibleNavigationGroups' => [
            'enabled' => true,
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
            'Users',
        ],

    ],

];
