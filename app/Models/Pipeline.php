<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    protected $fillable = [
        'company_id',
        'pipeline_stage_id',
        'user_id',
        'project_name',
        'pic_name',
        'mobile_phone',
        'email',
        'value',
        'status',
        'progress',
        'meeting_date',
        'next_follow_up',
        'closing_date',
        'meeting_type',
        'notes',
    ];

    // 🔗 RELASI
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function stage()
    {
        return $this->belongsTo(PipelineStage::class, 'pipeline_stage_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}