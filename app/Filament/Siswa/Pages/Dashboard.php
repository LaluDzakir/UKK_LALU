<?php

namespace App\Filament\Siswa\Pages;

use App\Models\Siswa;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('siswa_id')
                            ->label('Cari Siswa')
                            ->placeholder('Cari nama atau NIS siswa')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => Siswa::query()
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('nis', 'like', "%{$search}%")
                                ->orderBy('name')
                                ->limit(50)
                                ->pluck('name', 'id')
                                ->all())
                            ->getOptionLabelUsing(fn (string $value): ?string => Siswa::query()
                                ->whereKey($value)
                                ->value('name')),
                    ])
                    ->columns(1),
            ]);
    }
}
