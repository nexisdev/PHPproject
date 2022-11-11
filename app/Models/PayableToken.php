<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayableToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    // active scope
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
