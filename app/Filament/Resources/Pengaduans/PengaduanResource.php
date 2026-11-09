<?php

namespace App\Filament\Resources\Pengaduans;

use App\Filament\Resources\Pengaduans\Pages\CreatePengaduan;
use App\Filament\Resources\Pengaduans\Pages\EditPengaduan;
use App\Filament\Resources\Pengaduans\Pages\ListPengaduans;
use App\Filament\Resources\Pengaduans\Schemas\PengaduanForm;
use App\Filament\Resources\Pengaduans\Tables\PengaduansTable;
use App\Models\Pengaduan;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pengaduan';

    public static function form(Schema $schema): Schema
    {
        return PengaduanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengaduansTable::configure($table);
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
            'index' => ListPengaduans::route('/'),
            'create' => CreatePengaduan::route('/create'),
            'edit' => EditPengaduan::route('/{record}/edit'),
        ];
    }
}
