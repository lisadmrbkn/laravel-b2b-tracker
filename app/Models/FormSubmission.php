<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['form_id',
        'name',
        'email',
        'phone',
        'answers',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array'
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
