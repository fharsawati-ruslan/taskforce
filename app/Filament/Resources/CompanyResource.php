<?php

namespace App\Filament\Resources;

use App\Models\Company;
use App\Exports\CompanyExport;
use App\Imports\CompanyImport;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    TextInput,
    Textarea,
    Select,
    Section,
    FileUpload
};

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

use Filament\Resources\Resource;
use Filament\Notifications\Notification;

use Maatwebsite\Excel\Facades\Excel;

use App\Filament\Resources\CompanyResource\Pages;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationGroup = '⚙️ Data Master';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Perusahaan';
    protected static ?string $pluralModelLabel = 'Perusahaan';
    protected static ?string $modelLabel = 'Perusahaan';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('Informasi Perusahaan')
                ->schema([

                    TextInput::make('name')
                        ->label('Nama Perusahaan')
                        ->required(),

                    Select::make('industry_id')
                        ->relationship('industry', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),

                    TextInput::make('customer_name'),
                    TextInput::make('pic_name'),
                    TextInput::make('pic_position'),

                ])->columns(2),

            Section::make('Kontak')
                ->schema([

                    TextInput::make('office_phone'),
                    TextInput::make('mobile_phone'),
                    TextInput::make('email')->email(),
                    TextInput::make('website')->url(),

                ])->columns(2),

            Section::make('Alamat')
                ->schema([
                    Textarea::make('address')->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')->searchable()->sortable(),

                TextColumn::make('industry.name')
                    ->label('Industri')
                    ->badge(),

                TextColumn::make('pic_name')->label('PIC'),
                TextColumn::make('mobile_phone')->label('No HP'),

                TextColumn::make('website')
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab(),

                TextColumn::make('email')->copyable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),

            ])

            ->headerActions([

                // ✅ EXPORT
                Action::make('export')
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        return Excel::download(new CompanyExport(), 'company.xlsx');
                    }),

                // ✅ IMPORT (FIX FINAL)
                Action::make('import')
                    ->label('Import')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('warning')
                    ->form([
                        FileUpload::make('file')
                            ->label('Upload Excel')
                            ->required()
                            ->storeFiles(false) // 🔥 WAJIB (biar gak error upload)
                    ])
                    ->action(function (array $data) {

                        try {
                            $file = $data['file'];

                            if (!$file) {
                                throw new \Exception('File tidak ditemukan');
                            }

                            // 🔥 IMPORT LANGSUNG
                            Excel::import(
                                new CompanyImport,
                                $file->getRealPath()
                            );

                            Notification::make()
                                ->title('Import berhasil!')
                                ->success()
                                ->send();

                        } catch (\Throwable $e) {

                            Notification::make()
                                ->title('Import gagal')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

            ])

            ->defaultSort('name', 'asc')

            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])

            ->striped()
            ->paginated([10, 25, 50]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}