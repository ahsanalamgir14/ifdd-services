<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategorieThematiqueResource\Pages;
use App\Filament\Resources\CategorieThematiqueResource\RelationManagers;
use App\Models\CategorieThematique;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategorieThematiqueResource extends Resource
{
    protected static ?string $model = CategorieThematique::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Type de Catégorie';

    protected static ?string $navigationGroup = 'Objectifs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('intitule')
                    ->required(),
                Forms\Components\TextInput::make('nom_en')
                    ->required(),
                Forms\Components\Select::make('id_thematique')
                    ->relationship('thematique', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('intitule')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id_thematique')
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
            'index' => Pages\ListCategorieThematiques::route('/'),
            'create' => Pages\CreateCategorieThematique::route('/create'),
            'view' => Pages\ViewCategorieThematique::route('/{record}'),
            'edit' => Pages\EditCategorieThematique::route('/{record}/edit'),
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