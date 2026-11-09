<?php

namespace App\Filament\Resources\Pengaduans\Schemas;

use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PengaduanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tempat')
                    ->required(),
                TextInput::make('description')
                    ->required(),
                Select::make('status')
                    ->options(['menunggu' => 'Menunggu', 'proses' => 'Proses', 'selesai' => 'Selesai'])
                    ->default('menunggu')
                    ->hidden(fn (): bool => Filament::getCurrentPanel()?->getId() === 'siswa')
                    ->required(),
                Select::make('siswa_id')
                    ->relationship(name: 'siswa', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('category_id')
                    ->relationship(name: 'category', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
