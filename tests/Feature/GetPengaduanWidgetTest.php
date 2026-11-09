<?php

use App\Filament\Widgets\GetPengaduan;
use App\Models\Category;
use App\Models\Siswa;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('the student widget defaults to zero and filters counts by the selected student while admin sees all complaints', function () {
    expect(Filament::getPanel('admin')->getWidgets())
        ->toContain(GetPengaduan::class)
        ->and(Filament::getPanel('siswa')->getWidgets())
        ->toContain(GetPengaduan::class);

    $selectedSiswa = Siswa::query()->create([
        'name' => 'Siswa Pertama',
        'nis' => '12345',
        'kelas' => 'X',
    ]);

    $otherSiswa = Siswa::query()->create([
        'name' => 'Siswa Kedua',
        'nis' => '67890',
        'kelas' => 'XI',
    ]);

    $category = Category::query()->create(['name' => 'Fasilitas']);

    DB::table('pengaduans')->insert([
        [
            'tempat' => 'Kelas',
            'description' => 'Lampu mati',
            'status' => 'menunggu',
            'siswa_id' => $selectedSiswa->id,
            'category_id' => $category->id,
        ],
        [
            'tempat' => 'Kelas',
            'description' => 'Kursi rusak',
            'status' => 'selesai',
            'siswa_id' => $selectedSiswa->id,
            'category_id' => $category->id,
        ],
        [
            'tempat' => 'Lapangan',
            'description' => 'Keran bocor',
            'status' => 'proses',
            'siswa_id' => $otherSiswa->id,
            'category_id' => $category->id,
        ],
    ]);

    $getStatValues = static function (GetPengaduan $widget): array {
        $method = new ReflectionMethod($widget, 'getStats');
        $stats = $method->invoke($widget);

        return array_map(
            static fn (Stat $stat): mixed => $stat->getValue(),
            $stats,
        );
    };

    Filament::setCurrentPanel('siswa');

    try {
        $widget = new GetPengaduan;

        expect($getStatValues($widget))->toBe([0, 0, 0]);

        $widget->pageFilters = ['siswa_id' => (string) $selectedSiswa->id];

        expect($getStatValues($widget))->toBe([1, 0, 1]);
    } finally {
        Filament::setCurrentPanel('admin');
    }

    expect($getStatValues(new GetPengaduan))->toBe([1, 1, 1]);
});
