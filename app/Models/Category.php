<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Solution;

class Category extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relation: Category has many Solutions
     */
    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }
}