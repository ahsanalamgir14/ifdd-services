<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategorieOddResource\Pages;
use App\Filament\Resources\CategorieOddResource\RelationManagers;
use App\Models\CategorieOdd;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CategorieOddResource extends Resource
{
    protected static ?string $model = CategorieOdd::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $title = 'Cibles des ODDs';

    protected static ?string $navigationLabel = 'Cibles des Objectifs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('intitule')
                    ->required()
                    ->maxLength(255),
                Select::make('id_odd')
                    ->relationship('odd', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category_number'),
                Tables\Columns\TextColumn::make('intitule'),
                Tables\Columns\TextColumn::make('id_odd'),


            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                ExportBulkAction::make()
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
            'index' => Pages\ListCategorieOdds::route('/'),
            'create' => Pages\CreateCategorieOdd::route('/create'),
            'view' => Pages\ViewCategorieOdd::route('/{record}'),
            'edit' => Pages\EditCategorieOdd::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public function getTableBulkActions()
    {
        return  [
            ExportBulkAction::make()
        ];
    }
}
