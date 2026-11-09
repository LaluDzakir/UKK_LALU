<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\Tables\SiswasTable;
use App\Models\Siswa;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Siswa';

    public static function form(Schema $schema): Schema
    {
        return SiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiswasTable::configure($table);
    }

    public static function canEdit(Model $record): bool
    {
        return static::getEditAuthorizationResponse($record)->allowed();
    }

    public static function getEditAuthorizationResponse(Model $record): Response
    {
        if (Filament::getCurrentPanel()?->getId() === 'siswa') {
            return Response::deny();
        }

        return static::getAuthorizationResponse('update', $record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::getDeleteAuthorizationResponse($record)->allowed();
    }

    public static function getDeleteAuthorizationResponse(Model $record): Response
    {
        if (Filament::getCurrentPanel()?->getId() === 'siswa') {
            return Response::deny();
        }

        return static::getAuthorizationResponse('delete', $record);
    }

    public static function canDeleteAny(): bool
    {
        return static::getDeleteAnyAuthorizationResponse()->allowed();
    }

    public static function getDeleteAnyAuthorizationResponse(): Response
    {
        if (Filament::getCurrentPanel()?->getId() === 'siswa') {
            return Response::deny();
        }

        return static::getAuthorizationResponse('deleteAny');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiswas::route('/'),
            'create' => CreateSiswa::route('/create'),
            'edit' => EditSiswa::route('/{record}/edit'),
        ];
    }
}
