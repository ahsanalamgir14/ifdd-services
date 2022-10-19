<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OscResource\Pages;
use App\Filament\Resources\OscResource\RelationManagers;
use App\Filament\Resources\OscResource\Widgets\OscOverview;
use App\Models\CategorieOdd;
use App\Models\Osc;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OscResource extends Resource
{
    protected static ?string $model = Osc::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Organisations';

    protected static ?string $recordTitleAttribute = 'oscs';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('abbreviation')
                    ->required()
                    ->maxLength(255),
                Select::make('pays')
                    ->required()
                    ->options([
                        'Benin' => 'Benin',
                        'Togo' => 'Togo',
                    ]),
                Forms\Components\DatePicker::make('date_fondation'),
                Forms\Components\Textarea::make('description'),
                Forms\Components\TextInput::make('personne_contact')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telephone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_osc')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('site_web')
                    ->maxLength(255),
                Forms\Components\TextInput::make('facebook')
                    ->maxLength(255),
                Forms\Components\TextInput::make('twitter')
                    ->maxLength(255),
                Forms\Components\TextInput::make('instagram')
                    ->maxLength(255),
                Forms\Components\TextInput::make('linkedin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('siege')
                    ->required(),
                Hidden::make('user_id')->default(auth()->user()->id),
                Forms\Components\Toggle::make('active')
                    ->required(),
                Repeater::make('zoneInterventions')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('longitude')->required(),
                        TextInput::make('latitude')->required()
                            ->required(),
                    ])
                    ->columns(3),
                Repeater::make('categorie_odd_id')
                    ->relationship('oscCategorieOdds')
                    ->schema([
                        Select::make('categorie_odd_id')
                            ->label('Cible Odd')
                            ->options(CategorieOdd::all()->pluck('category_number', 'id'))
                            ->searchable(),
                        TextInput::make('description')->required(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('abbreviation'),
                Tables\Columns\TextColumn::make('pays'),
                Tables\Columns\TextColumn::make('date_fondation')
                    ->date(),
                Tables\Columns\TextColumn::make('personne_contact'),
                Tables\Columns\TextColumn::make('telephone'),
                Tables\Columns\TextColumn::make('email_osc'),
                Tables\Columns\TextColumn::make('site_web'),
                Tables\Columns\TextColumn::make('siege'),

                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\BooleanColumn::make('active')->sortable(),
            ])
            ->defaultSort('active')
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOscs::route('/'),
            'create' => Pages\CreateOsc::route('/create'),
            'view' => Pages\ViewOsc::route('/{record}'),
            'edit' => Pages\EditOsc::route('/{record}/edit'),
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
