<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email_address', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($subscriber) {
            $subscriber->fields()->delete();
        });
    }
}
