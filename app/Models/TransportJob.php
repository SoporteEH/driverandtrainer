<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_artist',
        'location',
        'van',
        'date',
        'entry_time',
        'exit_time',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'transport_job_id');
    }

    public function isEditable(): bool
    {
        return $this->date->diffInDays(now()) < 10;
    }
}
