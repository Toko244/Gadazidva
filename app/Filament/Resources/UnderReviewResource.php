<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnderReviewResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UnderReviewResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Under Review Employees';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->sortable()
                    ->wrap()
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options(function () {
                        return \Spatie\Permission\Models\Role::all()->pluck('name', 'name')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->whereHas('roles', function (Builder $query) use ($data) {
                                $query->where('name', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->button()
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (User $record, $livewire) {
                        $record->update(['approved' => true]);

                        Notification::make()
                            ->success()
                            ->title('User approved')
                            ->body("{$record->name} has been approved.")
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->visible(fn (User $record) => !$record->approved),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approveSelected')
                        ->label('Approve Selected')
                        ->color('success')
                        ->icon('heroicon-o-check')
                        ->requiresConfirmation()
                        ->action(function ($records, $livewire) {
                            foreach ($records as $record) {
                                $record->update(['approved' => true]);
                            }

                            Notification::make()
                                ->success()
                                ->title('Users approved')
                                ->body('Selected users have been approved.')
                                ->send();
                            }),

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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('approved', false)
            ->with('roles');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnderReviews::route('/'),
        ];
    }
}
