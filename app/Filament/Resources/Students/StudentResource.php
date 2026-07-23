<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\ManageStudents;
use App\Models\Colleges;
use App\Models\Departments;
use App\Models\Students;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Students::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('department_id')->relationship('department', 'name')->preload()->searchable(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->email(),
                Select::make('gender')
                    ->options([
                        'Male' => 'male',
                        'Female' => 'female',
                    ])->preload(),
                TextInput::make('matric_no')->label('Matric No.'),
                Select::make('level')->label('Level')
                    ->options([
                        100 => 'Year 1',
                        200 => 'Year 2',
                        300 => 'Year 3',
                        400 => 'Year 4',
                        500 => 'Year 5',
                    ]),
                Toggle::make('is_graduated')->label('Graduated'),

            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistColumnSearchesInSession()
            ->persistFiltersInSession()
            ->persistSortInSession()
            ->deferLoading()
            ->deferFilters()
            ->groups([
                Group::make('department.name'),
            ])
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('department.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('gender'),
                TextColumn::make('matric_no')->label('Matric No.')->searchable(),
                IconColumn::make('is_graduated')->label('Graduated')->boolean(),
                TextColumn::make('level')->label('Level')->sortable(),
            ])
            ->filters([
                SelectFilter::make('gender')
                    ->options([
                        'Male' => 'male',
                        'Female' => 'female',
                    ]),
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->options(
                        Departments::query()->pluck('name', 'id')
                    )
                    ->searchable(),
                // SelectFilter::make('college_id')
                //     ->label('College Name')
                //     ->options(
                //         Colleges::query()->pluck('name', 'id')
                //     )
                //     ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('promote')
                    ->label('Promote')
                    ->icon(Heroicon::ArrowUp)
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Students $record)
                    {
                        if ($record->level >= 500) {
                             Notification::make()
                                ->warning()
                                ->title('Student is already in the final year.')
                                ->send();

                            return;
                        }

                        $record->increment('level', 100);

                        Notification::make()
                            ->success()
                            ->title('Student promoted successfully.')
                            ->send();
                    }),
                    Action::make('demote')
                    ->label('Demote')
                    ->icon(Heroicon::ArrowDown)
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Students $record)
                    {
                        if ($record->level <= 100) {
                             Notification::make()
                                ->warning()
                                ->title('Student is already in the final year.')
                                ->send();

                            return;
                        }

                        $record->decrement('level', 100);

                        Notification::make()
                            ->success()
                            ->title('Student demoted successfully.')
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markAllAsGraduated')
                        ->label('Mark all as Graduated')
                        ->icon(Heroicon::AcademicCap)
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records)
                        {
                            $records->toQuery()->update([
                                'is_graduated' => true,
                            ]);

                            Notification::make()
                                ->success()
                                ->title('Selected students successfully marked as graduated.')
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStudents::route('/'),
        ];
    }
}
