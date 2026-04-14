<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PipelineStageResource\Pages;
use App\Models\PipelineStage;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\Resource;

class PipelineStageResource extends Resource
{
    protected static ?string $model = PipelineStage::class;

   protected static ?string $navigationGroup = '⚙️ Data Master';
    protected static ?string $navigationIcon = 'heroicon-o-flag'; // lebih cocok

    protected static ?string $navigationLabel = 'Pipeline Stages';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Stage Information')
                    ->schema([

                        TextInput::make('name')
                            ->label('Stage Name')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('order')
                            ->label('Order')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Select::make('color')
                            ->label('Color')
                            ->options([
                                'gray' => 'Gray',
                                'primary' => 'Blue',
                                'success' => 'Green',
                                'danger' => 'Red',
                                'warning' => 'Orange',
                            ])
                            ->default('primary')
                            ->required(),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->badge()
                    ->color(fn ($record) => $record->color ?? 'primary')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('order')
                    ->sortable(),

                TextColumn::make('color')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // upgrade
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->reorderable('order') // 🔥 drag & drop stage
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            // nanti bisa relasi ke Pipeline
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPipelineStages::route('/'),
            'create' => Pages\CreatePipelineStage::route('/create'),
            'edit' => Pages\EditPipelineStage::route('/{record}/edit'),
        ];
    }
}