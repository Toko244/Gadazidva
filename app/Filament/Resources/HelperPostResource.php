<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HelperPostResource\Pages;
use App\Filament\Resources\HelperPostResource\RelationManagers;
use App\Models\HelperPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HelperPostResource extends Resource
{
    protected static ?string $model = HelperPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('driver_id')
                    ->relationship('driver', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('location_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location_city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location_latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('location_longitude')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('required_date')
                    ->required(),
                Forms\Components\TextInput::make('duration_hours')
                    ->numeric(),
                Forms\Components\TextInput::make('helpers_needed')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('offered_rate')
                    ->numeric(),
                Forms\Components\TextInput::make('contact_phone')
                    ->tel()
                    ->required()
                    ->maxLength(50),
                Forms\Components\Textarea::make('requirements')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Toggle::make('is_published')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('driver.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location_city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location_latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location_longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('required_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_hours')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('helpers_needed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('offered_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\IconColumn::make('is_published')
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
            'index' => Pages\ListHelperPosts::route('/'),
            'create' => Pages\CreateHelperPost::route('/create'),
            'edit' => Pages\EditHelperPost::route('/{record}/edit'),
        ];
    }
}
