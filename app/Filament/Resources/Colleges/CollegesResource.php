<?php

namespace App\Filament\Resources\Colleges;

use App\Filament\Resources\Colleges\Pages\CreateColleges;
use App\Filament\Resources\Colleges\Pages\EditColleges;
use App\Filament\Resources\Colleges\Pages\ListColleges;
use App\Filament\Resources\Colleges\Pages\ViewColleges;
use App\Filament\Resources\Colleges\Schemas\CollegesForm;
use App\Filament\Resources\Colleges\Schemas\CollegesInfolist;
use App\Filament\Resources\Colleges\Tables\CollegesTable;
use App\Models\Colleges;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CollegesResource extends Resource
{
    protected static ?string $model = Colleges::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CollegesForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CollegesInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollegesTable::configure($table);
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
            'index' => ListColleges::route('/'),
            'create' => CreateColleges::route('/create'),
            'view' => ViewColleges::route('/{record}'),
            'edit' => EditColleges::route('/{record}/edit'),
        ];
    }
}
