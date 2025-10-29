<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverProfileResource\Pages;
use App\Filament\Resources\DriverProfileResource\RelationManagers;
use App\Models\DriverProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverProfileResource extends Resource
{
    protected static ?string $model = DriverProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('vehicle_type_id')
                    ->relationship('vehicleType', 'name')
                    ->required(),
                Forms\Components\TextInput::make('vehicle_make')
                    ->maxLength(255),
                Forms\Components\TextInput::make('vehicle_model')
                    ->maxLength(255),
                Forms\Components\TextInput::make('vehicle_year'),
                Forms\Components\TextInput::make('vehicle_plate_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('vehicle_color')
                    ->maxLength(255),
                Forms\Components\TextInput::make('vehicle_capacity')
                    ->numeric(),
                Forms\Components\Textarea::make('bio')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('base_rate_per_km')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('base_rate_fixed')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('total_trips')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_verified')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicle_make')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_year'),
                Tables\Columns\TextColumn::make('vehicle_plate_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_capacity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_rate_per_km')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_rate_fixed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_trips')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDriverProfiles::route('/'),
            'create' => Pages\CreateDriverProfile::route('/create'),
            'edit' => Pages\EditDriverProfile::route('/{record}/edit'),
        ];
    }
}
