<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Industry;

class Company extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'industry_id',
        'customer_name',
        'pic_name',
        'pic_position',
        'office_phone',
        'mobile_phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'website', // 🔥 INI WAJIB ADA
    ];

    /**
     * Relation: Company belongs to Industry
     */
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}