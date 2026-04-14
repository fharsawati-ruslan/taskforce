<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolutionResource\Pages;
use App\Models\Solution;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\Resource;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static ?string $navigationGroup = '⚙️ Data Master';
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Solusi';
    protected static ?string $pluralModelLabel = 'Solusi';
    protected static ?string $modelLabel = 'Solusi';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Solution Information')
                    ->schema([

                        TextInput::make('name')
                            ->label('Solution Name')
                            ->required()
                            ->maxLength(255),

                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        // 🔥 FIX BRAND (lebih jelas + pasti keisi)
                        TextInput::make('brand')
                            ->label('Brand / Vendor')
                            ->placeholder('Cisco, Fortinet, Hikvision')
                            ->maxLength(255),

                        TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp')
                            ->maxLength(15),

                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge(),

                // 🔥 FIX BRAND BIAR KELIATAN
                TextColumn::make('brand')
                    ->label('Brand')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->striped();
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
            'index' => Pages\ListSolutions::route('/'),
            'create' => Pages\CreateSolution::route('/create'),
            'edit' => Pages\EditSolution::route('/{record}/edit'),
        ];
    }
}