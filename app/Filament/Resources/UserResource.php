<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form->schema([

            // 🔥 AVATAR
            FileUpload::make('avatar')
                ->image()
                ->directory('avatars')
                ->imagePreviewHeight('120')
                ->circleCropper()
                ->columnSpanFull(),

            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->password()
                ->required(fn ($record) => $record === null)
                ->dehydrated(fn ($state) => filled($state))
                ->dehydrateStateUsing(fn ($state) => bcrypt($state)),

            Select::make('division')
                ->options([
                    'network' => '🌐 Network',
                    'system' => '🖥️ System',
                    'iot' => '📡 IoT',
                    'security' => '🔐 Security',
                    'app' => '📱 Application',
                    'sales' => '💰 Sales',
                    'presales' => '🤝 Pre Sales',
                    'project' => '📊 Project',
                ])
                ->required()
                ->searchable(),

            Select::make('roles')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // 🔥 AVATAR
                ImageColumn::make('avatar')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->searchable(),

                // 🔥 DIVISION BADGE
                TextColumn::make('division')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'network' => '🌐 Network',
                        'system' => '🖥️ System',
                        'iot' => '📡 IoT',
                        'security' => '🔐 Security',
                        'app' => '📱 Application',
                        'sales' => '💰 Sales',
                        'presales' => '🤝 Pre Sales',
                        'project' => '📊 Project',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'network' => 'info',
                        'system' => 'gray',
                        'iot' => 'warning',
                        'security' => 'danger',
                        'app' => 'success',
                        'sales' => 'success',
                        'presales' => 'primary',
                        'project' => 'secondary',
                        default => 'gray',
                    }),

                // 🔥 ROLE BADGE
                TextColumn::make('roles.name')
                    ->badge()
                    ->label('Role')
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])

            // 🔥 TOMBOL CREATE (INI YANG KEMARIN HILANG 😄)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add User')
                    ->icon('heroicon-o-user-plus'),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}