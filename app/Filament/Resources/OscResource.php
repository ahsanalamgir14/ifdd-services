<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OscResource\Pages;
use App\Filament\Resources\OscResource\RelationManagers;
use App\Models\Osc;
use App\Models\CategorieOdd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class OscResource extends Resource
{
    protected static ?string $model = Osc::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationLabel = 'Organisations';

    protected static ?string $recordTitleAttribute = 'oscs';

    protected static ?string $navigationGroup = 'Objectifs';

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
                Forms\Components\Select::make('pays')
                    ->required()
                    ->options([
                        'Benin' => 'Benin',
                        'Togo' => 'Togo',
                        'Cameroun' => 'Cameroun',
                        'Senegal' => 'Senegal',
                        'Cote d\'ivoire' => 'Cote d\'ivoire',
                        'Tanzania' => 'Tanzania',
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
                Forms\Components\Textarea::make('reference'),
                Forms\Components\Hidden::make('user_id')->default(auth()->user()->id),
                Forms\Components\Toggle::make('active')
                    ->required(),
                Forms\Components\Repeater::make('zoneInterventions')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('longitude')->required(),
                        Forms\Components\TextInput::make('latitude')->required()
                            ->required(),
                    ])
                    ->columns(3),
                Forms\Components\Repeater::make('categorie_odd_id')
                    ->relationship('oscCategorieOdds')
                    ->schema([
                        Forms\Components\Select::make('categorie_odd_id')
                            ->label('Cible Odd')
                            ->options(CategorieOdd::all()->pluck('category_number', 'id'))
                            ->searchable(),
                        Forms\Components\TextInput::make('description')->required(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->sortable()
                      ->searchable(query: function (Builder $query, string $search): Builder {
        return $query
            ->where('name', 'like', "%{$search}%");
    }),
                Tables\Columns\TextColumn::make('abbreviation')
                    ,
                Tables\Columns\TextColumn::make('pays')
                ->sortable()
                   ,
                Tables\Columns\TextColumn::make('date_fondation')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ,
                Tables\Columns\TextColumn::make('personne_contact')
                    ,
                Tables\Columns\TextColumn::make('telephone')
                    ,
                Tables\Columns\TextColumn::make('email_osc')
                    ,
                Tables\Columns\TextColumn::make('site_web')
                    ,
                Tables\Columns\TextColumn::make('longitude')
                    ,
                Tables\Columns\TextColumn::make('latitude')
                    ,
                Tables\Columns\IconColumn::make('active')
                ->sortable()
                    ->boolean(),
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
            'index' => Pages\ListOscs::route('/'),
            'create' => Pages\CreateOsc::route('/create'),
            'view' => Pages\ViewOsc::route('/{record}'),
            'edit' => Pages\EditOsc::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    { 
        if( auth()->user()->role == 3) {
            return parent::getEloquentQuery()->where('pays', 'Togo')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        } 
        if( auth()->user()->role == 4) {
            return parent::getEloquentQuery()->where('pays', 'Benin')->orWhere('pays', 'Bénin')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        }
        if( auth()->user()->role == 5) {
            return parent::getEloquentQuery()->where('pays', 'Cameroun')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        }
        if( auth()->user()->role == 6) {
            return parent::getEloquentQuery()->where('pays', 'Senegal')->orWhere('pays', 'Sénégal')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        }
        if( auth()->user()->role == 7) {
            return parent::getEloquentQuery()->where('pays', 'Cote d\'ivoire')->orWhere('pays', 'Côte d\'ivoire')->orWhere('pays', 'Côte d\'Ivoire')->orWhere('pays', 'Cote d\'Ivoire')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        }
        if( auth()->user()->role == 8) {
            return parent::getEloquentQuery()->where('pays', 'Tanzania')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        }
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        
    }

    public static function getNavigationBadge(): ?string
{
    if( auth()->user()->role == 3) {
        
    $country = parent::getEloquentQuery()->where('pays', 'Togo');
    return $country->count();
    }

    if( auth()->user()->role == 4) {
        
    $country = parent::getEloquentQuery()->where('pays', 'Benin')->orWhere('pays', 'Bénin');
    return $country->count();
    }

    if( auth()->user()->role == 5) {
        
    $country = parent::getEloquentQuery()->where('pays', 'Cameroun');
    return $country->count();
    }

    if( auth()->user()->role == 6) {
        
    $country = parent::getEloquentQuery()->where('pays', 'Senegal')->orWhere('pays', 'Sénégal');
    return $country->count();
    }

    if( auth()->user()->role == 7) {
        
    $country = parent::getEloquentQuery()->where('pays', 'Cote d\'ivoire')->orWhere('pays', 'Côte d\'ivoire')->orWhere('pays', 'Côte d\'Ivoire')->orWhere('pays', 'Cote d\'Ivoire');
    return $country->count();
    }

    if( auth()->user()->role == 8) {
        
    $country = parent::getEloquentQuery()->where('pays', 'Tanzania');
    return $country->count();
    }

    return static::getModel()::count();
}
}
