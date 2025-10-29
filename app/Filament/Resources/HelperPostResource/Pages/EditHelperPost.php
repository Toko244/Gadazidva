<?php

namespace App\Filament\Resources\HelperPostResource\Pages;

use App\Filament\Resources\HelperPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHelperPost extends EditRecord
{
    protected static string $resource = HelperPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
