<?php

use App\Filament\Resources\Pengaduans\PengaduanResource;
use App\Filament\Resources\Siswas\SiswaResource;
use App\Models\Pengaduan;
use App\Models\Siswa;
use Filament\Facades\Filament;

test('the student panel allows creating records but prevents editing and deleting them', function () {
    Filament::setCurrentPanel('siswa');

    try {
        foreach ([
            [SiswaResource::class, new Siswa],
            [PengaduanResource::class, new Pengaduan],
        ] as [$resource, $record]) {
            expect($resource::canCreate())->toBeTrue()
                ->and($resource::canEdit($record))->toBeFalse()
                ->and($resource::canDelete($record))->toBeFalse()
                ->and($resource::canDeleteAny())->toBeFalse()
                ->and($resource::getEditAuthorizationResponse($record)->allowed())->toBeFalse()
                ->and($resource::getDeleteAuthorizationResponse($record)->allowed())->toBeFalse()
                ->and($resource::getDeleteAnyAuthorizationResponse()->allowed())->toBeFalse();
        }
    } finally {
        Filament::setCurrentPanel(null);
    }
});
