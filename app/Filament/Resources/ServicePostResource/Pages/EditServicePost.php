<?php

namespace App\Filament\Resources\ServicePostResource\Pages;

use App\Filament\Resources\ServicePostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServicePost extends EditRecord
{
    protected static string $resource = ServicePostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
