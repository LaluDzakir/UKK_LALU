<?php

namespace App\Filament\Resources\Pengaduans\Pages;

use App\Filament\Resources\Pengaduans\PengaduanResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreatePengaduan extends CreateRecord
{
    protected static string $resource = PengaduanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (Filament::getCurrentPanel()?->getId() === 'siswa') {
            $data['status'] = 'menunggu';
        }

        return $data;
    }
}
