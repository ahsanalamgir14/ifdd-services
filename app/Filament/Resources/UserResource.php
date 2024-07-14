<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohammadhprp\IPToCountryFlagColumn\Columns\IPToCountryFlagColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->options([
                        '1' => 'Administrateur',
                        '2' => 'Utilisateur',
                        '3' => 'Utilisateur Benin',
                        '4' => 'Utilisateur Burkina Faso',
                        '5' => 'Utilisateur Burundi',
                        '6' => 'Utilisateur Cabo Verde',
                        '7' => 'Utilisateur Cameroun',
                        '8' => 'Utilisateur Comores',
                        '9' => 'Utilisateur Côte d\'ivoire',
                        '10' => 'Utilisateur Djibouti',
                        '11' => 'Utilisateur Guinée Conakry',
                        '12' => 'Utilisateur Guinée Bissau',
                        '13' => 'Utilisateur Madagascar',
                        '14' => 'Utilisateur Mali',
                        '15' => 'Utilisateur Mauritanie',
                        '16' => 'Utilisateur Niger',
                        '17' => 'Utilisateur République Centrafricaine',
                        '18' => 'Utilisateur République du Congo',
                        '19' => 'Utilisateur République Démocratique du Congo',
                        '20' => 'Utilisateur Sénégal',
                        '21' => 'Utilisateur Sao Tomé et Principe',
                        '22' => 'Utilisateur Tchad',
                        '23' => 'Utilisateur Togo',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
               /*  IPToCountryFlagColumn::make('adresse_ip'), */
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role == 1;
    }

        public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}
}
