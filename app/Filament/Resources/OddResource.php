<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OddResource\Pages;
use App\Filament\Resources\OddResource\RelationManagers;
use App\Models\Odd;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OddResource extends Resource
{
    protected static ?string $model = Odd::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Objectifs de Developpement Durable';

    protected static ?string $title = 'ODD';

    protected static ?string $recordTitleAttribute = 'odds';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number_categorie')
                    ->required(),
                Forms\Components\TextInput::make('logo_odd')
                    ->required()
                    ->maxLength(255),
                ColorPicker::make('color')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('number'),
                Tables\Columns\TextColumn::make('number_categorie'),

                Tables\Columns\TextColumn::make('logo_odd'),
                Tables\Columns\TextColumn::make('color'),
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
            'index' => Pages\ListOdds::route('/'),
            'create' => Pages\CreateOdd::route('/create'),
            'view' => Pages\ViewOdd::route('/{record}'),
            'edit' => Pages\EditOdd::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }
}
