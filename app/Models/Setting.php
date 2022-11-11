<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getSocialLinksAttribute(): array
    {
        return [
            'facebook' => $this->facebook,
            'discord' => $this->discord,
            'github' => $this->github,
            'slack' => $this->slack,
            'reddit' => $this->reddit,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'telegram' => $this->telegram_channel,
            'medium' => $this->medium,
            'linkedin' => $this->linkedin,
        ];
    }
}
