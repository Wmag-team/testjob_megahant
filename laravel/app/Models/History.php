<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'model_id',
        'model_name',
        'before',
        'after',
        'action',
    ];

    protected $casts = [
        'before' => 'json',
        'after' => 'json',
    ];

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function modelable()
    {
        return $this->morphTo();
    }
}
