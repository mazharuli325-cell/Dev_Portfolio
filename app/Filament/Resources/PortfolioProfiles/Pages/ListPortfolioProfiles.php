<?php

namespace App\Filament\Resources\PortfolioProfiles\Pages;

use App\Filament\Resources\PortfolioProfiles\PortfolioProfileResource;
use App\Models\PortfolioProfile;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPortfolioProfiles extends ListRecords
{
    protected static string $resource = PortfolioProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn (): bool => PortfolioProfile::query()->doesntExist()),
        ];
    }
}
