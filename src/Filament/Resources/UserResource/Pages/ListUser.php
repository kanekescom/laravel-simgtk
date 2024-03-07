<?php

namespace Kanekescom\Simgtk\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Kanekescom\Simgtk\Filament\Resources\UserResource;

class ListUser extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'User';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
}
