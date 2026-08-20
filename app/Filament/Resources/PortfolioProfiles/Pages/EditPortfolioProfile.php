<?php

namespace App\Filament\Resources\PortfolioProfiles\Pages;

use App\Filament\Resources\PortfolioProfiles\PortfolioProfileResource;
use Filament\Resources\Pages\EditRecord;

class EditPortfolioProfile extends EditRecord
{
    protected static string $resource = PortfolioProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
