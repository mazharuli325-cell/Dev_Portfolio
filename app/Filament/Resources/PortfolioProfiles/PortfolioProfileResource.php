<?php

namespace App\Filament\Resources\PortfolioProfiles;

use App\Filament\Resources\PortfolioProfiles\Pages\CreatePortfolioProfile;
use App\Filament\Resources\PortfolioProfiles\Pages\EditPortfolioProfile;
use App\Filament\Resources\PortfolioProfiles\Pages\ListPortfolioProfiles;
use App\Filament\Resources\PortfolioProfiles\Schemas\PortfolioProfileForm;
use App\Filament\Resources\PortfolioProfiles\Tables\PortfolioProfilesTable;
use App\Models\PortfolioProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PortfolioProfileResource extends Resource
{
    protected static ?string $model = PortfolioProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCommandLine;

    protected static string | UnitEnum | null $navigationGroup = 'Portfolio';

    protected static ?string $navigationLabel = 'Portfolio Content';

    protected static ?string $modelLabel = 'Portfolio Content';

    protected static ?string $pluralModelLabel = 'Portfolio Content';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PortfolioProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortfolioProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPortfolioProfiles::route('/'),
            'create' => CreatePortfolioProfile::route('/create'),
            'edit' => EditPortfolioProfile::route('/{record}/edit'),
        ];
    }
}
