<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingRoomResource\Pages;
use App\Filament\Resources\BookingRoomResource\RelationManagers;
use App\Models\BookingRoom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingRoomResource extends Resource
{
    protected static ?string $model = BookingRoom::class;

   // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

protected static ?string $navigationGroup = '📅 Booking';
protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
protected static ?string $navigationLabel = 'Booking Room Kantor Trinet';
protected static ?string $modelLabel = 'Booking Room Kantor Trinet';
protected static ?string $pluralModelLabel = 'Booking Room Kantor Trinet';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([


		  Forms\Components\Hidden::make('user_id')
        ->default(auth()->id()),
             
   Forms\Components\Section::make('Booking Info')
                ->schema([

                    Forms\Components\Select::make('room')
                        ->label('Ruangan')
                        ->options([
                            'Lantai 2 - Meeting Room' => 'Lantai 2 - Meeting Room',
                            'Lantai 1 - Open Space' => 'Lantai 1 - Open Space',
                            'Lantai 1 - Server Room' => 'Lantai 1 - Server Room',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('activity')
                        ->label('Kegiatan')
                        ->required(),

                    Forms\Components\DatePicker::make('date')
                        ->required(),

                   // Forms\Components\TimePicker::make('time')
                      
Forms\Components\TimePicker::make('start_time')
  ->label('Jam Mulai')
                        ->required(),

Forms\Components\TimePicker::make('end_time')
    ->label('Jam Selesai')
    ->required(),



                    Forms\Components\TextInput::make('company')
                        ->label('Perusahaan')
                        ->required(),

                    Forms\Components\TextInput::make('total_guest')
                        ->numeric()
                        ->label('Jumlah Tamu')
                        ->required(),

                ])->columns(2),

            Forms\Components\Section::make('Minuman')
                ->schema([

                    Forms\Components\TextInput::make('aqua')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('coffee')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('tea')
                        ->numeric()
                        ->default(0),

                ])->columns(3),           

                




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               
Tables\Columns\TextColumn::make('room'),
    Tables\Columns\TextColumn::make('activity'),
    Tables\Columns\TextColumn::make('company'),
    Tables\Columns\TextColumn::make('date'),
    Tables\Columns\TextColumn::make('time'),
    Tables\Columns\TextColumn::make('total_guest'),





















            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBookingRooms::route('/'),
            'create' => Pages\CreateBookingRoom::route('/create'),
            'edit' => Pages\EditBookingRoom::route('/{record}/edit'),
        ];
    }
}
