<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatesOverview;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('country_id')
                        ->label("Country")
                        ->options(Country::all()->pluck('name', 'id')->toArray())
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set("state_id", "null")),
                    Select::make('state_id')
                        ->label("State")
                        ->options(function (callable $get){
                            $country = Country::find($get("country_id"));
                            if (!$country) {
                                return State::all()->pluck("name", "id");
                            }
                            return $country->states->pluck("name", "id");
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set("city_id", "null")),
                    Select::make('city_id')
                        ->label("City")
                        ->options(function (callable $get){
                            $state = State::find($get("state_id"));
                            if (!$state) {
                                return City::all()->pluck("name", "id");
                            }
                            return $state->cities->pluck("name", "id");
                        })
                        ->required(),
                    Select::make("department_id")->relationship("department","name")->required(),
                    TextInput::make('first_name')->maxLength(255)->required(),
                    TextInput::make('last_name')->maxLength(255)->required(),
                    TextInput::make('address')->maxLength(255)->required(),
                    TextInput::make('zip_code')->maxLength(255)->required(),
                    DatePicker::make('birth_date')->required(),
                    DatePicker::make('date_hired')->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->sortable(),
                TextColumn::make('last_name')->sortable(),
                TextColumn::make('department.name')->sortable(),
                TextColumn::make('birth_date')->sortable(),
                TextColumn::make('date_hired')->sortable(),
            ])
            ->filters([
                SelectFilter::make('department')->relationship('department', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
