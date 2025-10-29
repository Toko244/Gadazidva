<?php

namespace App\Filament\Resources\AssistantProfileResource\Pages;

use App\Filament\Resources\AssistantProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssistantProfile extends EditRecord
{
    protected static string $resource = AssistantProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
