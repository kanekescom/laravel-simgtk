<?php

namespace Kanekescom\Simgtk\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Kanekescom\Simgtk\Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Create User';
}
