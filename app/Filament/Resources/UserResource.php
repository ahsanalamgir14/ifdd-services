<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohammadhprp\IPToCountryFlagColumn\Columns\IPToCountryFlagColumn;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;

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
                Select::make('role')
                    ->options(
                        Role::pluck('name', 'id')
                            ->prepend('Select a role', '')
                    )
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $role = Role::find($state);
                        if ($role && $role->role_type == 'client') {
                            $set('client_id', null);
                        }
                    }),
                Select::make('client_id')
                    ->label('Client')
                    ->options(function (Get $get) {
                        $roleId = $get('role');
                        if ($roleId) {
                            $role = Role::find($roleId);
                            if ($role && $role->role_type == 'user') {
                                $clientRole = Role::where('role_type', 'client')
                                    ->where('country', $role->country)
                                    ->first();
                                if ($clientRole) {
                                    return User::where('role', $clientRole->id)
                                        ->pluck('name', 'id');
                                }
                            }
                        }
                        return [];
                    })
                    ->nullable()
                    ->hidden(function (Get $get) {
                        $roleId = $get('role');
                        if ($roleId) {
                            $role = Role::find($roleId);
                            return $role && $role->role_type == 'client';
                        }
                        return false;
                    }),
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
                IPToCountryFlagColumn::make('adresse_ip'),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn ($state) => Role::find($state)?->name ?? '')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Client')
                    ->searchable()
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
        $query = parent::getEloquentQuery();
        $user = Auth::user();
        if ($user->role == 1) {
            return $query;
        }

        if ($user->role) {
            $role = Role::find($user->role);
    
            if ($role && $role->role_type == 'client') {
                $query->where('client_id', $user->id);
            }
        }
        return $query;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role == 1 || auth()->user()->role == 9;
    }

        public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}
}
