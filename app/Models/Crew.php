<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;
    protected $primaryKey = 'crew_id';

    public function scopeActor($query)
    {
        return $query->where('position', 0);
    }

    public function scopeDirector($query)
    {
        return $query->where('position', '!=', 0);
    }
}
