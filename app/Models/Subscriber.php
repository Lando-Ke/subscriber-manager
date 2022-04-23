<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Metable\Metable;

class Subscriber extends Model
{
    use HasFactory;
    use Metable;

    protected $with = ['meta'];
    protected $fillable = ['name', 'email_address', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
