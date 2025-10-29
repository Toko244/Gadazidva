<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePostResource\Pages;
use App\Filament\Resources\ServicePostResource\RelationManagers;
use App\Models\ServicePost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServicePostResource extends Resource
{
    protected static ?string $model = ServicePost::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('cargo_type_id')
                    ->relationship('cargoType', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('origin_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('origin_city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('origin_latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('origin_longitude')
                    ->numeric(),
                Forms\Components\TextInput::make('destination_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('destination_city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('destination_latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('destination_longitude')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('loading_date')
                    ->required(),
                Forms\Components\TextInput::make('cargo_weight')
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('contact_phone')
                    ->tel()
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('contact_email')
                    ->email()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cargoType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('origin_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('origin_city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('origin_latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('origin_longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destination_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('destination_city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('destination_latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destination_longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loading_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cargo_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_email')
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
            'index' => Pages\ListServicePosts::route('/'),
            'create' => Pages\CreateServicePost::route('/create'),
            'edit' => Pages\EditServicePost::route('/{record}/edit'),
        ];
    }
}
