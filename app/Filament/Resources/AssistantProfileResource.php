<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssistantProfileResource\Pages;
use App\Filament\Resources\AssistantProfileResource\RelationManagers;
use App\Models\AssistantProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssistantProfileResource extends Resource
{
    protected static ?string $model = AssistantProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Textarea::make('bio')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('skills')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('years_of_experience')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('hourly_rate')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('total_jobs')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('has_own_tools')
                    ->required(),
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
                Tables\Columns\TextColumn::make('years_of_experience')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hourly_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_jobs')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_own_tools')
                    ->boolean(),
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
            'index' => Pages\ListAssistantProfiles::route('/'),
            'create' => Pages\CreateAssistantProfile::route('/create'),
            'edit' => Pages\EditAssistantProfile::route('/{record}/edit'),
        ];
    }
}
