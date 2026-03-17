<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'transport_job_id',
        'type',
        'file_path',
    ];

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'fuel'     => 'Gasoil',
            'food'     => 'Comida',
            'promoter' => 'Promotora',
            default    => ucfirst($this->type),
        };
    }

    public function transportJob()
    {
        return $this->belongsTo(TransportJob::class, 'transport_job_id');
    }
}
