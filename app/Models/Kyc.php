<?php

namespace App\Models;

use App\Enums\DocumentType;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kyc extends Model
{
    use HasFactory, Searchable;

    public array $searchableFields = [
        'first_name',
        'last_name',
        'phone_number',
    ];

    protected $casts = [
        'document_type' => DocumentType::class
    ];

    protected $guarded = [];

    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
