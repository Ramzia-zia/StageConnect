<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'student_id',
        'status',
        'cover_letter_custom',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}