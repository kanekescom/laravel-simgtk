<?php

namespace Kanekescom\Simgtk\Filament\Resources;

use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Kanekescom\Simgtk\Filament\Resources\UserResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $slug = 'user';

    protected static ?string $pluralLabel = 'User';

    protected static ?string $model = User::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'User';

    protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(32)
                    ->label('Name'),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->label('Email'),
                Forms\Components\TextInput::make('password')
                    ->revealable()
                    ->required()
                    ->password()
                    ->maxLength(32)
                    ->label('Password'),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->label('Roles'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name', 'asc')
            ->modifyQueryUsing(fn ($query) => $query->whereNot('id', auth()->user()?->id))
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->wrap()
                    ->grow()
                    ->searchable()
                    ->sortable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('email')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->listWithLineBreaks()
                    ->bulleted(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('name')
                            ->heading('Name'),
                        Column::make('email')
                            ->heading('Email'),
                        Column::make('roles')
                            ->getStateUsing(fn ($record) => $record->roles()->pluck('name')->implode(', '))
                            ->heading('Roles'),
                    ])->withFilename(fn ($resource) => str($resource::getSlug())->replace('/', '_').'-'.now()->format('Y-m-d')),
                ])->visible(auth()->user()->can('export_'.self::class)),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUser::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'import',
            'export',
        ];
    }
}
