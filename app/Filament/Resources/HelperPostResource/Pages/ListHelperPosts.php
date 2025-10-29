<?php

namespace App\Filament\Resources\HelperPostResource\Pages;

use App\Filament\Resources\HelperPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHelperPosts extends ListRecords
{
    protected static string $resource = HelperPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
