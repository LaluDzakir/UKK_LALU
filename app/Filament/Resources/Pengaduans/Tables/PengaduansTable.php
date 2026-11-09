<?php

namespace App\Filament\Resources\Pengaduans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PengaduansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tempat')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->hidden(fn (): bool => Filament::getCurrentPanel()?->getId() === 'siswa'),
                TextColumn::make('siswa.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->hidden(fn (): bool => Filament::getCurrentPanel()?->getId() === 'siswa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->hidden(fn (): bool => Filament::getCurrentPanel()?->getId() === 'siswa'),
                ]),
            ]);
    }
}
