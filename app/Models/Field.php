<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['subscriber_id','title', 'type', 'value'];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
