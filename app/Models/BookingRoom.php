<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingRoom extends Model
{
    use HasFactory;

    protected $table = 'booking_rooms';

    protected $fillable = [
        'user_id',
        'room',
        'activity',
        'date',
        'start_time',
        'end_time',
        'company',
        'total_guest',
        'aqua',
        'coffee',
        'tea',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * 🔗 Relasi ke User (PIC / Sales)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔥 Accessor: Total minuman
     */
    public function getTotalDrinkAttribute()
    {
        return ($this->aqua ?? 0) + ($this->coffee ?? 0) + ($this->tea ?? 0);
    }

    /**
     * 🔥 Helper: Nama ruangan clean
     */
    public function getRoomLabelAttribute()
    {
        return match ($this->room) {
            'Lantai 2 - Ruang Meeting' => 'Meeting Room Lt.2',
            'Lantai 1 - Open Space' => 'Open Space Lt.1',
            'Lantai 1 - Ruang Server' => 'Server Room Lt.1',
            default => $this->room,
        };
    }
}
