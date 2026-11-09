<?php

namespace App\Filament\Widgets;

use App\Models\Pengaduan;
use Filament\Facades\Filament;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class GetPengaduan extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $siswaId = null;

        if (Filament::getCurrentPanel()?->getId() === 'siswa') {
            $siswaId = filter_var($this->pageFilters['siswa_id'] ?? null, FILTER_VALIDATE_INT);

            if ($siswaId === false || $siswaId < 1) {
                return $this->makeStats([]);
            }
        }

        $totals = Pengaduan::query()
            ->select('status')
            ->selectRaw('COUNT(*) as total')
            ->when($siswaId, fn (Builder $query) => $query->where('siswa_id', $siswaId))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        return $this->makeStats($totals);
    }

    /**
     * @param  array<string, int|string>  $totals
     * @return array<Stat>
     */
    private function makeStats(array $totals): array
    {
        return [
            Stat::make('Menunggu', $totals['menunggu'] ?? 0),
            Stat::make('Proses', $totals['proses'] ?? 0),
            Stat::make('Selesai', $totals['selesai'] ?? 0),
        ];
    }
}
