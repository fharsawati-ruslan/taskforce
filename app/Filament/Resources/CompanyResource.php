<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{TextInput, Textarea, Select, Section};

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\Resource;

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
        return $form
            ->schema([

                // 🔥 INFORMASI
                Section::make('Informasi Perusahaan')
                    ->schema([

                        TextInput::make('name')
                            ->label('Nama Perusahaan')
                            ->required()
                            ->maxLength(255),

                        Select::make('industry_id')
                            ->label('Industri')
                            ->relationship('industry', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Industri')
                                    ->required(),
                            ]),

                        TextInput::make('customer_name')
                            ->label('Nama Customer'),

                        TextInput::make('pic_name')
                            ->label('PIC Customer'),

                        TextInput::make('pic_position')
                            ->label('Jabatan PIC'),

                    ])
                    ->columns(2),

                // 📞 KONTAK
                Section::make('Kontak')
                    ->schema([

                        TextInput::make('office_phone')
                            ->label('Telepon Kantor')
                            ->tel(),

                        TextInput::make('mobile_phone')
                            ->label('No. HP')
                            ->tel()
                            ->suffixAction(
                                fn ($state) =>
                                    \Filament\Forms\Components\Actions\Action::make('wa')
                                        ->icon('heroicon-m-chat-bubble-left-right')
                                        ->url(fn () => $state ? 'https://wa.me/' . preg_replace('/^0/', '62', $state) : null)
                                        ->openUrlInNewTab()
                            ),

                        TextInput::make('email')
                            ->label('Email')
                            ->email(),

                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->placeholder('https://example.com')
                            ->suffixIcon('heroicon-m-globe-alt')
                            ->formatStateUsing(fn ($state) =>
                                $state && !str_starts_with($state, 'http')
                                    ? 'https://' . $state
                                    : $state
                            )
                            ->suffixAction(
                                fn ($state) =>
                                    \Filament\Forms\Components\Actions\Action::make('open')
                                        ->icon('heroicon-m-arrow-top-right-on-square')
                                        ->url($state)
                                        ->openUrlInNewTab()
                            ),

                    ])
                    ->columns(2),

                // 📍 ALAMAT
                Section::make('Alamat')
                    ->schema([

                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('industry.name')
                    ->label('Industri')
                    ->badge()
                    ->sortable(),

                TextColumn::make('pic_name')
                    ->label('PIC'),

                TextColumn::make('mobile_phone')
                    ->label('No HP'),

                TextColumn::make('website')
                    ->label('Website')
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab()
                    ->toggleable(),

                TextColumn::make('email')
                    ->copyable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),

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