<?php

namespace App\Filament\Resources\CargoTypeResource\Pages;

use App\Filament\Resources\CargoTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCargoType extends EditRecord
{
    protected static string $resource = CargoTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
