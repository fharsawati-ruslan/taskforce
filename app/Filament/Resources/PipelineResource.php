<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PipelineResource\Pages;
use App\Models\Pipeline;
use App\Models\Company;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    Select,
    TextInput,
    Textarea,
    Section,
    Hidden,
    DatePicker,
    DateTimePicker
};

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

use Filament\Resources\Resource;

class PipelineResource extends Resource
{
    protected static ?string $model = Pipeline::class;

    protected static ?string $navigationGroup = '🚀 Sales';
    protected static ?string $navigationLabel = 'Pipeline';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Pipeline';
    protected static ?string $pluralModelLabel = 'Pipeline';

    protected static ?string $recordTitleAttribute = 'project_name';

    // 🔥 FORM
    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('🔥 Opportunity')
                ->schema([

                    Select::make('company_id')
                        ->label('Perusahaan')
                        ->relationship('company', 'name')
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $company = Company::find($state);

                            if ($company) {
                                $set('pic_name', $company->pic_name);
                                $set('mobile_phone', $company->phone);
                                $set('email', $company->email);
                            }
                        })
                        ->required(),

                    TextInput::make('project_name')
                        ->label('Project')
                        ->required(),

                    Select::make('pipeline_stage_id')
                        ->label('Stage')
                        ->relationship('stage', 'name')
                        ->required(),

                    TextInput::make('value')
                        ->numeric()
                        ->prefix('Rp'),

                    Select::make('status')
                        ->options([
                            'open' => 'Open',
                            'progress' => 'Progress',
                            'won' => 'Won 🏆',
                            'lost' => 'Lost ❌',
                        ])
                        ->reactive()
                        ->afterStateUpdated(fn ($state, $set) =>
                            $state === 'won' ? $set('progress', 100) : null
                        ),

                    TextInput::make('progress')
                        ->numeric()
                        ->suffix('%'),

                ])->columns(2),

            Section::make('📞 Contact')
                ->schema([

                    TextInput::make('pic_name')
                        ->label('PIC'),

                    TextInput::make('mobile_phone')
                        ->label('No HP'),

                    TextInput::make('email'),

                ])->columns(3),

            Section::make('📅 Activity')
                ->schema([

                    DateTimePicker::make('meeting_date'),

                    Select::make('meeting_type')
                        ->options([
                            'onsite' => 'Onsite',
                            'online' => 'Online',
                        ]),

                    DatePicker::make('next_follow_up'),
                    DatePicker::make('closing_date'),

                    Textarea::make('notes')
                        ->rows(3),

                ])->columns(2),

            // 🔒 AUTO SALES LOGIN
            Hidden::make('user_id')
                ->default(auth()->id()),

        ]);
    }

    // 📊 TABLE
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable(),

                TextColumn::make('pic_name')
                    ->label('PIC'),

                TextColumn::make('mobile_phone')
                    ->label('WhatsApp')
                    ->formatStateUsing(fn () => 'Chat WA')
                    ->url(fn ($record) =>
                        $record->mobile_phone
                            ? 'https://wa.me/' . preg_replace('/^0/', '62', $record->mobile_phone)
                            : null
                    )
                    ->openUrlInNewTab()
                    ->color('success'),

                TextColumn::make('project_name')
                    ->weight('bold'),

                TextColumn::make('stage.name')
                    ->badge(),

                TextColumn::make('value')
                    ->money('IDR'),

                TextColumn::make('progress')
                    ->suffix('%'),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'won',
                        'danger' => 'lost',
                        'warning' => 'progress',
                    ]),

                TextColumn::make('next_follow_up')
                    ->date(),

            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // 📄 PAGE ROUTE
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPipelines::route('/'),
            'create' => Pages\CreatePipeline::route('/create'),
            'edit' => Pages\EditPipeline::route('/{record}/edit'),
        ];
    }
}