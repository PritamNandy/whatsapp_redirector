<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $fillable = [
        'campaign_id',
        'name',
        'whatsapp_link',
        'access_limit',
        'total_redirects'
    ];
}
