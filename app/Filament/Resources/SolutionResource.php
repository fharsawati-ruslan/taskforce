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
use Filament\Forms\Components\FileUpload;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Hidden;
use App\Imports\SolusiImport;
use Maatwebsite\Excel\Facades\Excel;

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

    protected static ?string $recordTitleAttribute = 'solution_name';

    // =========================
    // FORM
    // =========================
    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Solution Information')
                ->schema([
                    TextInput::make('solution_name')
                        ->label('Solution Name')
                        ->required(),

		    Hidden::make('category_id')
                ->default(1),
	


                    Select::make('category')
                        ->required()
                        ->options([
                            'Security' => 'Security',
                            'IoT' => 'IoT',
                            'Network' => 'Network',
                            'Software' => 'Software',
                        ]),

                    TextInput::make('brand')
                        ->label('Brand / Vendor'),

                    TextInput::make('price')
                        ->numeric()
                        ->prefix('Rp'),

                    Textarea::make('description')
                        ->rows(3),
                ])
                ->columns(2),
        ]);
    }

    // =========================
    // TABLE
    // =========================
    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                // 🔥 IMPORT EXCEL
                Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        FileUpload::make('file')
                            ->required()
                            ->disk('public')
                            ->directory('imports')
                            ->acceptedFileTypes([
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ]),
                    ])
                    ->action(function (array $data) {
                        Excel::import(
                            new SolusiImport,
                            storage_path('app/public/' . $data['file'])
                        );
                    }),
            ])

            ->columns([
                TextColumn::make('solution_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('brand')
                    ->placeholder('-'),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])

            ->defaultSort('created_at', 'desc')

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
        return [];
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
