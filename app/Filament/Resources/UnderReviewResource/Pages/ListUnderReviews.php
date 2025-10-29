<?php

namespace App\Filament\Resources\UnderReviewResource\Pages;

use App\Filament\Resources\UnderReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnderReviews extends ListRecords
{
    protected static string $resource = UnderReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
