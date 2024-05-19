<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientUserResource\Pages;
use App\Models\User;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;

class ClientUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    protected static ?string $navigationLabel = 'Client Users';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $clientRole = Role::find($user->role);

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
                    ->options(function () use ($clientRole) {
                        if ($clientRole && $clientRole->role_type == 'client') {
                            return Role::where('role_type', 'user')
                                ->where('country', $clientRole->country)
                                ->pluck('name', 'id');
                        }
                        return [];
                    })
                    ->required(),
                Forms\Components\Hidden::make('client_id')->default(auth()->user()->id),
            ]);
    }

    public static function getClientName($clientId)
    {
        $client = User::find($clientId);
        $role = Role::find($client->role);
        return $role->name;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn ($state) => Role::find($state)?->name ?? '')
                    ->sortable(),
                Tables\Columns\TextColumn::make('client_id')
                    ->label('Client Name')
                    ->formatStateUsing(fn ($state) => self::getClientName($state))
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
            'index' => Pages\ListClientUsers::route('/'),
            'create' => Pages\CreateClientUser::route('/create'),
            'view' => Pages\ViewClientUser::route('/{record}'),
            'edit' => Pages\EditClientUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();
        $role = Role::find($user->role);
        if ($role && $role->role_type == 'client') {
            $query->where('client_id', $user->id);
        }
        return $query;
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user->role && Role::find($user->role)->role_type == 'client';
    }

    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();
        $role = Role::find($user->role);
        if ($role && $role->role_type == 'client') {
            return User::where('client_id', $user->id)->count();
        }
        return null;
    }
}
