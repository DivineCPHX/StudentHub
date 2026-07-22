<?php

namespace App\Filament\Resources\Colleges\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CollegesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
            ]);
    }
}
