<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\Resource;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

   protected static ?string $navigationGroup = '⚙️ Data Master';
    
    protected static ?string $navigationIcon = 'heroicon-o-tag'; // lebih cocok

    protected static ?string $navigationLabel = 'Kategori';
protected static ?string $pluralModelLabel = 'Kategori';
protected static ?string $modelLabel = 'Kategori';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Category Information')
                    ->schema([

                        TextInput::make('name')
                            ->label('Category Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                    ])
                    ->columns(1),
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

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // tambahan biar lengkap
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
            // nanti bisa tambah relasi ke Solutions
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}