<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThematiqueResource\Pages;
use App\Filament\Resources\ThematiqueResource\RelationManagers;
use App\Models\Thematique;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use IbrahimBougaoua\FilamentSortOrder\Actions\DownStepAction;
use IbrahimBougaoua\FilamentSortOrder\Actions\UpStepAction;

class ThematiqueResource extends Resource
{
    protected static ?string $model = Thematique::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

     protected static ?string $navigationGroup = 'Objectifs';

    protected static ?string $navigationLabel = 'Thématiques'; //THEMATIQUEs

    protected static ?string $title = 'Objectifs de Developpement Durable';

    protected static ?string $recordTitleAttribute = 'thématiques';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nom_en')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number_categorie')
                    ->required(),
                Forms\Components\TextInput::make('logo_thematique')
                    ->required()
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_categorie')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('logo_thematique')
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
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
                DownStepAction::make(),
    UpStepAction::make(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    ExportBulkAction::make()
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
            'index' => Pages\ListThematiques::route('/'),
            'create' => Pages\CreateThematique::route('/create'),
            'view' => Pages\ViewThematique::route('/{record}'),
            'edit' => Pages\EditThematique::route('/{record}/edit'),
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
